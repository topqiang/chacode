<?php
namespace Home\Controller;
use Think\Controller;

/**
 * Class IndexController
 * @package Home\Controller
 */
class IndexController extends BaseController {
    public function _initialize(){
    	parent::_initialize();
    	//完善购物车数量查询
        $this -> assign('ip',get_client_ip());
    }

    public function result(){
        $this -> display();
    }

    public function city(){
        $time = date('Y/m/d');
        $where['b_time'] = array('lt' , $time);
        $where['e_time'] = array('gt' , $time);
        $where['status'] = array('neq' , 9);
        $gsid = session('gsid');
        $compan = M('Company');
        $where['paygoods'] = array('like',"%$gsid%");
        $city = $compan -> distinct(true) -> field('provance') -> where($where) -> select();
        echo $compan->getLastSql();
        exit();
        $this -> assign('citylist',$city);
        $this -> display();
    }

    public function index(){
        $this -> display();
    }
}
