<?php
include_once '../share.php';


//page default
$obj_tmp1->jobManage="taolou_member_jobmanage";
$obj_tmp1->message="taolou_member_message";
$obj_tmp1->member='taolou_member_detail';

$obj_tmp1->userNotification="taolou_member_notification_user";
$obj_tmp1->hrNotification="taolou_member_notification_hr";

$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->jobtable="taolou_job";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';


//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}

//========================

if(@$_POST['method'] == "applyJob"){
	//print_r($_POST);
	if($userId != ""){
		//check collect yet?
		$sql_checkCollect="SELECT ".$obj_tmp1->jobManage.".*
						   FROM ".$obj_tmp1->jobManage."
						   WHERE ".$obj_tmp1->jobManage.".memberId='".$userId."'
						   AND ".$obj_tmp1->jobManage.".jobId='".$_POST['jobID']."'
						   AND ".$obj_tmp1->jobManage.".status='collect'";
		$obj_tmp1->laout_arr['checkCollect']=array();
	    $obj_tmp1->basic_select('laout_arr','checkCollect',$sql_checkCollect);
	        //echo $sql_checkCollect;
	        //print_r($obj_tmp1->laout_arr['checkCollect']);
	    if(!empty($obj_tmp1->laout_arr['checkCollect'])){
	    	$sql_update="UPDATE ".$obj_tmp1->jobManage." SET status='', cvId='".$_POST['CV']['id']."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->jobManage.".memberId='".$userId."' AND ".$obj_tmp1->jobManage.".jobId='".$_POST['jobID']."' AND ".$obj_tmp1->jobManage.".status='collect'";
	    	mysql_query($sql_update);
	    }else{
			$sql_apply="INSERT INTO ".$obj_tmp1->jobManage." VALUES(NULL,'".$userId."','".$_POST['jobID']."','".$_POST['CV']['id']."','n','','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
			mysql_query($sql_apply);
		}

		//notification to hr(只通知刊登職位的人)
			//1. find hr
		$sql_hr="SELECT ".$obj_tmp1->member.".*
				 FROM ".$obj_tmp1->jobtable."
				 LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->jobtable.".postMemberId
				 WHERE ".$obj_tmp1->jobtable.".id='".$_POST['jobID']."'";
		$obj_tmp1->laout_arr['hr']=array();
	    $obj_tmp1->basic_select('laout_arr','hr',$sql_hr);
		        //echo $sql_hr;
		        //print_r($obj_tmp1->laout_arr['hr']);
	    	//2. find job apply id
	    $sql_job="SELECT ".$obj_tmp1->jobManage.".*
				 FROM ".$obj_tmp1->jobManage."
				 WHERE ".$obj_tmp1->jobManage.".jobId='".$_POST['jobID']."'
				 AND ".$obj_tmp1->jobManage.".memberId='".$userId."'";
		$obj_tmp1->laout_arr['job']=array();
	    $obj_tmp1->basic_select('laout_arr','job',$sql_job);
		        //echo $sql_job;
		        //print_r($obj_tmp1->laout_arr['job']);
	    if(!empty($obj_tmp1->laout_arr['hr'])){
	    	$sql_insertNotiS="INSERT INTO ".$obj_tmp1->hrNotification." VALUES(NULL,'".$obj_tmp1->laout_arr['hr'][0]['id']."','jobApply','".$obj_tmp1->laout_arr['job'][0]['id']."','y',CURRENT_TIMESTAMP)";
	    	mysql_query($sql_insertNotiS);
	    	//echo $sql_insertNotiS;
	    }
	    //=============================================
		
		$message=array("first"=>"success");
		echo json_encode($message);
	}else{
		$message=array("first"=>"NotMember");
		echo json_encode($message);
	}
}
else if(@$_POST['method'] == "collectJob"){
	if($userId != ""){
		$sql_collect="INSERT INTO ".$obj_tmp1->jobManage." VALUES(NULL,'".$userId."','".$_POST['jobID']."','','n','collect','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
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
