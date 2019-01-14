<?php
namespace Admin\Model;
use Think\Model;

class Ques_judgeModel extends Model{

	protected $patchValidate = false; 
	protected $_validate = array(
		array('descr','require','题目描述必须填'),
		array('descr','1,1000','题目描述必须在1000字符以内',0,'length'),
		array('right_answ','require','正确答案必须勾选',1),
	);


	function deal_jud_show($data,$offset){
		$cou = M('Course');
		$k = 0;
		for($i=0 ; $i<count($data); $i++){
			//改变课程名字
			$cou_name = $cou->field('name')->find($data[$i]['course_id']);
			$data[$i]['course_name'] = $cou_name['name'];
			//改变is_show
			if($data[$i]['is_show'] == 1){
				$data[$i]['is_show'] = '是';
			}else{
				$data[$i]['is_show'] = '否';
			}
			//改变id为序号
			$data[$i]['xh'] = $offset+(++$k);
			//将编辑器里面存入的实体字符转化为html文字
			$data[$i]['descr'] = strip_tags(htmlspecialchars_decode($data[$i]['descr']));
            $data[$i]['descr'] = msubstr($data[$i]['descr'],0,30);

            //整合出right_answ信息
			if($data[$i]['is_true'] == 1){
				$data[$i]['right_answ'] = '正确';
			}else{
				$data[$i]['right_answ'] = '错误';
			}
			// 难度
			if($data[$i]['difficulty'] == 1){
				$data[$i]['difficulty'] = "简单";
			}elseif($data[$i]['difficulty'] == 2){
				$data[$i]['difficulty'] = "一般";
			}else{
				$data[$i]['difficulty'] = "困难";
			}
		}
		return $data;
	}

	function deal_jud_add($data){
		$answ = $data['right_answ'];
		$_POST[$answ] = 1;
	}

	function jud_edit_original($info){
		$info['descr'] = htmlspecialchars_decode($info['descr']);
		//已选课程
		$my_course = M('Course')->field('name')->find($info['course_id']);
		$info['course_name'] = $my_course['name'];
		//是否展示练习题
		if($info['is_show'] == 1){
			$info['show_name'] = '是';
		}else{
			$info['show_name'] = '否';
		}

		//难度
		if($info['difficulty'] == 1){
			$info['diff_name'] = "简单";
		}elseif($info['difficulty'] == 2){
			$info['diff_name'] = "一般";
		}else{
			$info['diff_name'] = "困难";
		}
		
		return $info;
	}

	function deal_jud_edit($data){
		if($data['right_answ'] == 'is_true'){
			$_POST['is_true'] = 1;
		}else{
			$_POST['is_true'] = 0;
		}

		if($data['right_answ'] == 'is_false'){
			$_POST['is_false'] = 1;
		}else{
			$_POST['is_false'] = 0;
		}


	}

	function deal_file($jud_file){
		$tmp_file = $jud_file['tmp_name'];
		//将文件名拆分成一个数组，里面包含 名字和后缀名
		$file_types = explode (".",$jud_file['name'] );
		//取出后缀名
		$file_type = $file_types[count($file_types )-1];
		//判别是不是.xls文件，判别是不是excel文件
		if(strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx"){
		    return false;
		 }
		//设置上传路径
		 $savePath = WORKING_PATH.UPLOAD_ROOT_PATH.'ques_judge/';
		//以时间来命名上传的文件
		$str = date ( 'Ymdhis' ); 
		$file_name = $str . "." . $file_type;
		$all_path = $savePath . $file_name ;
		//是否上传成功
		if(!copy($tmp_file,$all_path)){
		    return false;
		}
		return $all_path;
	}

		function deal_file_data($data){

			//判断角色,若为教师则要判断 导入的课程题目是否属自己所教的课程
			$role_id = session('role_id');
			$uid = session('bg_id');
			if($role_id == 1){
				//教师，展现自己所教课程
				$course_ids = M('User')->field('course_ids')->find($uid);
				$course_ids = $course_ids['course_ids'];
			}

		    $cou = M('Course');
		    // 需要验证的数据库字段 对应序号为 2,3,4,只能为1或0
		    $check_field = array(2,3,4);
		    //for循环验证数据格式
		    foreach($data as $k => $v){
                if($k == 0){
                    continue;
                }
		    	foreach ($v as $kk => $vv) {
                    // 从第二行开始判断并取得数据
		    		//将课程名字转化为对应的id
		    		if($kk == 0){
		    			$cou_info = $cou->field('id')->where("name='$vv'")->find();
		    			if($cou_info){

		    				//判断该 course_id 是否是当前所教课程
		    				// 对角色为老师的而言
		    				if($role_id == 1){
								$res = strpos($course_ids,$cou_info['id']);
		    					if(!is_numeric($res)){
		    						$info['status'] = '0';
		    						$info['msg'] = "失败！导入题目所属课程与教师所任的课程不符";
		    						return $info;
		    					}
		    				}

		    				$vv = $cou_info['id'];
		    			}else{
		    				//返回错误信息数组
		    				$row = $k+1;
		    				$col = $kk+1;
		    				$info['status'] = '0';
		    				$info['msg'] = "失败！第 $row 行，第 $col 列中的课程名字输入有误！";
		    				return $info;
		    			}
		    		}
		    		//验证格式：只能为1或0
		    		if(in_array($kk, $check_field)){
		    			if($vv != 1 && $vv != 0){
		    				$row = $k+1;
		    				$col = $kk+1;
		    				$info['status'] = '0';
		    				$info['msg'] = "失败！第 $row 行,第 $col 列中的数据只能为1或0！";
		    				return $info;
		    			}
		    		}
		    		//验证难度系数的范围
		    		if($kk == 5){
		    			if($vv > 3 || $vv < 1){
		    				$row = $k+1;
		    				$col = $kk+1;
		    				$info['status'] = '0';
		    				$info['msg'] = "失败！第 $row 行,第 $col 列中的数据只能在 1-3 之间！";
		    				return $info;
		    			}else{
		    				//转成int型
		    				$vv = intval($vv);
		    			}
		    		}

                    $check_data[$k-1]['adddate'] = time();
		    		//赋值到一个新的数组$check_data：
		    		switch ($kk) {
		    		case 0:
		    			$check_data[$k-1]['course_id'] = $vv;
		    		    break;
		    		case 1:
		    			$check_data[$k-1]['descr'] = htmlspecialchars($vv);
		    		    break;
		    		case 2:
		    			$check_data[$k-1]['is_true'] = $vv;
		    		    break;
		    		case 3:
		    			$check_data[$k-1]['is_false'] = $vv;
		    		    break;
		    		case 4:
		    			$check_data[$k-1]['is_show'] = $vv;
		    		    break;
	    		    case 5:
	    		    	$check_data[$k-1]['difficulty'] = $vv;
	    		        break;
		    		}
		    	}
		    	//检查正确选项是否只有一个，
		    	$answ = array("$v[2]","$v[3]");
		    	//(只有为字符的时候才会计算)
		    	$num = array_count_values($answ);
		    	if($num['1'] != 1){
		    		$row = $k+1;
		    		$info['status'] = '0';
		    		$info['msg'] = "失败！第 $row 行中的正确答案只能有一个！";
		    		return $info;
		    	}
		    }
		    return $check_data;
		}


}