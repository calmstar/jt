<?php
namespace Admin\Controller;
use Tools\AccessController;

class AnalyzeController extends AccessController{

	function showlist(){

		$score = new \Admin\Model\Stu_scoreModel();
		$role_id = session('role_id');
		$uid = session('bg_id');

		if($role_id == 1){
			// 教师，只能看见自己出的试卷

			//通过maker_id找到相应的paper_id
			$ids = M('Paper_basic')->field('id')->where("maker_id=$uid")->select();
			foreach ($ids as $k => $v) {
				$id .= $v['id'].','; 
			}
			$paper_ids = rtrim($id,',');
			if($paper_ids == ''){
				echo "<h2 align='center'>你还未创建试卷</h2>";exit;
			}
			$s_info = $score->field("paper_id,max(all_score) as high,min(all_score) as low,avg(all_score) as aver,count(*) tested_num")->group('paper_id')->where("paper_id in ($paper_ids) ")->select();

		}else{
			//管理员
			//最高分 最低分 平均分  交卷人数
			$s_info = $score->field("paper_id,max(all_score) as high,min(all_score) as low,avg(all_score) as aver,count(*) tested_num")->group('paper_id')->select();
		}

		// 所有paper_id 已固定 通过paper_id查出 试卷名字 和 试卷总分
		$i = 1;
		foreach ($s_info as $k => &$v) {
			$p_info = $score->get_score($v['paper_id']);
			$v['paper_name'] = $p_info['paper_name'];
			$v['whole_score'] = $p_info['whole_score'];
			$v['xh'] = $i;
			$i++;
		}
		unset($v);

		//优秀 及格 良好率
		$data = $score->get_rate($s_info);

		if(IS_AJAX){
			$this->ajaxReturn($data);
		}

		$this->display();
	}


	function stu_list(){
		$pid = I('get.paper_id');
		$this->assign('paper_id',$pid); //此列表每个学生都是考同一张试卷
        //试卷名称
        $name = M('Paper_basic')->field('name')->find($pid);
        $this->assign('name',$name['name']);

		$score = new \Admin\Model\Stu_scoreModel();

		$info = M('Stu_score')->where("paper_id=$pid")->select();
		$info = $score->mix_stuinfo($info);

		if(IS_AJAX){
			$this->ajaxReturn($info);
		}
		
		$this->display();
	}


	function see_paper(){

		$sid = I('get.stu_id');
		$id = I('get.paper_id'); 

		// 检验paper_id
		$score = new \Admin\Model\Stu_scoreModel();
		$role_id = session('role_id');
		if($role_id == 1){
			$score->check_pid($id);
		}

		//调用前台Model
		$basic = new \Home\Model\Paper_basicModel();

		// 查询 基本 信息
		$basic_info = $basic->find($id);
		$basic_info = $basic->deal_basic($basic_info);

		// 判断组卷类型,得出 分数 信息
		if($basic_info['type'] == 1){
			//随机出卷，得出试题信息
			$score_info = M('Paper_ques_random')->where("paper_id=$id")->find();
		}else{
			//指定出卷
			$score_info = M('Paper_ques_fixed')->where("paper_id=$id")->find();
		}

		//根据各种类型题id，获得 试题 信息,并负责计算 各题个数
		$stu_ques = M('Stu_paper')->where("paper_id=$id and stu_id=$sid")->find();
		$ques_info = $basic->get_ques_info($stu_ques);
		
		// -----上面试卷试题基本信息输出完毕，下面为考生信息输出------

		//考生答案:checked中，将answ_info添加进ques_info中
		$score = new \Home\Model\Stu_scoreModel();
		$answ_info = M('Stu_answ')->where("stu_id=$sid and paper_id=$id")->find();
		$ques_info = $score->deal_myansw($answ_info,$ques_info);

		// 考生分数展示
		$my_score = M('Stu_score')->where("stu_id=$sid and paper_id=$id")->select();
		$my_score = $score->deal_show($my_score); //重用上文show方法，仍是二维
		$my_score = $my_score[0]; //变成一维
		$this->assign('my_score',$my_score); //不整合到info中

		//所有信息结合在一起，进行assign
		$info = array_merge($score_info,$basic_info,$ques_info);

		$this->assign('info',$info);
		$this->assign('i',1);

		//批改了，才显示各主观题得分
		if(is_numeric($my_score['subj_score'])){
			//主观题每道题得分展示
			$each_ms = M('Stu_score')->where("paper_id=$id and stu_id=$sid")->field('each_ms')->find();
			$each_ms = explode(',', $each_ms['each_ms']);
			$this->assign('each_ms',$each_ms);
		}
		
		// 考生个人信息
        $stu_info = M('Stu')->field('xuehao,name,college,stu_class,telphone,email')->find($sid);
		$this->assign('stu_info',$stu_info);
		
		$this->display();
	}


	function export(){

		$score = new \Admin\Model\Stu_scoreModel();

		//得到前台以get方式传输过来的paper json信息
		$get = I('get.info');
		$get = htmlspecialchars_decode($get); //由于部分字符被转义会出错
		$get = json_decode($get); //得到的get是一个对象
		

		//得到data
		$data = $score->match_pinfo($get);

		$table_head = array('试卷名称','参加总人数','最高分','最低分','平均分','试卷总分','不及格率','良好率','优秀率');


		//查询该试卷的考生信息
		$pid = $get->paper_id;
		$info = M('Stu_score')->where("paper_id=$pid")->select();
		$info= $score->mix_stuinfo($info);
		//得到data2
		$data2 = $score->match_sinfo($info);

		$table_head2 = array( '考生学号','考生名字','考生所在班级','所得总分','单选题得分','多选题得分','判断题得分','主观题得分');
		
		export_excel($data, $table_head,$data2, $table_head2);

	}


	//图形分析
	function graph(){
		
	}




}