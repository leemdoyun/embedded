<?php
@session_start();
@header('Content-type: text/text; charset=utf-8');
@header("Content-Type: application/json");

$con = mysql_connect("localhost", "root", "");

mysql_select_db("embedded",$con);
mysql_query('set names utf8',$con);

$value = array();
$i = 0;

$search_cl_sql = "select c.* from (select curdate() b) as t , class c where t.b between c.start and c.end";

$result=mysql_query($search_cl_sql);
$row = mysql_num_rows($result);

if((int)$row!=0){ 
	while($tuple = mysql_fetch_row($result)){
		$temp = array("cno"=>urlencode($tuple[0]),"name"=>urlencode($tuple[1]));
		$value[$i] = $temp;
		$i++;
	}
}
else{
	$temp = array("cno"=>urlencode("0"),"name"=>urlencode("강의가 없음"));
	$value[$i] = $temp;
}

$value = json_encode($value);
echo urldecode($value);

?>

