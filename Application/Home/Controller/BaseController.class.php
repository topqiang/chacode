<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller{
	public function _initialize(){
		$user = session('usid');
		$this -> appid = "wx83c3034ad39a324";
		$this -> scret = "ea225bd96b57b93dc4712f66f9e018e9";
		$redirect_uri = "http://chacode.txunda.com/index.php?s=/Index/index";
		$isweixin = preg_match('/MicroMessenger/',$_SERVER['HTTP_USER_AGENT']);

		$state = $_REQUEST['state'];
		if ($state) {
		 	echo "回调成功！";
		 	exit();
		}
		// echo ($user);
		if (!isset($user) && $isweixin) {
			$code = session('code');
			if (!isset($code)) {
				$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=snsapi_base&state=weixin#wechat_redirect";
		// 		echo "$url";
		// 		exit();
				echo "$url";
	 			Header("Location: $url");
			}
		 	exit();
		}
	}
}