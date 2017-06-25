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


	public function wxcompanylist(){
		$provance = $_GET['provance'];
		$gsname = $_GET['gsname'];
		if (!empty($provance)) {
			$ratem = M('Company');
			$time = date('Y/m/d');
        	$where['b_time'] = array('lt' , $time);
        	$where['e_time'] = array('gt' , $time);
        	$where['status'] = array('neq' , 9);
	        $where['provance'] = array('like' , "%$provance%");
			$rates = $ratem -> where( $where ) -> select();
			$cprates = array();
			foreach ($rates as $index => $obj) {
				$flag = false;
				$whe['id'] = array( 'in' , $obj['paygoods'] );
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
			if ($cprates) {
				apiResponse("success","查询成功！",$cprates);
			}else{
				apiResponse("error","查询失败！");
			}
		}
	}

	public function wxcomlist(){
		$provance = $_GET['provance'];
		$city = $_GET['city'];
		$area = $_GET['area'];
		$provance = str_replace("市","",$provance);
		$city = str_replace("市","",$city);
		$area = str_replace("市","",$area);
		if (!empty($provance)) {
			$ratem = M('Company');
			$time = date('Y/m/d');
        	$where['b_time'] = array('lt' , $time);
        	$where['e_time'] = array('gt' , $time);
        	$where['status'] = array('neq' , 9);
	        $where['provance'] = array(array('like' , "%$provance%"),array('like' , "%$city%"),array('like' , "%$area%"),'or');
			$rates = $ratem -> where( $where ) -> select();
			foreach ($rates as $index => $obj) {
				$whe['id'] = array( 'in' , $obj['paygoods'] );
				$res = $this -> goods -> where($whe) -> select();
				$str = "";
				foreach ($res as $key => $value) {
					if ($key != 0) {
						$str .=",";
					}
					$str .= $value['name'];
					
				}
				$rates[ $index ]['paygoods'] = $str;
			}
			if ($rates) {
				apiResponse("success","查询成功！",$rates);
			}else{
				apiResponse("error","查询无数据！",$ratem->getLastsql());
			}
		}
	}

	public function wxcompany(){
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
			apiResponse("success","查询成功！",$rates[0]);
		}else{
			apiResponse("error","查询失败！");
		}
	}


	public function lngLatCity(){
		$url = "http://zxty.91fluid.com/index.php/Api/Shop/lngLatCity";
		$data['lnt'] = $_POST['lnt'];
		$data['lat'] = $_POST['lat'];
		$res = $this -> curl ($data,$url);
		echo $res;
	}
}