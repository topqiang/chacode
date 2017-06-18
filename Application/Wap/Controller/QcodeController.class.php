<?php
namespace Wap\Controller;
use Think\Controller;
/**
* 
*/
class QcodeController extends BaseController{
	
	public function _initialize(){
		parent::_initialize();
		$this -> qcg = M('Qcg');
		$this -> qcode = M('Qcode');
		$this -> log = M('Log');

	}
	
	public function findcode(){
		$arg = $_GET['code_name'];
		if (empty($arg)) {
			$this -> display();
			exit();
		}
		$whe['wxcode'] = array('like',"%$arg%");
		$whe['provance'] = array('like',"%$arg%");
		$whe['name'] = array('like',"%$arg%");
		$whe['_logic'] = 'OR';
		$ratem = M('Company');
		$rates = $ratem -> where( $whe ) -> select();
		if ( $rates ) {
			$this -> assign("companylist",$rates);
			$this -> display();
			exit();
		}
		$where['codenum'] = $arg;
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

	public function fa(){
		$compid = $_POST['compid'];
		$gname = $_POST['gname'];
		$start = strtoupper($_POST['start']);
		$end = strtoupper($_POST['end']);
		if (substr($start,0,4) == substr($end,0,4)) {
			$whe['codenum'] = array(array('egt',$start),array('elt',$end),'and');
			$whe['name'] = $gname;
			$whe['curcomid'] = session("shop_id");
			$count = $this -> qcg -> where( $whe ) -> count();
			if ($count) {
				$where['codenum'] = array(array('egt',$start),array('elt',$end),'and');
				$data['curcomid'] = $compid;
				$istrue = $this -> qcode -> where( $where ) -> save( $data );
				if ($istrue) {
					//$num = intval(substr($end,4,6)) - intval(substr($start,4,6))+1;
					$num = $istrue;
					$logobj = array(
						'fromcid' => session("shop_id"),
						'tocid' => $compid,
						'begin' => $start,
						'code' => substr($start,0,4),
						'end' => $end, 
						'status' => 0, 
						'num' => $num,
						'time' => time(), 
						'gname' => $gname
						);
					$islog = $this -> log -> add($logobj);
					if ($islog) {
						apiResponse("success","发货成功！");
					}
				}else{
					apiResponse("error","发货失败！");
				}
			}else{
				apiResponse("error","未找到符合条件的产品！");
			}

		}else{
			apiResponse("error","初始编码不同！");
		}
	}

	public function tuihuo(){
		$id = $_GET['id'];
		$res = $this -> log -> where("id=$id") -> find();
		$this -> assign('pname',session('pname'));
		$this -> assign("res",$res);
		$this -> display();
	}


	public function tui(){
		$start = strtoupper($_POST['start']);
		$end = strtoupper($_POST['end']);
		$where['codenum'] = array(array('egt',$start),array('elt',$end),'and');
		$where['curcomid'] = session("shop_id");
		$data['curcomid'] = $_POST['compid'];
		$istrue = $this -> qcode -> where( $where ) -> save( $data );
		//$num = intval(substr($end,4,6)) - intval(substr($start,4,6))+1;
		if ($istrue) {
			$num = $istrue;
			$logobj = array(
				'fromcid' => $_POST['compid'],
				'tocid' => session("shop_id"),
				'begin' => $start,
				'code' => substr($start,0,4),
				'end' => $end, 
				'status' => 1,
				'num' => $num,
				'time' => time(),
				'remark' => $_POST['remark'],
				'gname' => $_POST['gname']
			);

			$thdui = $this -> log -> add($logobj);

			if ($thdui) {
				apiResponse("success","退货成功！");
			}else{
				apiResponse("error","退货成功,记录失败！");
			}
		}else{
			apiResponse("error","退货失败！请确认该商品是否在仓库！");
		}

	}

	public function fahuo(){
		$id = session('shop_id');
		$ratem = M('Company');
		if (!empty($id)) {
			$time = date('Y/m/d');
        	$where['b_time'] = array('elt' , $time);
        	$where['e_time'] = array('egt' , $time);
        	$where['status'] = array('neq' , 9);
	        $where['pid'] = $id;
			$rates = $ratem -> where( $where ) -> select();
		}
		$this -> assign("companylist",$rates);
		$rate = $ratem -> where( "id = $id" ) -> find();
		$whe['id'] = array('in' , $rate['paygoods']);
		$res = M('goods') -> where($whe) -> select();
		$this -> assign("goods",$res);
		$this -> display();
	}

}