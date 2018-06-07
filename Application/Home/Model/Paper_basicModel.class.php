<?php
namespace Home\Model;
use Think\Model;

//考生进入考试页面 

class Paper_basicModel extends Model{

	function deal_maker($data){
		$user = M('User');
		foreach($data as $k =>&$v){
			$maker_name = $user->field('name')->find($v['maker_id']);
			$v['maker_name'] = $maker_name['name'];
		}
		//去掉最后一个数据的 & 符号
		unset($v);
		return $data;
	}

	function check_limit_obj($paperid){
		//获取学生信息
		$sid = session('fg_id');
		$stu_info = M('Stu')->field('xuehao,stu_class')->find($sid);

		//获得试卷限制班级，学号
		$limit_info = M('Paper_limit')->where("paper_id=$paperid")->find();

		if($limit_info['limit_class'] != ''){
			//校验班级
			$limit_class = explode('+',$limit_info['limit_class']);
			if(!in_array($stu_info['stu_class'], $limit_class)){
				$info['status'] = 0;
				$info['msg'] = '你不在本次考试所在的班级里';
				return $info;
			}
		}

		if($limit_info['limit_stu_status'] == 1){
			//校验学号
			$xuehao = $stu_info['xuehao'];
			$z = M('Paper_limit_stu')->where("paper_id=$paperid and limit_xh=$xuehao")->find();
			if(!$z){
				$info['status'] = 0;
				$info['msg'] = '你不在本次考试所在的名单里';
				return $info;
			}
		}	

		$info['status'] = 1;
		return $info;
	}


	function deal_basic($data){
		//maker_id 和 course_id转化为 maker_name  course_name
		//一维数组不可调用上面方法
		$course_name = M('Course')->field('name')->find($data['course_id']);
		$data['course_name'] = $course_name['name'];
		$maker_name = M('User')->field('name')->find($data['maker_id']);
		$data['maker_name'] = $maker_name['name'];

		return $data;
	}

	function get_random_ques($data){
		//通过paper_id获得course_id,进而得到对应课程的题目id
		$course = M('Paper_basic')->field('course_id')->find($data['paper_id']);
		$cid = $course['course_id'];

		//单选题
		$sin_easy_ids = $this->get_random_ids($cid,$data['sin_easy_num'],'Ques_single',1);
		$sin_com_ids = $this->get_random_ids($cid,$data['sin_com_num'],'Ques_single',2);
		$sin_diff_ids = $this->get_random_ids($cid,$data['sin_diff_num'],'Ques_single',3);
		
		$stu_ques['single_ids'] = $this->merge_ids($sin_easy_ids,$sin_com_ids,$sin_diff_ids);

		//双选题
		$dou_easy_ids = $this->get_random_ids($cid,$data['dou_easy_num'],'Ques_double',1);
		$dou_com_ids = $this->get_random_ids($cid,$data['dou_com_num'],'Ques_double',2);
		$dou_diff_ids = $this->get_random_ids($cid,$data['dou_diff_num'],'Ques_double',3);

		$stu_ques['double_ids'] = $this->merge_ids($dou_easy_ids,$dou_com_ids,$dou_diff_ids);

		//判断题 
		$jud_easy_ids = $this->get_random_ids($cid,$data['jud_easy_num'],'Ques_judge',1);
		$jud_com_ids = $this->get_random_ids($cid,$data['jud_com_num'],'Ques_judge',2);
		$jud_diff_ids = $this->get_random_ids($cid,$data['jud_diff_num'],'Ques_judge',3);

		$stu_ques['judge_ids'] = $this->merge_ids($jud_easy_ids,$jud_com_ids,$jud_diff_ids);

		//主观题
		$sub_easy_ids = $this->get_random_ids($cid,$data['sub_easy_num'],'Ques_subj',1);
		$sub_com_ids = $this->get_random_ids($cid,$data['sub_com_num'],'Ques_subj',2);
		$sub_diff_ids = $this->get_random_ids($cid,$data['sub_diff_num'],'Ques_subj',3);

		$stu_ques['subj_ids'] = $this->merge_ids($sub_easy_ids,$sub_com_ids,$sub_diff_ids);

		return $stu_ques;
 	}


 	function merge_ids($easy,$com,$diff){

 		if($easy == '' && $com != '' && $diff != ''){
 			$all_ids = $com.','.$diff;
 		}elseif($easy != '' && $com == '' && $diff != ''){
 			$all_ids = $easy.','.$diff;
 		}elseif($easy != '' && $com != '' && $diff == ''){
 			$all_ids = $easy.','.$com;
 		}elseif($easy == '' && $com == '' && $diff != ''){
 			$all_ids = $diff;
 		}elseif($easy != '' && $com == '' && $diff == ''){
 			$all_ids = $easy;
 		}elseif($easy == '' && $com != '' && $diff == ''){
 			$all_ids = $com;
 		}elseif($easy == '' && $com == '' && $diff == ''){
 			$all_ids = '';
 		}else{
 			$all_ids = $easy.','.$com.','.$diff;
 		}
 		return $all_ids;

 	}


 	function get_random_ids($cid,$ques_num,$table,$diff){

 		if($ques_num != 0){
 			$num = $ques_num;

            //随机题目筛选要求：①符合所选课程题目 ② 属性为‘没有在练习题中展示’  ③ 各难度的题目数量 和 所填符合
            $ques = M("$table")->field('id')->where("course_id=$cid and is_show=0 and difficulty=$diff")->select();

 			//化为一维数组
 			foreach($ques as $k => $v){
 				$se[] = $v['id'];
 			}

 			// 随机出卷，实际可获得的试题数小于要求数
 			if(count($se) < $num){
 				echo "<h1 style='width:600px;margin:0 auto;text-align:center;'>ʕ•͓͡•ʔ 题库数量不足，请联系管理员 ʕ•͓͡•ʔ</h1>";exit;
 			}

 			//取得随机题目id的 键
 			if($num == 1){
 				//只有一道题时array_rand获得的是一个变量而不是数组，为了与下面for循环统一
 				$rand_keys[] = array_rand($se,$num);
 			}else{
 				$rand_keys = array_rand($se,$num);
 			}
 			
 			for($i=0; $i < count($rand_keys); $i++){ 
 				//取得随机题目id的value
 				$ques_ids .= $se[$rand_keys[$i]] .',';
 			}
 			$ques_ids = rtrim($ques_ids,',');

 			return $ques_ids;
 		}
 		//return 为空，不能return 0，否则打印有一道题空在试卷上
 		return;

 	}



	function get_fixed_ques($data){
		//分类，变为二维数组
		$stu_ques['sin'] = explode(',', $data['limit_sin']);
		$stu_ques['dou'] = explode(',', $data['limit_dou']);
		$stu_ques['jud'] = explode(',', $data['limit_jud']);
		$stu_ques['sub'] = explode(',', $data['limit_sub']);
		
		// 打乱第二维数据
		shuffle($stu_ques['sin']);
		shuffle($stu_ques['dou']);
		shuffle($stu_ques['jud']);
		shuffle($stu_ques['sub']);
		//组装第二维数据
		$stu_ques['single_ids'] = implode(',',$stu_ques['sin']);
		$stu_ques['double_ids'] = implode(',',$stu_ques['dou']);
		$stu_ques['judge_ids'] = implode(',',$stu_ques['jud']);
		$stu_ques['subj_ids'] = implode(',',$stu_ques['sub']);
		unset($stu_ques['sin']);
		unset($stu_ques['dou']);
		unset($stu_ques['jud']);
		unset($stu_ques['sub']);

		return $stu_ques;
	}

	function get_ques_info($stu_ques){
		//计算各试题个数,随机和指定出卷都是在这里计算
		$data['sin_num'] = substr_count($stu_ques['single_ids'], ',')+1;
		$data['dou_num'] = substr_count($stu_ques['double_ids'], ',')+1;
		$data['jud_num'] = substr_count($stu_ques['judge_ids'], ',')+1;
		$data['sub_num'] = substr_count($stu_ques['subj_ids'], ',')+1;

		$data['sin'] = M('Ques_single')->where("id in ($stu_ques[single_ids])")->order("field(id,$stu_ques[single_ids])")->select();
		$data['dou']= M('Ques_double')->where("id in ($stu_ques[double_ids])")->order("field(id,$stu_ques[double_ids])")->select();
		$data['jud'] = M('Ques_judge')->where("id in ($stu_ques[judge_ids])")->order("field(id,$stu_ques[judge_ids])")->select();
		$data['sub'] = M('Ques_subj')->where("id in ($stu_ques[subj_ids])")->order("field(id,$stu_ques[subj_ids])")->select();

		return $data;
	}


}