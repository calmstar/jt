<?php
namespace Admin\Model;
use Think\Model;
class AuthorityModel extends Model{

	protected $_map = array(
		//映射规则：左边表单中name，右边数据表字段名
		'authID' => 'id',
		'authName' => 'name',
		'authPid' => 'pid',
		'authController' => 'auth_c',
		'authAction' => 'auth_a',
	);
	
	protected $patchValidate = false; //不开启批量验证，否则多个错误出现结果为array
	protected $_validate = array(
	    array('name','require','权限名称不能为空',0),
	    // array('name','/[\u4e00-\u9fa5]/','权限名称必须是中文',0,'regex'),
	    array('auth_c','/^[A-Za-z]+$/','权限控制器必须为英文',2,'regex'),  //2表示值为空时不验证
	    array('auth_a','/^[A-Za-z][A-Za-z_]*$/','权限操作方法必须以英文开头，其余只能为英文或下划线',2,'regex'),
	);

	function add_date($data){
		 //1 将当前所有的四条记录信息先插入，得到一个新的id值
		 $newid = $this->add($data);
		 //2 制作全路径：父类ID-新纪录ID
		 if($data['pid'] == 0){
		     $path = $newid;
		 }else{
		     $pinfo = $this->find($data['pid']);
		     $path = $pinfo['auth_path']."-".$newid;
		 }
		 //制作auth_level
		 $level = substr_count($path,'-');
		 
		$sql = "UPDATE jt_authority SET auth_path='$path',auth_level='$level' WHERE id='$newid'";
		$info = $this->execute($sql);
		return $info;
	}

	function save_date($data){
		$res = $this->save($data);//这里的$newid为它自身的ID不变
		//看数据是否改动
		if($res){
		    //1 制作全路径
		    if($data['pid'] == 0){
		        $path = $data['id'];
		    }else{
		        $pinfo = $this->find("{$data['pid']}");  //find括号里面的为id，寻找 这条记录父ID  为其他记录主ID的 记录
		        $path = $pinfo['auth_path']."-".$data['id'];
		    }
		    //2 制作level
		    $level = substr_count($path,'-');

	        $sql = "UPDATE jt_authority SET auth_path='$path',auth_level='$level' WHERE id='$data[id]'";
	        $info = $this->execute($sql);
		    return $info;
		}
		return $res;
	}

}