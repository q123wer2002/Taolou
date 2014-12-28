<?php
include_once '../share.php';

//page default
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->companySkill="taolou_company_skill";
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->companyFin="taolou_company_finance";

$obj_tmp1->sysComSkill="taolou_system_companyskill";



//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_SESSION['user']['company']){$companyID=$_SESSION['user']['company'];}else{$companyID="";exit;}

//========================

if(@$_POST['method']=="updateCompanyPhoto"){
	if(!empty($_FILES)){
		
		$sql_company="SELECT ".$obj_tmp1->companyTable.".*
					 FROM ".$obj_tmp1->companyTable."
					 WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
		$obj_tmp1->laout_arr['company']=array();
		$obj_tmp1->basic_select('laout_arr','company',$sql_company);
			//echo $sql_company;
			//print_r($obj_tmp1->laout_arr['company']);
		//==========================

		//upload
		$file_path=APP_PATH."/userObject/companyObject/".$obj_tmp1->laout_arr['company'][0]['id']."/";
  		$type=split("/",$_FILES['file']['type']);
  		$file_name=$file_path."CompanyPhoto.".$type[1];
	  	move_uploaded_file($_FILES["file"]["tmp_name"],$file_name);

	  	$file_path="userObject/companyObject/".$obj_tmp1->laout_arr['company'][0]['id']."/"."CompanyPhoto.".$type[1];
		//end Upload

		//update user profile_photo
		$sql_updatePhoto="UPDATE ".$obj_tmp1->companyTable." SET logo='".$file_path."' WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
		mysql_query($sql_updatePhoto);
		//end update

		$message=array('first'=>"success");
		echo json_encode($message);

	}else{
		$message=array('first'=>"no file");
		echo json_encode($message);
	}
}
else if(@$_POST['method']=="updateCEOPhoto"){
	if(!empty($_FILES)){
		
		$sql_company="SELECT ".$obj_tmp1->companyTable.".*
					 FROM ".$obj_tmp1->companyTable."
					 WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
		$obj_tmp1->laout_arr['company']=array();
		$obj_tmp1->basic_select('laout_arr','company',$sql_company);
			//echo $sql_company;
			//print_r($obj_tmp1->laout_arr['company']);
		//==========================

		//upload
		$file_path=APP_PATH."/userObject/companyObject/".$obj_tmp1->laout_arr['company'][0]['id']."/";
  		$type=split("/",$_FILES['file']['type']);
  		$file_name=$file_path."ceoPhoto.".$type[1];
	  	move_uploaded_file($_FILES["file"]["tmp_name"],$file_name);

	  	$file_path="userObject/companyObject/".$obj_tmp1->laout_arr['company'][0]['id']."/"."ceoPhoto.".$type[1];
		//end Upload

		//update user profile_photo
		$sql_updatePhoto="UPDATE ".$obj_tmp1->companyTable." SET ceoPhoto='".$file_path."' WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
		mysql_query($sql_updatePhoto);
		//echo $sql_updatePhoto;
		//end update

		//$message=array('first'=>"success");
		//echo json_encode($message);

	}else{
		$message=array('first'=>"no file");
		echo json_encode($message);
	}
} 
else if(@$_POST['method']=="updateLocation"){
	
	$locationObject = split('&',$_POST['location']);
	$county = split('=',$locationObject[0]);
	$district = split('=',$locationObject[1]);
	$zipcode = split('=',$locationObject[2]);

	$location=$county[1]."/".$district[1]."/".$zipcode[1];

	$sql_updateLocation="UPDATE ".$obj_tmp1->companyTable." SET location='".$location."' WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
	mysql_query($sql_updateLocation);

	$message=array('first'=>"success");
	echo json_encode($message);	
}
else if(@$_POST['method']=="newSkill"){
	$sql_check_newSkill="SELECT ".$obj_tmp1->sysComSkill.".*
						FROM ".$obj_tmp1->sysComSkill."
						WHERE ".$obj_tmp1->sysComSkill.".skillName='".$_POST['skill']."'";
	$obj_tmp1->laout_arr['check_skill']=array();
	$obj_tmp1->basic_select('laout_arr','check_skill',$sql_check_newSkill);

	if($obj_tmp1->laout_arr['check_skill'][0]['id'] != ""){$message=array("message"=>"aleady done");}
	else{
		//儲存新的技能
		$sql_addnewSkill="INSERT INTO ".$obj_tmp1->sysComSkill." VALUES (NULL,'".$_POST['skill']."','n',CURRENT_TIMESTAMP)";
		mysql_query($sql_addnewSkill);
		$message=["message"=>"ok"];
	}
	echo json_encode($message);
	exit;
}
else if(@$_POST['method']=="saveEditCom"){

	/*foreach($_POST as $Key => $Value){

	}
	$_POST=laout_check($_POST);
	print_r($_POST);*/
	//公司基本資料
	$sql_company="UPDATE ".$obj_tmp1->companyTable." SET companyShortName='".$_POST['companyShortName']."', companyName='".$_POST['companyName']."', website='".$_POST['website']."', companyFB='".$_POST['companyFB']."', memberSize='".$_POST['memberSize']."', detail='".$_POST['detail']."', CEO='".$_POST['CEO']."', createDate='".$_POST['companyCreateYear']."-".$_POST['companyCreateMonth']."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
	mysql_query($sql_company);
	//=======================

	//公司技能
		//先確定技能代號
	$mySkillId="";
	foreach($_POST['companySkill'] as $SkillKey => $SkillValue){
		$sql_checkSkill="SELECT ".$obj_tmp1->sysComSkill.".*
						FROM ".$obj_tmp1->sysComSkill."
						WHERE ".$obj_tmp1->sysComSkill.".skillName='".$SkillValue."'";
		$obj_tmp1->laout_arr['checkSkill']=array();
		$obj_tmp1->basic_select('laout_arr','checkSkill',$sql_checkSkill);
		$mySkillId=$mySkillId.$obj_tmp1->laout_arr['checkSkill'][0]['id']."|";
	}
	$mySkillId=substr($mySkillId,0,-1);
	//print_r($mySkillId);

		//開始存入資料庫
	$sql_myskill="UPDATE ".$obj_tmp1->companySkill." SET skillList='".$mySkillId."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->companySkill.".companyId='".$companyID."'";
	mysql_query($sql_myskill);
	//=======================

	//公司融資
	//確認是否要keyIn
	$sql_checkFIN="SELECT ".$obj_tmp1->companyFin.".* FROM ".$obj_tmp1->companyFin." WHERE ".$obj_tmp1->companyFin.".stage='".$_POST['stage']."' AND date='".$_POST['companyFinYear']."-".$_POST['companyFinMonth']."' AND ".$obj_tmp1->companyFin.".companyId='".$companyID."'";
	$obj_tmp1->laout_arr['checkFIN']=array();
	$obj_tmp1->basic_select('laout_arr','checkFIN',$sql_checkFIN);
		//echo $sql_checkFIN;
		//print_r($obj_tmp1->laout_arr['checkFIN']);
	//==========================
	if(empty($obj_tmp1->laout_arr['checkFIN'][0]['id'])){
		$sql_companyFin="INSERT INTO ".$obj_tmp1->companyFin." VALUES(NULL,'".$companyID."','".$_POST['stage']."','".$_POST['companyFinYear']."-".$_POST['companyFinMonth']."',CURRENT_TIMESTAMP)";
		mysql_query($sql_companyFin);
		//=======================
	}

	$message=["message"=>"ok"];
	echo json_encode($message);
	exit;
}

?>