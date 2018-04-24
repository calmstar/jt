<?php
namespace  Admin\Controller;
use Tools\AccessController;

class StudentController extends AccessController{

	function showlist(){
		$this->assign('i',icount());
		$data = M('Stu')->select();
		$this->assign('data',$data);
		$this->display();
	}

	function add(){
		if(!empty($_POST)){
			
			$stu = D('Stu');
			$data = $stu->create();

			if($data){
				$res = $stu->add_data($data);
				if($res){
					$this->success('添加成功',U('Student/showlist'));
				}else{	
					$this->error('添加失败');
				}
			}else{
				$mess = $stu->getError();
				$this->error($mess);
			}
		}else{
			$this->display();
		}
	}

	function isable(){
		if(!empty($_POST)){
			$post = I('post.');
			$stu = M('Stu');
			$data = $stu->field('status')->find($post['id']);
			if($data){
				if($data['status'] == 1){
					$post['status'] = 0;
					$res = $stu->save($post);
					if($res){
						echo 2;
					}else{
						echo false;
					}
				}else{
					$post['status'] = 1;
					$res = $stu->save($post);
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
			$res = M('Stu')->save($post);
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
		$res = M('Stu')->delete($ids);
		if($res){
			$this->success('删除成功'); 
		}else{
			$this->error('删除失败');
		}
	}

	function edit(){
		if(!empty($_POST)){
			$stu = D('Stu');
			$data = $stu->create();
			if($data){
				$res = $stu->save($data); //无需处理
				if($res !== false){
					$this->success('修改成功',U('Student/showlist'));
				}else{
					$this->error('修改失败');
				}
			}else{
				$this->error($stu->getError());
			}
		}else{
			//原有信息
			$info = M('Stu')->find(I('get.id'));
			$this->assign('info',$info);
			$this->display();
		}

	}


}