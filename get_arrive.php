<?php
@header('Content-type: text/text; charset=utf-8');
@header("Content-Type: application/json");

$con = mysql_connect("localhost", "root", "");
mysql_select_db("embedded",$con);
mysql_query('set names utf8',$con);

$cno = $_POST['cno'];
$arrive = $_POST['day'];
$return_value = array();
$i =0;
$sql = "select s.department,s.stnumber,s.name,k.arrive_time,s.sno  from (select l.*,t.arrive_time from time t, list l where t.arrive_time between  '".$arrive." 00:00:00' and '".$arrive." 23:59:59' and  t.list_no = l.lno and l.class_no = '$cno') as k , student s where k.stu_no = s.sno order by arrive_time ASC";

$result = mysql_query($sql);
$row_count = mysql_num_rows($result);

if((int)$row_count != 0){

	while($row = mysql_fetch_row($result)){
		
		$year = explode(' ',$row[3]); 
		$date = str_replace(":","",$year[1]);
		
		$tmp = array("result"=>urlencode("ok"),"sno"=>urlencode($row[4]),"arrive_time"=>urlencode($year[1]),"time_con"=>urlencode($date));
	
		$return_value[$i]=$tmp;
		$i++;
				
	}
}
else{
	$tmp = array("result"=>urlencode("fail"));
	$return_value[0]=$tmp;

}

$return_value = json_encode($return_value);
echo urldecode($return_value);
?>
