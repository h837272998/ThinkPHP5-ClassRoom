<?php
namespace app\api\controller;
use think\Controller;
class Curl1 extends controller{
 public function getSyllabusForZHKU(){
 	$d = dirname(__FILE__);
	echo $d;
	$myfile = fopen(dirname(__FILE__).'\cookie\test.txt', "r") or die("Unable to open file!");
	
	$str =  fread($myfile,filesize("test.txt"));
	fclose($myfile);
	$str=iconv("GBK","UTF-8",$str);
//	$preg = '/<td width=\'5%\' align=\'center\' >(.*?)<br><\/td>/is';
//	$s = '<br><\/td>ss';
//	echo $pr;
//	preg_match($pr,$s,$rrrr);
//	print_r($rrrr);
	//$preg = '/杨(.*?)楼/is';
	$preg = '/<td width=\'5%\' align=\'center\' >(.*?)<br><\\\\\/td><td width=\'22%\' align=\'left\' >(.*?)<br><\\\\\/td><td width=\'10%\' align=\'center\' >(.*?)<br><\\\\\/td><td width=\'5%\' align=\'right\' >(.*?)<br><\\\\\/td><td width=\'10%\' align=\'left\' >(.*?)<br><\\\\\/td><td width=\'12%\' align=\'left\' >(.*?)<br><\\\\\/td><td width=\'16%\' align=\'left\' >\(白\)杨钊杨勋楼(.*?)<br><\\\\\/td><td width=\'20%\' align=\'left\' >(.*?)<\\\\\/td><\\\\\/tr>/is';
	preg_match_all($preg,$str,$result);
	//print_r($result);
	$html = '';
	echo $result[1][1];
	echo $result[6][1];
	for($j=1;$j<count($result[1])+1;$j++){
			$html = $html."<tr class=\"text-c\"><td>".$result[1][$j]."</td><td>".$result[6][$j]."</td><td>".$result[7][$j]."</td><td>".$result[2][$j]. "教师：".$result[5][$j]."'</td>";
		}
	
		
	echo $html;
	}
	}