<?php
namespace Admin\Controller;
use Tools\AccessController;

class IndexController extends AccessController {

    public function index(){
        //右上角信息打印
       	$user_info = M('User')->field('name')->find(session('bg_id'));
       	$this->assign('username',$user_info['name']);

       	if(session('role_id') == 0){
       		$rolename = "超级管理员";
       	}else{
       		$role_info = M('Role')->field('name')->find(session('role_id'));
       		$rolename = $role_info['name'];
       	}
       	$this->assign('rolename',$rolename);

        //左侧列表权限打印
        $role_info = M('Role')->find(session('role_id'));
        $auth_ids = $role_info['auth_ids'];
        if(session('role_id') == 0){
            //超级管理员显示全部权限
            $auth_info1 = M('Authority')->where('auth_level=0 and display=1')->select(); //父级
            $auth_info2 = M('Authority')->where('auth_level=1 and display=1')->select(); //子级
        }else{
            //其他用户
            $auth_info1 = D('Authority')->where("auth_level=0 and display=1 and id in($auth_ids)")->select();
            $auth_info2 = D('Authority')->where("auth_level=1 and display=1 and id in($auth_ids)")->select();
        }
        
        $this->assign('auth_info1',$auth_info1);
        $this->assign('auth_info2',$auth_info2);
       	$this->display();
    }

    
    
}