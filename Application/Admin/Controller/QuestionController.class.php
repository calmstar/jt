<?php
namespace Admin\Controller;
use Tools\AccessController;

class QuestionController extends AccessController{

	function sin_showlist(){
		$sin = new \Admin\Model\Ques_singleModel();
		
		//判断角色
		$role_id = session('role_id');
		$uid = session('bg_id');
		if($role_id == 1){
			//教师，展现自己所教课程的题目
			$course_ids = M('User')->field('course_ids')->find($uid);
			$course_ids = $course_ids['course_ids'];
			$data = $sin->where("course_id in($course_ids)")->select();
		}else{
			//管理员，所有课程的单选题展示
			$data = $sin->select();
		}

		$data = $sin->deal_sin_show($data);
		if(IS_AJAX){
			$this->ajaxReturn($data);
		}
		$this->display();
	}

	function sin_add(){
		if(!empty($_POST)){
			//用D方法不行，其下划线会被风格转化掉，从而用不了自定义的模型类的方法
			$sin = new \Admin\Model\Ques_singleModel(); 
			//将right_answ整理成数据表字段 is_op1,2..
			$sin->deal_sin_add($_POST);
			//数据表中没有的字段会被过滤掉
			//create方法若是填了参数就不会使用I方法将特殊符号变为html实体字符了
			//所有我在deal_data方法中将变化的字段赋到post中，create方法没有参数，自动调用POST参数
			$data = $sin->create();  
			if($data){
				$res = $sin->add($data);
				if($res){
					$this->success('添加成功',U('Question/sin_showlist'));
				}else{	
					$this->error('添加失败');
				}
			}else{
				$mess = $sin->getError();
				$this->error($mess);
			}
		}else{
			//课程信息

			//判断角色
			$role_id = session('role_id');
			$uid = session('bg_id');
			if($role_id == 1){
				//教师，展现自己所教课程
				$course_ids = M('User')->field('course_ids')->find($uid);
				$course_ids = $course_ids['course_ids'];

				$cou_info = M('Course')->select($course_ids);
			}else{
				//管理员，所有课程
				$cou_info = M('Course')->select();
			}
			
			$this->assign('cou_info',$cou_info);
			$this->display();
		}
	}

	function sin_dele(){
		if(!empty($_POST)){
			$ids = I('post.ids');
			$res = M('Ques_single')->delete($ids);
			if($res){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	function sin_edit(){
		if(!empty($_POST)){
			$sin = new \Admin\Model\Ques_singleModel();
			$sin->deal_sin_edit($_POST);
			$data = $sin->create();
			if($data){
				$res = $sin->save($data); //无需处理
				if($res !== false){
					$this->success('修改成功',U('Question/sin_showlist'));
				}else{
					$this->error('修改失败');
				}
			}else{
				$this->error($sin->getError());
			}
		}else{
			//下拉课程列表

			//判断角色
			$role_id = session('role_id');
			$uid = session('bg_id');
			if($role_id == 1){
				//教师，展现自己所教课程
				$course_ids = M('User')->field('course_ids')->find($uid);
				$course_ids = $course_ids['course_ids'];

				$cou_info = M('Course')->select($course_ids);
			}else{
				//管理员，所有课程
				$cou_info = M('Course')->select();
			}

			$this->assign('cou_info',$cou_info);
			//原有信息	
			$id = I('get.id');
			$sin = new \Admin\Model\Ques_singleModel();
			$info = $sin->find($id);
			$info = $sin->sin_edit_original($info);
			$this->assign('info',$info);
			$this->display();
		}
	}

	function sin_import(){
		if(!empty($_FILES['sin_file']['name'])){
			$sin = new \Admin\Model\Ques_singleModel();
			$all_path = $sin->deal_file($_FILES['sin_file']);
			if(!$all_path){
				$this->error('上传失败,请检查文件格式！');exit;
			}

		   //上传文件成功后的操作
		    $data = excelToArray($all_path);
		    //处理excel中生成的二维数据
		    $check_data = $sin->deal_file_data($data);
		    //错误时返回一个 一维的错误信息数组，正确时返回一个二维数组数据
		    //必须为字符 0 ,而不能是数字0！后者意味着找不到,就和前面的匹配了
		    if($check_data['status'] == '0'){ 
		    	$this->error($check_data['msg']);exit;
		    }
		    //最后无误将改造后的数组addall
		    $res = $sin->addall($check_data);
		    if($res){
		    	$this->success('导入数据库成功');
		    }else{
		    	$this->error('导入数据库失败');
		    }
		}else{
			$this->error('未选择文件');
		}
	}

	//--------- 双选题 ---------------
	function dou_showlist(){
		$dou = new \Admin\Model\Ques_doubleModel();

		//判断角色
		$role_id = session('role_id');
		$uid = session('bg_id');
		if($role_id == 1){
			//教师，展现自己所教课程的题目
			$course_ids = M('User')->field('course_ids')->find($uid);
			$course_ids = $course_ids['course_ids'];
			$data = $dou->where("course_id in($course_ids)")->select();
		}else{
			//管理员，所有课程的题展示
			$data = $dou->select();
		}

		
		$data = $dou->deal_dou_show($data);
		if(IS_AJAX){
			$this->ajaxReturn($data);
		}
		$this->display();
	}

	function dou_add(){
		if(!empty($_POST)){
			$dou = new \Admin\Model\Ques_doubleModel(); 
			$dou->deal_dou_add($_POST);
			$data = $dou->create(); 

			if($data){
				$res = $dou->add($data);
				if($res){
					$this->success('添加成功',U('Question/dou_showlist'));
				}else{	
					$this->error('添加失败');
				}
			}else{
				$mess = $dou->getError();
				$this->error($mess);
			}
		}else{
			//课程信息

			//判断角色
			$role_id = session('role_id');
			$uid = session('bg_id');
			if($role_id == 1){
				//教师，展现自己所教课程
				$course_ids = M('User')->field('course_ids')->find($uid);
				$course_ids = $course_ids['course_ids'];

				$cou_info = M('Course')->select($course_ids);
			}else{
				//管理员，所有课程
				$cou_info = M('Course')->select();
			}

			$this->assign('cou_info',$cou_info);
			$this->display();
		}
	}

	function dou_dele(){
		if(!empty($_POST)){
			$ids = I('post.ids');
			$res = M('Ques_double')->delete($ids);
			if($res){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	function dou_edit(){
		if(!empty($_POST)){
			$dou = new \Admin\Model\Ques_doubleModel();
			$dou->deal_dou_edit($_POST);
			$data = $dou->create();
			if($data){
				$res = $dou->save($data); //无需处理
				if($res !== false){
					$this->success('修改成功',U('Question/dou_showlist'));
				}else{
					$this->error('修改失败');
				}
			}else{
				$this->error($dou->getError());
			}
		}else{
			//下拉课程列表

			//判断角色
			$role_id = session('role_id');
			$uid = session('bg_id');
			if($role_id == 1){
				//教师，展现自己所教课程
				$course_ids = M('User')->field('course_ids')->find($uid);
				$course_ids = $course_ids['course_ids'];

				$cou_info = M('Course')->select($course_ids);
			}else{
				//管理员，所有课程
				$cou_info = M('Course')->select();
			}
			
			$this->assign('cou_info',$cou_info);
			//原有信息	
			$id = I('get.id');
			$dou = new \Admin\Model\Ques_doubleModel();
			$info = $dou->find($id);
			$info = $dou->dou_edit_original($info);
			$this->assign('info',$info);
			$this->display();
		}
	}


	function dou_import(){
		if(!empty($_FILES['dou_file']['name'])){
			$dou = new \Admin\Model\Ques_doubleModel();
			$all_path = $dou->deal_file($_FILES['dou_file']);
			if(!$all_path){
				$this->error('上传失败,请检查文件格式！');exit;
			}
		   //上传文件成功后的操作
		    $data = excelToArray($all_path);
		    //处理excel中生成的二维数据
		    $check_data = $dou->deal_file_data($data);
		    //错误时返回一个 一维的错误信息数组，正确时返回一个二维数组数据
		    //必须为字符 0 ,而不能是数字0！后者意味着找不到,就和前面的匹配了
		    if($check_data['status'] == '0'){ 
		    	$this->error($check_data['msg']);exit;
		    }
		    //最后无误将改造后的数组addall	
		    $res = $dou->addall($check_data);
		    if($res){
		    	$this->success('导入数据库成功');
		    }else{
		    	$this->error('导入数据库失败');
		    }
		}else{
			$this->error('未选择文件');
		}
	}

	//----- 判断题 -----------
	function jud_showlist(){
		$jud = new \Admin\Model\Ques_judgeModel();

		//判断角色
		$role_id = session('role_id');
		$uid = session('bg_id');
		if($role_id == 1){
			//教师，展现自己所教课程的题目
			$course_ids = M('User')->field('course_ids')->find($uid);
			$course_ids = $course_ids['course_ids'];
			$data = $jud->where("course_id in($course_ids)")->select();
		}else{
			//管理员，所有课程的题展示
			$data = $jud->select();
		}

		$data = $jud->deal_jud_show($data);
		if(IS_AJAX){
			$this->ajaxReturn($data);
		}
		$this->display();
	}


	function jud_add(){
		if(!empty($_POST)){
			$jud = new \Admin\Model\Ques_judgeModel(); 
			$jud->deal_jud_add($_POST);
			$data = $jud->create(); 
			if($data){
				$res = $jud->add($data);
				if($res){
					$this->success('添加成功',U('Question/jud_showlist'));
				}else{	
					$this->error('添加失败');
				}
			}else{
				$mess = $jud->getError();
				$this->error($mess);
			}
		}else{
			//课程信息

			//判断角色
			$role_id = session('role_id');
			$uid = session('bg_id');
			if($role_id == 1){
				//教师，展现自己所教课程
				$course_ids = M('User')->field('course_ids')->find($uid);
				$course_ids = $course_ids['course_ids'];

				$cou_info = M('Course')->select($course_ids);
			}else{
				//管理员，所有课程
				$cou_info = M('Course')->select();
			}

			$this->assign('cou_info',$cou_info);
			$this->display();
		}
	}

	function jud_dele(){
		if(!empty($_POST)){
			$ids = I('post.ids');
			$res = M('Ques_judge')->delete($ids);
			if($res){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	function jud_edit(){
		if(!empty($_POST)){
			$jud = new \Admin\Model\Ques_judgeModel();
			$jud->deal_jud_edit($_POST);
			$data = $jud->create();
			if($data){
				$res = $jud->save($data); 
				if($res !== false){
					$this->success('修改成功',U('Question/jud_showlist'));
				}else{
					$this->error('修改失败');
				}
			}else{
				$this->error($jud->getError());
			}
		}else{
			//下拉课程列表

			//判断角色
			$role_id = session('role_id');
			$uid = session('bg_id');
			if($role_id == 1){
				//教师，展现自己所教课程
				$course_ids = M('User')->field('course_ids')->find($uid);
				$course_ids = $course_ids['course_ids'];

				$cou_info = M('Course')->select($course_ids);
			}else{
				//管理员，所有课程
				$cou_info = M('Course')->select();
			}

			$this->assign('cou_info',$cou_info);
			//原有信息	
			$id = I('get.id');
			$jud = new \Admin\Model\Ques_judgeModel();
			$info = $jud->find($id);
			$info = $jud->jud_edit_original($info);
			$this->assign('info',$info);
			$this->display();
		}
	}

	function jud_import(){
		if(!empty($_FILES['jud_file']['name'])){
			$jud = new \Admin\Model\Ques_judgeModel();
			$all_path = $jud->deal_file($_FILES['jud_file']);
			if(!$all_path){
				$this->error('上传失败,请检查文件格式！');exit;
			}
		   //上传文件成功后的操作
		    $data = excelToArray($all_path);
		    //处理excel中生成的二维数据
		    $check_data = $jud->deal_file_data($data);
		    //错误时返回一个 一维的错误信息数组，正确时返回一个二维数组数据
		    //必须为字符 0 ,而不能是数字0！后者意味着找不到,就和前面的匹配了
		    if($check_data['status'] == '0'){ 
		    	$this->error($check_data['msg']);exit;
		    }
		    //最后无误将改造后的数组addall	
		    $res = $jud->addall($check_data);
		    if($res){
		    	$this->success('导入数据库成功');
		    }else{
		    	$this->error('导入数据库失败');
		    }
		}else{
			$this->error('未选择文件');
		}
	}

	// 主观题
	function sub_showlist(){
		$sub = new \Admin\Model\Ques_subjModel();

		//判断角色
		$role_id = session('role_id');
		$uid = session('bg_id');
		if($role_id == 1){
			//教师，展现自己所教课程的题目
			$course_ids = M('User')->field('course_ids')->find($uid);
			$course_ids = $course_ids['course_ids'];
			$data = $sub->where("course_id in($course_ids)")->select();
		}else{
			//管理员，所有课程的题展示
			$data = $sub->select();
		}

		$data = $sub->deal_sub_show($data);
		if(IS_AJAX){
			$this->ajaxReturn($data);
		}
		$this->display();
	}

	function sub_add(){
		if(!empty($_POST)){
			$sub = new \Admin\Model\Ques_subjModel(); 
			$data = $sub->create(); 
			if($data){
				$res = $sub->add($data);
				if($res){
					$this->success('添加成功',U('Question/sub_showlist'));
				}else{	
					$this->error('添加失败');
				}
			}else{
				$mess = $sub->getError();
				$this->error($mess);
			}
		}else{
			//课程信息

			//判断角色
			$role_id = session('role_id');
			$uid = session('bg_id');
			if($role_id == 1){
				//教师，展现自己所教课程
				$course_ids = M('User')->field('course_ids')->find($uid);
				$course_ids = $course_ids['course_ids'];

				$cou_info = M('Course')->select($course_ids);
			}else{
				//管理员，所有课程
				$cou_info = M('Course')->select();
			}

			$this->assign('cou_info',$cou_info);
			$this->display();
		}
	}

	function sub_dele(){
		if(!empty($_POST)){
			$ids = I('post.ids');
			$res = M('Ques_subj')->delete($ids);
			if($res){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	function sub_edit(){
		if(!empty($_POST)){
			$sub = new \Admin\Model\Ques_subjModel();
			$data = $sub->create();
			if($data){
				$res = $sub->save($data); 
				if($res !== false){
					$this->success('修改成功',U('Question/sub_showlist'));
				}else{
					$this->error('修改失败');
				}
			}else{
				$this->error($sub->getError());
			}
		}else{
			//下拉课程列表
			//判断角色
			$role_id = session('role_id');
			$uid = session('bg_id');
			if($role_id == 1){
				//教师，展现自己所教课程
				$course_ids = M('User')->field('course_ids')->find($uid);
				$course_ids = $course_ids['course_ids'];

				$cou_info = M('Course')->select($course_ids);
			}else{
				//管理员，所有课程
				$cou_info = M('Course')->select();
			}
			
			$this->assign('cou_info',$cou_info);
			//原有信息	
			$id = I('get.id');
			$sub = new \Admin\Model\Ques_subjModel();
			$info = $sub->find($id);
			$info = $sub->sub_edit_original($info);
			$this->assign('info',$info);
			$this->display();
		}
	}

	function sub_import(){
		if(!empty($_FILES['sub_file']['name'])){
			$sub = new \Admin\Model\Ques_subjModel();
			$all_path = $sub->deal_file($_FILES['sub_file']);
			if(!$all_path){
				$this->error('上传失败,请检查文件格式！');exit;
			}
		    //上传文件成功后的操作
		    $data = excelToArray($all_path);
		    //处理excel中生成的二维数据
		    $check_data = $sub->deal_file_data($data);
		    if($check_data['status'] == '0'){ 
		    	$this->error($check_data['msg']);exit;
		    }
		    $res = $sub->addall($check_data);
		    if($res){
		    	$this->success('导入数据库成功');
		    }else{
		    	$this->error('导入数据库失败');
		    }
		}else{
			$this->error('未选择文件');
		}
	}

	
}