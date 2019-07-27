<?php
function show($ret,$msg='',$data=[]){
	return [
		'ret'=>intval($ret),
		'msg'=>$msg,
		'data'=>$data,
	];
}
function dayChange($str){
	switch($str){
		case '一':
			return 1;
			break;
		case '二':
			return 2;
			break;
		case '三':
			return 3;
			break;
		case '四':
			return 4;
			break;
		case '五':
			return 5;
			break;
		case '六':
			return 6;
			break;
		case '日':
			return 7;
			break;
		case '七':
			return 7;
			break;
	}
}
