<?php
include_once '../share.php';


//page default
$obj_tmp1->job="taolou_job";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';


//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_SESSION['user']['company']){$companyId=$_SESSION['user']['company'];}else{$companyID="";exit;}

//========================



if(@$_POST['method']=="saveJob"){
	//print_r($_POST);

	if($_POST['stock_option']){$stock="y";}
	else{$stock="n";}

	$sql_postJob="INSERT INTO ".$obj_tmp1->job." VALUES(NULL,'".$userId."','".$_POST['title']."','".$companyId."','".$_POST['jobName']."','".$_POST['location']."','".$_POST['jobType']."','".$_POST['jobNature']."','".$_POST['salary']."','".$stock."','".$_POST['detail']."','y','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);";
	mysql_query($sql_postJob);

	$message=array("first"=>"ok");
	echo json_encode($message);
	exit;
}
else if(@$_POST['method']=="updateJob"){
	//print_r($_POST);
	
	if($_POST['stock_option']){$stock="y";}
	else{$stock="n";}

	if($_POST['status']=="有效職位"){$status='y';}
	else if($_POST['status']=="已解決"){$status='F';}
	else if($_POST['status']=="無效職位"){$status='n';}

	$sql_updateJob="UPDATE ".$obj_tmp1->job." SET title='".$_POST['title']."',jobName='".$_POST['jobName']."',location='".$_POST['location']."',jobType='".$_POST['jobType']."',jobNature='".$_POST['jobNature']."',salary='".$_POST['salary']."',stock_option='".$stock."',detail='".$_POST['detail']."',status='".$status."',updateDate=CURRENT_TIMESTAMP WHERE id='".$_POST['ID']."'";
	mysql_query($sql_updateJob);

	$message=array("first"=>"ok");
	echo json_encode($message);
	exit;
}

?>
