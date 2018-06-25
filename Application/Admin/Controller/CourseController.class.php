<?php
namespace Admin\Controller;
use Tools\AccessController;
 
class CourseController extends AccessController{

	function showlist(){
		$data = M('Course')->select();
		$this->assign('i',icount());
		$this->assign('data',$data);
		$this->display();
	}

	function add(){
		if(IS_AJAX){
			$post = I('post.');
			$post['rgdate'] = time();
			$res = M('course')->add($post);
			if($res){
				$data['num'] = M('Course')->count();
				$data['id'] = $res;
				$data['rgdate'] = date('Y-m-d H:i:s',time());
				$data['status'] = 1;
				$this->ajaxReturn($data);
				//直接调用传输数据格式为：{id:"85",rgdate:"2017-07-28 16:08:41"}，前台直接当成数组使用即可

				// $this->success('添加成功','showlist');
				 //如果是ajax请求，会自动调用ajaReturn方法，将数据变成以json格式传输，并返回给前台
				//{info: "添加成功", status: 1, url:"showlist"}为json格式的,
				//前台可以直接当成数组 使用data['status'] 就等于1了
			}else{
				echo false;
				
			}
		}
	}

	function dele(){
		if(IS_AJAX){
			$post = I('post.');
			$res = M('Course')->delete($post['ids']);
			if($res){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	function edit(){
		if(IS_AJAX){
			$post = I('post.');
			$res = M('Course')->save($post);
			if($res !== false){
				$this->success('编辑成功');
			}else{
				$this->error('编辑失败');
			}
		}
	}

	function disp(){
		if(IS_AJAX){
			$post['id'] = I('post.id');
            $dis = M('Course')->field('display')->find($post['id']);
            if($dis['display'] == 1){
                $post['display'] = 0;
                $res['status'] = 2;
            }else{
                $post['display'] = 1;
                $res['status'] = 1;
            }
            $z = M('Course')->save($post);
            if(!$z){
                $res['status'] = 0;
            }
            $this->ajaxReturn($res);
        }
	}

    function ques_show(){
        if(IS_AJAX){
            $id = I('post.id');
            $data['is_show'] = 1;
            M()->startTrans();
            $r1 = M('Ques_single')->where("course_id=$id")->save($data);
            $r2 = M('Ques_double')->where("course_id=$id")->save($data);
            $r3 = M('Ques_judge')->where("course_id=$id")->save($data);
            $r4 = M('Ques_subj')->where("course_id=$id")->save($data);
            if($r1 && $r2 && $r3 && $r4){
                $res['status'] = 1;
                M()->commit();
            }else{
                $res['status'] = 0;
                M()->rollback();
            }
            $this->ajaxReturn($res);
        }
        
    }

    function ques_no(){
        if(IS_AJAX){
            $id = I('post.id');
            $data['is_show'] = 0;
            M()->startTrans();
            $r1 = M('Ques_single')->where("course_id=$id")->save($data);
            $r2 = M('Ques_double')->where("course_id=$id")->save($data);
            $r3 = M('Ques_judge')->where("course_id=$id")->save($data);
            $r4 = M('Ques_subj')->where("course_id=$id")->save($data);
            if($r1 && $r2 && $r3 && $r4){
                $res['status'] = 1;
                M()->commit();
            }else{
                $res['status'] = 0;
                M()->rollback();
            }
            $this->ajaxReturn($res);
        }
    }

}