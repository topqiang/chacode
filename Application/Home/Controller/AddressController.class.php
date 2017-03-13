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
		$this->display();
	}
}
