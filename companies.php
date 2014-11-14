<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->financetable='taolou_finance';
$obj_tmp1->companySkill='taolou_skill';
$obj_tmp1->hrtable='taolou_member';
$obj_tmp1->tmp_where="";
@$obj_tmp1->tmp_comanyId = $obj_tmp1->decode(laout_check($_REQUEST["company"]));;
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//decode company id

//==================


switch($action){
	default:
	//公司基本資料
	$sql_company="SELECT ".$obj_tmp1->companyTable.".* 
				  FROM ".$obj_tmp1->companyTable."
				  WHERE ".$obj_tmp1->companyTable.".id='".$obj_tmp1->tmp_comanyId."'";
	$obj_tmp1->laout_arr['company']=array();
	$obj_tmp1->basic_select('laout_arr','company',$sql_company);
	//===========================

	//公司技能標籤
	$sql_comSkill="SELECT ".$obj_tmp1->companySkill.".*
				   FROM ".$obj_tmp1->companySkill."
				   LEFT JOIN ".$obj_tmp1->companytable." ON ".$obj_tmp1->companySkill.".companyId=".$obj_tmp1->companytable.".id
				   WHERE ".$obj_tmp1->companySkill.".companyId='".$obj_tmp1->tmp_comanyId."'";
	$obj_tmp1->laout_arr['comskill']=array();
	$obj_tmp1->basic_select('laout_arr','comskill',$sql_comSkill);
	//===========================

	//公司融資階段
	$sql_comFinance="SELECT ".$obj_tmp1->financetable.".*
				     FROM ".$obj_tmp1->financetable."
				     LEFT JOIN ".$obj_tmp1->companytable." ON ".$obj_tmp1->financetable.".companyId=".$obj_tmp1->companytable.".id
				     WHERE ".$obj_tmp1->financetable.".companyId='".$obj_tmp1->tmp_comanyId."'";
	$obj_tmp1->laout_arr['comFinance']=array();
	$obj_tmp1->basic_select('laout_arr','comFinance',$sql_comFinance);
	//===========================

	//公司人資帳號
	$sql_comHr="SELECT ".$obj_tmp1->hrtable.".*
				FROM ".$obj_tmp1->hrtable."
				LEFT JOIN ".$obj_tmp1->companytable." ON ".$obj_tmp1->hrtable.".companyId=".$obj_tmp1->companytable.".id
				WHERE ".$obj_tmp1->hrtable.".companyHr='y'
				AND ".$obj_tmp1->hrtable.".companyId='".$obj_tmp1->tmp_comanyId."'";
	$obj_tmp1->laout_arr['comHr']=array();
	$obj_tmp1->basic_select('laout_arr','comHr',$sql_comHr);
	//===========================

	//職位列表
	$sql_job="SELECT ".$obj_tmp1->jobtable.".*
			  FROM ".$obj_tmp1->jobtable."
			  LEFT JOIN ".$obj_tmp1->companytable." ON ".$obj_tmp1->jobtable.".companyId=".$obj_tmp1->companytable.".id
			  WHERE ".$obj_tmp1->jobtable.".companyId='".$obj_tmp1->tmp_comanyId."'";
	$obj_tmp1->laout_arr['job']=array();
	$obj_tmp1->basic_select('laout_arr','job',$sql_job);
	//===========================


    //echo $obj_tmp1->encode("1"),"<BR>";
    //echo $obj_tmp1->decode($obj_tmp1->encode("1"));


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;
}


?>