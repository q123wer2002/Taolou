<?php
include_once 'share.php';

//page default
$obj_tmp1->sysJobType="taolou_system_jobtype";

$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberJob="taolou_member_jobmanage";

$obj_tmp1->job="taolou_job";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
if(@laout_check($_GET['action']) != ""){$getAction=laout_check($_GET['action']);}else{$getAction="";}
if(@laout_check($_GET['jobId']) != ""){@$jobId=$obj_tmp1->decode(laout_check($_GET['jobId']));}else{@$jobId="";}

if(@$_SESSION['user']['id'] != ""){
    if(@$_SESSION['user']['userType']=='2'){
        if(@$_SESSION['user']['company'] != "" && @$_SESSION['user']['company'] != "0"){
            @$companyId=$_SESSION['user']['company'];
            if(@$_SESSION['user']['companyValid']!='y' && @$_SESSION['user']['companyValid']!='Host'){
                $action="companyValid";
            }else{
                if($getAction==""){$action="checkSeeker";}
                else{$action=$getAction;}
            }
        }else{$action="no_company";}
    }else{$action="none";}
}else{$action='none';}
//===================

switch(@$action){
    
    case "no_company":
    
    $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company/no_company.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
    $obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

    break;

    case "companyValid":

    //find comapny and let him/her can valid
    $sql_company="SELECT ".$obj_tmp1->companyTable.".*
                  FROM ".$obj_tmp1->companyTable."
                  WHERE ".$obj_tmp1->companyTable.".id='".$companyId."'";
    $obj_tmp1->laout_arr['company']=array();
    $obj_tmp1->basic_select('laout_arr','company',$sql_company);
        //echo $sql_company;
        //print_r($obj_tmp1->laout_arr['company']);
    //===============================

    $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company/no_validCompany.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
    $obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================
    break;

    case "checkSeeker":

    $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company/checkSeeker.html';

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