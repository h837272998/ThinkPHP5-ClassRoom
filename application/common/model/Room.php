<?php
namespace app\common\model;
use think\Model;

class Room extends Model{
	public function getroom($condition=''){
		$order = [
			'roomid'=>'desc',
		];
		
//		return $this->order($order)
//			->select();
		//多表查询
		if(empty($condition)){  //显示所有
			$str = 'building.buildid = room.buildid';
		}else{  //显示某个
			$str = "building.buildid = room.buildid and room.buildid = $condition";
		}
		return $this->field('building.buildname,building.status status1,room.*')
			->table(['building'=>'building','room'=>'room'])
			->order($order)
			->where($str)
			->select();
	}
	public function addroom($data){
		return $this->save($data);
	}
//	public function myget($id){
//		return $this->where('roomid',$id)->select();
//	}
	public function delroom($data=''){
		$this->startTrans();  //开始事务
		try{
			foreach($data as $val){
				$re = $this->where($val)
					->delete();
				if($re==0){
					throw new \Exception("删除失败");
				}
			}
			$this->commit();
			return ['code'=>1];
		}catch(\Exception $e){
			$this->rollback();
			$data = ['code'=>0,'msg'=>'可能外键问题，或者其他错误'];
			return $data;
		}
	}
	
	public function getSelect($date){
		$order = [
			'roomid'=>'desc',
		];
		$where = [
			'buildid'=>$date,
		];
		return $this->field('roomid')
				->order($order)
				->where($where)
				->select();
				
	}
}