<?php
namespace Admin\Controller;
use Tools\AccessController;

class AnnounceController extends AccessController{

	function showlist(){

		// 置顶 优先排列，然后是发布日期（id）
		$sql = "select a.*,u.name from jt_announce a join jt_user u on u.id=a.pub_id order by top desc,id desc ";
		$data = M()->query($sql);
		
		$this->assign('data',$data);
		$this->assign('i',1);
		$this->display();
	}


	function add(){
		
		if(!empty($_POST)){
			$descr = I('post.descr');
			if(mb_strlen($descr,'utf8') < 5 ||  mb_strlen($descr,'utf8') > 950){
				$this->error('发布内容不符合规范');exit;
			}else{
				$data['content'] = $descr;
				$data['pubdate'] = time();
				$data['pub_id'] = session('bg_id');
				$res = M('Announce')->add($data);
				if($res){
					$this->success('发布成功',U('showlist'));exit;
				}else{
					$this->error('发布失败');exit;
				}
			}

		}else{
			$this->display();
		}

	}


	function edit(){

		if(!empty($_POST)){
			$descr = I('post.descr');
			if(mb_strlen($descr,'utf8') < 5 ||  mb_strlen($descr,'utf8') > 950){
				$this->error('修改内容不符合规范');exit;
			}else{
				$data['id'] = I('post.id');
				$data['content'] = $descr;
				$data['pub_id'] = session('bg_id');
				$res = M('Announce')->save($data);
				if($res){
					$this->success('修改成功',U('showlist'));exit;
				}else{
					$this->error('修改失败');exit;
				}
			}

		}else{
			$id = I('get.id');
			$content = M('Announce')->field('content')->find($id);

			$this->assign('content',$content['content']);
			$this->assign('id',$id);
			$this->display();
		}
	}


	function dele(){
		if(!empty($_POST)){
			$ids = I('post.ids');
			$res = M('Announce')->delete($ids);
			if($res){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	function top(){

		if(!empty($_GET)){

			$id = I('get.id');
			$top = M('Announce')->field('top')->find($id);
			if($top['top'] == 1){
				//取消置顶
				$data['top'] = 0;
			}else{
				//置顶
				$data['top'] = 1;
			}
			$data['id'] = $id;
			$res = M('Announce')->save($data);
			if($res){
				$this->success('操作成功');
			}else{
				$this->error('操作失败');
			}
		}

	}


}