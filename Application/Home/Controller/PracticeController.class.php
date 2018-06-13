<?php
namespace Home\Controller;
use Tools\HomeacceController;

class PracticeController extends HomeacceController {

	function sin_show(){
		$cid = I('get.cou_id','','int');
		$num = M('Ques_single')->where("course_id=$cid and is_show=1")->count();

        $r = M('Course')->where("id=$cid and display=1")->count();
        if($r == '0'){
            echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 此课程不开放练习题 ʕ•͓͡•ʔ</h1> ';
            exit;
        }

	    $page = new \Think\Page($num,1); //每页输出一条练习题,1为listRows
	    $page -> rollPage = 0; //分页数小于rollPage时，不显示首末页
	    $page -> lastSuffix = false;  //是否显示最后一页
	    $page -> setConfig('prev','上一道');
	    $page -> setConfig('next','下一道');
	    $page -> setConfig('last','末道');
	    $page -> setConfig('first','首道');

	    //添加bootstrap样式
	    $page->setConfig('header','<li class="disabled hwh-page-info"><a>共 <em>%TOTAL_ROW%</em> 道练习题  , <em>%NOW_PAGE%</em> / %TOTAL_PAGE% 道</a></li>');
	    $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
	    $page_show = bootstrap_page_style($page->show());
	    $this->assign('page_show',$page_show);//输出分页

	    $info = M('Ques_single')->where("course_id=$cid and is_show=1")->limit($page -> firstRow , $page -> listRows )->select();

	    $this->assign('info',$info); //输出数据

	    //得到课程名称
	    $cou_info = M('Course')->find($cid);
	    $this->assign('cou_name',$cou_info['name']);
	   
	    $p = I('get.p','','int');
	    if(!empty($p)){
	    	$this->assign('p',$p);
	    }else{
	    	$this->assign('p',1);
	    }

		$this->display();
	}

	function check_sin(){

	    if(IS_AJAX){
	    	//得到要校验的单选题id
	    	$answ = I('post.sin');
	    	if($answ == '1'){
	    		$data['status'] = '1';  //正确
	    	}else{
	    		$data['status'] = '0';
	    	}

	    	$this->ajaxReturn($data);//返回给前台（return无效）
	    }
	}


	function dou_show(){
		$cid = I('get.cou_id','','int');
		$num = M('Ques_double')->where("course_id=$cid and is_show=1")->count();

        $r = M('Course')->where("id=$cid and display=1")->count();
        if($r == '0'){
            echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 此课程不开放练习题 ʕ•͓͡•ʔ</h1> ';
            exit;
        }

	    $page = new \Think\Page($num,1); //每页输出一条练习题,1为listRows
	    $page -> rollPage = 0; //分页数小于rollPage时，不显示首末页
	    $page -> lastSuffix = false;  //是否显示最后一页
	    $page -> setConfig('prev','上一道');
	    $page -> setConfig('next','下一道');
	    $page -> setConfig('last','末道');
	    $page -> setConfig('first','首道');

	    //添加bootstrap样式
	    $page->setConfig('header','<li class="disabled hwh-page-info"><a>共 <em>%TOTAL_ROW%</em> 道练习题  , <em>%NOW_PAGE%</em> / %TOTAL_PAGE% 道</a></li>');
	    $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
	    $page_show = bootstrap_page_style($page->show());
	    $this->assign('page_show',$page_show);//输出分页

	    $info = M('Ques_double')->where("course_id=$cid and is_show=1")->limit($page -> firstRow , $page -> listRows )->select(); 

	    $this->assign('info',$info); //输出数据

	    //得到课程名称
	    $cou_info = M('Course')->find($cid);
	    $this->assign('cou_name',$cou_info['name']);
	   
	    $p = I('get.p','','int');
	    if(!empty($p)){
	    	$this->assign('p',$p);
	    }else{
	    	$this->assign('p',1);
	    }
		$this->display();
	}

	function check_dou(){
		if(IS_AJAX){
			$answ1 = I('post.dou');
			$answ2 = I('post.dou');

			if($answ1[0] == '1' && $answ2[1] == '1'){
	    		$data['status'] = '1';  //正确
	    	}else{
	    		$data['status'] = '0';
	    	}
	    	$this->ajaxReturn($data);
		}
	}


	function jud_show(){
		$cid = I('get.cou_id','','int');
		$num = M('Ques_judge')->where("course_id=$cid and is_show=1")->count();

        $r = M('Course')->where("id=$cid and display=1")->count();
        if($r == '0'){
            echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 此课程不开放练习题 ʕ•͓͡•ʔ</h1> ';
            exit;
        }

	    $page = new \Think\Page($num,1); //每页输出一条练习题,1为listRows
	    $page -> rollPage = 0; //分页数小于rollPage时，不显示首末页
	    $page -> lastSuffix = false;  //是否显示最后一页
	    $page -> setConfig('prev','上一道');
	    $page -> setConfig('next','下一道');
	    $page -> setConfig('last','末道');
	    $page -> setConfig('first','首道');

	    //添加bootstrap样式
	    $page->setConfig('header','<li class="disabled hwh-page-info"><a>共 <em>%TOTAL_ROW%</em> 道练习题  , <em>%NOW_PAGE%</em> / %TOTAL_PAGE% 道</a></li>');
	    $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
	    $page_show = bootstrap_page_style($page->show());
	    $this->assign('page_show',$page_show);//输出分页

	    $info = M('Ques_judge')->where("course_id=$cid and is_show=1")->limit($page -> firstRow , $page -> listRows )->select(); 

	    $this->assign('info',$info); //输出数据

	    //得到课程名称
	    $cou_info = M('Course')->find($cid);
	    $this->assign('cou_name',$cou_info['name']);
	   
	    $p = I('get.p','','int');
	    if(!empty($p)){
	    	$this->assign('p',$p);
	    }else{
	    	$this->assign('p',1);
	    }

		$this->display();
	}

	function check_jud(){
		if(IS_AJAX){
			$answ = I('post.jud');
			if($answ == '1'){
	    		$data['status'] = '1';  //正确
	    	}else{
	    		$data['status'] = '0';
	    	}
	    	$this->ajaxReturn($data);
		}
	}
	
	function sub_show(){
        $cid = I('get.cou_id','','int');
        $r = M('Course')->where("id=$cid and display=1")->count();
        if($r == '0'){
            echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 此课程不开放练习题 ʕ•͓͡•ʔ</h1> ';
            exit;
        }
        //得到课程名称
        $cou_info = M('Course')->find($cid);
        $this->assign('cou_name',$cou_info['name']);
        $this->assign('cid',$cid);

        //输出数据,得到表格请求的参数
        if(IS_AJAX){
            $limit = I('post.limit','','int'); //显示多少条数据
            $pageNo = I('post.pageNo','','int');  // 第几页
            $offset = ($pageNo-1)*$limit;   //算出偏移量
            $sort = I('post.sort');
            if($sort == 'xh'){
                $sort = 'id';
            }
            $order = I('post.order');
            $text = str_replace('\'',' ',htmlspecialchars(I('post.text')));

            if(!empty($text)){
                // 模糊查询返回数据
                $info = M('Ques_subj')
                    ->where("course_id=$cid and is_show=1 and (descr like '%{$text}%' or keyword like '%{$text}%' ) ")
                    ->limit($offset,$limit)
                    ->order($sort.' '.$order)
                    ->select();
                $num = M('Ques_subj')->where("course_id=$cid and is_show=1 and (descr like '%{$text}%' or keyword like '%{$text}%' ) ")->count();
            }else{
                $info = M('Ques_subj')->where("course_id=$cid and is_show=1")->limit($offset,$limit)->order($sort.' '.$order)->select();
                $num = M('Ques_subj')->where("course_id=$cid and is_show=1")->count();
            }
            $subj = new \Home\Model\Ques_subjModel();
            $info = $subj->deal_info($info,$offset);
            $data['rows'] = $info;
            $data['total'] = $num;

            $this->ajaxReturn($data);
        }

        $this->display();
    }


    function sub_detail(){
        $id = I('get.id','','int');
        $cid = I('get.cid','','int');

        $r = M('Ques_subj')->field('is_show')->find($id);
        if($r['is_show'] == '0'){
            echo ' <h1 style="width:500px;margin:0 auto;text-align:center;">ʕ•͓͡•ʔ 此题未展示到练习题中 ʕ•͓͡•ʔ</h1> ';
            exit;
        }
        $data = M('Ques_subj')->find($id);
        $cou_info = M('Course')->field('name')->find($cid);
        $data['cname'] = $cou_info['name'];
        $this->assign('data',$data);

        // 显示其余题目
        $ids = M('Ques_subj')->field('id')->order('id desc')->where('course_id='.$cid.' and is_show=1')->select();
        foreach($ids as $k => $v){
            $id_arr[] = $v['id'];
        }
        $offset = array_search($id,$id_arr);
        $num = count($id_arr);

        if($num <= 20){
            // 取出所有id
            $other = M('Ques_subj')->field('id,keyword,course_id,descr')->order('id desc')->where('course_id='.$cid.' and is_show=1')->select();
        }else{
            // 取出部分id
            // 往前取出最多十条；没有十条就往前取完
            if(($offset-10) >= 0){
                $p = $offset-10;
            }else{
                $p = 0;
            }
            // 往后取出最多十条，不够就往后取完
            if(($offset+10) <= $num){
                $n = $offset+10;
            }else{
                $n = $num;
            }
            // 得到所有id
            for($i=$p;$i<=$n;$i++){
                $id_str .= $id_arr[$i].',';
            }
            $id_str = rtrim($id_str,',');
            $other = M('Ques_subj')->field('id,keyword,course_id,descr')->order('id desc')->where("course_id=$cid and id in ($id_str) and is_show=1")->select();

        }
        $this->assign('other',$other);

        $this->display();
    }


}