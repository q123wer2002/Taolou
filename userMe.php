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
$obj_tmp1->workLoc="taolou_system_location";
$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}
if(@$_SESSION['user']['userType'] != ""){
	if(@$_SESSION['user']['userType'] == '1'){$action='user';}
	else if(@$_SESSION['user']['userType'] == '2'){$action='hr';}
	else{$action='none';}
}else{$action='none';}
//===================


switch(@$action){
	case "hr":

	//顯示基本訊息
	$sql_member="SELECT ".$obj_tmp1->member.".*
				 FROM ".$obj_tmp1->member."
				 WHERE ".$obj_tmp1->member.".id=".$userId." AND ".$obj_tmp1->member.".companyHr='y'";
	$obj_tmp1->laout_arr['member']=array();
	$obj_tmp1->basic_select('laout_arr','member',$sql_member);
		//echo $sql_member;
		//print_r($obj_tmp1->laout_arr['member']);
	//==========================


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/userHr.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;

	case "user":
	//合作的公司，頁面左邊banner
	$sql_partner="SELECT ".$obj_tmp1->companyTable.".* 
				  FROM ".$obj_tmp1->companyTable."
				  WHERE ".$obj_tmp1->companyTable.".recommendation='y'
				  ORDER BY ".$obj_tmp1->companyTable.".id
				  LIMIT 10;";
	$obj_tmp1->laout_arr['partner']=array();
	$obj_tmp1->basic_select('laout_arr','partner',$sql_partner);
		//echo $sql_partner;
		//print_r($obj_tmp1->laout_arr['partner']);
	//==========================

	//顯示個人基本訊息
	$sql_member="SELECT ".$obj_tmp1->member.".*
				 FROM ".$obj_tmp1->member."
				 WHERE ".$obj_tmp1->member.".id='".$userId."' AND ".$obj_tmp1->member.".companyHr='n'";
	$obj_tmp1->laout_arr['member']=array();
	$obj_tmp1->basic_select('laout_arr','member',$sql_member);
		//echo $sql_member;
		//print_r($obj_tmp1->laout_arr['member']);
	//==========================

	//希望的工作
	$sql_wantjob="SELECT ".$obj_tmp1->memberwanttjob.".*
				  FROM ".$obj_tmp1->memberwanttjob."
				  LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->memberwanttjob.".memberId
				  WHERE ".$obj_tmp1->memberwanttjob.".memberId='".$userId."'";
	$obj_tmp1->laout_arr['wantjob']=array();
	$obj_tmp1->basic_select('laout_arr','wantjob',$sql_wantjob);
		//echo $sql_wantjob;
		//print_r($obj_tmp1->laout_arr['wantjob']);
		//顯示工作地區
		$sql_workLocation="SELECT ".$obj_tmp1->workLoc.".*
						   FROM ".$obj_tmp1->workLoc."
						   WHERE ".$obj_tmp1->workLoc.".status = 'y'
						   ORDER BY ".$obj_tmp1->workLoc.".id";
		$obj_tmp1->laout_arr['workLocation']=array();
		$obj_tmp1->basic_select('laout_arr','workLocation',$sql_workLocation);
			//echo $sql_workLocation;
			//print_r($obj_tmp1->laout_arr['workLocation']);
	//==========================


	//專長技能
	//==========================

	//教育狀況
	$sql_education="SELECT ".$obj_tmp1->memberedu.".*
					FROM ".$obj_tmp1->memberedu."
					LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->memberedu.".memberId
					WHERE ".$obj_tmp1->memberedu.".memberId=".$userId;
	$obj_tmp1->laout_arr['education']=array();
	$obj_tmp1->basic_select('laout_arr','education',$sql_education);
		//echo $sql_education;
		//print_r($obj_tmp1->laout_arr['education']);
	//==========================

	//經歷
	$sql_experience="SELECT ".$obj_tmp1->memberExp.".*
				  	 FROM ".$obj_tmp1->memberExp."
				  	 LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->memberExp.".memberId
				  	 WHERE ".$obj_tmp1->memberExp.".memberId=".$userId;
	$obj_tmp1->laout_arr['experience']=array();
	$obj_tmp1->basic_select('laout_arr','experience',$sql_experience);
		//echo $sql_experience;
		//print_r($obj_tmp1->laout_arr['experience']);
	//==========================
	


    //echo $obj_tmp1->encode("1"),"<BR>";
    //echo $obj_tmp1->decode($obj_tmp1->encode("1"));


	$obj_tmp1->showad=false;
	$obj_tmp1->javaData='js/AN_onlineCV.js';
    $obj_tmp1->content_html='content/user/userMe.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;

	default:

	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/404.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;
}


?>