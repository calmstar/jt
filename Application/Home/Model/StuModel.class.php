<?php
namespace Home\Model;
use Think\Model;

class StuModel extends Model{
	protected $_map = array(
		'stuNumber' => 'xuehao',
		'password' => 'pwd',
		'sid' => 'id',
		'phone' => 'telphone',
		'mail' => 'email',
	);

	protected $patchValidate = false; 
	protected $_validate = array(
		//字符映射过后的字段来验证而不是oldPass；
		// 说明先进行字符映射，后自动验证，最后进行非数据表字段过滤
		array('pwd','6,16','密码必须在6-16个字符内',0,'length'),
		//也可用来验证其他的表单字段
		array('checkPass','pwd','两次密码不一致',0,'confirm'),

		array('telphone','number','电话号码必须是纯数字',2),
		array('telphone','11','电话号码必须是11位数字',2,'length'),
		array('email','email','用户名邮箱格式不正确',2),

	);


	function deal_login($data){
		$res['status'] = 0;
		$where['xuehao'] = $data['xuehao'];
		$z = $this->where($where)->find();
		if($z){     
			if($z['status'] == 1){
				$res['info'] = '您已被管理员禁用';
				return $res;
			}
		    if(password_verify($data['pwd'], $z['pwd'])){
		        $log['lgip'] = get_client_ip();
		        $log['lgdate'] = time();
		        $log['sid'] = $z['id'];
		        //学生登录日志
                $zz = M('Stu_log')->add($log);
		        if($zz){
                    session('fg_id',$z['id']);
                    $res['status'] = 1;
		        	return $res;
		        }else{
		        	$res['info'] = '更新登录时间和IP出错';
		        	return $res;
		        }
		    }else{
		    	$res['info'] = '账号或密码错误';
		    	return $res;
		    }
		}else{
            $res['info'] = '账号未注册';
            return $res;
		}
	}

	function deal_import_basic($data){
        $url = "http://210.38.162.".$data['line'];

        $g = new \Tools\ZF($data['xuehao'], $data['pwd'], $url);
        $res = $g->login();

		if(!empty($res['name'])){
            $new['id'] = $data['id'];
            $new['xuehao'] = $data['xuehao'];
            $new['name'] = $res['name'];
            $new['college'] = $res['college'];
            $new['major'] = $res['major'];
            $new['stu_class'] = $res['class'];
		    $z = D('Stu')->save($new);
		    if($z !== false){
		    	return true;
		    }else{
		    	return false;
		    }
		}else{
			return false;
		}
	}

	function deal_pass($data){
		$res['status'] = 0;
		//验证旧密码
		$z = $this->field('pwd')->find($data['id']);
		if(password_verify($data['oldPass'], $z['pwd'])){
			$data['pwd'] = password_hash($data['pwd'],PASSWORD_BCRYPT);
			$zz = $this->save($data);
			if($zz){
				$res['status'] = 1;
				$res['info'] = '密码修改成功';
				return $res;
			}else{
				$res['info'] = '密码修改失败';
				return $res;
			}
		}else{
			$res['info'] = '原有密码输入错误';
			return $res;
		}
	}


}