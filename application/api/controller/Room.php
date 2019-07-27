<?php
namespace app\api\controller;
use think\Controller;
class Room extends controller{
	public function postSelectBuild(){
		 	if(!request()->isPost()){
				$this->error('request failure！');
			}
			$data = request()->post();
			$result = model('room')->getSelect($data['date']);
			return show(1,'请求成功',$result);
			
		 }
}
