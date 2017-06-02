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
					$num = intval(substr($end,4,6)) - intval(substr($start,4,6))+1;
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


	public function tui(){
		$id = $_POST['id'];
		$res = $this -> log -> where("id=$id") -> find();
		if ($res) {
			$where['codenum'] = array(array('egt',$res['begin']),array('elt',$res['end']),'and');
			$where['curcomid'] = session("shop_id");
			$data['curcomid'] = $res['fromcid'];
			$istrue = $this -> qcode -> where( $where ) -> save( $data );
			if ($istrue) {
				$logobj = array(
					'id' => $id,
					'status' => 1
					);
				$thdui = $this -> log -> save($logobj);
				if ($thdui) {
					apiResponse("success","退货成功！");
				}else{
					apiResponse("error","退货成功,记录失败！");
				}
			}else{
				apiResponse("error","退货失败！");
			}
		}else{
			apiResponse("error","不存在！");
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