<?php
namespace app\admin\validate;
use think\Validate;

class Building extends Validate{
	protected $rule = [
		['buildid','require','请填写教学楼;警告不合法！'],
		['roomid','require','请填写教室;警告不合法！'],
		['week','require','请填写时间;警告不合法！'],
		['day','require','请填写时间;警告不合法！'],
		['section','require','请填写时间;警告不合法！'],
		['status','require','请填写时间;警告不合法！'],
	];
//	场景设置
	protected $scence = [
		'add' =>['buildid'],
		'syllabus'=>['buildid','roomid','week','day','section','status'],
	];
}
