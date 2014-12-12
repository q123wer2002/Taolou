<?php
include_once 'share.php';

//page default

$obj_tmp1->member='taolou_member_detail';

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_REQUEST['action']!=""){@$action=laout_check($_REQUEST['action']);}
else {@$action='changePW';}
//===================


switch(@$action){
	case "changePW":


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/user/changePassword.html';
    $obj_tmp1->subMenu='content/user/MenuuserSetting.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;

	case "mailAlert":	

    //讀取使用者資訊
    $sql_loadUser="SELECT ".$obj_tmp1->member.".*
                   FROM ".$obj_tmp1->member."
                   WHERE ".$obj_tmp1->member.".id='".$userId."'";
    $obj_tmp1->laout_arr['loadUser']=array();
    $obj_tmp1->basic_select('laout_arr','loadUser',$sql_loadUser);
    //=======================
        //print_r($obj_tmp1->laout_arr['loadUser']);

    //echo $obj_tmp1->encode("1"),"<BR>";
    //echo $obj_tmp1->decode($obj_tmp1->encode("1"));


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/user/mailAlert.html';
    $obj_tmp1->subMenu='content/user/MenuuserSetting.html';

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