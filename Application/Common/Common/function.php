<?php
/**
 * 公共函数
 */

/**
 * 获得天数 return day_num
 */
function getDayNum($year,$month){
	if(in_array($month,array('01','03','05','07','08','10','12'))){
		$day_num = 31;
	}elseif(in_array($month,array('04','06','09','11'))){
		$day_num = 30;
	}else{
		if ($year%4==0 && ($year%100!=0 || $year%400==0)) {
			$day_num = 29;
		}else{
			$day_num = 28;
		}
	}
	return $day_num;
}
/**
 * 数组转换成字符串  2013-8-27 16:08:25
 * @param array $arr 要转换的数组
 * @return string $str 字符串   逗号分隔
 */
function arrayToString($arr=array()){
	//判断是否为字符串
	if(!is_array($arr)) return '';
	//记录循环次数
	$number = 0;
	//传入数组长度
	$length = count($arr);
	//返回的字符串
	$str='';
	//遍历数组
	foreach ($arr as $val){
		if($number==($length-1)){
			$str .= $val;
		}else{
			$str .= $val.',';
		}
		$number++;
	}
	return $str;
}

/**剥离转义
 * @param $string
 *
 * @return array|string
 */
function sstripslashes($string){
	if(is_array($string)){
		foreach($string as $key => $val){
			$string[$key] = sstripslashes($val);
		}
	}else{
		$string = stripslashes($string);
	}
	return $string;
}
/**
 * 过滤掉html标签 2013-8-3 15:06:38
 * */
function filterHtml($str){
	if(is_array($str)){
		foreach($str as $key => $val){
			$str[$key] = sstripslashes(preg_replace("/(\<[^\<]*\>|\r|\n|\s|\&nbsp;|\[.+?\])/is", '', $val));
		}
	}else{
		$str = preg_replace("/(\<[^\<]*\>|\r|\n|\s|\&nbsp;|\[.+?\])/is", '', $str);
	}
	return $str;
}
/**
 * 上传图片公共函数
 */
function uploadThemeImg($file){
	//load("@.uploadfile");
	include_once 'uploadfile.php';
	$save_path = "./Uploads/".$file."/".date('Ym')."/";
	$upload_info = getUpLoadFiles('',$save_path,'','','200','200','',$is_thumb=true);
	if(count($upload_info[0])<=1){
		return array('error'=>$upload_info);
	}else{
		foreach($upload_info as $k=>$v){
			$url_arr[]=date('Ym')."/".$v['savename'];
		}
	}
	return $url_arr;
}

/**获得图片缩略图文件名
 * @param $filename
 *
 * @return string
 */
function getThumb($filename){
	$dir=substr($filename,0,6);
	$name=substr($filename,7,17);
	return $dir.'/thumb_'.$name;
}

/**
 * @param $filename
 * @param $dirname
 *
 * @return bool
 */
function delPicFile($filename,$dirname){
	if(!empty($filename)){
		unlink('./Uploads/'.$dirname.'/'.$filename);
		$dir=substr($filename,0,6);
		$file=substr($filename,7,17);
		unlink('./Uploads/'.$dirname.'/'.$dir.'/thumb_'.$file);
	}
	return true;
}

/**合并数组,重组数组键值，删除空元素,会丢失数组的字符键值，只保存重组后的数字键值
 * @param $arr1
 * @param $arr2
 *
 * @return array
 */
function arrMerge($arr1,$arr2){
	if(empty($arr1))return $arr2;
	if(empty($arr2))return $arr1;
	if(!is_array($arr1))$arr1[]=$arr1;
	if(!is_array($arr2))$arr2[]=$arr2;
	foreach($arr1 as $k=>$v){
		if(!empty($v))$arr[]=$v;
	}
	foreach($arr2 as $k=>$v){
		if(!empty($v))$arr[]=$v;
	}
	return $arr;
}


/**
 * @param $filename
 * @param $dirname
 *
 * @return string
 */
function getPicUrl($filename,$dirname){
	return C('API_URL').'/Uploads/'.$dirname.'/'.$filename;
}

/**验证提交数据
 * @param $arr=array(验证格式数组
 * 				'fields_name'=>'text,null,length,type',如果不限制为空并且数据是空值的话，不会进行长度和类型的判断
 * 			);
 * @param $check_data验证数据数组
 *
 * @return array|bool
 */
function checkData($arr,$check_data){
	if(empty($check_data))return array('flag'=>'error','message'=>'empty:check_data');
	if(empty($arr))return array('flag'=>'error','message'=>'empty:arr');
	/*$data_type=array(
		'email'	=>'/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',
		'mobile'=>'/^((0?1[358]\d{9})|((0(10|2[1-3]|[3-9]\d{2}))?[1-9]\d{6,7}))$/',
		'phone'	=>'/^\d{3,4}-\d{7,8}(-\d{3,4})?$/',
		'date'	=>'/^\d{4}\-\d{2}\-\d{2}$/',
		'time'	=>'/^(0\d{1}|1\d{1}|2[0-3]):([0-5]\d{1})$/',
		'num'	=>'/^[0-9]*$/',//任意位数数字
	);*/
	$data_type=array(
		'email'	=>C('EMAIL'),
		'mobile'=>C('MOBILE'),
		'phone'	=>C('PHONE'),
		'date'	=>C('DATE'),
		'time'	=>C('TIME'),
		'num'	=>'/^[0-9]*$/',//任意位数数字
	);
	foreach($arr as $k=>$v){
		$old_arr[$k]=explode(',',$v);
	}
	//重组数组键值
	foreach($old_arr as $k=>$v){
		//提示文字
		if(empty($v[0])){
			$data[$k]['text']	=$k;
		}else{
			$data[$k]['text']	=$v[0];
		}
		//是否允许为空
		if(!empty($v[1])){
			$data[$k]['null']	=$v[1];
		}
		//处理长度
		if(empty($v[2])){
			$data[$k]['length']	=$v[2];
		}else{
			if(strpos($v[2],'-')){
				$data[$k]['length']	=explode('-',$v[2]);
			}else{
				$data[$k]['length'][0]=0;
				$data[$k]['length'][1]=$v[2];
			}
		}
		//检测数据类型
		if(!empty($v[3])){
			$data[$k]['type']	=$v[3];
		}
	}

	foreach($data as $k=>$v){
		//判空
		if(!empty($v['null'])){
			if(empty($check_data[$k]))return array('flag'=>'error','message'=>$v['text'].'为空');
		}
		//判断字段长度
		if(!empty($v['length']) and !empty($check_data[$k])){
			if(strlen($check_data[$k])>$v['length'][1])return array('flag'=>'error','message'=>$v['text'].'不得超过'.$v['length'][1].'位');
			if(strlen($check_data[$k])<$v['length'][0])return array('flag'=>'error','message'=>$v['text'].'最少'.$v['length'][0].'位');
		}
		//判断字段类型
		if(!empty($v['type']) and !empty($check_data[$k])){
			if(!preg_match($data_type[$v['type']],$check_data[$k]))return array('flag'=>'error','message'=>$v['text'].'格式错误');
		}
	}
	
	return array('flag'=>'success','message'=>'success');
}

/**函数返回信息格式函数
 * @param        $message
 * @param string $flag
 *
 * @return array
 */
function errorInfo($message,$flag='error'){
	$arr = array('flag'=>$flag,'message'=>$message);
	return $arr;
}

/**API返回信息格式函数
 * @param        $message
 * @param string $flag
 */
function errorApi($message,$flag='error'){
	$arr = array('flag'=>$flag,'message'=>$message);
	print json_encode($arr);exit;
}

/**判空，转换时间戳，序列化数组转字符串，过滤html标签等
 * @param $list
 * @param $rule
 */
function apiChangeDate($list,$rule){
	
}

function apiResponse($flag = 'error', $message = '',$data = array()){
    $result = array('flag'=>$flag,'message'=>$message,'data'=>$data);
    print json_encode($result);exit;
}


/**
 * 功能：生成二维码
 * @param string $qr_data   手机扫描后要跳转的网址
 * @param string $qr_level  默认纠错比例 分为L、M、Q、H四个等级，H代表最高纠错能力
 * @param string $qr_size   二维码图大小，1－10可选，数字越大图片尺寸越大
 * @param string $save_path 图片存储路径
 * @param string $save_prefix 图片名称前缀
 */
function createQRcode($save_path,$qr_data='PHP QR Code :)',$qr_level='L',$qr_size=4,$save_prefix='qrcode'){
    if(!isset($save_path)) return '';
    //设置生成png图片的路径
    $PNG_TEMP_DIR = & $save_path;
    //导入二维码核心程序
    vendor('PHPQRcode.class#phpqrcode');//注意这里的大小写哦，不然会出现找不到类，PHPQRcode是文件夹名字，class#phpqrcode就代表class.phpqrcode.php文件名
    //检测并创建生成文件夹
    if (!file_exists($PNG_TEMP_DIR)){
        mkdir($PNG_TEMP_DIR);
    }
    $filename = $PNG_TEMP_DIR.'test.png';
    $errorCorrectionLevel = 'L';
    if (isset($qr_level) && in_array($qr_level, array('L','M','Q','H'))){
        $errorCorrectionLevel = & $qr_level;
    }
    $matrixPointSize = 4;
    if (isset($qr_size)){
        $matrixPointSize = & min(max((int)$qr_size, 1), 10);
    }
    if (isset($qr_data)) {
        if (trim($qr_data) == ''){
            die('data cannot be empty!');
        }
        //生成文件名 文件路径+图片名字前缀+md5(名称)+.png
        $filename = $PNG_TEMP_DIR.$save_prefix.md5($qr_data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        //开始生成
        QRcode::png($qr_data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    } else {
        //默认生成
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    }
    if(file_exists($PNG_TEMP_DIR.basename($filename)))
        return basename($filename);
    else
        return FALSE;
}


