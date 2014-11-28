<?php
include_once '../share.php';

$obj_tmp1->company='taolou_company';
$obj_tmp1->job='taolou_job';
$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

if(@$_POST['method'] == 'search'){

	$obj_tmp1->tmp_where=$_POST['keyword'];

	//開始搜尋公司
	$sql_searchC="SELECT ".$obj_tmp1->company.".*
				 FROM ".$obj_tmp1->company."
				 WHERE ".$obj_tmp1->company.".companyName LIKE '%".$obj_tmp1->tmp_where."%' ";
	$obj_tmp1->laout_arr['searchC']=array();
	$obj_tmp1->basic_select('laout_arr','searchC',$sql_searchC);
	//============================

	//開始搜尋工作
	$sql_searchJ="SELECT ".$obj_tmp1->job.".*
				 FROM ".$obj_tmp1->job."
				 WHERE ".$obj_tmp1->job.".jobName LIKE '%".$obj_tmp1->tmp_where."%' ";
	$obj_tmp1->laout_arr['searchJ']=array();
	$obj_tmp1->basic_select('laout_arr','searchJ',$sql_searchJ);
	//=============================

	echo "yes";

	exit;
}

?>