<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * Class OrderController
 * @package Admin\Controller
 */
class CompanyController extends AdminBasicController{
    public function _initialize(){
        $this->goods = D("Goods");
        $this->company = D("Company");
    }

    public function companyList(){
        
        if(!empty($_POST['name']))$where['name']=array('like','%'.$_POST['name'].'%');
        if(!empty($_POST['provance']))$where['provance'] = $_POST['provance'];
        if(!empty($_POST['tel']))$where['wxcode'] = $_POST['tel'];
        $where['status'] = array('neq' , '9');
        // $time = date('Y/m/d');
        // $where['b_time'] = array('lt' , $time);
        // $where['e_time'] = array('gt' , $time);
        $count = $this -> company -> where($where) -> count();
        $page = new \Think\Page($count,100);
        $res=$this -> company -> where($where) -> limit($page->firstRow,$page->listRows) -> select();
        //echo $this -> company -> getLastSql();
        //exit();
        $this->assign('list',$res);
        $this->assign('page',$page->show());
        $this->display('companyList');
    }

    public function companyAdd(){
        if(empty($_POST)){
            $where['status'] = array('neq' , '9');
            $gods = $this->goods ->where($where)->select();
            $this -> assign("goods",$gods);
            $this->display('companyAdd');
        }else{

            if (empty($_POST['name'])) {
                $this->error('经销商不能为空！');
            }
            if (empty($_POST['address'])) {
                $this->error('地址不能为空！');
            }
            if (empty($_POST['boss'])) {
                $this->error('负责人不能为空！');
            }
            if (empty($_POST['b_time'])) {
                $this->error('授权起始时间不能为空！');
            }
            if (empty($_POST['e_time'])) {
                $this->error('授权结束时间不能为空！');
            }
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

            if ($_POST['class'] && $_POST['class']!=1) {
                if ($_POST['pwxcode']) {
                    $info=$this->company->where(array('wxcode'=>$_POST['pwxcode']))->find();
                    if ($info) {
                        $data['pid'] = $info['id'];
                        $data['pname'] = $info['name'];
                        $data['pwxcode'] = $_POST['pwxcode'];
                    }else{
                        $this->error('上级经销商手机号填写有误！');
                    }
                }else{
                    $this->error('上级经销商手机号不能为空！');
                }
            }
            

            if (!empty($_POST['paygoods'])) {
                $data['paygoods'] = implode(",",$_POST['paygoods']);
            }

            // tel 公司logo
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
            $where['status'] = array('neq' , '9');
            $gods = $this->goods->where($where)->select();
            $this -> assign("goods",$gods);

            $this->assign('id',$_GET['id']);
            $info=$this->company->where(array('id'=>$_GET['id']))->select();
                $info[0]['paygoods'] = explode(',', $info[0]['paygoods']);

            $this->assign('info',$info[0]);
            $this->display('companyEdit');
        }else{


            if (empty($_POST['name'])) {
                $this->error('经销商不能为空！');
            }
            if (empty($_POST['address'])) {
                $this->error('地址不能为空！');
            }
            if (empty($_POST['boss'])) {
                $this->error('负责人不能为空！');
            }
            if (empty($_POST['b_time'])) {
                $this->error('授权起始时间不能为空！');
            }
            if (empty($_POST['e_time'])) {
                $this->error('授权结束时间不能为空！');
            }

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
                'b_time'        =>$_POST['b_time'],
                'e_time'        =>$_POST['e_time'],
                'status'        =>0,
            );

            if ($_POST['class'] && $_POST['class']!=1) {
                if ($_POST['pwxcode']) {
                    $info=$this->company->where(array('wxcode'=>$_POST['pwxcode']))->find();
                    if ($info) {
                        $data['pid'] = $info['id'];
                        $data['pname'] = $info['name'];
                        $data['pwxcode'] = $_POST['pwxcode'];
                    }else{
                        $this->error('上级经销商手机号填写有误！');
                    }
                }else{
                    $this->error('上级经销商手机号不能为空！');
                }
            }else{
                $data['pid'] = 0;
                $data['pwxcode'] = "";
            }

            if (!empty($_POST['paygoods'])) {
                $data['paygoods'] = implode(",",$_POST['paygoods']);
            }

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
        $res = $this->company->save(array('id'=>$_GET['id'],'status'=>"9"));
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
