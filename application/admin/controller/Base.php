<?php
namespace app\admin\controller;
use think\Controller;

class Base extends Controller
{
    public function _initialize(){
    	//
    	$isLogin = $this->isLogin();
		if(!$isLogin){
			return $this->redirect(url('user/index'));
		}
	}
	
	public function isLogin(){
			$user = $this->getLoginUser();
			if($user && $user->adminid){
				return true;
			}
			return false;
	}
	public function getLoginUser(){
		$account = session('Admins','','admin');
		return $account;
	}
}