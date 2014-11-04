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


//判斷是不是會員
if($_SESSION['user']){}
else{}
//===============

//判斷是個人帳號，還是企業帳戶

//============================


//==========================================


?>