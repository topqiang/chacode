<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * Class OrderController
 * @package Admin\Controller
 */
class CompanyController extends AdminBasicController{
    public function _initialize(){
        $this->company = D("Company");
    }

    public function companyList(){
        
        if(!empty($_POST['name']))$where['name']=array('like','%'.$_POST['name'].'%');
        if(!empty($_POST['provance']))$where['provance'] = $_POST['provance'];
        $where['status'] = array('neq' , '9');
        $count = $this -> company -> where($where) -> count();
        $page = new \Think\Page($count,15);
        $res=$this -> company -> where($where) -> limit($page->firstRow,$page->listRows) -> select();
        $this->assign('list',$res);
        $this->assign('page',$page->show());
        $this->display('companyList');
    }

    public function companyAdd(){
        if(empty($_POST)){
            $this->display('companyAdd');
        }else{
            //存储数据
            $data=array(
                'name'          =>$_POST['name'],
                'address'       =>$_POST['address'],
                'boss'          =>$_POST['boss'],
                'wxcode'        =>$_POST['wxcode'],
                'email'         =>$_POST['email'],
                'class'         =>$_POST['class'],
                'provance'      =>$_POST['provance'],
                'lat'           =>$_POST['lat'],
                'lnt'           =>$_POST['lnt'],
                'b_time'        =>$_POST['b_time'],
                'e_time'        =>$_POST['e_time'],
                'status'        =>0,
            );
            if (!empty($_FILES['tel'])) {
                $res = $this -> upload('tel','company');
                if ($res != 'error') {
                    $data['tel'] = $res;
                }
            }
            $res=$this->company->add($data);
            if($res){
                $this->success('添加成功',U('Company/companyList'));
            }else{
                $this->error('添加失败');
            }
        }
    }

    public function companyEdit(){
        if(empty($_GET['id']))$this->error('没有商品id');
        if(empty($_POST)){
            $this->assign('id',$_GET['id']);
            $info=$this->company->where(array('id'=>$_GET['id']))->select();
            $this->assign('info',$info[0]);
            $this->display('companyEdit');
        }else{
            $data=array(
                'id'            =>$_GET['id'],
                'name'          =>$_POST['name'],
                'address'       =>$_POST['address'],
                'boss'          =>$_POST['boss'],
                'wxcode'        =>$_POST['wxcode'],
                'email'         =>$_POST['email'],
                'class'         =>$_POST['class'],
                'provance'      =>$_POST['provance'],
                'lat'           =>$_POST['lat'],
                'lnt'           =>$_POST['lnt'],
                'b_time'        =>strtotime($_POST['b_time']),
                'e_time'        =>strtotime($_POST['e_time']),
                'status'        =>0,
            );
            if (!empty($_FILES['tel'])) {
                $res = $this -> upload('tel','company');
                if ($res != 'error') {
                    $data['tel'] = $res;
                }
            }
            $res=$this->company->save($data);
            if($res){
                $this->success('修改成功',U('Company/companyList'));
            }else{
                $this->error('修改失败');
            }
        }
    }
    public function companyDel(){
        if(empty($_GET['id']))$this->error('没有经销商id');
        $res=$this->goods->save(array('id'=>$_GET['id'],'status'=>"9"));
        if($res){
            $this->success('删除成功',U('Company/companyList'));
        }else{
            $this->error('删除失败');
        }
    }

    public function upload($filename,$path){
        $config = array(
            'subName'    =>    $path, //设置文件名
        );
        $upload = new \Think\Upload($config);
        $upload->maxSize   =     30145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'pdf', 'mp4');// 设置附件上传类型
        $upload->rootPath  =      './Uploads/' .$path. '/'; // 设置附件上传根目录

        $upload->saveRule       = !empty($name) ? $name : 'uniqid' ;      //保存文件命名规则
        // 上传单个文件 
        $info = $upload->uploadOne($_FILES[$filename]);
        if(!$info) {// 上传错误提示错误信息
            return "error";
        }else{// 上传成功 获取上传文件信息
            return $info['savepath'].$info['savename'];
        }
    }
}
