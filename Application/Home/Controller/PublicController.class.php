<?php
namespace Home\Controller;
use Think\Controller;

class PublicController extends Controller {

    public function login(){
    	if(!empty($_POST)){
    		$code = I('post.code');
    		$ver = new \Think\Verify();
			if($ver->check($code)){
	    		$stu = D('Stu');
	    		$data = $stu->field('xuehao,pwd')->create(); //完成字符映射,过滤非数据表字段
				$res = $stu->deal_login($data);

			}else{
				$res['status'] = 0;
				$res['info'] = '您输入的验证码错误';
			}
			$this->ajaxReturn($res);
    	}else{
    		$this->display();
    	}
      	
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
		session('fg_id',null);
		$this->redirect('login');
	}

	public function register(){
        $post = I('post.');
        if(!is_numeric($post['rnum']) || $post['rpwd'] == '' ){
            $this->error('输入内容有误');exit;
        }
        $z = M('Stu')->where('xuehao='.$post['rnum'])->find();
        if($z){
            $this->error('此账号已注册');
        }else{
            $line = $post['line'];
            $url = "http://210.38.162.$line";

            $g = new \Tools\ZF($post['rnum'], $post['rpwd'], $url);
            $res = $g->login();

            if($res['name'] == ''){
                $this->error('正方账号或密码错误');
            }else{
                $data['xuehao'] = $post['rnum'];
                $data['pwd'] = password_hash($post['rpwd'],PASSWORD_BCRYPT);
                $data['name'] = $res['name'];
                $data['college'] = $res['college'];
                $data['major'] = $res['major'];
                $data['stu_class'] = $res['class'];
                $data['rgdate'] = time();

                $zz = M('Stu')->add($data);
                if($zz){
                    $this->success('注册成功');
                }else{
                    $this->error('注册失败');
                }
            }
        }
    }

	function forgetpwd(){
		$post = I('post.');
		if(!is_numeric($post['fnumb']) || $post['fpwd'] == '' ){
            $this->error('输入内容有误');exit;
        }
		$z = M('Stu')->where('xuehao='.$post['fnumb'])->find();
		if(!$z){
			$this->error('此账号还未在本系统注册');
		}else{
			$_POST['xuehao'] = $post['fnumb'];
			$_POST['pwd'] = $post['fpwd'];
			$line = $post['line'];
			$url = "http://210.38.162.$line";

            $g = new \Tools\ZF($_POST['xuehao'], $_POST['pwd'], $url);
            $res = $g->login();

		    if($res['name'] == ''){
		    	$this->error('正方账号或密码错误');
		    }else{
		    	$data['id'] = $z['id'];
		    	$data['pwd'] = password_hash($_POST['pwd'],PASSWORD_BCRYPT);

		    	$zz = M('Stu')->save($data);
		    	if($zz){
		    		$this->success('重置密码成功');
		    	}else{
		    		$this->error('重置密码失败');
		    	}
		    }
		}
	}

    public function _empty(){
        $this->error('抱歉，访问的页面不存在','',5);
    }

    
}