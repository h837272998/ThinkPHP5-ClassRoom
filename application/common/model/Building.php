<?php
namespace app\common\model;
use think\Model;

class Building extends Model{
	public function addbuilding($data){
//		$db = db('building');
//		return $db->insert($data);
		return $this->save($data);
	}
	public function getbuilding(){
		$order = [
			'buildname'=>'desc',
		];
//		$db = db('building');
//		return $db->order($order)->select();
		return $this->order($order)
			->select();
	}
	public function delbuilding($data){
		$db = db('building');
		return $db->where('buildid',$data)->delete();
	}
}