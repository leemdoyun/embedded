<?php
header('Content-type: text/text; charset=utf-8');
header("Content-Type: application/json");

$con = mysql_connect("localhost", "root", "");
mysql_select_db("embedded",$con);
mysql_query('set names utf8',$con);


$return_value = array();
$i =0;

$sql = "select * from class";


$result = mysql_query($sql);
$row_count = mysql_num_rows($result);

if((int)$row_count != 0){
while($row = mysql_fetch_row($result)){

                $tmp = array("result"=>urlencode("ok"),"cno"=>urlencode($row[0]),"cname"=>urlencode($row[1]));

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

