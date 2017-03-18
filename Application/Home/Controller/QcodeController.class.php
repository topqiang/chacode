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
			$this -> assign('res',$res[0]);
		
		}
		
		$this -> display();
	
	}



}