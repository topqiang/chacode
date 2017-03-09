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
        $this->article = D('Qcode');
        header("Content-type: text/html; charset=utf-8");
    }
    /**
     * 菜单列表
     */
    public function qcodeList(){
        $art_result = $this->article->searchArticle('','ctime desc',13);
        $this->assign('page',$art_result['page_info']);
        $this->assign('art_list',$art_result['list']);
        $this->display('articleList');
    }

}