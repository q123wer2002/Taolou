<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberCV='taolou_member_cv';
$obj_tmp1->memberExp='taolou_member_experience';
$obj_tmp1->memberedu='taolou_member_education';
$obj_tmp1->memberwanttjob='taolou_member_wantjob';
$obj_tmp1->memberSkill="taolou_member_specialskill";

$obj_tmp1->facebook="taolou_member_facebook";
$obj_tmp1->IN="taolou_member_linkedin";

$obj_tmp1->workLoc="taolou_system_location";
$obj_tmp1->skillList="taolou_system_specialskill";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';


// take user profile
if(@$_GET['seekerID'] != ''){
	if(@$_SESSION['user']['userType'] == '2'){
		$action='preview';
		$seekerID=$obj_tmp1->decode(laout_check($_GET['seekerID']));
	}else{$action='none';}
}else{
	if(@$_SESSION['user']['userType'] == '1'){
		$action='preview';
		$seekerID=$_SESSION['user']['id'];
	}else{$action='none';}
}
//===================

switch(@$action){

	case 'preview':

	//顯示個人基本訊息
	$sql_member="SELECT ".$obj_tmp1->member.".*
				 FROM ".$obj_tmp1->member."
				 WHERE ".$obj_tmp1->member.".id='".$seekerID."' AND ".$obj_tmp1->member.".companyHr='n'";
	$obj_tmp1->laout_arr['member']=array();
	$obj_tmp1->basic_select('laout_arr','member',$sql_member);
		//echo $sql_member;
		//print_r($obj_tmp1->laout_arr['member']);
	//==========================

	//希望的工作
	$sql_wantjob="SELECT ".$obj_tmp1->memberwanttjob.".*
				  FROM ".$obj_tmp1->memberwanttjob."
				  LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->memberwanttjob.".memberId
				  WHERE ".$obj_tmp1->memberwanttjob.".memberId='".$seekerID."'";
	$obj_tmp1->laout_arr['wantjob']=array();
	$obj_tmp1->basic_select('laout_arr','wantjob',$sql_wantjob);
		//echo $sql_wantjob;
		//print_r($obj_tmp1->laout_arr['wantjob']);
		
		//顯示所有工作地區
		$sql_workLocation="SELECT ".$obj_tmp1->workLoc.".*
						   FROM ".$obj_tmp1->workLoc."
						   WHERE ".$obj_tmp1->workLoc.".status = 'y'
						   ORDER BY ".$obj_tmp1->workLoc.".id";
		$obj_tmp1->laout_arr['workLocation']=array();
		$obj_tmp1->basic_select('laout_arr','workLocation',$sql_workLocation);
			//echo $sql_workLocation;
			//print_r($obj_tmp1->laout_arr['workLocation']);
		
		//顯示想要的地區
		if(!empty($obj_tmp1->laout_arr['wantjob'][0]['location'])){
			$wantLocationNum=array();
			$wantLocationNum=split('[|]',$obj_tmp1->laout_arr['wantjob'][0]['location']);
				//echo $obj_tmp1->laout_arr['wantjob'][0]['location'];
				//print_r($wantLocationNum);
			$obj_tmp1->wantLocation="";
			foreach($wantLocationNum as $WLKey => $WLValue){
				//echo $WLKey;
				$sql_WL="SELECT ".$obj_tmp1->workLoc.".*
						 FROM ".$obj_tmp1->workLoc."
						 WHERE ".$obj_tmp1->workLoc.".id='".$WLValue."'";
				$obj_tmp1->laout_arr['WL']=array();
				$obj_tmp1->basic_select('laout_arr','WL',$sql_WL);
					//echo $sql_WL;
					//print_r($obj_tmp1->laout_arr['WL']);
				$obj_tmp1->wantLocation=$obj_tmp1->wantLocation.$obj_tmp1->laout_arr['WL'][0]['location']."|";
					//echo $obj_tmp1->laout_arr['WL'][0]['location'];
			}
			$obj_tmp1->wantLocation=substr($obj_tmp1->wantLocation,0,-1);
			//print_r($obj_tmp1->wantLocation);
		}
	//==========================


	//專長技能
		//顯示所有技能
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

		//列出我的技能
		$sql_memberSkill="SELECT ".$obj_tmp1->memberSkill.".*
						   FROM ".$obj_tmp1->memberSkill."
						   WHERE ".$obj_tmp1->memberSkill.".memberId = '".$seekerID."'";
		$obj_tmp1->laout_arr['memberSkill']=array();
		$obj_tmp1->basic_select('laout_arr','memberSkill',$sql_memberSkill);
			//echo $sql_memberSkill;
			//print_r($obj_tmp1->laout_arr['memberSkill']);

			//顯示我的技能
			if(!empty($obj_tmp1->laout_arr['memberSkill'][0]['skillList'])){
				$skillLists=array();
				$skillLists=split('[|]',$obj_tmp1->laout_arr['memberSkill'][0]['skillList']);
					//echo $obj_tmp1->laout_arr['memberSkill'][0]['skillList'];
					//print_r($skillLists);
				$obj_tmp1->mySkillLists="";
				foreach($skillLists as $skListKey => $skListValue){
					//echo $skListValue;
					$sql_SL="SELECT ".$obj_tmp1->skillList.".*
						 	 FROM ".$obj_tmp1->skillList."
						 	 WHERE ".$obj_tmp1->skillList.".id='".$skListValue."'";
					$obj_tmp1->laout_arr['SL']=array();
					$obj_tmp1->basic_select('laout_arr','SL',$sql_SL);
						//echo $sql_SL;
						//print_r($obj_tmp1->laout_arr['SL']);
					$obj_tmp1->mySkillLists=$obj_tmp1->mySkillLists.$obj_tmp1->laout_arr['SL'][0]['skill']."|";
						//echo $obj_tmp1->laout_arr['SL'][0]['skill'];
				}
				$obj_tmp1->mySkillLists=substr($obj_tmp1->mySkillLists,0,-1);
				//print_r($obj_tmp1->mySkillLists);
			}
	//==========================

	//教育狀況
	$sql_education="SELECT ".$obj_tmp1->memberedu.".*
					FROM ".$obj_tmp1->memberedu."
					LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->memberedu.".memberId
					WHERE ".$obj_tmp1->memberedu.".memberId='".$seekerID."'";
	$obj_tmp1->laout_arr['education']=array();
	$obj_tmp1->basic_select('laout_arr','education',$sql_education);
		//echo $sql_education;
		//print_r($obj_tmp1->laout_arr['education']);


	//==========================

	//經歷
	$sql_experience="SELECT ".$obj_tmp1->memberExp.".*
				  	 FROM ".$obj_tmp1->memberExp."
				  	 LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->memberExp.".memberId
				  	 WHERE ".$obj_tmp1->memberExp.".memberId='".$seekerID."'";
	$obj_tmp1->laout_arr['experience']=array();
	$obj_tmp1->basic_select('laout_arr','experience',$sql_experience);
		//echo $sql_experience;
		//print_r($obj_tmp1->laout_arr['experience']);
	//==========================

	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/user/userMe_preview.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    //$obj_tmp1->footer_html="footer.html";
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