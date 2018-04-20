<?php
namespace Admin\Model;
use Think\Model;

class UserModel extends Model{
	protected $_map = array(
		'uid' => 'id',
		'mail' => 'email',
		'password' => 'pwd',
		'username' => 'name',
		'roleid' => 'role_id',
		'phone' => 'telphone',
		'course' => 'course_ids',

	);

	protected $patchValidate = false; //不开启批量验证，否则多个错误出现结果为array
	protected $_validate = array(
		//共用一个自动验证，所以考虑 修改和添加，（值不为空验证）
		array('email','require','用户名邮箱必须'),
		array('email','email','用户名邮箱格式不正确'),
		// 在新增的时候验证email字段是否唯一 (,,如下已足够)
		array('email','','邮箱已存在',0,'unique'),
		//修改的时候验证email是否唯一,
		// array('email','check_email','邮箱已存在',0,'callback',2),

		array('pwd','6,16','密码必须在6-16个字符内',0,'length'),
		//也可用来验证其他的表单字段
		array('checkPass','require','确认密码不能为空'), 
		array('checkPass','pwd','两次密码不一致',0,'confirm'),
		//个人信息中修改密码
		array('oldPass','check_oldPass','现有密码输入错误',0,'callback'),

		array('name','require','名字必须填写'),
		array('name','1,5','名字必须在5个字符内',0,'length'),
		//字段不为空时验证
		array('telphone','number','电话号码必须是纯数字',2),
		array('telphone','11','电话号码必须是11位数字',2,'length')
	);

	//自定义，为了解决下面check_oldPass方法无法同时传入两个字段值的问题
	private $id;
	function setid($id){
	    $this->id = $id;
	}
	//个人资料修改密码调用
	function check_oldPass($oldPass,$id){
		$id = $this->id;
		$pwd = $this->field('pwd')->find($id);
		if(password_verify($oldPass,$pwd['pwd'])){
			return true; //返回true不执行
		}else{
			return false; //返回false上面执行
		}
	}

	//以下为教师的添加和修改
	function add_data($data){
        $data['pwd'] = password_hash($data['pwd'],PASSWORD_BCRYPT);
	    $data['rgdate'] = time();
	    $data['course_ids'] = implode(',',$data['course_ids']);
        return $this->add($data);
	}

	function save_data($data){
		$data['course_ids'] = implode(',',$data['course_ids']);
		return $this->save($data);
	}

	//管理员
	function add_admin($data){
		$data['pwd'] = password_hash($data['pwd'],PASSWORD_BCRYPT);
		$data['rgdate'] = time();
		return $this->add($data);
	}

	//个人资料
	function save_personal($data){
		$data['pwd'] = password_hash($data['pwd'],PASSWORD_BCRYPT);
		return $this->save($data);
	}



}