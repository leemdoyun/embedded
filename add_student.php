<?php
@session_start(); 
@header('Content-type: text/text; charset=utf-8'); 
@header("Content-Type: application/json");                                    

$stname=$_POST["stname"];
$stnum=$_POST["stnum"]; 
$stphone = $_POST["stphone"]; 
$stdept = $_POST["stdept"]; 
$uid = $_POST["uid"];
$cno = $_POST["cno"];


$con = mysql_connect("localhost", "root", ""); 

mysql_select_db("embedded",$con);   
mysql_query('set names utf8',$con); 

$search_st_sql = "select * from student where stnumber = '$stnum' and uid ='$uid'";
$result=mysql_query($search_st_sql);
$row = mysql_num_rows($result); 

if((int)$row == 0){   
	$insert_st_sql = "insert into student(name,stnumber,department,phonenum,uid) values ('$stname','$stnum','$stdept','$stphone','$uid')"; 

	if(mysql_query($insert_st_sql)){
		$sno = mysql_insert_id();
		$insert_list_sql = "insert into list(class_no,stu_no) values ($cno,$sno)";
		if(mysql_query($insert_list_sql)){
			$lno = mysql_insert_id();
			$insert_time_sql = " insert into time(list_no) values ($lno)";
			if(mysql_query($insert_time_sql))	
				$value = array("result"=>urlencode("ok"));
			else
				$value = array("result"=>urlencode("fail"));
		}
		else
			$value = array("result"=>urlencode("fail"));
	}
	else
		$value = array("result"=>urlencode("fail"));
}
else
	$value = array("result"=>urlencode("fail"));	

$value = json_encode($value);
echo  urldecode($value); 

?>
