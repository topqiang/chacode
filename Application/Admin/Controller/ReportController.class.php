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
		$shopadd = D("Report");
		$name = $_POST['name'];
		$tel = $_POST['tel'];
		if ( isset($name) ) {
			$where['name'] = array('like',"%$name%");
		}
		if ( isset($tel) ) {
			$where['tel'] = array('like',"%$tel%");
		}
		$where['status'] = array('neq',9);
		if ( isset($status) ) {
			$where['status'] = $status;
		}
		$count = $shopadd ->where($where)->count();
        $page = new \Think\Page($count,15);
		$list = $shopadd->limit($page->firstRow,$page->listRows) -> where($where) -> select();
		$this->assign('page',$page->show());
		$this->assign("list",$list);
		$this->display();
	}

	public function reportedit(){
		$shopadd = D("Report");
        if(empty($_GET['id']))$this->error('举报信息id');
        $res = $shopadd -> save(array('id'=>$_GET['id'],'status'=>"1"));
        if($res){
            $this->success('处理成功',U('Report/reportlist'));
        }else{
            $this->error('处理失败');
        }
    }

    public function reportdel(){
		$shopadd = D("Report");
        if(empty($_GET['id']))$this->error('举报信息id');
        $res = $shopadd -> save(array('id'=>$_GET['id'],'status'=>"9"));
        if($res){
            $this->success('删除成功',U('Report/reportlist'));
        }else{
            $this->error('删除失败');
        }
    }
}