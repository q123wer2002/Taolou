<?php
include_once '../share.php';


//page default
$obj_tmp1->jobManage="taolou_member_jobmanage";
$obj_tmp1->message="taolou_member_message";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';


//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}

//========================

if(@$_POST['method'] == "applyJob"){
	//print_r($_POST);
	if($userId != ""){
		$sql_apply="INSERT INTO ".$obj_tmp1->jobManage." VALUES(NULL,'".$userId."','".$_POST['jobID']."','".$_POST['CV']['id']."','n','','',CURRENT_TIMESTAMP)";
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
		$sql_collect="INSERT INTO ".$obj_tmp1->jobManage." VALUES(NULL,'".$userId."','".$_POST['jobID']."','','n','collect','',CURRENT_TIMESTAMP)";
		mysql_query($sql_collect);

		$message=array("first"=>"success");
		echo json_encode($message);
	}else{
		$message=array("first"=>"NotMember");
		echo json_encode($message);
	}
}
else if(@$_POST['method'] == "message"){
	$receiveId=$obj_tmp1->decode($_POST['receiveID']);

	$sql_MessageCon="SELECT ".$obj_tmp1->message.".*
					 FROM ".$obj_tmp1->message."
					 WHERE (".$obj_tmp1->message.".receiveUserId='".$userId."' AND ".$obj_tmp1->message.".sendUserId ='".$receiveId."')
					 OR (".$obj_tmp1->message.".receiveUserId='".$receiveId."' AND ".$obj_tmp1->message.".sendUserId ='".$userId."')
					 ORDER BY ".$obj_tmp1->message.".createDate";
	$obj_tmp1->laout_arr['MessageCont']=array();
    $obj_tmp1->basic_select('laout_arr','MessageCont',$sql_MessageCon);
        //echo $sql_MessageCon;
        //print_r($obj_tmp1->laout_arr['MessageCont']);

    if(empty($obj_tmp1->laout_arr['MessageCont'])){
    	$sql_insertMes="INSERT INTO ".$obj_tmp1->message." VALUES(NULL,'".$userId."','".$receiveId."','-----system setting-----','n',CURRENT_TIMESTAMP)";
    	mysql_query($sql_insertMes);
    }

    $message=array("first"=>"success");
	echo json_encode($message);

}
else{}

?>
