<?php
namespace Tools;
use Tools\MyVender\Image;
use Tools\MyVender\Tool;

class ZF
{
    private $stuId = '';
    private $stuPwd = '';
    private $baseUrl = '';
    private $token = '';
    private $name = '';

    /**
     * 构造方法
     *
     * @param string $id
     * @param string $pwd
     * @param string $ip
     */
    public function __construct($id, $pwd, $host)
    {
        $this->stuId = $id;
        $this->stuPwd = $pwd;
        $this->baseUrl = $host;

        $this->token = $this->getToken();
        $this->baseUrl .= $this->token;
    }

    /**
     * 获取访问 token
     *
     * @return string
     */
    protected function getToken()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->baseUrl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 不直接输出
        curl_exec($curl);
        $header = curl_getinfo($curl); // 获取最后一次传输的相关信息
        curl_close($curl);

        // 从重定向地址中获取token
        preg_match("#/\(.*\)/#", $header['redirect_url'], $result);
        return $result[0];
    }

    /**
     * 获取验证码图片
     *
     * @return void
     */
    protected function saveChapterImg()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->baseUrl . 'CheckCode.aspx');
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $img = curl_exec($curl);

        curl_close($curl);

        $src = dirname(__FILE__).'/verifyCode.gif';
        $fp = fopen($src, 'w');
        fwrite($fp, $img);
        fclose($fp);

        return $src;
    }

    /**
     * 构造登录提交的数据
     *
     * @return array
     */
    protected function buildLoginData()
    {
        $data = [
            'TextBox1' => $this->stuId,
            'TextBox2' => $this->stuPwd,
            'txtSecretCode' => '',
            'lbLanguage' => '',
            'Button1' => '',
        ];

        // 获取 __VIEWSTATE
        $pageContent = file_get_contents($this->baseUrl);
        $pattern = '/name="__VIEWSTATE" value="(.*?)" \/>/is';
        preg_match($pattern, $pageContent, $matches);
        $data['__VIEWSTATE'] = $matches[1];

        // 获取验证码字符串
        $img = new Image($this->saveChapterImg());
        $data['TextBox3'] = Tool::match(Tool::split($img));

        return $data;
    }


    function curl_request($url,$post=''){//$cookie='', $returnCookie=0,
        //初始化
        $curl   = curl_init();
        //填入参数
        curl_setopt($curl, CURLOPT_URL, $url); //要从哪个页面获取信息
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); //302重定向
        curl_setopt($curl, CURLOPT_REFERER, $this->baseUrl);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设定返回 的数据是否自动显示
        
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);//post形式提交数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post)); //传递数据
        }
      
        //执行
        $result = curl_exec($curl);

        //关闭
        curl_close($curl);
        return $result;
    }


    /**
     * 登录
     *
     * @return void
     */
    public function login()
    {
        $url = $this->baseUrl . 'default2.aspx';
        $post = $this->buildLoginData();
        $result = $this->curl_request($url,$post);

        preg_match("/<span id=\"xhxm\">(.*)<\/span>/",$result, $names);
        if(empty($names[1])){
            return [0, '登录失败，用户名或密码错误'];
        }

        // 登陆成功，抓取返回来的主页信息
        $names[1] = explode("  ",$names[1]);
        $this -> name = iconv('gb2312','utf-8',$names[1][1]);
        $this -> name = str_replace("同学","",$this -> name);
        $data['name'] = $this -> name;

        // 抓取其他信息
        $url2 = $this->baseUrl.'xsgrxx.aspx?xh='. $this -> stuId.'&xm='.$this -> name.'&gnmkdm=N121501';
        $res2 = $this->curl_request($url2);
        preg_match("/<span id=\"lbl_xy\">(.*)<\/span>/",$res2, $college);
        preg_match("/<span id=\"lbl_zymc\">(.*)<\/span>/",$res2, $major);
        preg_match("/<span id=\"lbl_xzb\">(.*)<\/span>/",$res2, $class);

         $data['college'] = iconv('gb2312','utf-8',$college[1]);
         $data['major'] = iconv('gb2312','utf-8',$major[1]);
         $data['class'] = iconv('gb2312','utf-8',$class[1]);

        return $data;
    }

}
