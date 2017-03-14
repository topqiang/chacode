<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller{
	public function _initialize(){
		$user = session('usid');
		$this -> appid = "wx245365f89e539e23";
		$this -> scret = "e78d55752e8b5b31e4aa10254163c5af";
		$redirect_uri = "http://chacode.txunda.com"."/".$_SERVER['REQUEST_URI'];
		$isweixin = preg_match('/MicroMessenger/',$_SERVER['HTTP_USER_AGENT']);

		$state = $_REQUEST['state'];
		if (isset($state)) {
			echo "回调成功！";
		}
		echo ($user);
		if (!isset($user) && $isweixin) {
			$code = session('code');
			if (!isset($code)) {
				$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=snsapi_userinfo&state=weixin#wechat_redirect";
				echo "$url";
				exit();
				Header("Location: $url");
			}
			exit();
		}
	}
}