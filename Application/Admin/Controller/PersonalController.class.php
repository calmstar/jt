<?php
namespace Admin\Controller;
use Tools\AccessController;

class PersonalController extends AccessController{
	
	function show(){
		$user_info = M('User')->find(session('bg_id'));
		if(session('role_id') == 0){
			$user_info['role_name'] = "超级管理员";
		}else{
			$role_name = M('Role')->field('name')->find(session('role_id'));
			$user_info['role_name'] = $role_name['name'];
		}

        $cou = M('Course')->field('name')->select($user_info['course_ids']);
        foreach ($cou as $k => $v) {
            $user_info['cou_name'] = $user_info['cou_name'].$v['name'].'--';
        }
        $user_info['cou_name'] = rtrim($user_info['cou_name'],'--');
		$this->assign('user_info',$user_info);
		$this->assign('last_ip',session('last_ip'));
		$this->assign('last_lgdate',session('last_lgdate'));

		$this->display();
	}

	function basic_info(){
		if(!empty($_POST)){
			$user = D('User');
			$data = $user->create();
			if($data){
				$res = $user->save($data);
				if($res !== false){
					$this->success('修改成功');
				}else{	
					$this->error('修改失败');
				}
			}else{
				$mes = $user->getError();
				$this->error($mes);
			}
		}
	}

	function pass_info(){
		if(!empty($_POST)){
			$user = D('User');
			$user->setid($_POST['uid']); //传递id给模板
			$data = $user->create();
			if($data){
				$res = $user->save_personal($data);
				if($res !== false){
					$this->success('修改成功');
				}else{	
					$this->error('修改失败');
				}
			}else{
				$mes = $user->getError();
				$this->error($mes);
			}
		}
	}


	function sys_info(){

		//用户学院分布
		$sql = "select count(1) as sum,college from jt_stu group by college";
		$data = M()->query($sql);
		$yhxyfb = D('Stu')->check_coll($data);
		$this->assign('yhxyfb',$yhxyfb);

		//数据统计
		$today = strtotime(date('Y-m-d',time()));
		//今日访问学生
		$sjtj['tod_view'] = M('Stu')->where("last_lgdate > $today")->count();
		//今日新增学生
		$sjtj['tod_add'] = M('Stu')->where("rgdate > $today")->count();
		//历史访问次数
		$sjtj['hist_all'] = M('Stu')->sum('lg_num'); 
		//教师
		$sjtj['tea_num'] = M('User')->where('role_id=1')->count();
		//管理员（包含超级管理员）
		$sjtj['adm_num'] = M('User')->where('role_id!=1')->count();
		//学生
		$sjtj['stu_num'] = M('Stu')->count();
		//课程
		$sjtj['cou_num'] = M('Course')->count();
		$this->assign('sjtj',$sjtj);


		//考试动态
		//今日开始考试  (开始日期必须小于明天0点，大于今天0点)
		$now = time();
		$tomorrow = $today + 86400;
		$ksdt['tod_ing'] = M('Paper_basic')->where("startdate<$tomorrow && startdate>$today")->count();
		// 今日截止考试  (结束日期必须小于明天0点，大于今天0点)
		$ksdt['tod_ed'] = M('Paper_basic')->where("enddate<$tomorrow && enddate>$today")->count();
		//共有试卷
		$ksdt['all_num'] = M('Paper_basic')->count();
		//今日新建试卷
		$ksdt['new_paper'] = M('Paper_basic')->where("create_date<$tomorrow && create_date>$today")->count();
		//已审核
		$ksdt['check'] = M('Paper_basic')->where("review_status=1")->count();
		$ksdt['non_check'] = M('Paper_basic')->where("review_status!=1")->count();
		//未开始
		$ksdt['soon'] = M('Paper_basic')->where("startdate>$now")->count();
		//已结束
		$ksdt['ed'] = M('Paper_basic')->where("enddate<$now")->count();
		//进行中
		$ksdt['ing'] = M('Paper_basic')->where("enddate>$now && startdate<$now")->count();
		//随机出卷
		$ksdt['random'] = M('Paper_basic')->where("type=1")->count();
		//指定出卷
		$ksdt['fixed'] = M('Paper_basic')->where("type=2")->count();
		$this->assign('ksdt',$ksdt);

		//试题信息
		//单选题
		$sin = M('Ques_single');
		$info_sin['all_num'] = $sin->count();
		$info_sin['show'] = $sin->where("is_show=1")->count();
		$info_sin['no_show'] = $sin->where("is_show=0")->count();
		$info_sin['easy'] = $sin->where("difficulty=1")->count();
		$info_sin['common'] = $sin->where("difficulty=2")->count();
		$info_sin['diff'] = $sin->where("difficulty=3")->count();
		$sql = "select name,count(*) as num from jt_ques_single qs join jt_course c on c.id=qs.course_id group by course_id ";
		$info_sin['table'] = $sin->query($sql);
		$this->assign('info_sin',$info_sin);
		//双选题
		$dou = M('Ques_double');
		$info_dou['all_num'] = $dou->count();
		$info_dou['show'] = $dou->where("is_show=1")->count();
		$info_dou['no_show'] = $dou->where("is_show=0")->count();
		$info_dou['easy'] = $dou->where("difficulty=1")->count();
		$info_dou['common'] = $dou->where("difficulty=2")->count();
		$info_dou['diff'] = $dou->where("difficulty=3")->count();
		$sql = "select name,count(*) as num from jt_ques_double qd join jt_course c on c.id=qd.course_id group by course_id ";
		$info_dou['table'] = $dou->query($sql);
		$this->assign('info_dou',$info_dou);
		//判断题
		$jud = M('Ques_judge');
		$info_jud['all_num'] = $jud->count();
		$info_jud['show'] = $jud->where("is_show=1")->count();
		$info_jud['no_show'] = $jud->where("is_show=0")->count();
		$info_jud['easy'] = $jud->where("difficulty=1")->count();
		$info_jud['common'] = $jud->where("difficulty=2")->count();
		$info_jud['diff'] = $jud->where("difficulty=3")->count();
		$sql = "select name,count(*) as num from jt_ques_judge qj join jt_course c on c.id=qj.course_id group by course_id ";
		$info_jud['table'] = $jud->query($sql);
		$this->assign('info_jud',$info_jud);
		//主观题
		$sub = M('Ques_subj');
		$info_sub['all_num'] = $sub->count();
		$info_sub['easy'] = $sub->where("difficulty=1")->count();
		$info_sub['common'] = $sub->where("difficulty=2")->count();
		$info_sub['diff'] = $sub->where("difficulty=3")->count();
		$sql = "select name,count(*) as num from jt_ques_subj qj join jt_course c on c.id=qj.course_id group by course_id ";
		$info_sub['table'] = $sub->query($sql);
		$this->assign('info_sub',$info_sub);

		//运行信息
		$yx['tp_ver'] = 'ThinkPHP'.THINK_VERSION; //tp版本号
		$yx['yuming'] = $_SERVER['SERVER_NAME'];  //当前域名
		$yx['ser_info'] = $_SERVER['SERVER_SOFTWARE'];  //服务器标示字符串
		$yx['mysql_ver'] = 'Mysql'.mysql_get_server_info(); //mysql版本
		$yx['os'] =  php_uname(); //系统类型及版本号

		$sql = "SELECT sum(DATA_LENGTH)+sum(INDEX_LENGTH) as size
				FROM information_schema.TABLES where TABLE_SCHEMA='jmooctest2' ";
  		$size = M()->query($sql);
  		//数据库大小，默认为以字节为单位，除1024为K，除1048576为M
  		$yx['size'] = ($size[0]['size']/1048576).'M';  

		$this->assign('yx',$yx);

		$this->display();
	}



}