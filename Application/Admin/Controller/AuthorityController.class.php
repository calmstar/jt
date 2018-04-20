<?
namespace Admin\Controller;
use Tools\AccessController;

class AuthorityController extends AccessController{

	function showlist(){
	    $auth = D('Authority');
	    $count = $auth->count();
	    $page = new \Think\Page($count,20);
	    $page -> rollPage = 5; //分页数小于rollPage时，不显示首末页
	    $page -> lastSuffix = false; 
	    $page -> setConfig('prev','上一页');
	    $page -> setConfig('next','下一页');
	    $page -> setConfig('last','末页');
	    $page -> setConfig('first','首页');
	    //添加bootstrap样式
	    $page->setConfig('header','<li class="disabled hwh-page-info"><a>共 <em>%TOTAL_ROW%</em> 条  , <em>%NOW_PAGE%</em> / %TOTAL_PAGE% 页</a></li>');
	    $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
	    $page_show = bootstrap_page_style($page->show());
	    $this->assign('page_show',$page_show);//输出分页

	    $info = $auth->order('auth_path')->limit($page -> firstRow , $page -> listRows )->select();
	    $this->assign('info',$info); //输出数据
	    
	    //序号自增
	    $i = icount();
	    $this->assign('i',$i);
	    $this->display();
	}

	function add(){
		$auth = new \Admin\Model\AuthorityModel();
		if(!empty($_POST)){
			$check_info = $auth->create();
			if($check_info){
				//若是直接add进数据库，此处可不填参数
				$res = $auth->add_date($check_info);
				if($res){
					$this->success('添加成功',U('Authority/showlist'));
				}else{
					$this->error('添加失败');
				}
			}else{
				$this->error($auth->getError());
			}
		}else{
			//下拉列表
			$sele_info = $auth->field('id,name')->where('auth_level=0')->select();
			$this->assign('sele_info',$sele_info);
			$this->display();
		}
	}

	function dele(){
		if(!empty($_POST)){
			$post = I('post.');
			$ids = $_POST['ids'];
		}elseif(!empty($_GET)){
			$get = I('get.');
			$ids = $get['ids'];
		}

		$res = M('Authority')->delete($ids);
		if($res){
			$this->success('删除成功'); //删除成功跳回历史记录前一页并刷新?
		}else{
			$this->error('删除失败');
		}
	}

	function edit(){
		$auth = D('Authority');
		if(!empty($_POST)){
			$check_info = $auth->create();
			if($check_info){
				$res = $auth->save_date($check_info);
				if($res !== false ){
					$this->success('修改成功',U('Authority/showlist'));
				}else{
					$this->error('修改失败');
				}
			}else{
				$mess = $auth->getError();
				$this->error($mess);
			}
		}else{
			$get = I('get.');
			$this->assign('id',$get['id']);
			//原始信息
			$info = $auth->field('name,auth_c,auth_a,pid,display')->find($get['id']);
			$pname = $auth->field('name')->find($info['pid']);
			if($pname['name'] == ''){
				$pname['name'] = '无父类';
			}
			$info['pname'] = $pname['name'];
			$this->assign('info',$info);
			//下拉列表
			$sele_info = $auth->field('id,name')->where('auth_level=0')->select();
			$this->assign('sele_info',$sele_info);
			$this->display();
		}
	}


}