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
        $this -> company = D('Company');
    }

    public function login(){
        $wxcode = $_POST['wxcode'];
        $password = $_POST['password'];
        if ($wxcode && $password) {
            $wh = array(
                'wxcode' => $wxcode
                );
            $curobj = $this -> company -> where($wh) -> find();
            $time = date('Y/m/d');
            $wh['b_time'] = array('lt' , $time);
            $wh['e_time'] = array('gt' , $time);
            $wh['status'] = array('neq' , 9);
            $obj = $this -> company -> where($wh) -> find();
            if ($obj) {
                if (md5($password) == $obj['password']) {
                    session("shop_id",$obj['id']);
                    session("class",$obj['class']);

                    session("pname",$obj['pname']);
                    apiResponse('success','登录成功！');
                }else{
                    apiResponse('error','密码错误！');
                }
            }else{
                if ($curobj) {
                    apiResponse('error','审核中！');
                }
                apiResponse('error','用户不存在！');
            }
        }else{
            apiResponse("error","信息输入有误！");
        }
    }

    public function main(){
        $log = M('Log');
        $com_id = session("shop_id");
        $serday = time()-7*24*60*60;
        $thirty = time()-30*24*60*60;
        $time = date('Y/m/d');
        $where['pid'] = $com_id;
        $where['status'] = array('neq' , 9);
        $where['b_time'] = array('lt' , $time);
        $where['e_time'] = array('gt' , $time);
        $cnum = $this -> company -> where($where) -> count('id');
        $w['fromcid'] = $com_id;
        $w['time'] = array('gt',$serday);
        $snum = $log -> where($w) -> sum('num');
        $w['time'] = array('gt',$thirty);
        $tnum = $log -> where($w) -> sum('num');

        $this -> assign('cnum',$cnum ? $cnum : 0);
        $this -> assign('snum',$snum ? $snum : 0);
        $this -> assign('tnum',$tnum ? $tnum : 0);
        $this -> assign('class',session("class"));
        $this -> display();
        //$num = $log -> where($wh) -> sum('num');
    }

    public function index(){
         session("shop_id",null);
        $this -> display();
    }
}
