<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberCV='taolou_member_cv';
$obj_tmp1->memberExp='taolou_member_experience';
$obj_tmp1->memberedu='taolou_member_education';
$obj_tmp1->memberwanttjob='taolou_member_wantjob';
$obj_tmp1->tmp_where="";
$obj_tmp1->page="0";
$obj_tmp1->max_page="0";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
$userId='';
//===================


switch($action){
	case "change_email":

	break;

	case "change_password":

	break;

	default:
	
	//顯示個人基本訊息
	$sql_member="SELECT ".$obj_tmp1->member.".*
				 FROM ".$obj_tmp1->member."
				 WHERE ".$obj_tmp1->member.".id=".$userId." AND ".$obj_tmp1->member.".companyHr='n'";
	$obj_tmp1->laout_arr['member']=array();
	$obj_tmp1->basic_select('laout_arr','member',$sql_member);
		//echo $sql_member;
		//print_r($obj_tmp1->laout_arr['member']);
	//==========================

    //echo $obj_tmp1->encode("1"),"<BR>";
    //echo $obj_tmp1->decode($obj_tmp1->encode("1"));


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/userMe.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;
}


?>