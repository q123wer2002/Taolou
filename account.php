<?php
include_once 'share.php';

//page default
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->login='taolou_account';
$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認動作
if(@$_REQUEST['action']!=""){@$action=laout_check($_REQUEST['action']);}
else {@$action='login';}
//====================

 
switch($action){
	case 'signup':

	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/account/signup.html';
    $obj_tmp1->javaData='js/AN_account.js';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
	//=======================================
	break;

	case 'login':

	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/account/login.html';
    $obj_tmp1->javaData='js/AN_account.js';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
	//=======================================
	break;

	case 'forget_password':

	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/account/forget_password.html';
    $obj_tmp1->javaData='js/AN_account.js';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
	//=======================================.
	
	break;
	
	default:
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

	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/404.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');

	break;
}


?>