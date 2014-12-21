<?php
include_once 'share.php';

//page default
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->companySkill="taolou_company_skill";
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->companyFin="taolou_company_finance";

$obj_tmp1->sysComSkill="taolou_system_companyskill";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
if(@laout_check($_GET['action']) != ""){$companyID=$obj_tmp1->decode(laout_check($_GET['action']));}else{$companyID="";}
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_SESSION['user']['userType'] != "" && @$getAction==""){
    if(@$_SESSION['user']['userType'] == '1'){$action='none';}
    else if(@$_SESSION['user']['userType'] == '2' && $companyID != ""){$action='edit';}
    else{$action='none';}
}else{$action="none";}
//===================


switch(@$action){
	case "edit":

    //抓取公司資訊
    $sql_getCompanyInfo="SELECT ".$obj_tmp1->companyTable.".*
                         FROM ".$obj_tmp1->companyTable."
                         WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
    $obj_tmp1->laout_arr['company']=array();
    $obj_tmp1->basic_select('laout_arr','company',$sql_getCompanyInfo);
        //echo $sql_getCompanyInfo;
        //print_r($obj_tmp1->laout_arr['company']);

        //分析公司地址
        if(!empty($obj_tmp1->laout_arr['company'][0]['location'])){
            $obj_tmp1->location=array();
            $obj_tmp1->location=split('[/]',$obj_tmp1->laout_arr['company'][0]['location']);
            //print_r($obj_tmp1->location);
        }

        //分析公司成立年月
        if(!empty($obj_tmp1->laout_arr['company'][0]['createDate'])){
            $obj_tmp1->createDate=array();
            $obj_tmp1->createDate=split('[-]',$obj_tmp1->laout_arr['company'][0]['createDate']);
            //print_r($obj_tmp1->createDate);
        }
    //==========================


    //抓取公司技能
    $sql_companySkill="SELECT ".$obj_tmp1->companySkill.".*
                       FROM ".$obj_tmp1->companySkill."
                       WHERE ".$obj_tmp1->companySkill.".companyId = '".$companyID."'";
    $obj_tmp1->laout_arr['companySkill']=array();
    $obj_tmp1->basic_select('laout_arr','companySkill',$sql_companySkill);
        //echo $sql_companySkill;
        //print_r($obj_tmp1->laout_arr['companySkill']);

        //顯示公司的技能
            if(!empty($obj_tmp1->laout_arr['companySkill'][0]['skillList'])){
                $skillLists=array();
                $skillLists=split('[|]',$obj_tmp1->laout_arr['companySkill'][0]['skillList']);
                    //echo $obj_tmp1->laout_arr['companySkill'][0]['skillList'];
                    //print_r($skillLists);
                $obj_tmp1->mySkillLists="";
                foreach($skillLists as $skListKey => $skListValue){
                    //echo $skListValue;
                    $sql_SL="SELECT ".$obj_tmp1->sysComSkill.".*
                             FROM ".$obj_tmp1->sysComSkill."
                             WHERE ".$obj_tmp1->sysComSkill.".id='".$skListValue."'";
                    $obj_tmp1->laout_arr['SL']=array();
                    $obj_tmp1->basic_select('laout_arr','SL',$sql_SL);
                        //echo $sql_SL;
                        //print_r($obj_tmp1->laout_arr['SL']);
                    $obj_tmp1->mySkillLists=$obj_tmp1->mySkillLists.$obj_tmp1->laout_arr['SL'][0]['skillName']."|";
                        //echo $obj_tmp1->laout_arr['SL'][0]['skill'];
                }
                $obj_tmp1->mySkillLists=substr($obj_tmp1->mySkillLists,0,-1);
                //print_r($obj_tmp1->mySkillLists);
            }
    //==========================

    //抓取公司融資
    $sql_financeInfo="SELECT ".$obj_tmp1->companyFin.".*
                      FROM ".$obj_tmp1->companyFin."
                      WHERE ".$obj_tmp1->companyFin.".companyId='".$companyID."'
                      ORDER BY ".$obj_tmp1->companyFin.".createDate DESC
                      LIMIT 0,1";
    $obj_tmp1->laout_arr['finInfo']=array();
    $obj_tmp1->basic_select('laout_arr','finInfo',$sql_financeInfo);
        //echo $sql_financeInfo;
        //print_r($obj_tmp1->laout_arr['finInfo']);

        //分析公司融資成立年月
        if(!empty($obj_tmp1->laout_arr['finInfo'][0]['date'])){
            $obj_tmp1->financeDate=array();
            $obj_tmp1->financeDate=split('[-]',$obj_tmp1->laout_arr['finInfo'][0]['date']);
            //print_r($obj_tmp1->financeDate);
        }
    //==========================

    //抓取系統技能
    $sql_sysComSkill="SELECT ".$obj_tmp1->sysComSkill.".*
                      FROM ".$obj_tmp1->sysComSkill."
                      WHERE ".$obj_tmp1->sysComSkill.".status='y'";
    $obj_tmp1->laout_arr['sysComSkill']=array();
    $obj_tmp1->basic_select('laout_arr','sysComSkill',$sql_sysComSkill);
        //echo $sql_sysComSkill;
        //print_r($obj_tmp1->laout_arr['sysComSkill']);
    
    $obj_tmp1->allComSkill="";

    foreach($obj_tmp1->laout_arr['sysComSkill'] as $allSkillKey => $allSkillValue){
        $obj_tmp1->allComSkill=$obj_tmp1->allComSkill.$allSkillValue['skillName']."|";
    }
    $obj_tmp1->allComSkill=substr($obj_tmp1->allComSkill,0,-1);
        //print_r($obj_tmp1->allComSkill);

    //==========================




	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company/companyEdit.html';
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