<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->hrtable='taolou_member';
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->companySkill="taolou_company_skill";
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->companyFin="taolou_company_finance";

$obj_tmp1->sysComSkill="taolou_system_companyskill";

$obj_tmp1->tmp_where="";
$obj_tmp1->tmp_comanyId = "";
$obj_tmp1->ourCompany=false;
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

$action="";

//decode company id
if($_SESSION['user']['id'] != ""){
	if(@$_REQUEST["company"] == ""){
		if(@$_SESSION['user']['company'] != ""){
			@$obj_tmp1->tmp_comanyId=$_SESSION['user']['company'];
			$obj_tmp1->ourCompany=true;
		}
		else{$action="none";}
	}
	else{
		$obj_tmp1->tmp_comanyId = $obj_tmp1->decode(laout_check($_REQUEST["company"]));
		if($obj_tmp1->tmp_comanyId == @$_SESSION['user']['company']){$obj_tmp1->ourCompany=true;}
	}
	$userId=$_SESSION['user']['id'];
}
else{
	if(@$_REQUEST['company'] != ""){@$obj_tmp1->tmp_comanyId = $obj_tmp1->decode(laout_check($_REQUEST["company"]));}
	else{$action='none';}
}
//==================


switch($action){
	case "none":
	
	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/404.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;
	
	default:
	//公司基本資料
	$sql_company="SELECT ".$obj_tmp1->companyTable.".* 
				  FROM ".$obj_tmp1->companyTable."
				  WHERE ".$obj_tmp1->companyTable.".id='".$obj_tmp1->tmp_comanyId."'";
	$obj_tmp1->laout_arr['company']=array();
	$obj_tmp1->basic_select('laout_arr','company',$sql_company);
		//$sql_company
		//print_r($obj_tmp1->laout_arr['company']);
	//===========================

	//抓取公司技能
    $sql_companySkill="SELECT ".$obj_tmp1->companySkill.".*
                       FROM ".$obj_tmp1->companySkill."
                       WHERE ".$obj_tmp1->companySkill.".companyId = '".$obj_tmp1->tmp_comanyId."'";
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
                $obj_tmp1->myskill=split('[|]', $obj_tmp1->mySkillLists);
            }
    //==========================

	//抓取公司融資
    $sql_financeInfo="SELECT ".$obj_tmp1->companyFin.".*
                      FROM ".$obj_tmp1->companyFin."
                      WHERE ".$obj_tmp1->companyFin.".companyId='".$obj_tmp1->tmp_comanyId."'
                      ORDER BY ".$obj_tmp1->companyFin.".createDate DESC
                      LIMIT 0,1";
    $obj_tmp1->laout_arr['finInfo']=array();
    $obj_tmp1->basic_select('laout_arr','finInfo',$sql_financeInfo);
        //echo $sql_financeInfo;
        //print_r($obj_tmp1->laout_arr['finInfo']);
    //==========================

	//公司人資帳號
	$sql_comHr="SELECT ".$obj_tmp1->hrtable.".*
				FROM ".$obj_tmp1->hrtable."
				LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->hrtable.".companyId=".$obj_tmp1->companyTable.".id
				WHERE ".$obj_tmp1->hrtable.".companyHr='y'
				AND ".$obj_tmp1->hrtable.".companyId='".$obj_tmp1->tmp_comanyId."'";
	$obj_tmp1->laout_arr['comHr']=array();
	$obj_tmp1->basic_select('laout_arr','comHr',$sql_comHr);
		//$sql_comHr
		//print_r($obj_tmp1->laout_arr['comHr']);
	//===========================

	//職位列表
	$sql_job="SELECT ".$obj_tmp1->jobtable.".*
			  FROM ".$obj_tmp1->jobtable."
			  LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->jobtable.".companyId=".$obj_tmp1->companyTable.".id
			  WHERE ".$obj_tmp1->jobtable.".companyId='".$obj_tmp1->tmp_comanyId."'
			  AND ".$obj_tmp1->jobtable.".status='y'";
	$obj_tmp1->laout_arr['job']=array();
	$obj_tmp1->basic_select('laout_arr','job',$sql_job);
		//echo $sql_job;
		//print_r($obj_tmp1->laout_arr['job']);
	//===========================


    //echo $obj_tmp1->encode("1"),"<BR>";
    //echo $obj_tmp1->decode($obj_tmp1->encode("1"));


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/company.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;
}


?>