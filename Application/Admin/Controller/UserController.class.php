<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller{
	public function _initialize(){
		$this -> user = D('User');
	}
	public function userlist(){
		$name = $_POST['name'];
		if ($name) {
			$where['name'] = array("like","%$name%");
		}
		$count =  $this -> user -> where($where)->count();
		$page = new \Think\Page($count,15);
		if ($name) {
        	$page->parameter['name'] =  $name;
		}
		$userlist = $this -> user -> where($where) -> order('c_time desc') -> limit($page->firstRow,$page->listRows) -> select();
		$this -> assign('userlist',$userlist);
		$this -> assign('page',$page->show());
		$this -> display();
	}
}