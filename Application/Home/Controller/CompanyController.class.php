<?php
namespace Home\Controller;
use Think\Controller;
class CompanyController extends BaseController{
	public function _initialize(){
		parent::_initialize();
		$this -> goods = D('Goods');
	}
	public function company(){
		$id = $_GET['id'];
		$ratem = M('Company');
		$rates = $ratem -> where( array( 'id' => $id ) ) -> select();
		if ($rates) {
			$where['id'] = array('in' , $rates[0]['paygoods']);
			$res = $this -> goods -> where($where) -> select();
			$str = "";
			foreach ($res as $key => $value) {
				if ($key != 0) {
					$str .=",";
				}
				$str .= $value['name'];
			}
			$rates[0]['paygoods'] = $str;
		}
		$this -> assign("company",$rates[0]);
		$this -> display();
	}

	public function companylist(){
		$provance = $_GET['provance'];
		if (!empty($provance)) {
			$ratem = M('Company');
			$time = date('Y/m/d');
        	$where['b_time'] = array('lt' , $time);
        	$where['e_time'] = array('gt' , $time);
        	$where['status'] = array('neq' , 9);
	        $where['provance'] = array('like' , "%$provance%");
			$rates = $ratem -> where( $where ) -> select();
			$gsname = session('gsname');
			$cprates = array();
			foreach ($rates as $index => $obj) {
				$flag = false;
				$whe['id'] = array('in' , $obj['paygoods']);
				$res = $this -> goods -> where($whe) -> select();
				$str = "";

				foreach ($res as $key => $value) {
					if ($key != 0) {
						$str .=",";
					}
					$str .= $value['name'];
					if ( $gsname == $value['name']) {
						$flag = true;
					}
				}
				$rates[ $index ]['paygoods'] = $str;
				if ($flag) {
					array_push($cprates,$rates[ $index ]);
				}
			}
		}
		$this -> assign("companylist",$cprates);
		$this -> display();
	}
}