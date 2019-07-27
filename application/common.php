<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 状态函数
 */
function status($status){
	if($status==1){
		$str = '<span class="label label-success radius">已开放</span>';
	}else{
		$str = '<span class="label label-danger radius">未开放</span>';
	}
	return $str;
}

function syllabusStatus($status){
	if($status==1){
		$str = '<span class="label label-danger radius">有课</span>';
	}elseif($status==2){
		$str = '<span class="label label-success radius">普通申请</span>';
	}elseif($status==3){
		$str = '<span class="label label-success radius">教师申请</span>';
	}else{
		$str = '<span class="label label-defult radius">无课</span>';
	}
	return $str;
}

function week($w){
	switch($w){
		case 1:
			$str = '星期一';
			break;
		case 2:
			$str = '星期二';
			break;
		case 3:
			$str = '星期三';
			break;
		case 4:
			$str = '星期四';
			break;
		case 5:
			$str = '星期五';
			break;
		case 6:
			$str = '星期六';
			break;
		case 7:
			$str = '星期日';
			break;
	}
		return $str;
}

function section($s){
	switch($s){
		case 1:
			$str = '1-2节';
			break;
		case 2:
			$str = '3-4节';
			break;
		case 3:
			$str = '6-7节';
			break;
		case 4:
			$str = '8-9节';
			break;
		case 5:
			$str = '10-11节';
			break;
		case 6:
			$str = '10-12节';
			break;
	}
		return $str;
}