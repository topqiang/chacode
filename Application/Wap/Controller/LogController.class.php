<?php
namespace Wap\Controller;
use Think\Controller;

/**
 * Class IndexController
 * @package Wap\Controller
 */
class LogController extends BaseController {
    public function _initialize(){
    	parent::_initialize();
    	//完善购物车数量查询
        $this -> log = D('Log');
        $this -> logcom = D('Logcom');

    }

    public function loglist(){
        $id = session('shop_id');
        $where['fromcid'] = $id;
        $where['tocid'] = $id;
        $where['_logic'] = "or";

        $res = $this -> log -> where($where) -> order('time desc') -> select();
        // echo $this -> log -> getLastsql();
        // exit();
        if ( $res ) {
            $this -> assign('pname',session('pname'));
            $this -> assign('reslist',$res);
        }
        $this -> assign('shop_id',$id);

        $this -> display();
    }

    public function logbytime(){
        if ($_POST['b_time']) {
            $id = session('shop_id');
            $where['fromcid'] = $id;
            $where['tocid'] = $id;
            $where['_logic'] = "or";
            $btime = strtotime($_POST['b_time']);
            $etime = strtotime($_POST['e_time']);
            $res = $this -> logcom -> where("(fromcid=$id or tocid =$id) and time >= $btime and time <= $etime") -> select();
            // exit();
            if ( $res ) {
                $this -> assign('reslist',$res);
            }
        }

        $this -> display();
    }

    public function index(){
        $this -> display();
    }
}
