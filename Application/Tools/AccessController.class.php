<?php

//后台分组 普通控制器的父类
namespace Tools;
use Think\Controller;

class AccessController extends Controller{
    //构造方法：实现各个方法访问过滤效果
    function __construct() {
        parent::__construct();
        //获得当前用户访问的"控制器/操作方法"权限信息
        $nowac = CONTROLLER_NAME."-".ACTION_NAME;  //避免覆盖父类的构造方法，给其先执行
        //获得当前用户“允许”访问的权限信息：self_id-----role------auth
        $self_id   = session('bg_id');

        //未登录系统用户判断，如果未登录则跳转到登录页面去
        //(如果访问的是"登录页、验证码、退出页"则允许访问)
        $loginac = "Public-login,Public-verifyImg,Public-loginout";
        if(empty($self_id) && strpos($loginac,$nowac)===false){         
            $moduleurl = __MODULE__;
            $js = <<<eof
                   <script type="text/javascript">
                   window.top.location.href="{$moduleurl}/Public/login";//加上window.top  就可以让整个框架都退出来（相当于target=_top）
                   </script>
eof;
             echo $js;
            exit;
        }

        $roleid = session('role_id');
        //根据$roleid 获得角色信息
        $roleinfo = D('Role')->find($roleid);
        $auth_ac = $roleinfo['auth_ac']; //获得角色对应权限的"控制器-操作方法"信息
        //默认允许大家都可以访问的权限
        $allow_ac = "Public-login,Public-loginout,Public-verifyImg,Index-index";  //个人中心这些就放在权限列表里面赋予，此处只给出列表里没有的权限

        if(strpos($auth_ac,$nowac)===false && strpos($allow_ac,$nowac)===false && $roleid!=='0'){
           $this->error('您无此权限');exit;
        }
    }

    //每次运行empty方法，先要运行上面的构造方法
    //由于有权限的判断，所以除了“超级管理员，起始登录界面输错”，其他情况都不运行下方法
    //而被 “您无此权限”代替
    public function _empty () {
        $this->error('页面出错','',5);
    }


}
