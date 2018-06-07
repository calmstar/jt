<?php
namespace Admin\Controller;
use Tools\AccessController;

class PaperController extends AccessController{

	function showlist(){
		$paper = new \Admin\Model\Paper_basicModel();

		$role_id = session('role_id');
		$uid = session('bg_id');
		if($role_id == 1){
			// 教师，只能看见自己出的试卷
			$data = $paper->where("maker_id=$uid")->select();
		}else{
			// 管理员
			$data = $paper->select();
		}
		
		$data = $paper->deal_show($data);
		if(IS_AJAX){
			$this->ajaxReturn($data);
		}
		$this->display();
	}

	//随机出卷
	function add_random(){
		if(!empty($_POST)){
		    // 异步得知所属课程名字
            if (IS_AJAX) {
                // 得到选中的课程
                $cou_id = $_POST['cou_id'];
                // 各类型题目数量
                $data['sin_eas'] = M('Ques_single')->where("is_show=0 and difficulty=1 and course_id=$cou_id")->count();
                $data['sin_com'] = M('Ques_single')->where("is_show=0 and difficulty=2 and course_id=$cou_id")->count();
                $data['sin_dif'] = M('Ques_single')->where("is_show=0 and difficulty=3 and course_id=$cou_id")->count();

                $data['dou_eas'] = M('Ques_double')->where("is_show=0 and difficulty=1 and course_id=$cou_id")->count();
                $data['dou_com'] = M('Ques_double')->where("is_show=0 and difficulty=2 and course_id=$cou_id")->count();
                $data['dou_dif'] = M('Ques_double')->where("is_show=0 and difficulty=3 and course_id=$cou_id")->count();

                $data['jud_eas'] = M('Ques_judge')->where("is_show=0 and difficulty=1 and course_id=$cou_id")->count();
                $data['jud_com'] = M('Ques_judge')->where("is_show=0 and difficulty=2 and course_id=$cou_id")->count();
                $data['jud_dif'] = M('Ques_judge')->where("is_show=0 and difficulty=3 and course_id=$cou_id")->count();

                $data['sub_eas'] = M('Ques_subj')->where("is_show=0 and difficulty=1 and course_id=$cou_id")->count();
                $data['sub_com'] = M('Ques_subj')->where("is_show=0 and difficulty=2 and course_id=$cou_id")->count();
                $data['sub_dif'] = M('Ques_subj')->where("is_show=0 and difficulty=3 and course_id=$cou_id")->count();

                $this->ajaxReturn($data);
            }

			$paper = new \Admin\Model\Paper_basicModel(); 
			//数据是否合法
			$data = $paper->create(); 
			if($data){
				//有无限制学生考试文件上传
				if(!empty($_FILES['limit_stu_status']['name'])){
					//有文件
					$file_data = $paper->check_deal_file($_FILES['limit_stu_status']);
					//文件是否合法
					if($file_data['status'] == '0'){
						$this->error($file_data['msg']);exit;
					}
					//表示有文件且合法，方便下面判断
					$flag = 1;
				}

				$post = I('post.');
				//检验输入的各类型试题量在题库中是否足够，不够返回false
				$res = $paper->check_ques_num($post);
				if($res['status'] == 0){
					echo "<h2 align='center'>$res[info]，请先前往题库中补充对应类型试题</h2>";
                    exit;
				}
				//所有数据和文件合法，进行存储操作
				$res = $paper->deal_add_random($data,$post,$flag,$file_data);
				if($res['status'] == 0){
					$this->error($res['msg']);
				}else{
					$this->success($res['msg'],U('Paper/showlist'));
				}
			}else{
				$mess = $paper->getError();
				$this->error($mess);exit;
			}
		}else{

			$role_id = session('role_id');
			$id = session('bg_id');
			//课程，创建者信息
			if($role_id == 1){
				//角色为教师时创建者就是当前教师,课程就是当前教的课程
				//使用select是为了对应模板的foreach输出（由于是二维数组，下方才有[0]）
				$teac_info = M('User')->where("id = $id")->select();
				$cou_info = M('Course')->select($teac_info[0]['course_ids']);
			}else{
				//管理员，下拉列表供选择（注意不能让教师担任的课程与试卷所属课程不符合）
				$cou_info = M('Course')->select();
				$teac_info = M('User')->where('role_id=1')->select();
			}

			$this->assign('cou_info',$cou_info);
			$this->assign('teac_info',$teac_info);
			$this->display();
		}
	}

	function dele(){
		if(!empty($_POST)){
			$ids = I('post.ids');
			$res = M('Paper_basic')->delete($ids);
			if($res){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	function isable(){
		if(!empty($_GET)){
			$get = I('get.');
			$paper = M('Paper_basic');
			$data = $paper->field('review_status')->find($get['id']);

			if($data['review_status'] == 1){
				$get['review_status'] = 0;
				$res = $paper->save($get);
				if($res){
					$this->success('修改成功');
				}else{
					$this->error('审核状态修改失败');
				}
			}else{
				$get['review_status'] = 1;
				$res = $paper->save($get);
				if($res){
					$this->success('修改成功');
				}else{
					$this->error('审核状态修改失败');
				}
			}

		}
	}

	function edit(){
		if(!empty($_POST)){

			$paper = new \Admin\Model\Paper_basicModel(); 
			
			if($_POST['basic']){
				//修改基本信息

				$data = $paper->create();
				if($data){
					$data['startdate'] = strtotime($data['startdate']);
					$data['enddate'] = strtotime($data['enddate']);
					$res = $paper->save($data);
					if($res !== false){
						$this->success('基本信息修改成功');
					}else{
						$this->error('修改失败');
					}
				}else{
					$this->error($paper->getError());
				}
				
			}elseif($_POST['limit']){
				// 修改限制信息

				//有无限制学生考试文件上传
				if(!empty($_FILES['limit_stu_status']['name'])){
					$file_data = $paper->check_deal_file($_FILES['limit_stu_status']);
					//文件是否合法
					if($file_data['status'] == '0'){
						$this->error($file_data['msg']);exit;
					}
					//表示有文件且合法，方便下面判断
					$flag = 1;
				}
				$data = $paper->create();
				
				if($data){
					$post = I('post.');
					//验证通过，换用post数据，否则有些数据被过滤
					$res = $paper->deal_edit_limit($post,$flag,$file_data);
					if($res['status'] == 0){
						$this->error($res['msg']);
					}else{
						$this->success($res['msg']);
					}
				}else{
					$this->error($paper->getError());
				}

			}elseif($_POST['clear_stu']){
				// 点击--》清空学生名单操作
				$paper_id = I('post.paper_id');
				$res = M('Paper_limit_stu')->where("paper_id=$paper_id")->delete();
				if($res){
					// 修改paper_limit中的 limit_stu_status
					$limit['limit_stu_status'] = 0;
					$res = M('Paper_limit')->where("paper_id=$paper_id")->save($limit);

                    if($res){
						echo true; //这里使用succcess方法导致前台无法撤销对话框
					}else{
						echo false;
					}
				}else{
					echo false;
				}

			}elseif($_POST['ques']){
				// 修改试题信息
				$post = I('post.');
				$paper_id = $post['id'];
				if(count($post) == 6){
					//指定出卷（通过发送过来的数据数量来判断）
                    //修改每种类型题的分数信息，也要修改总分
                    $post = $paper->deal_whole_score($post);
                    unset($post['id']);
                    $res = M('Paper_ques_fixed')->where("paper_id=$paper_id")->save($post);
				}else{
					// 随机出卷 （大于六个）
                    unset($post['id']);
					$res = M('Paper_ques_random')->where("paper_id=$paper_id")->save($post);
				}
				if($res !== false){
					$this->success('修改试题成功');
				}else{
					$this->error('修改试题失败');
				}

			}
			//修改题目跳转到fixed_ques 中修改
		}else{

			//获得试卷id
			$id = I('get.id');
			//Paper_basic原本信息
			$basic_info = M('Paper_basic')->find($id);

			//通过course_id得到course_name
			$cou = M('Course')->find($basic_info['course_id']);
			$basic_info['course_name'] = $cou['name'];
			//通过maker_id得到maker_name
			$tea = M('User')->find($basic_info['maker_id']);
			$basic_info['maker_name'] = $tea['name'];

			$this->assign('basic_info',$basic_info);

			//paper_limit原本信息
			$limit_info = M('Paper_limit')->where("paper_id=$id")->find();
			// 先通过Paper_limit中的 limit_stu_status 来判断有无限制学生
			if($limit_info['limit_stu_status'] == 0){
				$limit_info['stu'] = '无';
			}else{
				//查询限制学生,$limit_info['stu']是个二维数组
				$limit_info['stu'] = M('Paper_limit_stu')->where("paper_id=$id")->select();
			}

			$this->assign('i',1);
			$this->assign('limit_info',$limit_info);

			//paper_ques_fixed(random)原本信息
			if($basic_info['type'] == 1){
				// paper_ques_random
				$ques_info = M('paper_ques_random')->where("paper_id=$id")->find();

			}else{
				// paper_ques_fixed
				$ques_info = M('paper_ques_fixed')->where("paper_id=$id")->find();
				//paper_ques_fixed 中的 limit_题型
				$sin = new \Admin\Model\Ques_singleModel();
				$table_sin = $sin->select($ques_info['limit_sin']);
				$table_sin = $sin->deal_sin_show($table_sin);

				$dou = new \Admin\Model\Ques_doubleModel();
				$table_dou = $dou->select($ques_info['limit_dou']);
				$table_dou = $dou->deal_dou_show($table_dou);

				$jud = new \Admin\Model\Ques_judgeModel();
				$table_jud = $jud->select($ques_info['limit_jud']);
				$table_jud = $jud->deal_jud_show($table_jud);

				$sub = new \Admin\Model\Ques_subjModel();
				$table_sub = $sub->select($ques_info['limit_sub']);
				$table_sub = $sub->deal_sub_show($table_sub);

				//在table中的data-url加上sin等标示请求数据
				if($_GET['sin']){
					$this->ajaxReturn($table_sin);
				}
				if($_GET['dou']){
					$this->ajaxReturn($table_dou);
				}
				if($_GET['jud']){
					$this->ajaxReturn($table_jud);
				}
				if($_GET['sub']){
					$this->ajaxReturn($table_sub);
				}
			}
			$this->assign('ques_info',$ques_info);

			//下拉列表信息
			//判断角色
			$role_id = session('role_id');
			$id = session('bg_id');
			//课程，创建者信息
			if($role_id == 1){
				//角色为教师时创建者就是当前教师,课程就是当前教的课程
				$teac_info = M('User')->where("id = $id")->select();
				$cou_info = M('Course')->select($teac_info[0]['course_ids']);
			}else{
				//管理员，下拉列表供选择
				$cou_info = M('Course')->select();
				$teac_info = M('User')->where('role_id=1')->select();
			}
			$this->assign('cou_info',$cou_info);
			$this->assign('teac_info',$teac_info);
			$this->display();
		}
	}

	//指定出卷
	function add_fixed(){
		if(!empty($_POST)){
			$paper = new \Admin\Model\Paper_basicModel(); 
			//数据是否合法
			$data = $paper->create(); 
			if($data){
				//有无限制学生考试文件上传
				if(!empty($_FILES['limit_stu_status']['name'])){
					$file_data = $paper->check_deal_file($_FILES['limit_stu_status']);
					if($file_data['status'] == '0'){
						$this->error($file_data['msg']);exit;
					}
					$flag = 1;
				}
				//所有数据和文件合法，进行存储操作
				$post = I('post.');
				$res = $paper->deal_add_fixed($data,$post,$flag,$file_data);

				if($res['status'] == 0){
					$this->error($res['msg']);
				}else{
					//成功后，跳转返回到选择试题fixed_ques页面带参数paper_id中
					$paper_id = $res['paper_id'];
					//带参数的success跳转
					$this->assign("jumpUrl",U('fixed_ques',array('paper_id'=>$paper_id)))->success($res['msg']);
				}
			}else{
				$mess = $paper->getError();
				$this->error($mess);
			}
		}else{
			//判断角色
			$role_id = session('role_id');
			$id = session('bg_id');
			//课程，创建者信息
			if($role_id == 1){
				//角色为教师时创建者就是当前教师,课程就是当前教的课程
				//使用select是为了对应模板（由于是二维数组，下方才有[0]）
				$teac_info = M('User')->where("id = $id")->select();
				$cou_info = M('Course')->select($teac_info[0]['course_ids']);
			}else{
				//管理员，下拉列表供选择（注意不能让教师担任的课程与试卷所属课程不符合）
				$cou_info = M('Course')->select();
				$teac_info = M('User')->where('role_id=1')->select();
			}
			$this->assign('cou_info',$cou_info);
			$this->assign('teac_info',$teac_info);

			$this->display();
		}
	}

	//分配指定题目
	function fixed_ques(){
		if(!empty($_POST)){
			
			$post = I('post.');

			//通过逗号计算各类题目个数，不为空才进行计算，否则下面加1就会出错
			if(!empty($post['limit_sin'])){
				$num_sin = substr_count($post['limit_sin'], ',')+1;
			}else{
				$num_sin = 0;
			}
			if(!empty($post['limit_jud'])){
				$num_jud = substr_count($post['limit_jud'], ',')+1;
			}else{
				$num_jud = 0;
			}
			if(!empty($post['limit_dou'])){
				$num_dou = substr_count($post['limit_dou'], ',')+1;
			}else{
				$num_dou = 0;
			}
			if(!empty($post['limit_sub'])){
				$num_sub = substr_count($post['limit_sub'], ',')+1;
			}else{
				$num_sub = 0;
			}

			//查询各类题每题分数
			$info = M('Paper_ques_fixed')->where("paper_id=$post[paper_id]")->find();
			$post['whole_score'] = $info['sin_score'] * $num_sin + $info['dou_score'] * $num_dou + $num_jud * $info['jud_score'] + $num_sub * $info['sub_score'];

			//存储传过来的各类型题目id字符串
			$res = M('Paper_ques_fixed')->where("paper_id=$post[paper_id]")->save($post);
			if($res){
				$this->success('操作成功');
			}else{
				$this->error('操作失败');
			}

		}else{
			//将paper_id转为course_id，name
			$paper_id = I('get.paper_id');
			$info = M('Paper_basic')->field('course_id,name,id')->find($paper_id);
			$this->assign('info',$info); //赋到各类型题请求的URL中

			// 可分配到的试卷题目 与 试卷所属课程绑定即可。而不管角色
			$course_id = $info['course_id'];

			$sin = new \Admin\Model\Ques_singleModel();
			$table_sin = $sin->where("course_id='$course_id'")->select();
			$table_sin = $sin->deal_sin_show($table_sin);

			$dou = new \Admin\Model\Ques_doubleModel();
			$table_dou = $dou->where("course_id='$course_id'")->select();
			$table_dou = $dou->deal_dou_show($table_dou);

			$jud = new \Admin\Model\Ques_judgeModel();
			$table_jud = $jud->where("course_id='$course_id'")->select();
			$table_jud = $jud->deal_jud_show($table_jud);

			$sub = new \Admin\Model\Ques_subjModel();
			$table_sub = $sub->where("course_id='$course_id'")->select();
			$table_sub = $sub->deal_sub_show($table_sub);

			//在table中的data-url加上sin等标示请求数据
			if($_GET['sin']){
				$this->ajaxReturn($table_sin);
			}
			if($_GET['dou']){
				$this->ajaxReturn($table_dou);
			}
			if($_GET['jud']){
				$this->ajaxReturn($table_jud);
			}
			if($_GET['sub']){
				$this->ajaxReturn($table_sub);
			}

			$this->display();
		}
		
	}


	//是否开放考生答案
	function answ(){
		if(!empty($_GET)){
			$get = I('get.');
			$paper = M('Paper_basic');
			$data = $paper->field('answ_status')->find($get['id']);

			if($data['answ_status'] == 1){
				$get['answ_status'] = 0;
				$res = $paper->save($get);
				if($res){
					$this->success('修改成功');
				}else{
					$this->error('审核状态修改失败');
				}
			}else{
				$get['answ_status'] = 1;
				$res = $paper->save($get);
				if($res){
					$this->success('修改成功');
				}else{
					$this->error('审核状态修改失败');
				}
			}

		}
	}


}