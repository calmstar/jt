<?php
namespace Admin\Model;
use Think\Model;

class Paper_basicModel extends Model{

	protected $patchValidate = false; 
	protected $_validate = array(
		array('name','1,50','试卷名字必须在 1-50 个字符内',0,'length'),
		array('maker_id','require','创建者必须填'),
		array('course_id','require','所属课程必须填'),
		array('limittime','1,300','限制时间在 1-300 分钟内',0,'between'),
		//值不为空就验证
		array('limit_class','check_class','限制班级不符合格式',2,'callback'),
	);

	function check_class($limit_class){
		//如果不用加号连接，势必也会验证为有误
        $lim_arr = explode('+',$limit_class);
        $arr = array("数学",'物理','化学','文学','外语','生科','政法','地理','经管','电子','计算机','土木','美术','体育','音乐','教科');  
        foreach($lim_arr as $k=>$v){
            $xueyuan = mb_substr($v,0,-5, 'utf-8');
            if(!in_array($xueyuan,$arr)){
                return false;
            } 
            $banji = mb_substr($v,-5,5,'utf8');
            if(!preg_match("/\d{4}班/",$banji)){
                return false;
            }
        }
        return true;     
    }



	function deal_show($data){
		$cou = M('Course');
		$user = M('User');
		$k = 0;
		foreach($data as $k => &$v){
			//转换course_id 为course_name
			$cou_name = $cou->field('name')->find($v['course_id']);
			$v['course_name'] = $cou_name['name'];

			//转换maker_id 为maker
			$user_name = $user->field('name')->find($v['maker_id']);
			$v['maker'] = $user_name['name'];

			//create_date
			$v['create_date'] = date('Y-m-d H:i:s',$v['create_date']);

			//review_status
			if($v['review_status'] == 0){
				$v['review_status'] = "<i class='glyphicon glyphicon-remove'></i>";
			}else{
				$v['review_status'] = "<i class='glyphicon glyphicon-ok'></i>";
			}

			//startdate 和 enddate 判断出test_status
			$time = time();
			if($time < $v['startdate']){
				$v['test_status'] = "<span class='badge badge-warning'>未开始</span>";
			}elseif($time >  $v['enddate']){
				$v['test_status'] = "<span class='badge badge-info'>已结束</span>";
			}else{
				$v['test_status'] = "<span class='badge badge-danger'>进行中</span>";
			}
			
			//序号
			$v['xh'] = ++$k;

			//出题规则type
			if($v['type'] == 1){
				$v['type'] = '随机出卷';
			}else{
				$v['type'] = '指定出卷';
			}

			//是否开放答案
			if($v['answ_status'] == 0){
				$v['answ_status'] = "<i class='glyphicon glyphicon-remove'></i>";
			}else{
				$v['answ_status'] = "<i class='glyphicon glyphicon-ok'></i>";
			}

		}

		return $data;
	}	

	//输入的各类型试题量在题库中是否足够,随机出题中验证
	function check_ques_num($post){
		$res['status'] = 0;

		//单选题 题目数量验证
		$sin = M('Ques_single')->field('count(*) as num,difficulty')->where("is_show=0 and course_id=$post[course_id]")->order('difficulty')->group('difficulty')->select();
        if (!isset($sin[0]['num'])) {
            $sin[0]['num'] = 0;
        }
        if (!isset($sin[1]['num'])) {
            $sin[1]['num'] = 0;
        }
        if (!isset($sin[2]['num'])) {
            $sin[2]['num'] = 0;
        }
        //前面已根据难度顺序排列，所以0为简单，1一般，2困难
		if($sin[0]['num'] < $post['sin_easy_num']){
			$res['info'] = '难度为简单的单选题数量不够';
			return $res;
		}
		if($sin[1]['num'] < $post['sin_com_num']){
			$res['info'] = '难度为一般的单选题数量不够';
			return $res;
		}
		if($sin[2]['num'] < $post['sin_diff_num']){
			$res['info'] = '难度为困难的单选题数量不够';
			return $res;
		}

		//双选题 题目数量验证
		$dou = M('Ques_double')->field('count(*) as num,difficulty')->where("is_show=0 and course_id=$post[course_id]")->order('difficulty')->group('difficulty')->select();
        if (!isset($dou[0]['num'])) {
            $dou[0]['num'] = 0;
        }
        if (!isset($dou[1]['num'])) {
            $dou[1]['num'] = 0;
        }
        if (!isset($dou[2]['num'])) {
            $dou[2]['num'] = 0;
        }
        //前面已根据难度顺序排列，所以0为简单，1一般，2困难
		if($dou[0]['num'] < $post['dou_easy_num']){
			$res['info'] = '难度为简单的双选题数量不够';
			return $res;
		}
		if($dou[1]['num'] < $post['dou_com_num']){
			$res['info'] = '难度为一般的双选题数量不够';
			return $res;
		}
		if($dou[2]['num'] < $post['dou_diff_num']){
			$res['info'] = '难度为困难的双选题数量不够';
			return $res;
		}

		//判断题 题目数量验证
		$jud = M('Ques_judge')->field('count(*) as num,difficulty')->where("is_show=0 and course_id=$post[course_id]")->order('difficulty')->group('difficulty')->select();
        if (!isset($jud[0]['num'])) {
            $jud[0]['num'] = 0;
        }
        if (!isset($jud[1]['num'])) {
            $jud[1]['num'] = 0;
        }
        if (!isset($jud[2]['num'])) {
            $jud[2]['num'] = 0;
        }
        //前面已根据难度顺序排列，所以0为简单，1一般，2困难
		if($jud[0]['num'] < $post['jud_easy_num']){
			$res['info'] = '难度为简单的判断题数量不够';
			return $res;
		}
		if($jud[1]['num'] < $post['jud_com_num']){
			$res['info'] = '难度为一般的判断题数量不够';
			return $res;
		}
		if($jud[2]['num'] < $post['jud_diff_num']){
			$res['info'] = '难度为困难的判断题数量不够';
			return $res;
		}

		//主观题 题目数量验证
		$sub = M('Ques_subj')->field('count(*) as num,difficulty')->where("course_id=$post[course_id]")->order('difficulty')->group('difficulty')->select();
        if (!isset($sub[0]['num'])) {
            $sub[0]['num'] = 0;
        }
        if (!isset($sub[1]['num'])) {
            $sub[1]['num'] = 0;
        }
        if (!isset($sub[2]['num'])) {
            $sub[2]['num'] = 0;
        }
        //前面已根据难度顺序排列，所以0为简单，1一般，2困难
		if($sub[0]['num'] < $post['sub_easy_num']){
			$res['info'] = '难度为简单的主观题数量不够';
			return $res;
		}
		if($sub[1]['num'] < $post['sub_com_num']){
			$res['info'] = '难度为一般的主观题数量不够';
			return $res;
		}
		if($sub[2]['num'] < $post['sub_diff_num']){
			$res['info'] = '难度为困难的主观题数量不够';
			return $res;
		}
		
		$res['status'] = '1';
		return $res;
	}

	function check_deal_file($file){
		$all_path = $this->deal_file($file);
		if(!$all_path){
			$info['status'] = '0';
			$info['msg'] = "上传失败,请检查文件格式！";
			return $info;
		}

	   //上传文件成功后的操作
	    $data = excelToArray($all_path);

	    //处理excel中生成的二维数据
	    $check_data = $this->deal_file_data($data);
	    if($check_data['status'] == '0'){ 
	    	$info['status'] = '0';
	    	$info['msg'] = $check_data['msg'];
	    	return $info;
	    }
	    //最后无误将改造后的数组返回
	    return $check_data;
	}

	function deal_file($file){
		$tmp_file = $file['tmp_name'];
		//将文件名拆分成一个数组，里面包含 名字和后缀名
		$file_types = explode (".",$file['name'] );
		//取出后缀名
		$file_type = $file_types[count($file_types )-1];
		//判别是不是.xls文件，判别是不是excel文件
		if(strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx"){
		    return false;
		 }
		//设置上传路径
		 $savePath = WORKING_PATH.UPLOAD_ROOT_PATH.'limit_stu/';
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
	    //for循环验证数据格式
	    foreach($data as $k => $v){
	    	foreach ($v as $kk => $vv) {
	    		//验证学号
	    		if($kk == 0){
		    		if($vv < 130000000 || $vv > 999999999){
		    			//返回错误信息数组
	    				$row = $k+1;
	    				$col = $kk+1;
	    				$info['status'] = '0';
	    				$info['msg'] = "失败！第 $row 行，第 $col 列中的 学号 有误！";
	    				return $info;
		    		}
	    		}else{	
		    		//验证名字,excel中只有两列 0和1
		    		if(mb_strlen($vv,'utf8') < 1 ||  mb_strlen($vv,'utf8') > 5){
		    			//返回错误信息数组
	    				$row = $k+1;
	    				$col = $kk+1;
	    				$info['status'] = '0';
	    				$info['msg'] = "失败！第 $row 行，第 $col 列中的 名字 有误！";
	    				return $info;
		    		}
	    		}

	    		//改变键名
	    		switch ($kk) {
	    		case 0:
	    			$check_data[$k]['limit_xh'] = $vv;
	    		    break;
	    		case 1:
	    			$check_data[$k]['stu_name'] = $vv;
	    		    break;
	    		}
	    	}
	    }
	    return $check_data;
	}


	function deal_basic($data,$type){
		$data['create_date'] = time();
		$data['startdate'] = strtotime($data['startdate']);
		$data['enddate'] = strtotime($data['enddate']);
		$data['type'] = $type;  //随机出卷
		return $this->add($data);
	}

	
	function deal_add_random($data,$post,$flag,$file_data){

		$info['status'] = 0;
		$type = 1; //代表随机出题
		//试卷基本信息入库：(paper_basic),第一存储，返回的id需要给下面表使用
		$res = $this->deal_basic($data,$type);
		if(!$res){
			$info['msg'] = '添加试卷基础信息失败';
			return $info;
		}

		$paper_id = $res;

		//试题信息入库，(Paper_ques_random),使用$_POST信息,而不是过滤后的data
		$post['paper_id'] = $paper_id;
		$res = M('Paper_ques_random')->add($post);
		if(!$res){
			$info['msg'] = '添加试题信息失败';
			return $info;
		}

		//有文件上传的操作，放在后面是为了得到paper_id
		if($flag == 1){
			//文件数据(限制学生名单)入库,(paper_limit_stu)
			foreach($file_data as $k => &$v){
				$v['paper_id'] = $paper_id;
			}
			$res = M('Paper_limit_stu')->addall($file_data);
			if(!$res){
				$info['msg'] = '导入学生名单失败';
				return $info;
			}
		}

		//限制数据 (paper_limit)
		$limit['paper_id'] = $paper_id;
		if(!empty($post['limit_class'])){
			$limit['limit_class'] = $post['limit_class'];
		}
		if($flag == 1){
			$limit['limit_stu_status'] = 1;
		}
		$res = M('Paper_limit')->add($limit);
		if(!$res){
			$info['msg'] = '限制数据添加失败';
			return $info;
		}

		//全部数据成功存储
		$info['status'] = 1;
		$info['msg'] = '试卷添加成功';
		return $info;
	}


	function deal_add_fixed($data,$post,$flag,$file_data){
		
		$info['status'] = 0;
		
		//paper_basic表
		$type = 2; //代表指定出题
		$res = $this->deal_basic($data,$type);
		if(!$res){
			$info['msg'] = '添加试卷基础信息失败';
			return $info;
		}

		$paper_id = $res;


		//试题信息入库，(Paper_ques_fixed),使用$_POST信息,而不是过滤后的data
		$post['paper_id'] = $paper_id;
		$res = M('Paper_ques_fixed')->add($post);
		if(!$res){
			$info['msg'] = '添加试题信息失败';
			return $info;
		}

		//有文件上传的操作，放在后面是为了得到paper_id
		if($flag == 1){
			//文件数据(限制学生名单)入库,(paper_limit_stu)
			foreach($file_data as $k => &$v){
				$v['paper_id'] = $paper_id;
			}
			$res = M('Paper_limit_stu')->addall($file_data);
			if(!$res){
				$info['msg'] = '导入学生名单失败';
				return $info;
			}
		}

		//限制数据 (paper_limit)
		$limit['paper_id'] = $paper_id;
		if(!empty($post['limit_class'])){
			$limit['limit_class'] = $post['limit_class'];
		}
		if($flag == 1){
			$limit['limit_stu_status'] = 1;
		}
		$res = M('Paper_limit')->add($limit);
		if(!$res){
			$info['msg'] = '限制数据添加失败';
			return $info;
		}
		//全部数据成功存储
		$info['status'] = 1;
		$info['msg'] = '试卷添加成功，请为其分配试题';
		$info['paper_id'] = $paper_id; //为了传递值
		return $info;

	}

	function deal_edit_limit($data,$flag,$file_data){

		$info['status'] = 0;

		if($flag == 1){

			//清空之前该试卷的限制名单
			$res = M('Paper_limit_stu')->where("paper_id=$data[id]")->delete();
			if($res === false){
				$info['msg'] = '清空旧学生名单失败';
				return $info;
			}

			//文件数据(限制学生名单)入库,(paper_limit_stu)
			foreach($file_data as $k => &$v){
				$v['paper_id'] = $data['id'];
			}
			$res = M('Paper_limit_stu')->addall($file_data);
			if(!$res){
				$info['msg'] = '导入学生名单失败';
				return $info;
			}
		}

		//限制数据 (paper_limit)
		$limit['limit_class'] = $data['limit_class']; //有无填写都要进行赋值修改
		if($flag == 1){
			$limit['limit_stu_status'] = 1;
		}
		$res = M('Paper_limit')->where("paper_id=$data[id]")->save($limit);

		if($res === false){
			$info['msg'] = '限制班级修改失败';
			return $info;
		}

		$info['status'] = 1;
		$info['msg'] = '修改成功';
		return $info;
	}

	function deal_whole_score($post){
        //查询各类题每题分数
        $info = M('Paper_ques_fixed')->where("paper_id=$post[id]")->find();

        //通过逗号计算各类题目个数，不为空才进行计算，否则下面加1就会出错
        if(!empty($info['limit_sin'])){
            $num_sin = substr_count($info['limit_sin'], ',')+1;
        }else{
            $num_sin = 0;
        }
        if(!empty($info['limit_jud'])){
            $num_jud = substr_count($info['limit_jud'], ',')+1;
        }else{
            $num_jud = 0;
        }
        if(!empty($info['limit_dou'])){
            $num_dou = substr_count($info['limit_dou'], ',')+1;
        }else{
            $num_dou = 0;
        }
        if(!empty($info['limit_sub'])){
            $num_sub = substr_count($info['limit_sub'], ',')+1;
        }else{
            $num_sub = 0;
        }

        $post['whole_score'] = $post['sin_score'] * $num_sin + $post['dou_score'] * $num_dou + $num_jud * $post['jud_score'] + $num_sub * $post['sub_score'];
        return $post;
    }
	


}