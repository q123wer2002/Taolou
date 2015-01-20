<?php
include_once 'share.php';

//page default
$obj_tmp1->sysJobType="taolou_system_jobtype";

$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberJob="taolou_member_jobmanage";
$obj_tmp1->memberCV="taolou_member_cv";

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

    //how many seeker wanna this job
    $obj_tmp1->seekers=array();
    $obj_tmp1->collectSeekers=array();

    foreach ($obj_tmp1->laout_arr['showJob'] as $key => $value) {
        $sql_seeker="SELECT COUNT(".$obj_tmp1->memberJob.".id) as COUNT_SEEKER 
                     FROM ".$obj_tmp1->memberJob."
                     LEFT JOIN ".$obj_tmp1->job." ON ".$obj_tmp1->job.".id=".$obj_tmp1->memberJob.".jobId
                     WHERE ".$obj_tmp1->memberJob.".jobId='".$value['id']."'
                     AND ".$obj_tmp1->memberJob.".status <> 'collect'";
        $obj_tmp1->laout_arr['seeker']=array();
        $obj_tmp1->basic_select('laout_arr','seeker',$sql_seeker);
            //echo $sql_seeker;
            //print_r($obj_tmp1->laout_arr['seeker']);
        if(!empty($obj_tmp1->laout_arr['seeker'])){
            $obj_tmp1->seekers[$value['id']]=$obj_tmp1->laout_arr['seeker'][0]['COUNT_SEEKER'];
            //print_r($obj_tmp1->seekers);
        }

        //collect
        $sql_collectSeeker="SELECT COUNT(".$obj_tmp1->memberJob.".id) as COUNT_SEEKER 
                     FROM ".$obj_tmp1->memberJob."
                     LEFT JOIN ".$obj_tmp1->job." ON ".$obj_tmp1->job.".id=".$obj_tmp1->memberJob.".jobId
                     WHERE ".$obj_tmp1->memberJob.".jobId='".$value['id']."'
                     AND ".$obj_tmp1->memberJob.".status = 'collect'";
        $obj_tmp1->laout_arr['collectSeeker']=array();
        $obj_tmp1->basic_select('laout_arr','collectSeeker',$sql_collectSeeker);
            //echo $sql_collectSeeker;
            //print_r($obj_tmp1->laout_arr['collectSeeker']);
        if(!empty($obj_tmp1->laout_arr['collectSeeker'])){
            $obj_tmp1->collectSeekers[$value['id']]=$obj_tmp1->laout_arr['collectSeeker'][0]['COUNT_SEEKER'];
            //print_r($obj_tmp1->collectSeekers);
        }
    }
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

    case "found":

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
    
    //catch all the access people
    $obj_tmp1->accessMan=array();
    if(!empty($obj_tmp1->laout_arr['showJob'])){
        foreach($obj_tmp1->laout_arr['showJob'] as $key => $value){
            $sql_findRightMan="SELECT ".$obj_tmp1->member.".*, ".$obj_tmp1->memberCV.".src as RESUME
                               FROM ".$obj_tmp1->memberJob."
                               LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->memberJob.".memberId=".$obj_tmp1->member.".id
                               LEFT JOIN ".$obj_tmp1->memberCV." ON ".$obj_tmp1->memberJob.".cvId=".$obj_tmp1->memberCV.".id 
                               WHERE ".$obj_tmp1->memberJob.".jobId='".$value['id']."'
                               AND ".$obj_tmp1->memberJob.".status='access'";
            $obj_tmp1->laout_arr['findRightMan']=array();
            $obj_tmp1->basic_select('laout_arr','findRightMan',$sql_findRightMan);
                //echo $sql_findRightMan;
                //print_r($obj_tmp1->laout_arr['findRightMan']);

            $obj_tmp1->accessMan[$value['id']]=$obj_tmp1->laout_arr['findRightMan'];
        }
        //print_r($obj_tmp1->accessMan);
    }
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