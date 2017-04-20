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

    public function wxupload(){
        $upload_res=$this->upload();
        if($upload_res['flag']=='success'){
            $data['pic']="Uploads/report/".$upload_res['result'];
            apiResponse("success","上传成功！",$data);
        }else{
            apiResponse("error","上传失败！");
        }
    }

    /**
     * 处理商品图片上传
     */
    public function upload(){
        if(empty($_FILES['pic']['name'])){
            $is_upload=false;
        }else{
            $is_upload=true;
        }
        /*foreach($_FILES['pic']['name'] as $k=>$v){
            if(!empty($v))$is_upload=true;
        }*/
        if($is_upload){
            //load("@.function.php");
            $upload_res=$this->uploadThemeImg('report');
            if(empty($upload_res['error'])){
                return array('flag'=>'success','result'=>$upload_res[0]);
            }else{
                return array('flag'=>'error','result'=>$upload_res['error']);//$this->error($upload_res['error']);
            }
        }else{
            return array('flag'=>'no');
        }
    }

    /**
     * 上传图片公共函数
     */
    function uploadThemeImg($file){

        //load("@.uploadfile");
        //include_once 'uploadfile.php';
        $save_path = "./Uploads/".$file."/".date('Ym')."/";
        //$save_path = "./Uploads/".$file."/201404/";
        $upload_info = $this->getUpLoadFiles('',$save_path,'','','200','200','');
        if(count($upload_info[0])<=1){
            return array('error'=>$upload_info);
        }else{
            foreach($upload_info as $k=>$v){
                $url_arr[]=date('Ym')."/".$v['savename'];
            }
        }
        return $url_arr;
    }



    /*
 * by king 2013年5月10日15:08:49
 * 自定义 简单上传类
 * 参数：$name-定义文件上传命名规则
 *      $url-原图保存地址
 *      $maxsize-文件最大 大小
 *      $type-上传文件类型
 *      $width-缩略图宽
 *      $height-缩略图高
 *      $thumb_pre-缩略图前坠名
 * 成功返回 上传后的信息
 * 失败返回异常名称
 * */
    function getUpLoadFiles($name,$url,$maxsize,$type,$width,$height,$thumb_pre,$is_thumb=false)
    {
        $upload = new \Think\UploadFile();
        $upload->maxSize        = !empty($maxsize)?$maxsize:20480000;
        $upload->allowExts      = is_array($type)?$type:array('jpg','png','jpeg','bmp','gif');
        $upload->savePath       = isset($url)?$url:'./Uploads'.date("Ym").'/';
        $upload->saveRule       = !empty($name)?$name:'uniqid';       //保存文件命名规则 如果不是规则的关键字 默认设为上传的文件名称

        if($is_thumb)
        {
            //生成缩略图
            $upload->thumb          = true;
            $upload->thumbPath      = isset($url)?$url:'./Uploads'.date("Ym").'/';
            $upload->thumbPrefix    = !empty($thumb_pre)?$thumb_pre:'thumb_';
            $upload->thumbMaxWidth  = $width;
            $upload->thumbMaxHeight = $height;
            $upload->uploadReplace = true;
        }
        if($upload->Upload())
        {
            $info = $upload->getUploadFileInfo();
            return $info;
        }
        else
        {
            return $upload->getErrorMsg();
        }
    }
}