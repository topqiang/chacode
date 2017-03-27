<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller{
	public function _initialize(){
		$user = session('usid');
		$this -> appid = "wx83c3034ad39a3d24";
		$this -> scret = "ea225bd96b57b93dc4712f66f9e018e9";
		$redirect_uri = "http://chacode.txunda.com/index.php?s=/Index/index";
		$isweixin = preg_match('/MicroMessenger/',$_SERVER['HTTP_USER_AGENT']);

		$state = $_REQUEST['state'];
		$code = $_REQUEST['code'];
		if ($state) {


		 	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this -> appid."&secret=".$this -> scret."&code=$code&grant_type=authorization_code";
			$res = $this -> curl("",$url);
			$access = json_decode($res,true);
			S('access_token',$access['access_token'],2*60*60);
			session('openid',$access['openid']);
			dump($this -> getUserInfo($access['openid'],$access['access_token']));
			//dump($access);
		 	exit();
		}else if (!isset($user) && $isweixin) {
			$code = session('code');
			if (!isset($code)) {
				$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=snsapi_userinfo&state=weixin#wechat_redirect";
		// 		echo "$url";
		// 		exit();
				echo "$url";
	 			Header("Location: $url");
			}
		 	exit();
		}
	}

	public function getUserInfo($openid,$access_token){
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
		$res = $this -> curl("",$url,"GET");
		$access = json_decode($res,true);
		return $access;
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