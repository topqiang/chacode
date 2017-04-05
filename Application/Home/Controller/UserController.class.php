<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{
	public function _initialize(){
		$this->user=D('User');
	}
	
	public function upduser(){
		$data['id'] = session('usid');
		if ($_POST['lat']) {
			$data['lat'] = $_POST['lat'];
		}
		if ($_POST['lng']) {
			$data['lnt'] = $_POST['lng'];
		}
		if ($_POST['tel']) {
			$data['tel'] = $_POST['tel'];
		}
		if ($_POST['provance']) {
			$data['provance'] = $_POST['provance'];
		}
		$res = $this -> user -> save( $data );
		if ($res) {
			echo json_encode(array('flag' => 'success','message' => '修改成功！' ));
		}else{
			echo json_encode(array('flag' => 'error','message' => '失败！' ));

		}
	}

	public function curl($data,$url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
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