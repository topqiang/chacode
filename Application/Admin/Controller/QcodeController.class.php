<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * Class ArticleController
 * @package Admin\Controller
 */
class QcodeController extends AdminBasicController{

    public $article = '';
    public function _initialize(){
        $this->qcode = D('Qcg');
        header("Content-type: text/html; charset=utf-8");
    }
    /**
     * 菜单列表
     */
    public function qcodeList(){

        if(!empty($_REQUEST['name'])){
            $where['name']=array('like','%'.$_REQUEST['name'].'%');
            $map['name'] = $_REQUEST['name'];
        }
        if(!empty($_REQUEST['creatcode'])){
            $where['creatcode']=$_REQUEST['creatcode'];
            $map['creatcode'] = $_REQUEST['creatcode'];
        }
        if(!empty($_REQUEST['codenum'])){
            $where['codenum']=$_REQUEST['codenum'];
            $map['codenum'] = $_REQUEST['codenum'];
        }


        $where['status'] = array('neq' , '9');

        $count = $this -> qcode -> where( $where ) -> order('visnum desc,id desc') -> count();
        $page = new \Think\Page($count,15);
        foreach($map as $key=>$val) {
            $page->parameter[$key]   =   $val;
        }
        $res=$this -> qcode -> where($where) -> order('id desc') -> limit($page->firstRow,$page->listRows) -> select();


        $this->assign('list',$res);
        $this->assign('page',$page->show());
        $this->display('qcodeList');
        
    }

    public function loglist(){
        $logcom = M('Logcom');
        $where['status'] = array('neq' , '9');
        if(!empty($_REQUEST['gname'])){
            $where['gname']=array('like','%'.$_REQUEST['gname'].'%');
            $map['gname'] = $_REQUEST['gname'];
        }
        $b_time = strtotime($_REQUEST['b_time']);
        $e_time = strtotime($_REQUEST['e_time']);
        if(!empty($b_time) && !empty($e_time)){
            $where['time']=array(array('egt',$b_time),array('elt',$e_time),'and');
            $map['time'] = $where['time'];
        }
        $count = $logcom -> where( $where ) -> count();
        $page = new \Think\Page($count,15);
        foreach($map as $key=>$val) {
            $page->parameter[$key]   =   $val;
        }
        $res=$logcom -> where($where) -> limit($page->firstRow,$page->listRows) -> select();
        
        $this->assign('list',$res);
        $this->assign('page',$page->show());

        $this -> display();
    }

    public function qcodeDel(){
        if(empty($_GET['id']))$this->error('没有商品id');
        
        $res=$this->qcode->save(array('id'=>$_GET['id'],'status'=>"9"));
        if($res){
            $this->success('删除成功',U('Qcode/qcodeList'));
        }else{
            $this->error('删除失败');
        }
    }

}