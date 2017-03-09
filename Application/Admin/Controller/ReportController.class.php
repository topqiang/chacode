<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 门店管理
*/
class ReportController extends AdminBasicController{
	public function _initialize(){
		
	}

	public function reportlist(){
		$shopadd = D("Repo");
		$name = $_POST['name'];
		$tel = $_POST['tel'];
		if ( isset($name) ) {
			$where['name'] = array('like',"%$name%");
		}
		if ( isset($tel) ) {
			$where['tel'] = array('like',"%$tel%");
		}
		$where['status'] = array('neq',9);
		$count = $shopadd ->where($where)->count();
        $page = new \Think\Page($count,15);
		$list = $shopadd->limit($page->firstRow,$page->listRows) -> where($where) -> select();
		$this->assign('page',$page->show());
		$this->assign("list",$list);
		$this->display();
	}

	
}