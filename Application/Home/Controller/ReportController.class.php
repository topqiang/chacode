<?php
namespace Home\Controller;
use Think\Controller;
class ReportController extends BaseController{
	public function _initialize(){
		parent::_initialize();
		$this -> report = M('Report');
	}

	public function addReport(){

		if ( !empty($_POST['name']) && !empty($_POST['tel']) ) {
			
			$data = array(
				'name' =>  $_POST['name'],
				'tel' => $_POST['tel'],
				'pic' => $_POST['pic'],
				'remark' => $_POST['remark'],
				'c_time' => time(),
				'u_time' => time(),
				'status' => 0
				);

			$res = $this -> report -> add( $data );
			if ($res) {
				$ajaxData = array("flag" => "success", "message"=>"举报成功" );
            	$ajaxData['data'] = $res;
            	echo json_encode($ajaxData);
            	exit();
			}
		}
			$ajaxData = array("flag" => "error", "message"=>"举报失败","data" => array());
            echo json_encode($ajaxData);
	}


	public function uploadPic(){
        $pic       = $_POST['pic'];
        $pic_name      = $_POST['pic_name'];
        $temp = explode('.',$pic_name);
        $ext = uniqid().'.'.end($temp);
        $base64    = substr(strstr($pic, ","), 1);
        $image_res = base64_decode($base64);
        $pic_link  = "Uploads/report/".$ext;
        $saveRoot = "Uploads/report/";
        //检查目录是否存在  循环创建目录
        if(!is_dir($saveRoot)){
            mkdir($saveRoot, 0777, true);
        }
        $res = file_put_contents($pic_link ,$image_res);
        if($res){
            $ajaxData = array("flag" => "success", "message"=>"上传成功！" );
            $ajaxData['data'] = $pic_link;
            echo json_encode($ajaxData);
        }else{
            $ajaxData = array("flag" => "error", "message"=>"上传失败","data" => array());
            echo json_encode($ajaxData);
        }
    }
}