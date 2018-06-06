<?php
namespace Admin\Controller;
use Tools\AccessController;

class RoleController extends AccessController{

	function showlist(){
		$data = M('Role')->select();
		$this->assign('i',icount());
		$this->assign('data',$data);
		$this->display();
	}

	function add(){
		if(IS_AJAX){
			$post = I('post.');
			$res = M('Role')->add($post);
			if($res){
				$num = M('Role')->count();
				$data['num'] = $num;
				$data['id'] = $res;
				$data['status'] = 1;
				$this->ajaxReturn($data);
			}else{
				$this->error('添加失败');
			}
		}
	}

	function edit(){
		if(IS_AJAX){
			$post = I('post.');
			//教师的id为1不可删除(后台验证)
			if(in_array(1,explode(',',$post['id']))){
				$this->error('编辑失败');;exit;
			}
			$res = M('Role')->save($post);
			if($res !== false){ //未改动数据提交也显示成功
				$this->success('编辑成功');
			}else{
				$this->error('编辑失败');
			}
		}
	}

	function dele(){
		if(IS_AJAX){
			$post = I('post.');
			//教师的id为1不可删除
			if(in_array(1,explode(',',$post['ids']))){
				$this->error('删除失败');;exit;
			}

			$res = M('Role')->delete($post['ids']);
			if($res){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	function distribute(){
		$get = I('get.');
		$id = $get['id'];
		$this->assign('id',$id); 
		//在distribute页面提交auth_id时，id会被覆盖，所以在其地址继续放id
	    $role = new \Admin\Model\RoleModel();
	    //所有可分配权限的遍历
	    $auth_infoA = D('Authority')->where('auth_level=0')->select();//父级
	    $auth_infoB = D('Authority')->where('auth_level=1')->select();//子级
	    $this->assign('auth_infoA',$auth_infoA);
	    $this->assign('auth_infoB',$auth_infoB);
	    //查询被分配权限的角色名称
	    $role_info = $role->field('name,auth_ids')->find($id);
	    $role_name = $role_info['name'];
	    $this->assign('role_name',$role_name);
	    //查询当前角色所拥有的权限，并默认勾上
	    $have_authids = $role_info['auth_ids'];
	    $have_authids = explode(',', $have_authids);
	    $this->assign('have_authids',$have_authids);
	    //分配权限
	    if($_POST){
	       $post = I('post.');
	       $res = $role->save_auth($id,$post);
	       if($res !== false ){
	           // $this->redirect('distribute',array('id'=>$id),2,'分配成功'); 
	       		$this->success('分配成功');exit;
	       }else{   
	       		$this->error('分配失败');exit;
	       }
	    }
	    $this->display();
	}



}