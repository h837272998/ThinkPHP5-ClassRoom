<?php
	namespace app\admin\controller;
	use think\Controller;
	
	class Building extends Controller{
		public function index(){
			
		}
		/**
		 * 初始化函数
		 */
		public function _initialize(){
			//init function
		}
		/**
		 *  教学楼主页面
		 */
		public function building(){
			$building = model("Building")->getbuilding();
			return $this->fetch('',['building'=>$building,'count'=>count($building)]);
		}
		/**
		 * 添加教学楼页面
		 */
		public function addbuilding(){
			
			return $this->fetch();
		}
		/**
		 * 添加教室与model
		 */
		public function save(){
//			print_r(request()->post());
			if(!request()->isPost()){
				$this->error('request failure！');
			}	
			$data = request()->post();
			//print_r($data);
			$validate = validate('Building');
			if(!$validate->check($data)){
				$this->error($validate->getError());
			}else{
//				$data 提交model层
				$ret = model("Building")->addbuilding($data);
			}
		}
		/**
		 * 编辑建筑页面
		 */
		public function editbuilding($id=0){
			if(intval($id)<1){
				$this->error('Fatal Error!');
			}
			$result = model('Building')->get($id);
			return $this->fetch('',['building'=>$result]);
		}
		/**
		 * 更新编辑的教学楼  model
		 */
		public function update(){
			if(!request()->isPost()){
				$this->error('request failure！');
			}	
			$data = request()->post();
			$result = model('Building')->save($data,['buildid'=>intval($data['buildid'])]);
			if(!$result){
				$this->error('修改错误');
			}
		}
		/**
		 * 删除教学楼
		 */
		public function del(){
			if(!request()->isPost()){
				$this->error('request failure！');
			}	
			$data = request()->post();
			$result = model('Building')->delbuilding($data['id']);
			if(!$result){
				return $this->error('删除失败');
			}else{
				return $this->success('删除成功');
			}
		}
		/**
		 * 课室主函数。有id代表查看某建筑课室
		 */
		public function room($id=''){
			if(!empty($id)){
				$room = model("Room")->getroom($id);
				return $this->fetch('',['room'=>$room,'count'=>count($room)]);
			}
			$room = model("Room")->getroom();
			return $this->fetch('',['room'=>$room,'count'=>count($room)]);
		}
		/**
		 * 添加课室页面
		 */
		public function addroom(){
			$building = model('Building')->getbuilding();
			return $this->fetch('',['building'=>$building,'list'=>'']);
		}
		/**
		 * 编辑课室页面
		 */
		
		public function editroom($id=0,$buildid = 0){
			if(intval($id)<1){
				$this->error('Fatal Error!');
			}
			$data = ['roomid'=>$id,'buildid'=>$buildid];//duoble primary key
			$result = model('Room')->get($data);
			$result1 = model('Building')->select();
			return $this->fetch('',['room'=>$result,'building'=>$result1]);
		}
		/**
		 * 保存编辑的 教室
		 */
		public function saveroom(){
			//严格的判断
			if(!request()->isPost()){
				$this->error('request failure！');
			}	
			$data = request()->post();
			//print_r($data);
			
//			$data 提交model层
			$ret = model("Room")->addroom($data);
			
		}
		/**
		 * model 保存编辑课室
		 */
		public function updateroom(){
			if(!request()->isPost()){
				$this->error('request failure！');
			}
			$data = request()->post();
			$result = model('Room')->save($data,['roomid'=>intval($data['roomid']),'buildid'=>$data['buildid']]);
			//echo $result;
			if(!$result){
				return $this->error('修改错误');
			}else{
				return $this->success('修改成功');
			}
		}
		/*
		 * 删除教室
		 */
		public function delroom($id=0,$buildid = 0){
//			if(!request()->isPost()){
//				$this->error('request failure！');
//			}
//			$data = request()->post();
			if(intval($id)<1){
				$this->error('Fatal Error!');
			}
			$data[] = ['roomid'=>$id,'buildid'=>$buildid];//duoble primary key
			$result = model('Room')->delroom($data);
			print_r($result);exit;
			if($result['code']==1){				
				return $this->success('删除成功');
			}else{
				return $this->error($result['msg']);
			}
		}
		/**
		 * 批量删除课室
		 */
		public function delchecked(){
			if(!request()->isPost()){
				$this->error('request failure！');
			}
			$data = request()->post();
			$data = $data['checked'];
			foreach($data as $val){
				$te = explode(',',$val);
				$ddata[] = ['roomid'=>$te[0],'buildid'=>$te[1]];//duoble primary key
			}
			$result = model('Room')->delroom($ddata);
			if($result==1){
				return $this->success('批量删除成功！');
			}else{
				return $this->error('批量删除失败，事务回滚！');
			}
		}
		/**
		 * 课室主页面，id代表看某课室课表，否则看全部
		 */
		public function syllabus($id=0){
			if(!empty($id)){
				$syllabus = model("syllabus")->getSyllabus($id);
				return $this->fetch('',['syllabus'=>$syllabus,'count'=>count($syllabus)]);
			}
			$syllabus = model("syllabus")->getSyllabus();
			return $this->fetch('',['syllabus'=>$syllabus,'count'=>count($syllabus)]);
		}
		/**
		 * 添加课程表页面
		 */
		 public function addsyllabus(){
		 	$building = model('Building')->getbuilding();
			return $this->fetch('',['building'=>$building,'list'=>'']);
		 }
		 
		 public function saveSyllabus(){
		 	if(!request()->isPost()){
				$this->error('request failure！');
			}
			$data = request()->post();
			$result = model('syllabus')->save($data);
			if($result){
				return $this->success('添加成功');
			}else{
				return $this->success('添加失败');
			}
		 }
		 
		 public function editSyllabus($data=0){
		 	
		 }
		 /**
		  * 删除某课表
		  */
		 public function delSyllabus($buildid=0,$roomid=0,$week=0,$day=0,$section=0){

			$data[] = ['buildid'=>$buildid,'roomid'=>$roomid,'week'=>$week,'day'=>$day,'section'=>$section];
			$result = model('Syllabus')->delSyllabus($data);
			if(!$result){
				return $this->error('删除失败');
			}else{
				return $this->success('删除成功');
			}
		 }
		/**
		 * 批量删除课表
		 */
		 public function delCheckSyllabus(){
		 	if(!request()->isPost()){
				$this->error('request failure！');
			}
			$data = request()->post();
			$data = $data['checked'];
			foreach($data as $val){
				$te = explode(',',$val);
				$ddata[] = ['roomid'=>$te[0],'buildid'=>$te[1],'week'=>$te[2],'day'=>$te[3],'section'=>$te[4]];//duoble primary key
			}
			$result = model('Syllabus')->delSyllabus($ddata);
			if($result==1){
				return $this->success('批量删除成功！');
			}else{
				return $this->error('批量删除失败，事务回滚！');
			}
		 }
		 
		 public function curlTOjw(){
		 	return $this->fetch();
		 }
	}