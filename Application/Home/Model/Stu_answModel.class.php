<?php
namespace Home\Model;
use Think\Model;

//考生提交试卷

class Stu_answModel extends Model{

	//使用在提交试卷上
	function check_post($post){

		$pid = $post['paper_id'];
		$sid = session('fg_id');
		$res = M('Stu_score')->where("paper_id=$pid and stu_id=$sid")->find();
		
		return $res;
	}

	//使用在 进入试卷 和 提交试卷 的判断上
	function check_finish($post){

		$pid = $post['paper_id'];
		$sid = session('fg_id');
		
		//查询出开始考试时间
		$stime = M('Stu_answ')->field('stime')->where("stu_id=$sid and paper_id=$pid")->find();

		//如果记录为空则说明是首次进入试卷，不验证此项，否则出错
		if(empty($stime)){
			return true;
		}

		$stime = $stime['stime'];
		//查询出限时时间
		$ltime = M('Paper_basic')->field('limittime')->find($pid);
		$limittime = $ltime['limittime'];
		//判断
		$finish_time = $stime + $limittime*60 + 60; //允许超时一分钟内提交
		
		//现在的时间 大于 规定的完成时间,超时
		if(time() > $finish_time){
			
			//超时,只提交考生信息，分数不add,自动为0
			$data['stu_id'] = $sid;
			$data['paper_id'] = $pid;
			$res = M('Stu_score')->add($data);

			return false;
		}
		
		return true;
	}

	function fill_blank($post){

		$a = $post['sin_num'];
		$b = $a+$post['dou_num'];
		$c = $b+$post['jud_num'];
		$d = $c+$post['sub_num'];

		//处理数据之前，必须先进行数据填充,用x填充
		for($i = 1;$i <= $d;$i++){

			if($i > $a && $i <= $b){
				//双选题，二维数组	
				for($k = 0;$k < 2;$k++){
					if(empty($post[$i][$k])){
						$post[$i][$k] = 'xx';
					}
				}

			}else{
				//其余类型题，一维数组
				if(empty($post[$i])){
					$post[$i] = 'xx';
				}

			}

		}
		return $post;
	}


	function split_kinds_answ($post){

		$a = $post['sin_num'];
		$b = $a+$post['dou_num'];
		$c = $b+$post['jud_num'];

		//将post数据按各类型题目分割，分别存入到各类题目数组中
		for($i = 1;$i <= $a;$i++){
			//分离单选题答案存入到一个新的数组，方便计算分数存入stu_score中
			$answ_kinds['sin'][] = $post[$i];
		}

		for($i = $a+1;$i <= $b;$i++){
			$answ_kinds['dou'][] = $post[$i];
		}

		for($i = $b+1;$i <= $c;$i++){
			$answ_kinds['jud'][] = $post[$i];
		}

		return $answ_kinds;
	}

	//得到正确的题目个数
	function deal_sin_answ($sin_ids,$answ_sin){
		$sin_info = M('Ques_single')->where("id in ($sin_ids)")->order("field(id,$sin_ids)")->select();

		//得到选项中结果为 1或0 的数组,并计算值为1的有多少个
		$num_right = 0;
		//for循环的是题目数量
		for($i=0;$i<count($sin_info);$i++){

			//$answ_sin[$i]的值为‘is_op1 2 3 4’
			$res = $sin_info[$i][ $answ_sin[$i] ];
			if($res == 1){
				$num_right++;
			}
		}
		return $num_right;		
	}


	function deal_dou_answ($dou_ids,$answ_dou){

		$dou_info = M('Ques_double')->where("id in ($dou_ids)")->order("field(id,$dou_ids)")->select($dou_ids);
		//得到选项中结果为 1或0 的数组,并计算值为1的有多少个
		$num = 0;
		$num_right = 0;
		//第一层for 循环的是题目数量
		//第二层for 循环的是双选的两个选项

		for($i=0;$i<count($answ_dou);$i++){
            //当选中四个答案，开头连续两个都为正确时就误判断为正确了，改进如下：
            if(count($answ_dou[$i]) != 2){
                continue;
            }
			for($k=0;$k<count($answ_dou[$i]);$k++){

				$res = $dou_info[$i][ $answ_dou[$i][$k] ];
				if($res == 1){
					$num++;
					//双选题两个答案必须正确，才算最终正确
					if($num == 2){
						$num_right++;
					}
				}else{
					//有一个选项不正确，就跳出第二个循环
					break;
				}
			}
			//转为下一道题时要清0，否则会一直累加
			$num = 0;
		}

		return $num_right;

	}	


	function deal_jud_answ($jud_ids,$answ_jud){

		$jud_info = M('Ques_judge')->where("id in ($jud_ids)")->order("field(id,$jud_ids)")->select($jud_ids);

		//得到选项中结果为 1或0 的数组,并计算值为1的有多少个
		$num_right = 0;
		for($i=0;$i<count($jud_info);$i++){
			$res = $jud_info[$i][ $answ_jud[$i] ];
			if($res == 1){
				$num_right++;
			}
		}
		
		return $num_right;
	}


	function deal_add_score($post,$right_sin,$right_dou,$right_jud){

		$data['stu_id'] = session('fg_id');
		$data['paper_id'] = $post['paper_id'];
		$data['single_score'] = $right_sin*$post['sin_score'];
		$data['double_score'] = $right_dou*$post['dou_score'];
		$data['judge_score'] = $right_jud*$post['jud_score'];
		$data['all_score'] = $data['single_score'] + $data['double_score'] + $data['judge_score'];

		return M('Stu_score')->add($data);

	}


	//使用flag来标示 是ajax处理答案 还是考生直接提交试卷 来调用此方法
	function deal_save_answ($post,$flag){
		
		$a = $post['sin_num'];
		$b = $a+$post['dou_num'];
		$c = $b+$post['jud_num'];
		$d = $c+$post['sub_num'];

		for($i = 1;$i <= $a;$i++){
			//处理答案，方便存入stu_answ中,以逗号分割
			$sin_answ = substr($post[$i],-1);
			$data['single_answ'] .= $sin_answ.',';
		}

		for($i = $a+1;$i <= $b;$i++){
			//注意下标这里为 0 开始
			for($k=0;$k<count( $post[$i] );$k++){

				$xx = substr($post[$i][$k], -1);
				$zz .= $xx.'-';
			}
			$zz = rtrim($zz,'-');
			$data['double_answ'] .= $zz.',';
			$zz = ''; //清空，否则累加
		}
		
		for($i = $b+1;$i <= $c;$i++){

			if($post[$i] == 'is_true'){
				$jud_answ = 1;
			}elseif($post[$i] == 'is_false'){
				$jud_answ = 0;
			}else{
				//上面两个if都不成立时，说明没有勾选答案，默认存入的为x
				$jud_answ = 'x';
			}
			
			$data['judge_answ'] .= $jud_answ.',';
		}

		//主观题答案,特殊分隔符
		for($i = $c+1;$i <= $d;$i++){
			$post[$i] = str_replace("@%@", "***",$post[$i]);
			$data['subj_answ'] .= $post[$i].'@%@'; 
		}

		$data['single_answ'] = rtrim($data['single_answ'],',');
		$data['double_answ'] = rtrim($data['double_answ'],',');
		$data['judge_answ'] = rtrim($data['judge_answ'],',');
		$data['subj_answ'] = rtrim($data['subj_answ'],'@%@');
		$data['etime'] = time();
		$pid = $post['paper_id'];
		$sid = session('fg_id');

		//flag为1是ajax异步提交的保存答案处理;
		//为0是直接提交了试卷，不再作答
		if($flag == '1'){
			return $data;
		}else{
			return $this->where("paper_id=$pid and stu_id=$sid")->save($data);
		}


	}



}