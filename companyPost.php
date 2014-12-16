<?php
include_once 'share.php';

//page default
$obj_tmp1->sysJobType="taolou_system_jobtype";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->job="taolou_job";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
if(@laout_check($_GET['action']) != ""){$getAction=laout_check($_GET['action']);}else{$getAction="";}
if(@laout_check($_GET['jobId']) != ""){@$jobId=$obj_tmp1->decode(laout_check($_GET['jobId']));}else{@$jobId="";}
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_SESSION['user']['company']!=""){@$companyId=$_SESSION['user']['company'];}
if(@$_SESSION['user']['userType'] != "" && @$getAction==""){
    if(@$_SESSION['user']['userType'] == '1'){$action='none';}
    else if(@$_SESSION['user']['userType'] == '2'){$action='ManageJob';}
    else{$action='none';}
}else{$action=laout_check($_GET['action']);}
//===================


switch(@$action){

	case "postJob":


    if(@$jobId!=""){
        //catch job from this company
        $sql_showJob="SELECT ".$obj_tmp1->job.".*
                      FROM ".$obj_tmp1->job."
                      WHE`RE ".$obj_tmp1->job.".id='".$jobId."'
                      AND ".$obj_tmp1->job.".status='y'";
        $obj_tmp1->laout_arr['showJob']=array();
        $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
            //echo $sql_showJob;
            //print_r($obj_tmp1->laout_arr['showJob']);
        //===========================
    }

    //抓取所有工作類別
    $sql_systemJobTypes="SELECT ".$obj_tmp1->sysJobType.".*
                         FROM ".$obj_tmp1->sysJobType."
                         WHERE ".$obj_tmp1->sysJobType.".status='y'";
    $obj_tmp1->laout_arr['sysJT']=array();
    $obj_tmp1->basic_select('laout_arr','sysJT',$sql_systemJobTypes);
        //echo $sql_systemJobTypes;
        //print_r($obj_tmp1->laout_arr['sysJT']);
    //===========================

    //抓取所有地區
    //===========================

	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company/postJob.html';
    //$obj_tmp1->subMenu='content/user/MenuuserSetting.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

    case "ManageJob":

    //catch "all" jobs from this company
    $sql_allShowJob="SELECT ".$obj_tmp1->job.".*
                  FROM ".$obj_tmp1->job."
                  WHERE ".$obj_tmp1->job.".companyId='".$companyId."'";
    $obj_tmp1->laout_arr['allShowJob']=array();
    $obj_tmp1->basic_select('laout_arr','allShowJob',$sql_allShowJob);
        //echo $sql_allShowJob;
        //print_r($obj_tmp1->laout_arr['allShowJob']);
    //===========================

    //catch all valid jobs from this company
    $sql_showJob="SELECT ".$obj_tmp1->job.".*
                  FROM ".$obj_tmp1->job."
                  WHERE ".$obj_tmp1->job.".companyId='".$companyId."'
                  AND ".$obj_tmp1->job.".status='y'";
    $obj_tmp1->laout_arr['showJob']=array();
    $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
        //echo $sql_showJob;
        //print_r($obj_tmp1->laout_arr['showJob']);
    //===========================



    $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company/jobManage.html';
    $obj_tmp1->subMenu='content/company/MenujobManage.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
    $obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;

    case "finded":

    //catch "all" jobs from this company
    $sql_allShowJob="SELECT ".$obj_tmp1->job.".*
                  FROM ".$obj_tmp1->job."
                  WHERE ".$obj_tmp1->job.".companyId='".$companyId."'";
    $obj_tmp1->laout_arr['allShowJob']=array();
    $obj_tmp1->basic_select('laout_arr','allShowJob',$sql_allShowJob);
        //echo $sql_allShowJob;
        //print_r($obj_tmp1->laout_arr['allShowJob']);
    //===========================

    //catch all solved jobs from this company
    $sql_showJob="SELECT ".$obj_tmp1->job.".*
                  FROM ".$obj_tmp1->job."
                  WHERE ".$obj_tmp1->job.".companyId='".$companyId."'
                  AND ".$obj_tmp1->job.".status='F'";
    $obj_tmp1->laout_arr['showJob']=array();
    $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
        //echo $sql_showJob;
        //print_r($obj_tmp1->laout_arr['showJob']);
    //===========================



    $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company/solvedJob.html';
    $obj_tmp1->subMenu='content/company/MenujobManage.html';

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