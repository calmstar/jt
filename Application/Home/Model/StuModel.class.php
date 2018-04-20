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
		//搜索数据库看看有没有这个学号,有就在本地进行验证，无则进行模拟登陆并抓取注册
		$where['xuehao'] = $data['xuehao'];
		$z = $this->where($where)->find();
		if($z){     

			//本地验证   
			if($z['status'] == 1){
				$res['info'] = '您已被管理员禁用';
				return $res;
			}
		    if(password_verify($data['pwd'], $z['pwd'])){

		        $ip = get_client_ip();
		        $timestamp = time(); 
		        $lg_num = $z['lg_num']+1;

		        //更改登录时间和ip还有 次数
		        $sql = "UPDATE jt_stu SET last_lgdate='$timestamp',last_ip='$ip',lg_num='$lg_num' WHERE id='$z[id]' ";
		        $zz = D()->execute($sql);
		        if($zz){
		        	//记录上次登录的信息，使用的是$z
		        	session('last_ip',$z['last_ip']);
		        	session('last_lgdate',$z['last_lgdate']);
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
		     //模拟登陆并抓取注册

			//与zhuaqu类保持统一变量
			$_POST['xuehao'] = $data['xuehao'];
			$_POST['pwd'] = $data['pwd'];

		    $url = 'http://210.38.162.117/default2.aspx'; //目标登录页面网址
		    $cookie = dirname(__FILE__).'/cookie_oschina.txt';  //许多网站会在一些需要登录后才能访问的页面进行设置，检查cookie数据是否存在
		    $zhuaqu = new \Tools\ZhuaQu($url,$cookie); 
		    $res = $zhuaqu -> login();

		    if(!empty($res['name'])){
		        $data = $data+$res;
		        $data['pwd'] = password_hash($data['pwd'],PASSWORD_BCRYPT);
		        $data['last_ip'] = get_client_ip();
		        $data['last_lgdate'] = time();                     
		        $data['rgdate'] = time();  
		        $data['lg_num'] = '1';                    
		        $id = D('Stu')->add($data);
		        if($id){
		        	$_SESSION['fg_id'] = $id;
		        	$res['status'] = 1;
		        }else{
		        	$res['info'] = '抓取的信息存入数据库失败';
		    		$res['status'] = 0;
		        }
		        return $res;
		    }else{
		    	$res['info'] = '正方账号或密码错误';
		    	$res['status'] = 0;
		    	return $res;
		    }            
		}

	}

	function deal_import_basic($data){
		$_POST = $data;
		//重新从正方系统导出，更新数据库
		$url = 'http://210.38.162.117/default2.aspx'; //目标登录页面网址
		$cookie = dirname(__FILE__).'/cookie_oschina.txt';  //许多网站会在一些需要登录后才能访问的页面进行设置，检查cookie数据是否存在
		$zhuaqu = new \Tools\ZhuaQu($url,$cookie);
		$res = $zhuaqu -> login();

		if(!empty($res['name'])){
		    $_POST = $_POST+$res;  
		    unset($_POST['pwd']);
		    $z = D('Stu')->save($_POST); 
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