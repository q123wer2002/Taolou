<?php
include_once '../share.php';

$obj_tmp1->job="taolou_job";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

if(!empty($_SESSION['user']['id'])){
	$userId=$_SESSION['user']['id'];
}
if(!empty($_SESSION['user']['company']))
	$companyId=$_SESSION['user']['company'];
}

if(@$_POST['method']=="saveJob"){
	$sql_postJob="INSERT INTO ".$obj_tmp1->job." VALUES(NULL,'".$_POST['title']."','".$companyId."','".$_POST['jobName']."','".$_POST['location']."','".$_POST['jobType']."','".$_POST['jobNature']."','".$_POST['salary']."','".$_POST['stock_option']."','".$_POST['detail']."','y',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);";
	//mysql_query($sql_postJob);

	$message=array("first"=>"ok");
	echo json_encode($message);
	exit;
}
else if(@$_POST['method']=="updateJob"){
	$sql_updateJob="UPDATE ".$obj_tmp1->job." SET title='".$_POST['title']."',jobName='".$_POST['jobName']."',location='".$_POST['location']."',jobType='".$_POST['jobType']."',jobNature='".$_POST['jobNature']."',salary='".$_POST['salary']."',stock_option='".$_POST['stock_option']."',detail='".$_POST['detail']."',status='".$_POST['status']."',updateDate=CURRENT_TIMESTAMP WHERE id='".$_POST['ID']."'";
	//mysql_query($sql_updateJob);

	$message=array("first"=>"ok");
	echo json_encode($message);
	exit;
}
