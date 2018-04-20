<?php

namespace Tools;
header("Content-type:text/html;charset='utf-8'");

class ZhuaQu{
    public $cookie;      //cookie保存地址
    public $url;         //登录地址

    //使用curl_request后正则匹配得出来的数据
    public $viewstate;   //随机字符串
    public $temp;        //随机参数

    //学生输入
    public $stuid;       //学号
    public $name;        //准备抓取并返回的信息

    function __construct($url,$cookie){
            $this -> url =$url;
            $this -> cookie = $cookie;
            $this -> viewstate = $this ->getView();
    }

    function getView(){
        //$result是上面方法curl_request返回来的目标登录网页数据（相当于得到了当前状态下的代码），
        //剩下的只是正则匹配获得当前网页登录所需要的post数据
         $url = $this -> url;
         $result = $this->curl_request($url);

            //正则匹配
         preg_match('/Location: \/\((.*)\)/', $result,$temp);
         $this -> temp = $temp[1];  //得到登录页面网址的随机参数

         $pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*?)" \/>/is';
            preg_match_all($pattern, $result, $matches);
            $res = $matches[1][0];
            return $res; //返回给构造方法__construct中的参数viewstate（随机字符串，为表单的隐藏域）
    }

    function curl_request($url,$post='',$cookie='', $show=1,$referer=''){//$cookie='', $returnCookie=0,
        //初始化
        $curl   = curl_init();
        //填入参数
        curl_setopt($curl, CURLOPT_URL, $url); //要从哪个页面获取信息
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_HEADER, $show);//设定是否显示头信息
        curl_setopt($curl, CURLOPT_REFERER, $this->url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设定返回 的数据是否自动显示
        
        // curl_setopt($curl, CURLOPT_SSLVERSION, 3);

        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);//post形式提交数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post)); //传递数据
        }
        if($cookie) { //判断是否有返回的cookie，有就把它保存在自定义的$cookie路径文件中
            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); // 把返回来的cookie信息保存在定义的$cookie路径文件中
        }
        if ($referer) {
             curl_setopt($curl, CURLOPT_REFERER, $referer);
        }
        //执行
        $data = curl_exec($curl);

        //关闭
        curl_close($curl);
        return $data;
    }

    function login(){
        //准备好post数据包等
        $url = 'http://210.38.162.117/('.$this->temp.')/default2.aspx'; //目标登录网页的地址
        $post['__VIEWSTATE'] = $this -> viewstate;
        $post['txtUserName'] = $_POST['xuehao'];
        $post['TextBox2'] = $_POST['pwd'];
        $post['txtSecretCode'] = '';
        $post['RadioButtonList1'] = @iconv('utf-8', 'gb2312', '学生');
        $post['Button1'] = '';
        $post['lbLanguage'] = '';
        $post['hidpdrs'] = '';
        $post['hidsc'] = '';

        //利用curl_request方法进行模拟登陆
        $result = $this->curl_request($url,$post);
        if (empty($result)) {
           return 0;exit;
        }
   //--------------------------------------------------------------------------------------
        //返回的数据不为空即为登陆成功，此时需要给出跳转的页面地址，并抓取该页面的某些内容
        $this -> stuid = $_POST['xuehao'];
        $url2 = 'http://210.38.162.117/('.$this->temp.')/xs_main.aspx?xh='. $this -> stuid;
        //以下为抓取的内容 
        $go = $this->curl_request($url2);
        

        preg_match("/<span id=\"xhxm\">(.*)<\/span>/",$go, $names);//抓取名字,(正则表达式，该页的html代码，匹配的结果) 
        $names[1] = explode("  ",$names[1]);
        $name = iconv('gb2312','utf-8',$names[1][1]);//名字，先转成utf8再截取替代
        $name = str_replace("同学","",$name);
        
        $this -> name = $name;  
            
        $url3 = 'http://210.38.162.117/('.$this->temp.')/xsgrxx.aspx?xh='. $this -> stuid.'&xm='.$this -> name.'&gnmkdm=N121501';
        $go3 = $this->curl_request($url3);
        preg_match("/<span id=\"lbl_xy\">(.*)<\/span>/",$go3, $college);
        preg_match("/<span id=\"lbl_zymc\">(.*)<\/span>/",$go3, $major);
        preg_match("/<span id=\"lbl_xzb\">(.*)<\/span>/",$go3, $class);
    
       //抓取的第二个内容   
        $college = iconv('gb2312','utf-8',$college[1]);
        $major = iconv('gb2312','utf-8',$major[1]);
        $class = iconv('gb2312','utf-8',$class[1]);
        
        $info = array("name"=>$name,"college"=>$college,"major"=>$major,"stu_class"=>$class);
        
        return $info;//return回一个数组
   }
   
}

?>
