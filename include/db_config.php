<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "1234";
$dbData = "carrybazi";

/*$dbHost = "203.69.42.12";
$dbUser = "L89940763";
$dbPass = "12012403";
$dbData = "DBL02526";*/

@$conn=mysql_connect($dbHost,$dbUser,$dbPass);
//連線到資料庫	


@mysql_query("SET NAMES utf8"); 
@mysql_query("SET CHARACTER_SET_CLIENT=utf8");
@mysql_query("SET CHARACTER_SET_RESULTS=utf8");
mysql_select_db('carrybazi', $conn) or die('1234');

?>
