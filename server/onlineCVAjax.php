<?php
include_once '../share.php';

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberCV='taolou_member_cv';
$obj_tmp1->memberExp='taolou_member_experience';
$obj_tmp1->memberedu='taolou_member_education';
$obj_tmp1->memberwanttjob='taolou_member_wantjob';
$obj_tmp1->workLoc="taolou_system_location";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

$userId=$_SESSION['user']['id'];

if(@$_POST['method'] == 'saveUserProfile'){
	//儲存基本資料
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