<?php
include_once '../share.php';


//page default
$obj_tmp1->jobManage="taolou_member_jobmanage";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';


//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}

//========================

if(@$_POST['method'] == "applyJob"){
	if($userId != ""){
		$sql_apply="INSERT INTO ".$obj_tmp1->jobManage." VALUES(NULL,'".$userId."','".$_POST['jobID']."','".$_POST['CV']['id']."','n','wait',CURRENT_TIMESTAMP)";
		mysql_query($sql_apply);

		$message=array("first"=>"success");
		echo json_encode($message);
	}else{
		$message=array("first"=>"NotMember");
		echo json_encode($message);
	}
}
else if(@$_POST['method'] == "collectJob"){
	if($userId != ""){
		$sql_collect="INSERT INTO ".$obj_tmp1->jobManage." VALUES(NULL,'".$userId."','".$_POST['jobID']."','0','n','collect',CURRENT_TIMESTAMP)";
		mysql_query($sql_collect);

		$message=array("first"=>"success");
		echo json_encode($message);
	}else{
		$message=array("first"=>"NotMember");
		echo json_encode($message);
	}
}
else{}

?>
