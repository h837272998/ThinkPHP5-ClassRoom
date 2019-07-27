<?php
namespace app\admin\controller;
use think\Controller;

class User extends Controller
{
	/**
	 * 只有登录界面
	 */
	public function index(){
		if(request()->isPost()){
			$data = request()->post();
			$ret = model('Admins')->get(['adminid'=>$data['username']]);
			if(!$ret || isset($ret->status)&&$ret->status!=1){
				$this->error('账号不存在！');
			}
			if($ret->password != md5($data['password'].$ret->code)){
				$this->error('密码不正确！');
			}
			model('Admins')->updateTimeById(['last_time'=>date("Y-m-d h:i:s",time())],$ret->adminid);
			session('Admins',$ret,'admin');
			//print_r($ret->power);exit;
			return $this->success('登录成功',url('index/index'));
//			, array('id' => 1), 5, '页面跳转中...');  
		}else{
			$account = session('Admins','','admin');
			if($account && $account->adminid){
				return $this->redirect(url('index/index'));
			}
			return $this->fetch();
		}
	}
	
	public function loginout(){
		session(null,'admin');
		return $this->redirect(url('user/index'));
	}
	public function changepsw(){
		$account = session('Admins','','admin');
		if($account && $account->adminid){
			return $this->fetch();
		}
		return $this->error('请重新登录后修改');
	}
	public function changepsw_post(){
		if(request()->isPost()){
			$data = request()->post();
			$account = session('Admins','','admin');
			$ret = model('Admins')->get(['adminid'=>$account->adminid]);
			if($ret->password != md5($data['oldpsw'].$ret->code)){
				$this->error('旧密码错误，请重新输入。忘记请联系超级管理员！');
			}
			model('Admins')->updateTimeById(['password'=>md5($data['onepsw'].$ret->code)],$ret->adminid);
			$this->success('修改成功');
		}else{
			$this->error('请求失败');
		}
	
	}
}