<?php
namespace Home\Model;
use Think\Model;

//考生查询分数--show

class Stu_scoreModel extends Model{

	function deal_show($data){
		 
		$answ = M('Stu_answ');
		$basic = M('Paper_basic');
		$i = 1;
		foreach($data as $k => &$v){

			//将paper_id转化为paper_name
			$pname = $basic->field('name,type')->find($v['paper_id']);
			$v['paper_name'] = $pname['name'];
			$v['type'] = $pname['type'];

			//由于使用了引用赋值，所有上面生成的键，在下面可以直接使用
			//根据type得出是哪一种出题类型，存试卷总分到数组中
			if($v['type'] == 1){
				//随机出卷
				$xx = M('Paper_ques_random');
			}else{
				//指定出卷
				$xx = M('Paper_ques_fixed');
			}
			$whole = $xx->field('whole_score,sub_score')->where("paper_id=$v[paper_id]")->find();
			$v['whole_score'] = $whole['whole_score'];

			//主观题三种状态判断，
			//mark_status为0时要么未批改，要么没有这种题，为1时说明有且批改了，直接显示分数
			if($v['mark_status'] == 0){
				$v['subj_score'] = '<span class="badge badge-info">未批改</span>';

				//通过paper_ques_fixed 或者 paper_ques_random 中的sub_score来判断
				//直接使用上面已经判断过的  $xx里面的$whole
				if($whole['sub_score'] == 0){
					//试卷信息里如果主观题的分数为0，则说明没有出这种类型题
					$v['subj_score'] = '<span class="badge badge-danger">无此题目类型</span>';
				}
			}

			//开始考试时间$stime存过来
			$stime = $answ->where("stu_id={$v['stu_id']} and paper_id=$v[paper_id]")->field('stime,etime')->find();
			$v['stime'] = date('Y-m-d H:i:s',$stime['stime']);
			$v['etime'] = date('Y-m-d H:i:s',$stime['etime']);//detail中用

			// 存序号
			$v['xh'] = $i++;

		}
		unset($v);

		return $data;
	}


	//---------考生查看自己的试卷,check中考生答案--detail----

	function deal_myansw($answ_info,$ques_info){

		$sin_answ = explode(',',$answ_info['single_answ']);
		$dou_answ = explode(',',$answ_info['double_answ']);
		$jud_answ = explode(',',$answ_info['judge_answ']);
		$sub_answ = explode('@%@',$answ_info['subj_answ']);

		foreach($ques_info['sin'] as $k => &$v){
			$v['myansw'] = $sin_answ[$k];
		}
		unset($v);

		foreach($ques_info['dou'] as $k => &$v){
			//双选题再进行拆分成二维数组存入
			$v['myansw'] = explode('-', $dou_answ[$k]);
		}
		unset($v);

		foreach($ques_info['jud'] as $k => &$v){
			$v['myansw'] = $jud_answ[$k];
		}
		unset($v);

		foreach($ques_info['sub'] as $k => &$v){
			$v['myansw'] = $sub_answ[$k];
		}
		unset($v);

		return $ques_info;
	}


}