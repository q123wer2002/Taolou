<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->financetable='taolou_finance';
$obj_tmp1->companySkill='taolou_skill';
$obj_tmp1->hrtable='taolou_member';
$obj_tmp1->tmp_where="";
@$obj_tmp1->tmp_jobsId = $obj_tmp1->decode(laout_check($_REQUEST["jobsid"]));;
@$obj_tmp1->tmp_comanyId="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//decode company id
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='jobList';}
if(@$_REQUEST['action']!=""){@$action=laout_check($_REQUEST['action']);}
else {@$action='jobList';}
//==================


switch($action){
	
	default:

	//職位列表
	$sql_job="SELECT ".$obj_tmp1->jobtable.".*
			  FROM ".$obj_tmp1->jobtable."
			  LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->jobtable.".companyId=".$obj_tmp1->companyTable.".id
			  WHERE ".$obj_tmp1->jobtable.".id='".$obj_tmp1->tmp_jobsId."'";
	$obj_tmp1->laout_arr['job']=array();
	$obj_tmp1->basic_select('laout_arr','job',$sql_job);
		//echo $sql_job;
		//print_r($obj_tmp1->laout_arr['job']);
	//===========================

	@$obj_tmp1->tmp_comanyId=$obj_tmp1->laout_arr['job'][0]['companyId'];
	//echo $obj_tmp1->tmp_jobsId;
	//echo $obj_tmp1->tmp_comanyId;

	//公司基本資料
	$sql_company="SELECT ".$obj_tmp1->companyTable.".* 
				  FROM ".$obj_tmp1->companyTable."
				  WHERE ".$obj_tmp1->companyTable.".id='".$obj_tmp1->tmp_comanyId."'";
	$obj_tmp1->laout_arr['company']=array();
	$obj_tmp1->basic_select('laout_arr','company',$sql_company);
		//echo $sql_company;
		//print_r($obj_tmp1->laout_arr['company']);
	//===========================

	//公司人資帳號
	$sql_comHr="SELECT ".$obj_tmp1->hrtable.".*
				FROM ".$obj_tmp1->hrtable."
				LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->hrtable.".companyId=".$obj_tmp1->companyTable.".id
				WHERE ".$obj_tmp1->hrtable.".companyHr='y'
				AND ".$obj_tmp1->hrtable.".companyId='".$obj_tmp1->tmp_comanyId."'";
	$obj_tmp1->laout_arr['comHr']=array();
	$obj_tmp1->basic_select('laout_arr','comHr',$sql_comHr);
		//echo $sql_comHr;
		//print_r($obj_tmp1->laout_arr['comHr']);
	//===========================


    //echo $obj_tmp1->encode("1"),"<BR>";
    //echo $obj_tmp1->decode($obj_tmp1->encode("1"));


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/jobList.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;
}


?>