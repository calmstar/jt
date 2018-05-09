<?php
namespace Home\Controller;
use Tools\HomeacceController;

class TestController extends HomeacceController {

	function show(){
		$paper = new \Home\Model\Paper_basicModel();
		$now = time();

		// 进行中
		$start_info = $paper->where("startdate < $now and enddate > $now and  review_status=1")->order('id desc')->select();
		$start_info = $paper->deal_maker($start_info);
		$this->assign('start_info',$start_info);

		// 待开始
		$wait_info = $paper->where("startdate > $now and review_status=1")->order('id desc')->limit(6)->select();
		$wait_info = $paper->deal_maker($wait_info);
		$this->assign('wait_info',$wait_info);

		// 已结束
		$end_info = $paper->where("enddate < $now and review_status=1")->order('id desc')->limit(6)->select();
		$end_info = $paper->deal_maker($end_info);
		$this->assign('end_info',$end_info);

		$this->display();
	}


	function exam(){

		if(IS_AJAX){
			$post = I('post.');
			$id = $post['paper_id'];
			$sid = session('fg_id');

			//防止考生双开题目页面窗口，一个页面提交完成考试，另一个页面还在缓存答案
			//判断当前学生是否考过本试卷
			$res = M('Stu_score')->where("paper_id=$id and stu_id=$sid")->find();
			if($res){
				echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 你已参加过本场考试 ʕ•͓͡•ʔ</h1> ';
				exit;
			}
			
			$answ = new \Home\Model\Stu_answModel(); 
			$post = $answ->fill_blank($post);
			$myansw = $answ->deal_save_answ($post,1);//1代表 保存考生答卷 时调用此方法

			//采用 jt_stu_answ_cache 来暂存考生答案
			unset($myansw['etime']);
			$z = D('Stu_answ_cache')->where("paper_id=$id and stu_id=$sid")->find();
			if(!$z){
				//第一次保存该考生答案
				$myansw['stu_id'] = $sid;
				$myansw['paper_id']	= $id;
				D('Stu_answ_cache')->add($myansw);
			}else{
				//非第一次保存
				D('Stu_answ_cache')->where("paper_id=$id and stu_id=$sid")->save($myansw);
			}
			exit;
		}


		$id = I('get.id','','int'); //试卷id
		$sid = session('fg_id'); //学生id
		$basic = new \Home\Model\Paper_basicModel();

		//判断试卷id是否为进行中的考试
		$now = time();
		$res = M('Paper_basic')->field('startdate,enddate,review_status')->find($id);
		if($res['startdate']>$now || $res['enddate']<$now || $res['review_status']==0){
			echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 不是进行中的考试或试卷未审核ʕ•͓͡•ʔ</h1> ';
			exit;
		}

		//判断学生是否符合该试卷限制对象的条件
		$res = $basic->check_limit_obj($id);
		if($res['status'] == 0){
			$this->error($res['msg']);exit;
		}

		//判断当前学生是否考过本试卷
		$res = M('Stu_score')->where("paper_id=$id and stu_id=$sid")->find();
		if($res){
			echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 你已参加过本场考试 ʕ•͓͡•ʔ</h1> ';
			exit;
		}

		//当前学生忘记提交，再回来考试，判断当前时间有没有超过考试规定时间
		$answ = new \Home\Model\Stu_answModel();
		$xx['paper_id'] = $id;
		$res = $answ->check_finish($xx); //与原方法参数相符
		if(!$res){
			echo ' <h1 style="width:600px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 无法进入试卷，考试时间已用完，已为你自动提交 ʕ•͓͡•ʔ</h1> ';
			exit;
		}


		// 查询基本信息
		$basic_info = $basic->find($id);
		$basic_info = $basic->deal_basic($basic_info);

		// 判断组卷类型
		if($basic_info['type'] == 1){
			//随机出卷，得出试题信息
			
			$random_info = M('Paper_ques_random')->where("paper_id=$id")->find();
			
			//判断是否已为该考生生成过试卷，防止考生刷新，再生成一份随机试卷
			$z = M('Stu_paper')->where("paper_id=$id and stu_id=$sid")->find();
			if(!$z){
				//paper_ques_random ,根据要求参数，随机乱序获得各类题目id字符串
				$stu_ques = $basic->get_random_ques($random_info);
				//add两张表
				//存入stu_paper中
				$stu_ques['paper_id'] = $id;
				$stu_ques['stu_id'] = $sid;
				$res = M('Stu_paper')->add($stu_ques);
				if(!$res){
					$this->error('试题存入到学生试卷中失败,请重试');exit;
				}

				//存入stu_answ中，必须两个都能同时存入---事务
				$stu_ques['stime'] = time();
				$res = M('Stu_answ')->add($stu_ques);
				if(!$res){
					$this->error('开始时间 存入到学生答卷中失败,请重试');exit;
				}

			}else{
				$stu_ques = $z;
			}
			//与下面出卷统一
			$score_info = $random_info;

		}else{

			$fixed_info = M('Paper_ques_fixed')->where("paper_id=$id")->find();

			//判断是否已为该考生生成过试卷，防止考生刷新，再生成一份随机试卷
			$z = M('Stu_paper')->where("paper_id=$id and stu_id=$sid")->find();
			if(!$z){
				//生成试卷
				// 指定出卷，得出试题信息
				
				//paper_ques_fixed ,随机乱序获得 各类题目id字符串
				$stu_ques = $basic->get_fixed_ques($fixed_info);
				//add两张表
				//存入stu_paper中
				$stu_ques['paper_id'] = $id;
				$stu_ques['stu_id'] = $sid;
				$res = M('Stu_paper')->add($stu_ques);
				if(!$res){
					$this->error('试题存入到学生试卷中失败,请重试');exit;
				}

				//存入stu_answ中，必须两个都能同时存入---事务
				$stu_ques['stime'] = time();
				$res = M('Stu_answ')->add($stu_ques);
				if(!$res){
					$this->error('开始时间 存入到学生答卷中失败,请重试');exit;
				}

			}else{
				// 取出考生试卷，各种类型题id
				$stu_ques = $z;
			}
			//与随机出卷统一
			$score_info = $fixed_info;
		}

//        根据stu_paper表中的id依次展示数据

		//根据各种类型题id，获得试题信息,并负责计算各题个数
		$ques_info = $basic->get_ques_info($stu_ques);

		//使用stu_answ_cache表来暂存答案数据
		$sss = D('Stu_answ_cache')->where("stu_id=$sid and paper_id=$id")->find();
		if(!empty($sss)){
			$myansw = $sss;
			//得到考生答案data和试题信息集成在一起，方便循环输出
			$score = new \Home\Model\Stu_scoreModel();
			$ques_info = $score->deal_myansw($myansw,$ques_info);
		}

		//所有信息结合在一起，进行assign
		$info = array_merge($score_info,$basic_info,$ques_info);

		// 选项随机排列
		$n = range(1,4);
		shuffle($n);
		$this->assign('n',$n); //所有题目一样乱序，每刷新一次不同位置

		$this->assign('info',$info);
		$this->assign('i',1);


		//给倒计时提供数据
		$stime = M('Stu_answ')->field('stime')->where("paper_id=$id and stu_id=$sid")->find();
		$stime = $stime['stime'];

		$limittime = $info['limittime'] * 60;
		$resttime = $limittime - ( time()-$stime );
		$this->assign('resttime',$resttime); //得到剩余时间戳

		$this->display();
	}


	function answ(){

		if(!empty($_POST)){
			
			$answ = new \Home\Model\Stu_answModel();
			$post = I('post.');

			//18.4.24改进：只依赖paper_id求出各类型题分数和数量，而不依赖页面上的隐藏域表单
            $paperid = $post['paper_id'];
            $type = M('Paper_basic')->field('type')->find($paperid);
            if ($type['type'] == 1) {
                //随机出卷
                $random = M('Paper_ques_random')->where("paper_id = $paperid")->find();
                //分数
                $post['sin_score'] = $random['sin_score'];
                $post['dou_score'] = $random['dou_score'];
                $post['jud_score'] = $random['jud_score'];
                //数量
                $post['sin_num'] = $random['sin_easy_num'] + $random['sin_com_num'] + $random['sin_diff_num'];
                $post['dou_num'] = $random['dou_easy_num'] + $random['dou_com_num'] + $random['dou_diff_num'];
                $post['jud_num'] = $random['jud_easy_num'] + $random['jud_com_num'] + $random['jud_diff_num'];
                $post['sub_num'] = $random['sub_easy_num'] + $random['sub_com_num'] + $random['sub_diff_num'];

            } else {
                //指定出卷
                $fixed = M('Paper_ques_fixed')->where("paper_id = $paperid")->find();
                //分数
                $post['sin_score'] = $fixed['sin_score'];
                $post['dou_score'] = $fixed['dou_score'];
                $post['jud_score'] = $fixed['jud_score'];
                //数量
                $post['sin_num'] = substr_count($fixed['limit_sin'], ',')+1;
                $post['dou_num'] = substr_count($fixed['limit_dou'], ',')+1;
                $post['jud_num'] = substr_count($fixed['limit_jud'], ',')+1;
                $post['sub_num'] = substr_count($fixed['limit_sub'], ',')+1;
            }

			//提交时间检验，防止超时提交，禁用js下后端判断
			$res = $answ->check_finish($post);
			if(!$res){
				echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 无法提交试卷，你已超时提交 ʕ•͓͡•ʔ</h1> ';
				exit;
			}

			// 防止重复提交判断
			$res = $answ->check_post($post);
			if($res){
				echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 无法重复提交 ʕ•͓͡•ʔ</h1> ';
				exit;
			}

			//开始处理
			$sid = session('fg_id');
			$paperid = $post['paper_id'];

			//进行数据填充,并将post数据按各类型题目分割
			$post = $answ->fill_blank($post);

			$answ_kinds = $answ->split_kinds_answ($post);

			//获得stu_paper中的各类题目id字符串
			$sp_info = M('Stu_paper')->where("stu_id=$sid and paper_id=$paperid")->find();

			//处理单选题,获得做对题目的个数
			$right_sin = $answ->deal_sin_answ($sp_info['single_ids'],$answ_kinds['sin']);

			$right_dou = $answ->deal_dou_answ($sp_info['double_ids'],$answ_kinds['dou']);

			$right_jud = $answ->deal_jud_answ($sp_info['judge_ids'],$answ_kinds['jud']);

			//stu_score 计算分数单 双 判 题的分数，并存入数据库中
			$res = $answ->deal_add_score($post,$right_sin,$right_dou,$right_jud);
			if(!$res){
				$this->error('考生分数提交失败，请重新提交或与管理员联系');exit;
			}

			//stu_answ,将该表里其他字段值save进去
			//去除答案中is_op字符，只留下数字
			//0代表 考生提交试卷 时调用此方法
			$res = $answ->deal_save_answ($post,0);
			if(!$res){
				$this->error('考生答案提交失败，请与管理员联系');exit;
			}else{

				//各项数据都提交成功，删除考生临时答题表
				M('Stu_answ_cache')->where("stu_id=$sid and paper_id=$paperid")->delete();

				echo ' <h1 style="width:600px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 试卷提交成功，请关闭此页面 ʕ•͓͡•ʔ</h1> ';
				exit;
			}
		}

	}


}