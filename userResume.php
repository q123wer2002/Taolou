<?php
include_once 'share.php';

//page default
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberCV='taolou_member_cv';

$obj_tmp1->skillList="taolou_system_specialskill";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
if(@laout_check($_GET['action']) != ""){$getAction=laout_check($_GET['action']);}else{$getAction="";}
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_SESSION['user']['userType'] != "" && @$getAction==""){
    if(@$_SESSION['user']['userType'] == '1'){$action='showResume';}
    else if(@$_SESSION['user']['userType'] == '2'){$action='none';}
    else{$action='none';}
}else{$action=laout_check($_GET['action']);}
//===================


switch(@$action){
	case "upload":


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/user/uploadResume.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;

	case "showResume":

    //讀取履歷
    $sql_CV="SELECT ".$obj_tmp1->memberCV.".*
             FROM ".$obj_tmp1->memberCV."
             LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->memberCV.".memberId
             WHERE ".$obj_tmp1->memberCV.".memberId='".$userId."'";
    $obj_tmp1->laout_arr['CV']=array();
    $obj_tmp1->basic_select('laout_arr','CV',$sql_CV);
        //echo $sql_CV;
        //print_r($obj_tmp1->laout_arr['CV']);
    //=========================

    //讀取系統技能
    $sql_skillList="SELECT ".$obj_tmp1->skillList.".*
                       FROM ".$obj_tmp1->skillList."
                       WHERE ".$obj_tmp1->skillList.".status = 'y'
                       ORDER BY ".$obj_tmp1->skillList.".id";
    $obj_tmp1->laout_arr['skillList']=array();
    $obj_tmp1->basic_select('laout_arr','skillList',$sql_skillList);
        //echo $sql_skillList;
        //print_r($obj_tmp1->laout_arr['skillList']);
    foreach($obj_tmp1->laout_arr['skillList'] as $allSkillKey => $allSkillValue){
        $obj_tmp1->allSkillList=$obj_tmp1->allSkillList.$allSkillValue['skill']."|";
    }
    $obj_tmp1->allSkillList=substr($obj_tmp1->allSkillList,0,-1);
        //print_r($obj_tmp1->allSkillList);
    //=========================


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/user/showResume.html';

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