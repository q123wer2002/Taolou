<?php
include_once 'share.php';

//page default

$obj_tmp1->member='taolou_member_detail';

$obj_tmp1->topicCompany="taolou_system_topic_company";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='showTopicComList';}
if(@$_REQUEST['action']!=""){@$action=laout_check($_REQUEST['action']);}
else {@$action='showTopicComList';}
//===================


switch(@$action){
	case "showTopicComList":

    $sql_topic="SELECT ".$obj_tmp1->topicCompany.".*
                FROM ".$obj_tmp1->topicCompany."
                WHERE ".$obj_tmp1->topicCompany.".topicStatus='y'";
    $obj_tmp1->laout_arr['topic']=array();
    $obj_tmp1->basic_select('laout_arr','topic',$sql_topic);
        //echo $sql_topic;
        //print_r($obj_tmp1->laout_arr['topic']);
    //===========================


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/topicCompanyList.html';
    //$obj_tmp1->subMenu='content/user/MenuuserSetting.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;

    case "newCompanies":


    //-----------
    $obj_tmp1->hideTitleBar=true;
    //------------
    $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/topicPage/newCompanies.html';
    //$obj_tmp1->subMenu='content/user/MenuuserSetting.html';

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