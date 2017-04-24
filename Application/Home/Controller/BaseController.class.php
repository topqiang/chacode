<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller{
	public function _initialize(){
		$ip = get_client_ip();
		$where['wx_id'] = $ip;
	 	$muser = D('User');
	 	//$userobj = $muser -> where($where) -> select();
	 	$useid = session('usid');
	 	if(!empty( $useid )){
	 		session('usid',$userobj[0]['id']);
	 	}else{
	 		if (preg_match('/iPhone/',$_SERVER['HTTP_USER_AGENT'])) {
	 			$where['address'] = "苹果手机";
	 		}else if (preg_match('/Android/',$_SERVER['HTTP_USER_AGENT'])) {
	 			$where['address'] = "安卓手机";
	 		}else if (preg_match('/iPad/',$_SERVER['HTTP_USER_AGENT'])) {
	 			$where['address'] = "iPad平板";
	 		}else if (preg_match('/Firefox/',$_SERVER['HTTP_USER_AGENT'])) {
	 			$where['address'] = "火狐内核浏览器";
	 		}else if (preg_match('/Chrome/',$_SERVER['HTTP_USER_AGENT'])) {
	 			$where['address'] = "谷歌内核浏览器";
	 		}else if (preg_match('/MSIE/',$_SERVER['HTTP_USER_AGENT'])) {
	 			$where['address'] = "IE内核";
	 		}else{
	 			$where['address'] = "PC电脑";
	 		}

	 		if ($_GET['motype'] || $_POST['motype']) {
	 			$where['address'] = $where['address']."小程序";
	 		}

	 		$where['useragent'] = $_SERVER['HTTP_USER_AGENT'];
	 		$where['c_time'] = time();
	 		$id = $muser -> add($where);
	 		session('usid',$id);
	 	}
		// $user = session('usid');
		// // $this -> appid = "wxcea55f8c63756008";
		// // $this -> scret = "e43a7eee290334ce8c3900bf85ecf161";
		// $this -> appid = "wx245365f89e539e23";
		// $this -> component_appid = "wxe247b4db6ae12262";
		// $this -> scret = "38d47c0f84d10b9a36c69ccda1a7d58b";
		// $uri = (strlen($_SERVER['REQUEST_URI']) > 1 ) ? $_SERVER['REQUEST_URI'] : "";
		// $redirect_uri = "http://admin.lypuer.com";
		// $isweixin = preg_match('/MicroMessenger/',$_SERVER['HTTP_USER_AGENT']);
		// $state = $_REQUEST['state'];
		// $code = $_REQUEST['code'];
		// if ($state && empty($user)) {
		//  	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this -> appid."&secret=".$this -> scret."&code=$code&grant_type=authorization_code";
		// 	$res = $this -> curl("",$url);
		// 	$access = json_decode($res,true);
		// 	S('access_token',$access['access_token'],2*60*60);
		// 	session('openid',$access['openid']);
		// 	$where['wx_id'] = session('openid');
		// 	$muser = D('User');
		// 	$userobj = $muser -> where($where) -> select();
		// 	if ($userobj) {
		// 		session('usid',$userobj[0]['id']);
		// 	}else{
		// 		$userobj = $this -> getUserInfo($access['openid'],$access['access_token']);
		// 		session('usid',$userobj['id']);
		// 		$data['name'] = $userobj['nickname'];
		// 		$data['sex'] = $userobj['sex'];
		// 		$data['provance'] = $userobj['province'].$userobj['city'];
		// 		$data['status'] = 0;
		// 		$data['wx_id'] = $userobj['openid'];
		// 		$data['address'] = $userobj['headimgurl'];
		// 		$data['c_time'] = time();
		// 		$muser -> add($data);
		// 	}
		// }else if (empty($user) && $isweixin) {
		// 	//$this -> assign('requri',urlencode($redirect_uri));
		// 	$code = session('code');
		// 	if (!isset($code)) {
		// 		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=snsapi_base&state=weixin&component_appid=".$this -> component_appid."#wechat_redirect";
		// 		Header("Location: $url");
		// 	}
		// }
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