<?php
namespace Admin\Controller;
use Tools\AccessController;

class AdminController extends AccessController{

	function showlist(){	
		$this->assign('i',1);
		$admin = M('User');
		//隐藏教师和超级管理员
		$data = $admin->where("role_id!=1 and role_id!=0")->select();
		//角色名字转换
		$role = M('Role');
		for($i = 0; $i < count($data); $i++){
			$role_name = $role->field('name')->find($data[$i]['role_id']);
			$data[$i]['role_name'] = $role_name['name'];
		}
		$this->assign('data',$data);
		$this->display();
	}

	function add(){
		if(!empty($_POST)){
			$admin = new \Admin\Model\UserModel();
			$data = $admin->create();
			if($data){
				$res = $admin->add_admin($data);
				if($res){
					$this->success('添加成功',U('Admin/showlist'));
				}else{	
					$this->error('添加失败');
				}
			}else{
				$mess = $admin->getError();
				$this->error($mess);
			}
		}else{
			//非教师角色展示
			$role_info = M('Role')->field('id,name')->where('id!=1')->select();
			$this->assign('role_info',$role_info);
			$this->display();
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


	function edit(){
		if(!empty($_POST)){
			$user = D('User');
			$data = $user->create();
			if($data){
				$res = $user->save($data); //无需处理
				if($res !== false){
					$this->success('修改成功',U('Admin/showlist'));
				}else{
					$this->error('修改失败');
				}
			}else{
				$this->error($user->getError());
			}
		}else{
			//原有信息
			$get = I('get.');
			$info = M('User')->find($get['id']);
			$this->assign('info',$info);
			$role = M('Role');
			//原本的角色名
			$role_name = $role->field('name')->find($info['role_id']);
			$this->assign('role_name',$role_name['name']);
			//下拉框所有角色信息
			$role_info = $role->select();
			$this->assign('role_info',$role_info);
			
			$this->display();
		}

	}



}