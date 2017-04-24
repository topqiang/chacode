<?php
namespace Home\Controller;
use Think\Controller;
/**
* 
*/
class QcodeController extends BaseController{
	
	public function _initialize(){
		parent::_initialize();
		$this -> qcg = M('Qcg');
	}
	
	public function findcode(){

		$where['codenum'] = $_GET['code_name'];
				
		$res = $this -> qcg -> where($where) -> select();
		
		if (!empty($res)) {
			$data = array(
				'id' => $res[0]['id'],
				'visnum' => $res[0]['visnum'] + 1
				);
			M('Qcode') -> save($data);
			session('gsname',$res[0]['name']);
			$her['name'] = $res[0]['name'];
			$gg = M("Goods") -> where($her) -> select();
			session('gsid',$gg[0]['id']);
			$this -> assign('res',$res[0]);
		
		}
		
		$this -> display();
	
	}


	public function wxfindcode(){

		$where['codenum'] = $_GET['code_name'];
		$where['name'] = array("like","%".$_GET['code_name']."%");

				
		$res = $this -> qcg -> where($where) -> select();
		
		if (!empty($res)) {
			$data = array(
				'id' => $res[0]['id'],
				'visnum' => $res[0]['visnum'] + 1
				);
			M('Qcode') -> save($data);
			$her['name'] = $res[0]['name'];
			$gg = M("Goods") -> where($her) -> select();
			$res[0]['gsid'] = $gg[0]['id'];
			apiResponse('success','查询成功！',$res[0]);
		}else{
			apiResponse('error','数据不存在！');
		}
	
	}



}