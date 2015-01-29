<?php
include_once '../share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberCV='taolou_member_cv';
$obj_tmp1->memberExp='taolou_member_experience';
$obj_tmp1->memberedu='taolou_member_education';
$obj_tmp1->memberwanttjob='taolou_member_wantjob';
$obj_tmp1->memberSkill="taolou_member_specialskill";

$obj_tmp1->workLoc="taolou_system_location";
$obj_tmp1->skillList="taolou_system_specialskill";


$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

$userId=$_SESSION['user']['id'];

if(@$_POST['method'] == 'saveUserProfile'){
	//儲存基本資料
	//print_r($_POST);
	$sql_updateProfile="UPDATE ".$obj_tmp1->member."
						SET name='".$_POST['userName']."', born='".$_POST['userBorn']."', lastEducation='".$_POST['userEducation']."', workYears='".$_POST['userWorkyear']."', jobStatus='".$_POST['userJobstatus']."' 
						WHERE id='".$userId."'";
	mysql_query($sql_updateProfile);

	echo "success";
	exit;
}
else if(@$_POST['method'] == 'savePhone'){
	//儲存電話號碼
	$sql_updateProfile="UPDATE ".$obj_tmp1->member."
						SET phone='".$_POST['phone']."' 
						WHERE id='".$userId."'";
	mysql_query($sql_updateProfile);

	echo "successPhone";
	exit;
}
else if(@$_POST['method'] == 'newLoca'){
	//新增工作地區
	$sql_check_newLoca="SELECT ".$obj_tmp1->workLoc.".*
						FROM ".$obj_tmp1->workLoc."
						WHERE ".$obj_tmp1->workLoc.".location='".$_POST['location']."'
						AND ".$obj_tmp1->workLoc.".status='y' ";
	$obj_tmp1->laout_arr['check_loca']=array();
	$obj_tmp1->basic_select('laout_arr','check_loca',$sql_check_newLoca);

	if($obj_tmp1->laout_arr['check_loca'][0]['id'] != ""){$message=array("message"=>"error");}
	else{
		$sql_addnewLoca="INSERT INTO ".$obj_tmp1->workLoc."
						 VALUES (NULL,'".$_POST['location']."','n',CURRENT_TIMESTAMP)";
		mysql_query($sql_addnewLoca);

		//顯示剛剛存的的是在哪一個ID
		$SQLSHOWLOCAID="SELECT ".$obj_tmp1->workLoc.".*
					  FROM ".$obj_tmp1->workLoc."
					  WHERE ".$obj_tmp1->workLoc.".location='".$_POST['location']."'
					  AND ".$obj_tmp1->workLoc.".status='y' ";
		$obj_tmp1->laout_arr['SHOWLOCAID']=array();
		$obj_tmp1->basic_select('laout_arr','SHOWLOCAID',$SQLSHOWLOCAID);
		$locationId=$obj_tmp1->laout_arr['SHOWLOCAID'][0]['id'];

		$message=["message"=>"ok"];
	}
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == 'jobwish'){
	//先確定工作地點代號
	$locationId="";
	foreach($_POST['location'] as $LocaKey => $LocaValue){
		$sql_checkLoca="SELECT ".$obj_tmp1->workLoc.".*
						FROM ".$obj_tmp1->workLoc."
						WHERE ".$obj_tmp1->workLoc.".location='".$LocaValue."'";
		$obj_tmp1->laout_arr['checkLoca']=array();
		$obj_tmp1->basic_select('laout_arr','checkLoca',$sql_checkLoca);
		$locationId=$locationId.$obj_tmp1->laout_arr['checkLoca'][0]['id']."|";
	}
	$locationId=substr($locationId,0,-1);
	//print_r($locationId);

	//工作類型 標準化
	$jobType=$_POST['jobType'][0]['status']."|".$_POST['jobType'][1]['status']."|".$_POST['jobType'][2]['status'];

	//開始存入資料庫
	$sql_jobwish="UPDATE ".$obj_tmp1->memberwanttjob."
				  SET name='".$_POST['name']."', jobType='".$jobType."', leastSalary='".$_POST['leastSalary']."', stock_option='".$_POST['stock_option']."', location='".$locationId."', telework='".$_POST['telework']."', updateDate=CURRENT_TIMESTAMP
				  WHERE ".$obj_tmp1->memberwanttjob.".memberId='".$userId."'";
	mysql_query($sql_jobwish);

	$message=array("first"=>"success");
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == 'newSkill'){
	$sql_check_newSkill="SELECT ".$obj_tmp1->skillList.".*
						FROM ".$obj_tmp1->skillList."
						WHERE ".$obj_tmp1->skillList.".skill='".$_POST['skill']."'";
	$obj_tmp1->laout_arr['check_skill']=array();
	$obj_tmp1->basic_select('laout_arr','check_skill',$sql_check_newSkill);

	if($obj_tmp1->laout_arr['check_skill'][0]['id'] != ""){$message=array("message"=>"aleady done");}
	else{
		//儲存新的技能
		$sql_addnewSkill="INSERT INTO ".$obj_tmp1->skillList." VALUES (NULL,'0','".$_POST['skill']."','n',CURRENT_TIMESTAMP)";
		mysql_query($sql_addnewSkill);
		$message=["message"=>"ok"];
	}
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == 'mySkill'){
	//先確定技能代號
	$mySkillId="";
	foreach($_POST['skillList'] as $SkillKey => $SkillValue){
		$sql_checkSkill="SELECT ".$obj_tmp1->skillList.".*
						FROM ".$obj_tmp1->skillList."
						WHERE ".$obj_tmp1->skillList.".skill='".$SkillValue."'";
		$obj_tmp1->laout_arr['checkSkill']=array();
		$obj_tmp1->basic_select('laout_arr','checkSkill',$sql_checkSkill);
		$mySkillId=$mySkillId.$obj_tmp1->laout_arr['checkSkill'][0]['id']."|";
	}
	$mySkillId=substr($mySkillId,0,-1);
	//print_r($mySkillId);

	//開始存入資料庫
	$sql_myskill="UPDATE ".$obj_tmp1->memberSkill."
				  SET skillList='".$mySkillId."', updateDate=CURRENT_TIMESTAMP
				  WHERE ".$obj_tmp1->memberSkill.".memberId='".$userId."'";
	mysql_query($sql_myskill);

	$message=array("first"=>"success");
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == 'myAddEducation'){
	$datatime=date("Y-m-d H:i:s");
	$sql_addEducation="INSERT INTO ".$obj_tmp1->memberedu." VALUES (NULL,'".$userId."','','','','','','".$datatime."','".$datatime."')";
	mysql_query($sql_addEducation);
	
	//找出剛剛存入的id
    $sql_searchID="SELECT ".$obj_tmp1->memberedu.".* FROM ".$obj_tmp1->memberedu." WHERE ".$obj_tmp1->memberedu.".createDate='".$datatime."'";
    $obj_tmp1->laout_arr['searchID']=array();
	$obj_tmp1->basic_select('laout_arr','searchID',$sql_searchID);
	//======================

	if(!empty($obj_tmp1->laout_arr['searchID'][0]['id'])){$EducationID=$obj_tmp1->laout_arr['searchID'][0]['id'];}
	else{$EducationID="noID";}

	$message=array("first"=>"success","Eduid"=>$EducationID);
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == 'myEducation'){
	$sql_saveEdu="UPDATE ".$obj_tmp1->memberedu." SET educationBG='".$_POST['educationBG']."', startYear='".$_POST['startYear']."', endYear='".$_POST['endYear']."', school='".$_POST['school']."', major='".$_POST['major']."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->memberedu.".id='".$_POST['id']."'";
	mysql_query($sql_saveEdu);

	$message=array("first"=>"success");
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == 'mydeleteEducation'){
	$sql_deleteEdu="DELETE FROM ".$obj_tmp1->memberedu."
					WHERE ".$obj_tmp1->memberedu.".id='".$_POST['id']."'";
	mysql_query($sql_deleteEdu);
	$message=array("first"=>"success");
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == "myAddExperience"){
	$datatime=date("Y-m-d H:i:s");
	$sql_addexperience="INSERT INTO ".$obj_tmp1->memberExp." VALUES (NULL,'".$userId."','','','','','','','".$datatime."','".$datatime."')";
	mysql_query($sql_addexperience);

	//找出剛剛存入的id
    $sql_searchID="SELECT ".$obj_tmp1->memberExp.".* FROM ".$obj_tmp1->memberExp." WHERE ".$obj_tmp1->memberExp.".createDate='".$datatime."'";
    $obj_tmp1->laout_arr['searchID']=array();
	$obj_tmp1->basic_select('laout_arr','searchID',$sql_searchID);
	//======================

	if(!empty($obj_tmp1->laout_arr['searchID'][0]['id'])){$ExperienceID=$obj_tmp1->laout_arr['searchID'][0]['id'];}
	else{$ExperienceID="noID";}

	$message=array("first"=>"success","Expid"=>$ExperienceID);
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == "myExperience"){
	$sql_saveExp="UPDATE ".$obj_tmp1->memberExp." SET name='".$_POST['name']."', year='".$_POST['year']."', continueTime='".$_POST['continueTime']."', company='".$_POST['company']."', role='".$_POST['role']."', detail='".$_POST['detail']."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->memberExp.".id='".$_POST['id']."'";
	mysql_query($sql_saveExp);

	$message=array("first"=>"success","sql"=>$sql_saveExp);
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == "mydeleteExperience"){
	$sql_deleteExp="DELETE FROM ".$obj_tmp1->memberExp."
					WHERE ".$obj_tmp1->memberExp.".id='".$_POST['id']."'";
	mysql_query($sql_deleteExp);
	$message=array("first"=>"success");
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == "addself"){
	$sql_addself="UPDATE ".$obj_tmp1->member." SET selfIntro='".$_POST['selfIntro']."' WHERE ".$obj_tmp1->member.".id='".$userId."'";
	mysql_query($sql_addself);
	$message=array("first"=>"success");
	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == "userPhoto"){
	$message=$_POST['photo'];
	echo json_encode($message);
	exit;
}