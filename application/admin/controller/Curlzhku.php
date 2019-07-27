<?php
	namespace app\admin\controller;
	use think\Controller;
	
	class Curlzhku extends Controller{
		public function index(){
			return $this->fetch();
		}
		public function getBuilding(){
			$re = model('building')->getbuilding();
			$result = '';
			foreach($re as $data){
				$result = $result.'<option value="'.$data['buildid'].'">'.$data['buildname'].'</option>';
			}
			return $result;
		}
	}