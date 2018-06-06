<?php
namespace Home\Controller;
use Tools\HomeacceController;

class IndexController extends HomeacceController {

    public function index(){
    	$stu = M('Stu')->find(session('fg_id'));
    	$this->assign('stu',$stu);

    	//练习题中课程信息
    	$cou_info = M('Course')->where('display=1')->select();
        foreach ($cou_info as $k => &$v){
            $sin_num = M('Ques_single')->where("course_id={$v['id']} and is_show=1")->count();
            if($sin_num == 0){
                $v['sin_status'] = 0;
            }else{
                $v['sin_status'] = 1;
            }

            $dou_num = M('Ques_double')->where("course_id={$v['id']} and is_show=1")->count();
            if($dou_num == 0){
                $v['dou_status'] = 0;
            }else{
                $v['dou_status'] = 1;
            }

            $jud_num = M('Ques_judge')->where("course_id={$v['id']} and is_show=1")->count();
            if($jud_num == 0){
                $v['jud_status'] = 0;
            }else{
                $v['jud_status'] = 1;
            }

            $sub_num = M('Ques_subj')->where("course_id={$v['id']}")->count();
            if($sub_num == 0){
                $v['sub_status'] = 0;
            }else{
                $v['sub_status'] = 1;
            }
        }
        unset($v);

        $this->assign('cou_info',$cou_info);

      	$this->display();
    }

    
}