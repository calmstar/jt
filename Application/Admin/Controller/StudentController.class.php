<?php
namespace  Admin\Controller;
use Tools\AccessController;

class StudentController extends AccessController{

	function showlist(){
		$this->assign('i',icount());
		$data = M('Stu')->order('id desc')->select();
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

	function import () {
        if(!empty($_FILES['stu_file']['name'])){
            $stu = new \Admin\Model\StuModel();
            $all_path = $stu->deal_file($_FILES['stu_file']);
            if(!$all_path){
                $this->error('上传失败,请检查文件格式！');exit;
            }

            //上传文件成功后的操作
            $data = excelToArray($all_path);
            //处理excel中生成的二维数据
            $check_data = $stu->deal_file_data($data);

            if($check_data['status'] == '0'){
                $this->error($check_data['msg']);exit;
            }
            //最后无误将改造后的数组addall
            $res = $stu->addall($check_data);
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