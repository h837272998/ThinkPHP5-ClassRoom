<?php
namespace app\admin\controller;
use think\Controller;

class Index extends Base
{
    public function index()
    {
    	return $this->fetch();
		
    }
	public function getSession(){
		$data = session('Admins','','admin');
		return $data;
	}
	public function welcome(){
//		return $this->fetch(); 需要index /welcome文件
//		\phpmailer\Email::send('vip6miss@163.com','黄锦焕','这是一个测试邮箱');
		return "欢迎来到ROOM管理员系统byHJH"; 
	}
}
