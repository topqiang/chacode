<?php
namespace Wap\Controller;
use Think\Controller;
class CompanyController extends BaseController{
	
	public function _initialize(){
		parent::_initialize();
		$this -> goods = D('Goods');
		$this -> company = M('Company');
	}

	public function regis(){
		$wxcode = $_POST['wxcode'];
		$password = $_POST['password'];
		$tel = $_POST['tel'];
		$boss = $_POST['boss'];

		if ($wxcode && $password && $tel) {
			$pid = 0;
			$pwxcode = "";
			$class = 1;
			if ($tel != "123456") {
				$whe['wxcode'] = $tel;
				$whe['class'] = array('IN',array('1','2'));
				$is_p = $this -> company -> where( $whe ) -> find();
				if (empty($is_p)) {
					apiResponse('error','上级不存在！');
				}
				$pid = $is_p['id'];
				$pname = $is_p['name'];

				if ($is_p['class'] == "1") {
					$class = 2;
				}else{
					$class = 3;
				}
				$pwxcode = $tel;
			}
			$wh['wxcode'] = $wxcode;
			$is_has = $this -> company -> where( $wh ) -> find();
			if ($is_has) {
				apiResponse('error','手机号已存在！');
			}
			$data = array(
				'wxcode' => $wxcode,
				'password' => md5($password),
				'pwxcode' => $tel,
				'pid' => $pid,
				'boss' => $boss,
				'class' => $class,
				'pname' => $pname,
				'status' => 1
				);
			$res = $this -> company -> add($data);
			if ($res) {
				session('shop_id',$res);
				apiResponse('success','添加成功！');
			}else{
				apiResponse('error','添加失败！');
			}

		}else{
			apiResponse("error","数据填写不完整！");
		}
	}

	public function reset(){
		$wxcode = $_POST['wxcode'];
		$password = $_POST['password'];
		if (empty($wxcode) || empty($password)) {
			apiResponse("error","输入内容为空！");
		}
		$id = session('shop_id');
		$rates = $this -> company -> where( array( 'id' => $id ) ) -> find();
		if ($rates['password'] == md5($wxcode)) {
			$data = array(
				'id' => $id,
				'password' => md5($password)
				);
			$res = $this -> company -> save($data);
			if ($res) {
				apiResponse("success","修改成功！");
			}else{
				apiResponse("error","修改失败！");
			}
		}else{
			apiResponse("error","原密码输入错误！");
		}
	}

	public function company(){
		if ($_GET['id']) {
			$id = $_GET['id'];
		}else{
			$id = session('shop_id');
		}
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
		$id = session('shop_id');
		if (!empty($id)) {
			$ratem = M('Company');
			$time = date('Y/m/d');
        	$where['b_time'] = array('lt' , $time);
        	$where['e_time'] = array('gt' , $time);
        	$where['status'] = array('neq' , 9);
	        $where['pid'] = $id;
			$rates = $ratem -> where( $where ) -> select();
			//dump($rates);
		}
		$this -> assign("companylist",$rates);
		$this -> display();
	}
}