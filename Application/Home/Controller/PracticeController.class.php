<?php
namespace Home\Controller;
use Tools\HomeacceController;

class PracticeController extends HomeacceController {

	function sin_show(){
		$cid = I('get.cou_id','','int');
		$num = M('Ques_single')->where("course_id=$cid and is_show=1")->count();
		if($num == '0'){
			echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 还没有练习题 ʕ•͓͡•ʔ</h1> ';
				exit;
		}
        $r = M('Course')->where("id=$cid and display=1")->count();
        if($r == '0'){
            echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 此课程不设置有练习题 ʕ•͓͡•ʔ</h1> ';
            exit;
        }

	    $page = new \Think\Page($num,1); //每页输出一条练习题,1为listRows
	    $page -> rollPage = 0; //分页数小于rollPage时，不显示首末页
	    $page -> lastSuffix = false;  //是否显示最后一页
	    $page -> setConfig('prev','上一道');
	    $page -> setConfig('next','下一道');
	    $page -> setConfig('last','末道');
	    $page -> setConfig('first','首道');

	    //添加bootstrap样式
	    $page->setConfig('header','<li class="disabled hwh-page-info"><a>共 <em>%TOTAL_ROW%</em> 道练习题  , <em>%NOW_PAGE%</em> / %TOTAL_PAGE% 道</a></li>');
	    $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
	    $page_show = bootstrap_page_style($page->show());
	    $this->assign('page_show',$page_show);//输出分页

	    $info = M('Ques_single')->where("course_id=$cid and is_show=1")->limit($page -> firstRow , $page -> listRows )->select();

	    $this->assign('info',$info); //输出数据

	    //得到课程名称
	    $cou_info = M('Course')->find($cid);
	    $this->assign('cou_name',$cou_info['name']);
	   
	    $p = I('get.p','','int');
	    if(!empty($p)){
	    	$this->assign('p',$p);
	    }else{
	    	$this->assign('p',1);
	    }

		$this->display();
	}

	function check_sin(){

	    if(IS_AJAX){
	    	//得到要校验的单选题id
	    	$answ = I('post.sin');
	    	if($answ == '1'){
	    		$data['status'] = '1';  //正确
	    	}else{
	    		$data['status'] = '0';
	    	}

	    	$this->ajaxReturn($data);//返回给前台（return无效）
	    }
	}


	function dou_show(){
		$cid = I('get.cou_id','','int');
		$num = M('Ques_double')->where("course_id=$cid and is_show=1")->count();
		if($num == '0'){
			echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 还没有练习题 ʕ•͓͡•ʔ</h1> ';
				exit;
		}
        $r = M('Course')->where("id=$cid and display=1")->count();
        if($r == '0'){
            echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 此课程不设置有练习题 ʕ•͓͡•ʔ</h1> ';
            exit;
        }

	    $page = new \Think\Page($num,1); //每页输出一条练习题,1为listRows
	    $page -> rollPage = 0; //分页数小于rollPage时，不显示首末页
	    $page -> lastSuffix = false;  //是否显示最后一页
	    $page -> setConfig('prev','上一道');
	    $page -> setConfig('next','下一道');
	    $page -> setConfig('last','末道');
	    $page -> setConfig('first','首道');

	    //添加bootstrap样式
	    $page->setConfig('header','<li class="disabled hwh-page-info"><a>共 <em>%TOTAL_ROW%</em> 道练习题  , <em>%NOW_PAGE%</em> / %TOTAL_PAGE% 道</a></li>');
	    $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
	    $page_show = bootstrap_page_style($page->show());
	    $this->assign('page_show',$page_show);//输出分页

	    $info = M('Ques_double')->where("course_id=$cid and is_show=1")->limit($page -> firstRow , $page -> listRows )->select(); 

	    $this->assign('info',$info); //输出数据

	    //得到课程名称
	    $cou_info = M('Course')->find($cid);
	    $this->assign('cou_name',$cou_info['name']);
	   
	    $p = I('get.p','','int');
	    if(!empty($p)){
	    	$this->assign('p',$p);
	    }else{
	    	$this->assign('p',1);
	    }
		$this->display();
	}

	function check_dou(){
		if(IS_AJAX){
			$answ1 = I('post.dou');
			$answ2 = I('post.dou');

			if($answ1[0] == '1' && $answ2[1] == '1'){
	    		$data['status'] = '1';  //正确
	    	}else{
	    		$data['status'] = '0';
	    	}
	    	$this->ajaxReturn($data);
		}
	}


	function jud_show(){
		$cid = I('get.cou_id','','int');
		$num = M('Ques_judge')->where("course_id=$cid and is_show=1")->count();
		if($num == '0'){
			echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 还没有练习题 ʕ•͓͡•ʔ</h1> ';
				exit;
		}
        $r = M('Course')->where("id=$cid and display=1")->count();
        if($r == '0'){
            echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 此课程不设置有练习题 ʕ•͓͡•ʔ</h1> ';
            exit;
        }

	    $page = new \Think\Page($num,1); //每页输出一条练习题,1为listRows
	    $page -> rollPage = 0; //分页数小于rollPage时，不显示首末页
	    $page -> lastSuffix = false;  //是否显示最后一页
	    $page -> setConfig('prev','上一道');
	    $page -> setConfig('next','下一道');
	    $page -> setConfig('last','末道');
	    $page -> setConfig('first','首道');

	    //添加bootstrap样式
	    $page->setConfig('header','<li class="disabled hwh-page-info"><a>共 <em>%TOTAL_ROW%</em> 道练习题  , <em>%NOW_PAGE%</em> / %TOTAL_PAGE% 道</a></li>');
	    $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
	    $page_show = bootstrap_page_style($page->show());
	    $this->assign('page_show',$page_show);//输出分页

	    $info = M('Ques_judge')->where("course_id=$cid and is_show=1")->limit($page -> firstRow , $page -> listRows )->select(); 

	    $this->assign('info',$info); //输出数据

	    //得到课程名称
	    $cou_info = M('Course')->find($cid);
	    $this->assign('cou_name',$cou_info['name']);
	   
	    $p = I('get.p','','int');
	    if(!empty($p)){
	    	$this->assign('p',$p);
	    }else{
	    	$this->assign('p',1);
	    }

		$this->display();
	}

	function check_jud(){
		if(IS_AJAX){
			$answ = I('post.jud');
			if($answ == '1'){
	    		$data['status'] = '1';  //正确
	    	}else{
	    		$data['status'] = '0';
	    	}
	    	$this->ajaxReturn($data);
		}
	}



}