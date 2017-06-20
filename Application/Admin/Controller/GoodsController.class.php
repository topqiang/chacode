<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends Controller{
	public function _initialize(){
		$this->goods = D("Good");
		$this->qcode = D('Qcode');
        $this->good = D("Goods");
        $this -> qcg = M('Qcg');
        $this -> log = M('Log');
        $this -> company = M('Company');
		$where['status'] = array('neq' , '9');
        $gods = $this->good ->where($where)->select();
        $this -> assign("goodss",$gods);
	}

	public function goodsList(){
		if(!empty($_POST['name']))$where['name']=array('like','%'.$_POST['name'].'%');
		if(!empty($_POST['creatcode']))$where['creatcode']=array('like','%'.$_POST['creatcode'].'%');
		$b_time = strtotime($_REQUEST['b_time']);
        $e_time = strtotime($_REQUEST['e_time']);
        if(!empty($b_time) && !empty($e_time)){
            $where['ctime']=array(array('egt',date('Y/m/d',$b_time)),array('elt',date('Y/m/d',$e_time+24*60*60)),'and');
        }
		$where['status'] = array('neq' , '9');
		$count = $this -> goods -> where($where) -> count();
		$page = new \Think\Page($count,100);
		$res=$this -> goods -> where($where) -> order('id desc,ctime desc') -> limit($page->firstRow,$page->listRows) -> select();
		$this->assign('list',$res);
		$this->assign('page',$page->show());
		$this->display('goodsList');
	}

	public function goodsAdd(){
		if(empty($_POST)){
			$this->display('goodsAdd');
		}else{
			$upload_res=$this->upload();
			if($upload_res['flag']=='no')$this->error('没有商品图片');
			//存储数据
			if (!$_POST['ctime']) {
				$this->error('生产日期不能为空！');
			}
			$data=array(
				'name'			=>$_POST['name'],
				'pic'			=>"Uploads/goods/".$upload_res['result'],
				'ctime'			=>$_POST['ctime'],
				'creatcode'		=>$_POST['creatcode'],
				'status'		=>0,
			);
			$res=$this->goods->add($data);
			if($res){
				$this->success('添加成功',U('Goods/goodsList'));
			}else{
				$this->error('添加失败');
			}
		}
	}

	public function goodsEdit(){
		if(empty($_GET['id']))$this->error('没有商品id');
		if(empty($_POST)){
			$this->assign('id',$_GET['id']);
			$info=$this->goods->where(array('id'=>$_GET['id']))->select();
			$this->assign('info',$info[0]);
			$this->display('goodsEdit');
		}else{
			$upload_res=$this->upload();
			//删除历史缩略图。。。。
			//存储数据
			$data=array(
				'id'			=>$_GET['id'],
				'name'			=>$_POST['name'],
				'creatcode'		=>$_POST['creatcode']
			);
			if($upload_res['flag']=='success')$data['pic']="Uploads/goods/".$upload_res['result'];
			$res=$this->goods->save($data);
			if($res){
				$this->success('修改成功',U('Goods/goodsList'));
			}else{
				$this->error('修改失败');
			}
		}
	}

	public function goodsDel(){
		if(empty($_GET['id']))$this->error('没有商品id');
		
		$res=$this->goods->save(array('id'=>$_GET['id'],'status'=>"9"));
		if($res){
			$this->success('删除成功',U('Goods/goodsList'));
		}else{
			$this->error('删除失败');
		}
	}

	public function createCode($path,$code){
		$save_path = 'Public/qrcode/'.$path.'/';  //图片存储的绝对路径
        $qr_data = "http://".$_SERVER['HTTP_HOST'].U('Home/Qcode/findcode',array('code_name'=>$code));
        $qr_level ='L';
        $qr_size = '4';
        $save_prefix = $code;
        return createQRcode($save_path,$qr_data,$qr_level,$qr_size,$save_prefix);
	}

// 回复二维码
	public function crecode(){
		$p = $_GET['p'];
		$where['status'] = array('neq',9);
		$res = $this -> qcode -> where( $where ) -> field('id,codenum,code_pic') -> order('ctime asc') -> limit(($p-1)*2000,2000) -> select();
		if (empty($res)) {
			echo "数据为空！";
			exit();
		}
		$istrue = true;
		header("Content-type: text/html; charset=utf-8");
		foreach ($res as $key => $value) {
			$code = $value['codenum'];
			$path = $value['code_pic'];
			$filename = strstr($path,$code);
			$save_path = substr($path,1,strlen($path)-1);
			echo "<br>";
			echo $filename;
			echo "<br>";
			echo str_replace($filename,"",$save_path);

			$save_path = str_replace($filename,"",$save_path);  //图片存储的绝对路径
  		      $qr_data = "http://".$_SERVER['HTTP_HOST'].U('Home/Qcode/findcode',array('code_name'=>$code));
  		      $qr_level ='L';
  		      $qr_size = '4';
  		      $save_prefix = $code;
			$istrue = Qcode($save_path,$qr_data,$qr_level,$qr_size,$save_prefix,$filename);
			if ( empty($istrue) ) {
				break;
			}else{
				echo "正确！";
			}
		}
		if ($istrue) {
			echo "正确！";
		}else{
			echo "错误！";
		}
	}

	public function qrcode(){
		set_time_limit(0);
		$id = $_POST['id'];
		$codenum = $_POST['codenum'];
		$start = $_POST['start'];
		$cnum = $_POST['cnum'];

		$ptest = $_POST['ptest'];
		$gname = $_POST['gname'];
		$hasgood = $this->good -> where("name = '".$gname."'") -> find();
		$com = $this -> company -> where( "wxcode=$ptest && class = 1" ) -> find();
        if (empty($com)) {
            apiResponse("error","经销商不存在！");
        }
        $arr = explode(",",$com['paygoods']);
        if ($hasgood) {
        	if (!in_array($hasgood['id'],$arr)) {
        		apiResponse("error","该经销商不具备代理权限");
        	}
        }else{
        	echo $this->good->getLastsql();
        	apiResponse("error","商品不存在！");
        }
		
		$path = $codenum."_".$start;
		$web_path = '/Public/qrcode/'.$path.'/';        //图片在网页上显示的路径
		if (empty($id) || empty($codenum)) {
			$data = array(
				'flag' => 'error',
				'message' => '缺少防伪码'
				);
			echo json_encode($date);
			exit();
		}
		$len = 10-strlen($codenum);
		for ( $i=0; $i < $len-strlen($start); $i++) { 
			$str .="0";
		}
		$startnum = $codenum.$str.$start;
		$length = $this -> qcode -> where(array('codenum' => $startnum)) -> select();

		if ( $length ) {
			echo json_encode(array('flag'=>'error','message'=>'编码已存在！'));
			exit();
		}

		while ( $cnum > 0) {
			$str = "";
			for ( $i=0; $i < $len-strlen($start); $i++) { 
				$str .="0";
			}
			$code = $codenum.$str.$start;
			if ($filename = $this -> createCode($path,$code)) {
				$ctime = time();
				$status = 0;
				$pic = $web_path.$filename;
	            $data = array(
	            	'fromid' => $id,
	            	'codenum' => $code,
	            	'code_pic' => $pic,
	            	'ctime' => $ctime,
	            	'status' => $status,
	            	'curcomid' => 1
	            	);
	            $res = $this->qcode->add($data);
	            if (!$res) {
	            	echo json_encode(array('flag'=>'error','message'=>'保存失败！'));
	            	exit();
	            }
			}else{
				$data = array(
					'flag' => 'error',
					'message' => '生成失败！'
					);
				echo json_encode($date);
				exit();
			}
			++$start;
			--$cnum;
		}
		$gooddata = array(
			'id' => $id,
			'company' => $startnum."---".$code
			);
		$res=$this->goods->save($gooddata);
		if ($res) {
			$this ->fa($ptest,$startnum,$code);
			//echo json_encode(array('flag'=>'success','message'=>'生成成功！'));
		}else{
			echo json_encode(array('flag'=>'error','message'=>'数据保存失败！'));
		}
    }

    public function fa($tel,$start1,$end1){
        $wxcode = $tel;
        $com = $this -> company -> where( "wxcode=$wxcode" ) -> find();
        if (empty($com)) {
            apiResponse("error","经销商不存在！");
        }
        $compid = $com['id'];
        $start = strtoupper($start1);
        $end = strtoupper($end1);
        if (substr($start,0,4) == substr($end,0,4)) {
            $whe['codenum'] = array(array('egt',$start),array('elt',$end),'and');
            $whe['curcomid'] = 1;
            $count = $this -> qcg -> where( $whe ) -> find();
            if ($count) {
                $where['codenum'] = array(array('egt',$start),array('elt',$end),'and');
                $data['curcomid'] = $compid;
                $istrue = $this -> qcode -> where( $where ) -> save( $data );
                if ($istrue) {
                    $num = intval(substr($end,4,6)) - intval(substr($start,4,6))+1;
                    $logobj = array(
                        'fromcid' => 1,
                        'tocid' => $compid,
                        'begin' => $start,
                        'code' => substr($start,0,4),
                        'end' => $end, 
                        'status' => 0, 
                        'num' => $num,
                        'time' => time(), 
                        'gname' => $count['name']
                        );
                    $islog = $this -> log -> add($logobj);
                    if ($islog) {
                        apiResponse("success","发货成功！");
                    }
                }else{
                    apiResponse("error","发货失败！");
                }
            }else{
                apiResponse("error","未找到符合条件的产品！");
            }

        }else{
            apiResponse("error","初始编码不同！");
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
			$upload_res=$this->uploadThemeImg('goods');
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