<?php
namespace Tools;
use Think\Controller;

class HomeacceController extends Controller{
    //构造方法：实现各个方法访问过滤效果
    function __construct() {
        //避免覆盖父类的构造方法，给其先执行
        parent::__construct();

        $nowac = CONTROLLER_NAME."-".ACTION_NAME;  
        
        $selfid   = $_SESSION['fg_id'];

        //未登录系统用户判断，如果未登录则跳转到登录页面去
        //(如果访问的是"登录页、验证码、退出页"则允许访问)
        $loginac = "Public-login,Public-verifyImg,Public-loginout";
        if(empty($selfid) && strpos($loginac,$nowac)===false){         
            $moduleurl = __MODULE__;
            $js = <<<eof
                   <script type="text/javascript">
                   window.top.location.href="{$moduleurl}/Public/login";//加上window.top  就可以让整个框架都退出来（相当于target=_top）
                   </script>
eof;
             echo $js;
            exit;
        }
        
    }

    public function _empty(){
        $this->error('抱歉，访问的页面不存在','',5);
    }

}