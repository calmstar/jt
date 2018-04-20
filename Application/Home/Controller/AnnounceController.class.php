<?php
namespace Home\Controller;
use Tools\HomeacceController;

class AnnounceController extends HomeacceController {

	function show(){

		$ann = M('Announce');

		//置顶公告
		$top_info = $ann->field('a.*,u.name as pubname')->where('top=1')->alias('a')->join('inner join jt_user as u on a.pub_id=u.id')->order('id desc')->select();

		$this->assign('top_info',$top_info);

		//普通公告
		$comm_info = $ann->field('a.*,u.name as pubname')->where('top=0')->alias('a')->join('inner join jt_user as u on a.pub_id=u.id')->order('id desc')->select();

		$this->assign('comm_info',$comm_info);

		$this->display();
	}

}