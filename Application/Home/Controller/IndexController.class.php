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
    }

    public function result(){
        $this -> display();
    }

    public function city(){
        $city = M('Company') -> distinct(true) -> field('provance') -> where(array('status' => array('neq',9))) -> select();
        $this -> assign('ip',get_client_ip());
        $this -> assign('citylist',$city);
        $this -> display();
    }

    public function index(){
        $this -> display();
    }
}
