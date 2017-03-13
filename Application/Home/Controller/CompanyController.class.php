<?php
namespace Home\Controller;
use Think\Controller;
class CompanyController extends BaseController{
	public function _initialize(){
		parent::_initialize();
	}
	public function company(){
		$id = $_GET['id'];
		$ratem = M('Company');
		$rates = $ratem -> where( array( 'id' => $id ) ) -> select();
		$this -> assign("company",$rates[0]);
		$this -> display();
	}

	public function companylist(){
		$provance = $_GET['provance'];
		if (!empty($provance)) {
			$ratem = M('Company');
			$rates = $ratem -> where( array('provance' => $provance) ) -> select();
		}

		$this -> assign("companylist",$rates);
		$this -> display();
	}
}