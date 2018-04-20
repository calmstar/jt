<?php
namespace Admin\Model;
use Think\Model;

class Stu_scoreModel extends Model{

	//批改主观题--showlist--
	function deal_show($data){
		$i = 1;
		foreach($data as $k => &$v){

			//paper_id得到 paper_name ，time
			$pinfo = M('Paper_basic')->field('name,startdate,enddate')->find($v['paper_id']);
			$v['paper_name'] = $pinfo['name'];
			$startdate = date('Y-m-d H:i:s',$pinfo['startdate']);
			$enddate = date('Y-m-d H:i:s',$pinfo['enddate']);
			$v['time'] = "$startdate -- $enddate";

			//序号
			$v['xh'] = $i++;

		}
		unset($v);

		return $data;
	}


	//marking中核对paper_id
	function check_pid($pid){
		// 教师，只能看见自己出的试卷
		$uid = session('bg_id');
		
		//通过maker_id找到相应的paper_id
		$ids = M('Paper_basic')->field('id')->where("maker_id=$uid")->select();
		foreach ($ids as $k => $v) {
			$id[] .= $v['id']; 
		}
		if(!in_array($pid, $id)){
			echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 你没有此的权限 ʕ•͓͡•ʔ</h1> ';  //批改和查看试卷共用检测id
					exit;
		}

	}

	//----marking得到试题信息----
	function get_subques($pid){
        //试题信息
        $z = M('Stu_paper')->field('subj_ids')->where("paper_id=$pid")->find();
        $data['sub_info'] = M('Ques_subj')->select($z['subj_ids']);

		$info = M('Stu_score')->field('stu_id,paper_id,id,each_ms')->where("paper_id=$pid and mark_status=0")->select();
		//通过stu_id 和 paper_id分别查询考生和试题信息 赋到 data数组中
		foreach ($info as $k => $v) {
			
			$data[$k]['ssid'] = $v['id']; //为stu_score的主键

			//考生信息
			$z = M('Stu')->field('xuehao,stu_class,name')->find($v[stu_id]);
			$data[$k]['xuehao'] = $z['xuehao'];
			$data[$k]['stu_class'] = $z['stu_class'];
			$data[$k]['name'] = $z['name'];

			//考生答题信息
			$zz = M('stu_answ')->field('etime,subj_answ')->where("stu_id=$v[stu_id] and paper_id=$v[paper_id]")->find();
			$data[$k]['etime'] = $zz['etime'];
			$myansw = explode('@%@', $zz['subj_answ']);

            //每个考生答题项带上对应id,让教师好分辨考生答的是哪一道题目
            $z = M('Stu_paper')->field('subj_ids')->where("paper_id=$pid and stu_id=$v[stu_id]")->find();
            $subj_ids = explode(',',$z['subj_ids']);

			//批改后的得分信息---放在答题信息中
			$each_ms = explode(',', $v['each_ms']);
			//改变数组位置
			for($i = 0;$i < count($myansw);$i++){
				$data[$k]['myansw'][$i]['answ'] = $myansw[$i];
				$data[$k]['myansw'][$i]['each_ms'] = $each_ms[$i];
                $data[$k]['myansw'][$i]['id'] = $subj_ids[$i];
			}
		}

		return $data;
	}


	function get_score($paper_id){

		//通过paper_id查询type
		$pinfo = M('Paper_basic')->field('name,type')->find($paper_id);

		if($pinfo['type'] == 1){
			//随机出卷
			$type = M('Paper_ques_random');
		}else{
			//指定出卷
			$type = M('Paper_ques_fixed');
		}

		$sub_score = $type->field('sub_score,whole_score')->where("paper_id= $paper_id ")->find();

		$sub_score['paper_name'] = $pinfo['name'];

		return $sub_score;
	}


	// ---marking 确认post
	function check_post($post){
		//检验分数
		foreach ($post as $k => &$v) {
			if(is_numeric($k)){
				for($i = 0;$i < count($v);$i++){
					if($post['highest'] < $v[$i]){
						return false;
					}
					//填充
					if($v[$i] == ''){
						$v[$i] = '0';
					}
				}
			}   
		}

		unset($v);
		return $post;
	}


	// ---marking 处理post
	function deal_post($post,$flag){

		//外层foreach考生循环，内层for代表考生每道题循环
		foreach($post as $k => $v){
			$zz = $this->find($k);
			//不这样做，第二次开始就会是四个题的总分，会累加错误
			$zz['all_score'] = $zz['single_score'] + $zz['double_score'] + $zz['judge_score'];

			for($i = 0;$i < count($v);$i++){

				$data[$k]['subj_score'] += $post[$k][$i];
				$data[$k]['id'] = $k;
				$data[$k]['each_ms'] .= $post[$k][$i].',';
				//修改总得分
				$data[$k]['all_score'] = $data[$k]['subj_score']+$zz['all_score'];
			}
			$data[$k]['each_ms'] = rtrim($data[$k]['each_ms'],',');

			//保存分数并完成批改
			if($flag == '1'){
				$data[$k]['mark_status'] = '1';
			}

			$res = $this->save($data[$k]);

			if($res === false){
				return false;
			}

		}
		return true;

	}


	// 试卷分析得到优秀率等
	function get_rate($s_info){

		foreach ($s_info as $k => &$v) {
			$bad_good = $v['whole_score']*0.6;
			$good_exce = $v['whole_score']*0.8;

			//计算考这张试卷的考生各个分数段的人数
			//占总分百分之60以下的
			$bad_num = $this->where("paper_id=$v[paper_id] and all_score<$bad_good")->count();
			//占总分百分之80以上的
			$exce_num = $this->where("paper_id=$v[paper_id] and all_score>$good_exce")->count();

			//计算各种率
			$v['bad'] = round($bad_num/$v['tested_num'],2); 
			$v['exce'] = round($exce_num/$v['tested_num'],2);
			$v['good'] = round(1-($v['bad']+$v['exce']),2) ;

			$v['bad'] = ($v['bad']*100).'%';
			$v['exce'] = ($v['exce']*100).'%';
			$v['good'] = ($v['good']*100).'%';

		}
		unset($v);

		return $s_info;
	}

	// 考生列表
	function mix_stuinfo($info){
		$stu = M('Stu');
		$i = 1;
		foreach ($info as $k => &$v) {

			$si = $stu->field('xuehao,stu_class,name')->find($v['stu_id']);
			$v['xuehao'] = $si['xuehao'];
			$v['stu_class'] = $si['stu_class'];
			$v['stu_name'] = $si['name'];
			$v['xh'] = $i;
			$i++;
		}
		unset($v);
		return $info;
	}


	function match_pinfo($get){

		$data[0]['paper_name'] = $get->paper_name;
		$data[0]['tested_num'] = $get->tested_num;
		$data[0]['high'] = $get->high;
		$data[0]['low'] = $get->low;
		$data[0]['aver'] = $get->aver;
		$data[0]['whole_score'] = $get->whole_score;
		$data[0]['bad'] = $get->bad;
		$data[0]['good'] = $get->good;
		$data[0]['exce'] = $get->exce;

		return $data;
	}

	function match_sinfo($info){

		for($i = 0;$i < count($info);$i++){
			$data2[$i]['xuehao'] = $info[$i]['xuehao'];
			$data2[$i]['stu_name'] = $info[$i]['stu_name'];
			$data2[$i]['stu_class'] = $info[$i]['stu_class'];
			$data2[$i]['all_score'] = $info[$i]['all_score'];
			$data2[$i]['single_score'] = $info[$i]['single_score'];
			$data2[$i]['double_score'] = $info[$i]['double_score'];
			$data2[$i]['judge_score'] = $info[$i]['judge_score'];
			$data2[$i]['subj_score'] = $info[$i]['subj_score'];
		}
		return $data2;

	}



}