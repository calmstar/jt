<?php
namespace Admin\Controller;
use Tools\AccessController;

class MarkController extends AccessController{

	//有交卷的考试才会在这里出现
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

            //未批改人数
            $mark_num = $score->field('paper_id,count(*) as mark_num')->where("mark_status=0 and paper_id in ($paper_ids)")->group('paper_id')->select();

            //已提交数 （=正常提交+超时提交）
            $sco_nums = $score->field('paper_id,count(*) as sco_nums')->group('paper_id')->where("paper_id in ($paper_ids) ")->select();
            //已参加考试人数 join_num
            $nums = M('Stu_paper')->field('paper_id,count(*) as join_num')->group('paper_id')->where("paper_id in ($paper_ids) ")->select();
            for ($i = 0;$i < count($sco_nums);$i++) {
                // 降维成单张试卷
                //未提交人数
                $nums[$i]['no'] = $nums[$i]['join_num'] - $sco_nums[$i]['sco_nums'];
                //正常交卷人数
                $nums[$i]['ok'] = (int)M('Stu_answ')->where("paper_id = {$sco_nums[$i][paper_id]} and etime != '' ")->count();
                //超时提交人数
                $nums[$i]['overtime'] = $sco_nums[$i]['sco_nums'] - $nums[$i]['ok'];
            }
		}else{
			// 管理员
			//未批改人数
			$mark_num = $score->field('paper_id,count(*) as mark_num')->where('mark_status=0')->group('paper_id')->select();
            //已提交数 （=正常提交+超时提交）
            $sco_nums = $score->field('paper_id,count(*) as sco_nums')->group('paper_id')->select();
            //已参加考试人数 join_num
            $nums = M('Stu_paper')->field('paper_id,count(*) as join_num')->group('paper_id')->select();
            for ($i = 0;$i < count($sco_nums);$i++) {
                // 降维成单张试卷
                //未提交人数
                $nums[$i]['no'] = $nums[$i]['join_num'] - $sco_nums[$i]['sco_nums'];
                //正常交卷人数
                $nums[$i]['ok'] = (int)M('Stu_answ')->where("paper_id = {$sco_nums[$i][paper_id]} and etime != '' ")->count();
                //超时提交人数
                $nums[$i]['overtime'] = $sco_nums[$i]['sco_nums'] - $nums[$i]['ok'];
            }
		}

		//将交卷和批改人数组成一个数组
		foreach ($nums as $k => &$v) {
			// 遍历data一次，就要遍历mark_num所有次，
			for ($i=0; $i < count($mark_num); $i++) { 
				//找到一个符合的就退出内部for循环
				if($v['paper_id'] == $mark_num[$i]['paper_id']){
					$v['mark_num'] = $mark_num[$i]['mark_num'];
					$v['mark_num'] = "<span class='badge badge-danger'>$v[mark_num]</span>";
					break;
				}
			}
			if(empty($v['mark_num'])){
				$v['mark_num'] = '0';
			}
		}
		unset($v);

		//得到paper_name和time
		$data = $score->deal_show($nums);
		if(IS_AJAX){
			$this->ajaxReturn($data);
		}
		$this->display();
	}


	function marking(){

		if(!empty($_POST['save'])){

			$post = I('post.');
			$score = new \Admin\Model\Stu_scoreModel();

			$post = $score->check_post($post);
			if(!$post){
				$this->error('输入的分数高于最大值');exit;
			}

			//保存分数
			// 下面有unset
			if($post['save'] == '完成批改'){
				$flag = '1';
			}
			
			unset($post['save']);
			unset($post['highest']);

			$res = $score->deal_post($post,$flag);

			if($res === false){
				$this->error('操作失败');
			}else{
				$this->success('操作成功');
			}

		}else{

			$pid = I('get.paper_id');
            //此批量批改功能只适用于指定出卷
             $type = M('Paper_basic')->field('type')->find($pid);
            if($type['type'] == 1){
                echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ此批量批改功能只适用于类型为指定出卷的试卷，随机出卷类型的必须逐个考生批改  ʕ•͓͡•ʔ</h1> ';
                exit;
            }

			$score = new \Admin\Model\Stu_scoreModel();
			// 核对传进来的pid
			$role_id = session('role_id');
			if($role_id == 1){
				$score->check_pid($pid);
			}

			//获取 主观题目和考生信息,答题信息
			$data = $score->get_subques($pid);

			//分离主观题目信息
			$sub_info = $data['sub_info'];
			unset($data['sub_info']);
			$this->assign('sub_info',$sub_info);
			$this->assign('info',$data);

			//获取分数 和 试卷名字
			$ns = $score->get_score($pid);
			$this->assign('ns',$ns);
			
			$this->assign('k',1);
			$this->display();

		}

	}

    function control () {
        $pid = I('get.paper_id');
        $role_id = session('role_id');
        $uid = session('bg_id');

        if($role_id == 1){
            //教师，核对是不是自己出的试卷
            $num = M('Paper_basic')->where("maker_id=$uid and id=$pid")->count();
            if($num == 0){
                echo "无权限查看此试卷";exit;
            }
        }

        $sql = "select stu_id as tester_id,xuehao,name as tester_name,stu_class as tester_class,stime,etime from jt_stu_answ sa join jt_stu s on s.id=sa.stu_id where paper_id=$pid order by stu_id";
        $data = M()->query($sql);

        //根据stu_id排序好,与上面data中stu_id一一对应，下面写二重foreach循环仍然要加判断了，中间空开个学生
        $mark_info = M('Stu_score')->field('stu_id,mark_status,subj_score')->where("paper_id = $pid")->order('stu_id')->select();

        $i = 1;
        foreach ($data as $k => &$v) {
            //提交状态判断
            if (!empty($v['etime'])) {
                $res = M('Stu_score')->where("paper_id = $pid and stu_id = {$v['tester_id']}")->count();
                if($res){
                    $v['sub_status'] = '正常提交';
                }
            } else {
                $res = M('Stu_score')->where("paper_id = $pid and stu_id = {$v['tester_id']}")->count();
                if($res){
                    $v['sub_status'] = '超时提交';
                }else{
                    $v['sub_status'] = '未提交';
                }
                //提交时间赋值
                $v['etime'] = '-';
            }

            //批改状态
            foreach ($mark_info as $a => $b) {
                if($b['stu_id'] == $v['tester_id']){
                    if ($b['mark_status']) {
                        $v['mark_status'] = $b['subj_score'];
                    } else {
                        $v['mark_status'] = '未批改';
                    }
                    break;
                }
            }

            //答案缓存
            $res = M('Stu_answ_cache')->where("paper_id = $pid and stu_id = {$v['tester_id']}")->find();
            if ($res) {
                $v['cache_status'] = '存在';
            } else {
                $v['cache_status'] = '不存在';
            }

            //序号
            $v['xh'] = $i;
            $i++;

            //日期
            $v['stime'] = date('Y-m-d H:i:s',$v['stime']);
            $v['etime'] = date('Y-m-d H:i:s',$v['etime']);
        }
        unset($v);

        if(IS_AJAX){
            $this->ajaxReturn($data);
        }

        $name = M('Paper_basic')->field('name')->find($pid);
        $this->assign('name',$name['name']);
        $this->assign('paper_id',$pid);
        $this->display();
    }

    //重新考试,解决服务器或网络原因造成的考生考试无法正常提交答案的问题
    function reset(){
        $sid = I('get.tester_id');
        $pid = I('get.paper_id');

        //开始清空相关记录
        // 清空score表
        $res1 = M('Stu_score')->where("paper_id=$pid and stu_id=$sid")->delete();

        //修改stu_answ表
        $answ = M('Stu_answ');
        $data = array(
            'stime' => time(),   //开始考试时间设置为当前时间
            'etime' => '',
            'single_answ' => '',
            'double_answ' => '',
            'judge_answ' => '',
            'subj_answ' => '',
        );
        $res2 = $answ->where("paper_id=$pid and stu_id=$sid")->save($data);

        if($res1 && $res2){
            $this->success('操作成功',U('control',array('paper_id'=>$pid)));
        }else{
            $this->success('已清除相关数据');
        }

    }

//    删除考生
    function remove(){
        $sid = I('get.tester_id');
        $pid = I('get.paper_id');

        //先删除3张表
        $res1 = M('Stu_paper')->where("paper_id=$pid and stu_id=$sid")->delete();
        $res2 = M('Stu_answ')->where("paper_id=$pid and stu_id=$sid")->delete();
        $res3 = M('Stu_score')->where("paper_id=$pid and stu_id=$sid")->delete();

        if($res1 && $res2 && $res3 ){
            $this->success('操作成功',U('control',array('paper_id'=>$pid)));
        } else {
            $this->success('已清除该生的考试数据',U('control',array('paper_id'=>$pid)));
        }

    }

    //清除缓存答案
    function clear(){
        $sid = I('get.tester_id');
        $pid = I('get.paper_id');
        $res = M('Stu_answ_cache')->where("paper_id=$pid and stu_id=$sid")->delete();
        if($res){
            $this->success('操作成功',U('control',array('paper_id'=>$pid)));
        }else{
            $this->error('操作失败');
        }

    }


//    逐个批改主观题
    function smark(){
        $sid = I('get.tester_id');
        $pid = I('get.paper_id');
        $post = I('post.');
        if(!empty($post)){
            $full_score = $post['full_score'];
            unset($post['full_score']);
            for($i = 0;$i < count($post);$i++){
                if($post[$i] == ''){
                    $post[$i] = 0;
                }
                if($post[$i] > $full_score){
                    $this->error('批改的分数大于设定值');exit;
                }
                $data['subj_score'] += $post[$i];
                $data['each_ms'] = $data['each_ms'].$post[$i].',';
            }
            $data['each_ms'] = rtrim($data['each_ms'],',');
            $data['mark_status'] = 1;

            //all_score总分也要修改
            $old_score = M('Stu_score')->where("stu_id=$sid and paper_id=$pid")->field("single_score,double_score,judge_score")->find();
//            $data['all_score'] = $all_score['all_score'] + $data['subj_score']; 不能直接相加，修改分数可能会比原来的分数小
            $data['all_score'] = $old_score['single_score'] + $old_score['double_score'] + $old_score['judge_score'] + $data['subj_score'];

            $res = M('Stu_score')->where("stu_id=$sid and paper_id=$pid")->save($data);
            if ($res) {
                $this->success('批改成功');
            } else {
                $this->error('批改失败');
            }

        }else{

            // 检验paper_id
            $score = new \Admin\Model\Stu_scoreModel();
            $role_id = session('role_id');
            if($role_id == 1){
                $score->check_pid($pid);
            }

            // 查询 基本 信息
            $basic_info = M('Paper_basic')->field('name,type')->find($pid);
            // 判断组卷类型,得出 分数信息
            if($basic_info['type'] == 1){
                //随机出卷，得出试题信息
                $score_info = M('Paper_ques_random')->field('sub_score')->where("paper_id=$pid")->find();
            }else{
                //指定出卷
                $score_info = M('Paper_ques_fixed')->field('sub_score')->where("paper_id=$pid")->find();
            }
            //题目数量
            $subj_ids = M('Stu_paper')->field('subj_ids')->where("paper_id=$pid and stu_id=$sid")->find();
            $score_info['sub_num'] = substr_count($subj_ids['subj_ids'], ',')+1;
            //得分情况
            $get_score = M('Stu_score')->field('subj_score,mark_status')->where("stu_id=$sid and paper_id=$pid")->find();
            if($get_score['mark_status'] == 0){
                $get_score['subj_score'] = "<span class=\"badge badge-info\">未确认批改</span>";
            }
            $score_info['get_score'] = $get_score['subj_score'];
            $this->assign('score_info',$score_info);

            //考生信息
            $stu = M('Stu')->field('name,xuehao,stu_class')->find($sid);
            $stu['type'] = $basic_info['type'];
            $stu['pname'] = $basic_info['name'];
            $this->assign('stu',$stu);

            //试题及答案信息
            //主观题必须按照考生得到试题的顺序
            $subj = M('Ques_subj')->where("id in({$subj_ids['subj_ids']})")->order("field(id,{$subj_ids['subj_ids']})")->select();
            //答案顺序已按照考生试题顺序进行存储，所以直接拿来用
            $answ = M('Stu_answ')->field('subj_answ')->where("stu_id=$sid and paper_id=$pid")->find();
            $myansw = explode('@%@',$answ['subj_answ']);
            //分数和答案一样，直接拿来用
            $myscore = M('Stu_score')->field('each_ms')->where("stu_id=$sid and paper_id=$pid")->find();
            $myscore = explode(',',$myscore['each_ms']);

            foreach($subj as $k => &$v){
                $v['myansw'] = $myansw[$k];
                $v['myscore'] = $myscore[$k];
            }
            unset($v);
            $this->assign('subj',$subj);
            $this->assign('i',1);
            $this->assign('sid',$sid);
            $this->assign('pid',$pid);

            $this->display();

        }

    }



}