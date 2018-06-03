<?php
namespace Home\Controller;
use Tools\HomeacceController;

class PersonalController extends HomeacceController {

    public function show(){
    	$fg_id = session('fg_id');
    	$stu_info = M('stu')->find($fg_id);

        //登录次数
        $sql_num = "select count(*) as num from jt_stu_log group by sid having sid=$fg_id";
        $num = M()->query($sql_num);
        $stu_info['lg_num'] = $num[0]['num'];

        // 等于1时为首次登陆
        if($stu_info['lg_num'] > 1){
            // 该学生最大的登录时间
            $sql = "select max(lgdate) as mdate  from jt_stu_log where sid=$fg_id";
            $mdate = M()->query($sql);
            $mdate = $mdate[0]['mdate'];
            // 该学生次大的登录时间
            $sql2 = "select max(lgdate) as sdate  from jt_stu_log where sid=$fg_id and lgdate<$mdate";
            $sdate = M()->query($sql2);
            $sdate = $sdate[0]['sdate'];

            $log = M('Stu_log')->where("sid=$fg_id and lgdate=$sdate")->find();
            $stu_info['last_ip'] = $log['lgip'];
            $stu_info['last_lgdate'] = $log['lgdate'];

        } else {
            $stu_info['last_lgdate'] = ' ';
        }
    	$this->assign('stu_info',$stu_info);
    	
      	$this->display();
    }

    //重新从正方系统导入基础信息
    function import_basic(){
    	if(!empty($_POST['password'])){
    	    $line = $_POST['line'];
    		$stu = D('Stu');
    		$data = $stu->field('id,xuehao,pwd')->create();
    		$data['line'] = $line;
    		$res = $stu->deal_import_basic($data);
    		if($res){
    			$this->success('重新从正方系统导入成功');
    		}else{
    			$this->error('重新导入失败');
    		}
    	}else{
            $this->error('请输入正方密码');
		}
    }

    //修改密码
    function pass_info(){
    	if($_POST['oldPass'] != '' && $_POST['password'] != '' &&  $_POST['checkPass'] != ''){
    		$stu = D('Stu');
    		$data = $stu->field('id,pwd')->create();
    		if($data){
    			$data['oldPass'] = I('post.oldPass');
    			$res = $stu->deal_pass($data);
    			if($res['status'] == 1){
    				$this->success($res['info']);exit;
    			}else{
    				$this->error($res['info']);exit;
    			}
    		}else{
    			$this->error($stu->getError());exit;
    		}
    	}else{
            $this->error('请输入所有内容');
        }

    }

    //修改补充信息
    function extra_info(){
    	if($_POST['phone'] != '' || $_POST['mail'] != '' ){
    		$stu = D('Stu');
    		$data = $stu->field('id,telphone,email')->create();
            dump($data);
    		if($data){
    			$res = $stu->save($data);
    			if($res !== false){
    				$this->success('修改成功');exit;
    			}else{
    				$this->error('修改失败');exit;
    			}
    		}else{
    			$this->error($stu->getError());exit;
    		}
    	} else {
            $this->error('请至少填入一项内容进行修改');
        }
    }

    
}