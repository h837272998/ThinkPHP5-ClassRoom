<?php
namespace app\api\controller;
use think\Controller;
class Curl extends controller{
	private $postUrl ='http://jw.zhku.edu.cn/ZNPK/KBFB_DayJCSel_rpt.aspx'; //教室课表Post连接
	private $sectetUrl = 'http://jw.zhku.edu.cn/sys/ValidateCode.aspx';
	private $useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36';
	private $refererUrl ='http://jw.zhku.edu.cn/ZNPK/KBFB_DayJCSel.aspx'; //教室课表获取连接
	private $cookie = '';
	
	/**
	 * 字符串转二进制
	 */
	public function StrToBin($str){
	    //1.列出每个字符
	    $arr = preg_split('/(?<!^)(?!$)/u', $str);
	    //2.unpack字符
	    foreach($arr as &$v){
	        $temp = unpack('H*', $v);
	        $v = base_convert($temp[1], 16, 2);
	        unset($temp);
	    }
	
	    return join(' ',$arr); 
	}
	public function getValidata(){
//		$getUrl ='http://jw.zhku.edu.cn/ZNPK/KBFB_DayJCSel.aspx'; //教室课表获取连接
//		$sectetUrl = 'http://jw.zhku.edu.cn/sys/ValidateCode.aspx';
//		$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36';
//		
		$this->cookie = dirname(__FILE__) . '/cookie/cookie.txt';
		//执行登录界面获得cookie和viewstate
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->refererUrl);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);  //保存cookie
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  //不自动输出数据，要echo才行
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  //重要，抓取跳转后数据
		$login1 = curl_exec($ch);  //执行curl
		curl_close($ch);
		$ch1 = curl_init();
		curl_setopt($ch1,CURLOPT_URL,$this->sectetUrl);
		curl_setopt($ch1,CURLOPT_USERAGENT,$this->useragent);
		curl_setopt($ch1,CURLOPT_COOKIEFILE,$this->cookie);
		curl_setopt($ch1,CURLOPT_REFERER,$this->refererUrl);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch1, CURLOPT_HEADER, 0);
		$img = curl_exec($ch1);  //执行curl
    	curl_close($ch1);
		$image = imagecreatefromstring($img);//将字符串转换成图像流
		header("Content-type:image/png");
	 	imagepng($image);
		
		imagedestroy($image);exit;
	}
	
	public function getSyllabusForZHKU(){
		if(!request()->isPost()){
				$this->error('request failure！');
		}
		$this->cookie = dirname(__FILE__) . '/cookie/cookie.txt';
		$data = request()->Post();
		$data['rad'] = 1;
		$result = [];
		$html = '';
		$sqlhtml = '';
		$build = model('building')->get($data['Sel_JXL']);//获得教学楼信息匹配有用
		for($i=1;$i<2;$i++){
			$data['Sel_ZC'] = $i;
			$ch2 = curl_init();
			curl_setopt($ch2,CURLOPT_URL,$this->postUrl);
			curl_setopt($ch2,CURLOPT_USERAGENT,$this->useragent);
			curl_setopt($ch2,CURLOPT_COOKIEFILE,$this->cookie);
			curl_setopt($ch2,CURLOPT_REFERER,$this->refererUrl);
			curl_setopt($ch2, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch2, CURLOPT_HEADER, 0);
			curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);  //重要，抓取跳转后数据
			curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($data));
			$re = curl_exec($ch2);
			curl_close($ch2);
			$str=iconv("GBK","UTF-8",$re);
			$result[$i] = $str;
			$pe = '/<script language=javascript>alert\(\'验证码错误！\'\)/is';
			preg_match($pe,$str,$ju);
			if(isset($ju[0])&&$ju[0]!=''){
				return $this->error('验证码错误');
			}
			$preg = '/<td width=\'5%\' align=\'center\' >(.*?)<br><\/td><td width=\'22%\' align=\'left\' >(.*?)<br><\/td><td width=\'10%\' align=\'center\' >(.*?)<br><\/td><td width=\'5%\' align=\'right\' >(.*?)<br><\/td><td width=\'10%\' align=\'left\' >(.*?)<br><\/td><td width=\'12%\' align=\'left\' >(.*?)<br><\/td><td width=\'16%\' align=\'left\' >\(白\)'.$build['buildname'].
			'(.*?)<br><\/td><td width=\'20%\' align=\'left\' >(.*?)<\/td><\/tr>/is';
			//$preg = '/<td width=\'5%\' align=\'center\' >(.*?)<br><\/td>/is';
			preg_match_all($preg,$result[$i],$res);
			//print_r($res);
			for($j=0;$j<count($res[1]);$j++){
				$html = $html."<tr class=\"text-c\"><td>".$res[1][$j]."</td>
				<td>".$i."周</td>
				<td>星期".$res[6][$j]."</td>
				<td>".$build['buildname'].$res[7][$j]."</td>
				<td>".$res[2][$j]. "教师：".$res[5][$j]."'</td></tr>";
			}
			
			for($j=0;$j<count($res[1]);$j++){
				$sql = [
					'roomid'=>$res[7][$j],
					'buildid'=>$data['Sel_JXL'],
					'week'=>$i,
					'day'=>dayChange(substr($res[6][$j],0,3)),
					'section'=>substr($res[6][$j], 3),
					'status'=>1,
					'remarks'=>"课程：".$res[2][$j]."教师：".$res[5][$j],
				];
				//print_r($sql);
				$result = model('syllabus')->save($sql);
				if($result){
					$sqlhtml = $sqlhtml."<tr class=\"text-c\"><td>".$sql['roomid'].'</td>
					<td>'.$sql['buildid'].'</td>
					<td>'.$sql['week'].'</td>
					<td>'.$sql['day'].'</td>
					<td>'.$sql['section'].'</td>
					<td>'.$sql['remarks'].'</td></tr>';
				}
			}
		}
		$theResult = ['curlhtml'=>$html,'sqlhtml'=>$sqlhtml];
		return $theResult;
		
	} 
}