<?php
namespace Wap\Controller;
use Think\Controller;

/**
 * Class IndexController
 * @package Wap\Controller
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
        $this -> assign('citylist',$city);
        $this -> display();
    }

    public function wxcity(){
        $time = date('Y/m/d');
        $where['b_time'] = array('lt' , $time);
        $where['e_time'] = array('gt' , $time);
        $where['status'] = array('neq' , 9);
        $gsid = $_GET['gsid'];
        $compan = M('Company');
        $where['paygoods'] = array('like',"%$gsid%");
        $city = $compan -> distinct(true) -> field('provance') -> where($where) -> select();
        if ($city) {
            apiResponse('success','查询成功！',$city);
        }else{
            apiResponse('error','查询失败！');
        }
    }

    public function index(){
        $this -> display();
    }
}
