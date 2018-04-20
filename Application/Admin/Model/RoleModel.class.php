<?php
namespace Admin\Model;
use Think\Model;

class RoleModel extends Model{

	function save_auth($roleid,$data){
	    //制作auth_ids
	    $auth_ids = implode(',',$data['authid']);     
	    //制作auth_ac
	    $authinfo = D('Authority')->select($auth_ids);
	    $s = "";
	    foreach($authinfo as $k => $v){
	        if(!empty($v['auth_c']) && !empty($v['auth_a'])){
	             $s .= $v['auth_c']."-".$v['auth_a'].",";
	        }
	    }
	    $s = rtrim($s,',');
	     

	    
	    $sql = "UPDATE jt_role SET auth_ids='$auth_ids',auth_ac='$s' WHERE id='$roleid' ";

	    $res = $this->execute($sql);
	    
	    return $res;
	}
}