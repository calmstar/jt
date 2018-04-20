<?php
namespace Admin\Controller;
use Tools\AccessController;

class TeacherController extends AccessController{

	function showlist(){
		$this->assign('i',1);
		$teac = M('User');
		$data = $teac->where('role_id=1')->select(); //教师roleid固定为1
		//课程名转化
		$cour = M('Course');
		for($i = 0; $i < count($data); $i++){
			$cour_info=$cour->field('name')->select($data[$i]['course_ids']);
			for ($k=0; $k < count($cour_info); $k++) { 
				$cou_name[$i] = $cou_name[$i]."，".$cour_info[$k]['name'];
			}
			$data[$i]['course_names'] = ltrim($cou_name[$i],'，');//中文逗号隔开
		}
		$this->assign('data',$data);
		$this->display();
	}

	function add(){
		if(!empty($_POST)){
			$teac = new \Admin\Model\UserModel();
			$data = $teac->create();
			if($data){
				$res = $teac->add_data($data);
				if($res){
					$this->success('添加成功',U('Teacher/showlist'));
				}else{	
					$this->error('添加失败');
				}
			}else{
				$mess = $teac->getError();
				$this->error($mess);
			}
		}else{
			//所有课程展示
			$cour_info = M('Course')->select();
			$this->assign('cour_info',$cour_info);
			$this->display();
		}
	}

	function isable(){
		if(!empty($_POST)){
			$post = I('post.');
			$user = M('User');
			$data = $user->field('status')->find($post['id']);
			if($data){
				if($data['status'] == 1){
					$post['status'] = 0;
					$res = $user->save($post);
					if($res){
						echo 2;
					}else{
						echo false;
					}
				}else{
					$post['status'] = 1;
					$res = $user->save($post);
					if($res){
						echo 1;
					}else{
						echo false;
					}
				}
			}else{
				echo false;
			}
		}
	}

	function reset(){
		if(!empty($_POST)){
			$post = I('post.');
        	$post['pwd'] = password_hash('123456',PASSWORD_BCRYPT);
			$res = M('User')->save($post);
			if($res){
				$this->success('重置成功');
			}else{
				$this->error('重置失败');
			}

		}
	}

	function dele(){
		if(!empty($_POST)){
			$post = I('post.');
			$ids = $_POST['ids'];
		}elseif(!empty($_GET)){
			$get = I('get.');
			$ids = $get['ids'];
		}
		$res = M('User')->delete($ids);
		if($res){
			$this->success('删除成功'); //删除成功跳回历史记录前一页并刷新?
		}else{
			$this->error('删除失败');
		}
	}

	function edit(){
		if(!empty($_POST)){
			$user = D('User');
			$data = $user->create();
			if($data){
				$res = $user->save_data($data);
				if($res !== false){
					$this->success('修改成功',U('Teacher/showlist'));
				}else{
					$this->error('修改失败');
				}
			}else{
				$this->error($user->getError());
			}
		}else{
			$get = I('get.');
			$info = M('User')->find($get['id']);
			//将course_ids分解成数组
			$have_courses = explode(',', $info['course_ids']);
			$this->assign('have_courses',$have_courses);
			$this->assign('info',$info);
			//所有课程展示
			$cour_info = M('Course')->select();
			$this->assign('cour_info',$cour_info);
			$this->display();
		}

	}


}