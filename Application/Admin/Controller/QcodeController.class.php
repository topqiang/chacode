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

        if(!empty($_POST['name']))$where['name']=array('like','%'.$_POST['name'].'%');
        if(!empty($_POST['creatcode']))$where['creatcode']=$_POST['creatcode'];
        if(!empty($_POST['codenum']))$where['codenum']=$_POST['codenum'];

        $where['status'] = array('neq' , '9');
        $count = $this -> qcode -> where( $where ) -> count();
        $page = new \Think\Page($count,15);
        $res=$this -> qcode -> where($where) -> limit($page->firstRow,$page->listRows) -> select();
        $this->assign('list',$res);
        $this->assign('page',$page->show());
        $this->display('qcodeList');
        
    }

}