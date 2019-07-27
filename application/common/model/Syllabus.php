<?php
namespace app\common\model;
use think\Model;

class Syllabus extends Model{
	public function getSyllabus($condition=''){
		$order = [
			'roomid'=>'desc',
		];
		
		//多表查询
		if(empty($condition)){  //显示所有
			$str = 'syllabus.roomid = room.roomid AND syllabus.buildid = room.buildid AND syllabus.buildid = building.buildid';
		}else{  //显示某个
			$str = "syllabus.roomid = room.roomid AND syllabus.buildid = room.buildid AND syllabus.buildid = building.buildid and room.buildid = $condition";
		}
		return $this->field('building.buildname,building.status bstatus,room.status rstatus,syllabus.*')
			->table(['building','room','syllabus'])
			->order($order)
			->where($str)
			->select();
	}
	
	public function delSyllabus($data=''){
//		return $this->where($data)
//			->delete();	
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
			return 1;
		}catch(\Exception $e){
			$this->rollback();
			return 0;
		}
		
	}

}