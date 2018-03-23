<!DOCTYPE html>
<html lang='zh_cn'>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
	<title><?php printf($_POST['account']); ?> - 报修结果</title>
	<link rel="stylesheet" href="//cdn.bootcss.com/weui/0.4.0/style/weui.min.css"/>
	<link rel="stylesheet" href="style/accordion.css">
	<link rel="stylesheet" href="style/weui.css">
	<link rel="stylesheet" href="style/example.css">
</head>
<?php
header("Content-type: text/html; charset=utf-8");  //视学校而定，一般是gbk编码，php也采用的gbk编码方式

$userId=$_POST['account'];
$password=$_POST['password'];
$patterns = "/\d+/";
preg_match_all($patterns,$_POST['type1'],$arr1);
$type1=$arr1[0][0];
preg_match_all($patterns,$_POST['type2'],$arr2);
$type2=$arr2[0][0];
$districtname=$_POST['districtname'];
$floorid=$_POST['floorid'];
$dormitoryid=$_POST['dormitoryid'];
$phone=$_POST['phone'];
$describe=$_POST['describe'];


function login_post($url,$cookie,$post){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  //不自动输出数据，要echo才行
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  //重要，抓取跳转后数据
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); 
        curl_setopt($ch, CURLOPT_REFERER, 'http://202.119.160.238/Repair/');  //重要，302跳转需要referer，可以在Request Headers找到 
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post);  //post提交数据
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }
	
	
	$cookie = tempnam('./cookie1', 'cookie');   
	$cookie_url = 'http://202.119.160.238/Repair/'; 
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $cookie_url); 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie); 
	$content = curl_exec($ch); 
	curl_close($ch);  
	
	$login_url= 'http://202.119.160.238/Repair/UserServlet';
	$post=array(
		'flag'=> 'toCheckStuLogin',
		'userId' => $userId,
		'password' => $password
    );
	
	$login_con = login_post($login_url,$cookie,http_build_query($post));
	$add_url1 = 'http://202.119.160.238/Repair/jsp/student/repair_add.jsp';
	$add_con=login_post($add_url1  ,$cookie,'');
	preg_match_all('/<input.+?(value=\"(.+?)\")/',$add_con, $view); //获取__VIEWSTATE字段并存到$view数组中
	//var_dump($view[1][1]);
	preg_match_all($patterns,$view[1][1],$arr3);
	$tusersid = $arr3[0][0];
	
	$updateAddress_url = 'http://202.119.160.238/Repair/StudentServlet?flag=updateAddress';
	$updateAddress_post=array(	
	'tId' => $tusersid,
	'districtname' => $districtname,
	'floorid' => $floorid,
	'dormitoryid' => $dormitoryid
	);
	
	$updateAddress_con = login_post($updateAddress_url,$cookie,http_build_query($updateAddress_post));
	$repair_add_url = "http://202.119.160.238/Repair/StudentServlet?userId=".$userId;
	$repair_add_post=array(	
	'flag'=> 'repairAdd',
	'tusersid' => $tusersid,
	'districtname' => $districtname,
	'floorid' => $floorid,
	'dormitoryid'=> $dormitoryid,
	'phone' => $phone,
	'goodsType' => $type1,
	'goodsid' => $type2,
	'describe'=> $describe
	);
		
	$repair_add_con = login_post($repair_add_url,$cookie,http_build_query($repair_add_post));
	if($repair_add_con);{
		echo '
		<div class="weui-msg">
			<div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
			<div class="weui-msg__text-area">
				<h2 class="weui-msg__title">报修成功</h2>
			</div>
			<div class="weui-msg__opr-area">
				<p class="weui-btn-area">
					<a href="javascript:;" onClick="location.href=document.referrer" class="weui-btn weui-btn_primary">返回</a>
				</p>
			</div>
		</div>';
	}

	
?>
</body>
</html>