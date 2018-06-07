<?php
namespace Home\Controller;
use Tools\HomeacceController;

class PaperController extends HomeacceController {

	function show(){
		$score = new \Home\Model\Stu_scoreModel();
		$sid = session('fg_id');

		//只筛选出答案已开放的试卷ids，给下面查询做条件
		$open_paper = M('Paper_basic')->field('id')->where("answ_status=1")->select();
		foreach ($open_paper as $k => $v) {
			$ids = $ids.$v['id'].',';
		}
		$ids = rtrim($ids,',');
		if($ids == ''){
			echo "<h2 align='center'>你还未参加过任何考试</h2>";exit;
		}

		//查询数据
		$score_info = M('Stu_score')->where("stu_id=$sid and paper_id in($ids)")->order('id desc')->select();
		$data = $score->deal_show($score_info);
		if(IS_AJAX){
			$this->ajaxReturn($data);
		}
		$this->display();
	}


	function detail(){

		$id = I('get.id','','int'); //试卷id
		$sid = session('fg_id'); //学生id
		$basic = new \Home\Model\Paper_basicModel();


		//核实看是否是该考生参加过的试卷(Stu_score中有记录才算是完成了考试)
		$res = M('Stu_score')->where("stu_id=$sid and paper_id=$id")->find();
		if(empty($res)){
			echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 你没有参加过此考试 ʕ•͓͡•ʔ</h1> ';
			exit;
		}

		//核实get的试卷id答案是否已经开放
		$res = M('Paper_basic')->field('answ_status')->find($id);
		if($res['answ_status'] == '0'){
			echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 此试卷答案还未开放 ʕ•͓͡•ʔ</h1> ';
			exit;
		}

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

		if(is_numeric($my_score['subj_score'])){
			//主观题每道题得分展示
			$each_ms = M('Stu_score')->where("paper_id=$id and stu_id=$sid")->field('each_ms')->find();
			$each_ms = explode(',', $each_ms['each_ms']);
			$this->assign('each_ms',$each_ms);
		}

		$this->display();
	}
	
}