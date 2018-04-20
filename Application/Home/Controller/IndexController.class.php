<?php
namespace Home\Controller;
use Tools\HomeacceController;

class IndexController extends HomeacceController {

    public function index(){
    	$stu = M('Stu')->find(session('fg_id'));
    	$this->assign('stu',$stu);

    	//练习题中课程信息
    	$cou_info = M('Course')->where('display=1')->select();
    	$this->assign('cou_info',$cou_info);
    	
      	$this->display();
    }

    
}