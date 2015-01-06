<?php
include_once 'share.php';

//page default
$obj_tmp1->sysJobType="taolou_system_jobtype";

$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->member='taolou_member_detail';
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
                if($getAction==""){$action="ManageJob";}
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

	case "postJob":


    if(@$jobId!=""){
        //catch job from this company
        $sql_showJob="SELECT ".$obj_tmp1->job.".*
                      FROM ".$obj_tmp1->job."
                      WHERE ".$obj_tmp1->job.".id='".$jobId."'";
        $obj_tmp1->laout_arr['showJob']=array();
        $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
            //echo $sql_showJob;
            //print_r($obj_tmp1->laout_arr['showJob']);

            //設定工作地點
            if(!empty($obj_tmp1->laout_arr['showJob'])){
                foreach($obj_tmp1->laout_arr['showJob'] as $key => $value){
                    $obj_tmp1->jobLoca=split("/",$value['location']);
                    //print_r($jobLoca);
                }
            }
        //===========================
    }else{$obj_tmp1->laout_arr['showJob']=array();}

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
    $obj_tmp1->content_html='content/company/Jobpost.html';
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
                  AND ".$obj_tmp1->job.".status='y'
                  ORDER BY ".$obj_tmp1->job.".createDate DESC";
    $obj_tmp1->laout_arr['showJob']=array();
    $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
        //echo $sql_showJob;
        //print_r($obj_tmp1->laout_arr['showJob']);
    //===========================



    $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company/Jobmanage.html';
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
                  AND ".$obj_tmp1->job.".status='F'
                  ORDER BY ".$obj_tmp1->job.".createDate DESC";
    $obj_tmp1->laout_arr['showJob']=array();
    $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
        //echo $sql_showJob;
        //print_r($obj_tmp1->laout_arr['showJob']);
    //===========================



    $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company/Jobsolved.html';
    $obj_tmp1->subMenu='content/company/MenujobManage.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
    $obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

    break;

    case "invalid":

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
                  AND ".$obj_tmp1->job.".status='n'
                  ORDER BY ".$obj_tmp1->job.".createDate DESC";
    $obj_tmp1->laout_arr['showJob']=array();
    $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
        //echo $sql_showJob;
        //print_r($obj_tmp1->laout_arr['showJob']);
    //===========================



    $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company/Jobinvalid.html';
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