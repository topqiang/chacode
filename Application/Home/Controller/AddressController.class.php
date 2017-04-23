<?php
namespace Home\Controller;
use Think\Controller;

/**
 * Class RoomController
 * @package Home\Controller
 */
class AddressController extends BaseController{
	public function _initialize(){
		parent::_initialize();
	}
	
	public function address(){
		$this->assign('ip',get_client_ip());
		$this->display();
	}

	public function wxaddress(){
		$fromlat = $_GET['fromlat'];
		$fromlng = $_GET['fromlng'];
		$tolat = $_GET['tolat'];
		$tolng = $_GET['tolng'];
		$url = "http://api.map.baidu.com/direction/v2/transit?origin=$fromlat,$fromlng&destination=$tolat,$tolng&ak=l51Pp7gkTg8aqPNIgUh3UlClq8NBBeza";
		$datajson = $this -> curl( "" , $url);
		if ( $datajson ) {
			$obj = json_decode($datajson,true);
			apiResponse( "success" , "返回成功！" , $obj );
		}else{
			apiResponse( "error" , "返回错误！" );
		}
	
	}

	public function curl($data,$url,$type="POST"){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT,  'Mozilla/5.0 (compatible;MSIE 5.01;Windows NT5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo=curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_errno($ch);
        }
        curl_close($ch);
        return $tmpInfo;
    }
}
