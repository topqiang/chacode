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
            $map['name'] = $where['name'];
        }
        if(!empty($_REQUEST['creatcode'])){
            $where['creatcode']=$_REQUEST['creatcode'];
            $map['creatcode'] = $where['creatcode'];
        }
        if(!empty($_REQUEST['codenum'])){
            $where['codenum']=$_REQUEST['codenum'];
            $map['codenum'] = $where['codenum'];
        }


        $where['status'] = array('neq' , '9');

        $count = $this -> qcode -> where( $where ) -> count();
        $page = new \Think\Page($count,15);
        foreach($map as $key=>$val) {
            $page->parameter[$key]   =   urlencode($val);
        }
        $res=$this -> qcode -> where($where) -> limit($page->firstRow,$page->listRows) -> select();


        $this->assign('list',$res);
        $this->assign('page',$page->show());
        $this->display('qcodeList');
        
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