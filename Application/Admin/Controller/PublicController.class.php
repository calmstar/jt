<?php
namespace Admin\Controller;
use Think\Controller;
//use Tools\AccessController;

class PublicController extends Controller {

	function login(){
		if(IS_AJAX){
            $post = I('post.');
			$ver = new \Think\Verify();
			if($ver->check($post[code])){			
				$data = M('User')->where("email='$post[mail]'")->find();
				if(password_verify($post[password],$data[pwd])){
					if($data['status'] == 0){
						$this->error('此账号已禁用，请与管理员联系');exit;
					}	
					session('bg_id',$data['id']);
					session('role_id',$data['role_id']);
					//先记录上次登录的信息
					session('last_ip',$data['last_ip']);
					session('last_lgdate',$data['last_lgdate']);
					//更改登录时间和ip
					$user = M('User');
					$user->id = $data['id'];
					$user->last_lgdate = time();
					$user->last_ip = get_client_ip();
					$user->save();
					$this->success('登录成功');exit;
				}else{
					$this->error("用户邮箱或密码错误");exit;
				}
			}else{
				$this->error('您输入的验证码错误');exit;
			}
		}
        $this->display();
	}

	function verifyImg(){
		$cfg = array(
			'imageH' => 33,
            'imageW' => 120,
            'fontSize' => 18,
            'length' => 4,
            'fontttf' => '4.ttf',
		);
		$ver = new \Think\Verify($cfg);
		$ver->entry();
	} 

	function loginout(){
		session('bg_id',null);
		$this->redirect('login');
	}

    public function _empty () {
        $this->error('页面出错','',5);
    }

}