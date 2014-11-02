<?php

include_once 'include/main.php';
header("Content-Type:text/html; charset=utf-8");



$obj_tmp1 = new  Basic_page();
//default set
$obj_tmp1->table_name;
$obj_tmp1->tmp_comanyId;
$obj_tmp1->tmp_order ='order by id asc';
$obj_tmp1->tmp_id;
/////////////////////////
$obj_tmp1->ip_address;
$obj_tmp1->ipVisit_date;
/////////////////////////

//$obj_tmp1->login_time=$_SESSION[USER_INFO]["login_time"];
//$obj_tmp1->login_name=$_SESSION[USER_INFO]["name"];


?>