<?php
include_once '../share.php';
require('../include/sendMail.php');

//page default
$obj_tmp1->sysJobType="taolou_system_jobtype";

$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->memberCV="taolou_member_cv";
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberJob="taolou_member_jobmanage";
$obj_tmp1->message="taolou_member_message";

$obj_tmp1->job="taolou_job";




//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_SESSION['user']['company']){$companyID=$_SESSION['user']['company'];}else{$companyID="";exit;}

//========================
if(@$_POST['method']=='saveSeeker'){

	//job info
    $sql_jobInfo="SELECT ".$obj_tmp1->job.".* , ".$obj_tmp1->companyTable.".companyName as Company
					 FROM ".$obj_tmp1->job."
					 LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->job.".companyId 
					 WHERE ".$obj_tmp1->job.".id='".$_POST['JOB_ID']."'";
	$obj_tmp1->laout_arr['jobInfo']=array();
    $obj_tmp1->basic_select('laout_arr','jobInfo',$sql_jobInfo);
    //echo $sql_jobInfo;
    //print_r($obj_tmp1->laout_arr['jobInfo']);
    //===============================

	foreach($_POST['seekers'] as $key => $value){
		if($value['change']){
			if($value['status']==0){$status='';continue;}
			else if($value['status']==1){$status='reject';$detail="您的履歷不被錄取，系統拒絕";}
			else if($value['status']==2){$status='download';$detail="您的履歷被下載了";}
			else if($value['status']==3){$status='wait';$detail="通知您，將要面試，或是已經面試完畢，請等候公司回覆";}
			else if($value['status']==4){
				$status='access';
				$detail="恭喜您！您錄取了";
				//更改職缺狀態
				$sql_updateJobStatus="UPDATE ".$obj_tmp1->job." SET status='F', hirePeople='".$value['id']."' WHERE ".$obj_tmp1->job.".id='".$_POST['JOB_ID']."'";
				mysql_query($sql_updateJobStatus);
			}

			//seeker info
			$sql_seekerInfo="SELECT ".$obj_tmp1->member.".*
							 FROM ".$obj_tmp1->member."
							 WHERE ".$obj_tmp1->member.".id='".$value['id']."'";
			$obj_tmp1->laout_arr['seekerInfo']=array();
	        $obj_tmp1->basic_select('laout_arr','seekerInfo',$sql_seekerInfo);
	        //echo $sql_seekerInfo;
	        //print_r($obj_tmp1->laout_arr['seekerInfo']);
	        //===============================

			//send mail to seekers
				//認證密碼
				$validCode=md5(uniqid(rand()));
				$homeURL=WEB_PATH."index.php";

			$email=$obj_tmp1->laout_arr['seekerInfo'][0]['email'];
			// 收件者信箱
			$name=$obj_tmp1->laout_arr['seekerInfo'][0]['name'];
			$account=$name;
			// 收件者的名稱or暱稱
			$mail->AddAddress($email,$name);
			$mail->Subject = "=?UTF-8?B?".base64_encode("[頭路網 TaoLou]求職狀態更新嚕！來自".$obj_tmp1->laout_arr['jobInfo'][0]['Company']."的更新")."?=";//信件標題，解決亂碼問題
			// 信件標題
			$mail->Body = "Hi ".$account.",<br><br>
			歡迎您使用<a href='".$homeURL."'>頭路網TaoLou</a>求職！<br><br>
			您的求職狀態更新了喔！<br>
			".$obj_tmp1->laout_arr['jobInfo'][0]['Company']."刊登的職位_".$obj_tmp1->laout_arr['jobInfo'][0]['jobName']."<br>
			<span style='color:red;'>".$detail."</span><br>
			趕緊上<a href='".$homeURL."'>頭路網TaoLou</a>確認狀態。
			<br><br><br>
			-----------<br>
			<span style='font-size:9px;'>頭路網服務團隊發送，如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。</span>";

			if(!$mail->Send()){echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
			}else{
				$sql_updateJobManage="UPDATE ".$obj_tmp1->memberJob." SET status='".$status."', comment='".$value['comment']."' WHERE ".$obj_tmp1->memberJob.".jobId='".$_POST['JOB_ID']."' AND ".$obj_tmp1->memberJob.".memberId='".$value['id']."'";
				//echo $sql_updateJobManage;
				mysql_query($sql_updateJobManage);
			}
		}else{}

	}


	$message=array("first"=>"success");
	echo json_encode($message);
	exit;


}
else if(@$_POST['method']=='messageToSeeker'){

	$sql_insertMessage="INSERT INTO ".$obj_tmp1->message." VALUES (NULL,'".$userId."','".$_POST['receiveId']."','".$_POST['message']."','y',CURRENT_TIMESTAMP)";
	mysql_query($sql_insertMessage);

	//mail alert
		//check receiver mailAlert
	$sql_check="SELECT ".$obj_tmp1->member.".*
				FROM ".$obj_tmp1->member."
				WHERE ".$obj_tmp1->member.".id='".$_POST['receiveId']."'";
	$obj_tmp1->laout_arr['checkUser']=array();
	$obj_tmp1->basic_select('laout_arr','checkUser',$sql_check);
		//echo $sql_check;
		//print_r($obj_tmp1->laout_arr['checkUser']);
	//==========================

	if(!empty($obj_tmp1->laout_arr['checkUser']) && $obj_tmp1->laout_arr['checkUser'][0]['messageEmail']=='y'){
		//寄信等待認證
			//確認傳送者
		$sql_sender="SELECT ".$obj_tmp1->member.".*, ".$obj_tmp1->companyTable.".companyName 
					 FROM ".$obj_tmp1->member."
					 LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->member.".companyId 
					 WHERE ".$obj_tmp1->member.".id='".$userId."'";
		$obj_tmp1->laout_arr['sender']=array();
		$obj_tmp1->basic_select('laout_arr','sender',$sql_sender);
			//echo $sql_sender;
			//print_r($obj_tmp1->laout_arr['sender']);
		//==========================

			if($obj_tmp1->laout_arr['sender'][0]['companyName']==NULL){$type="求職者";}
			else{$type=$obj_tmp1->laout_arr['sender'][0]['companyName']."的";}
			$logoImg=WEB_PATH."images/taolou_logo.jpg";
			$MessageURL=WEB_PATH."userMessage.php";

		$email=$obj_tmp1->laout_arr['checkUser'][0]['email'];
		// 收件者信箱
		$name=$obj_tmp1->laout_arr['checkUser'][0]['name'];
		// 收件者的名稱or暱稱
		$mail->AddAddress($email,$name);
		$mail->Subject = "=?UTF-8?B?".base64_encode("[頭路網 TaoLou]".$type.$obj_tmp1->laout_arr['sender'][0]['name']."私信你喔")."?=";//信件標題，解決亂碼問題
		// 信件標題
		$mail->Body = "<div style='width:580px;padding:5px 5px 5px 20px;border-top:2px solid #46A3FF;border-bottom:2px solid #46A3FF;'><img src='".$logoImg."' height='20px'></div>
		<br><span style='background:#eceef1;padding:10px;border-radius:3px;'>".$obj_tmp1->laout_arr['sender'][0]['name']."：".$_POST['message']."</span><br><br><br><br>
		趕緊回信給他吧！<a href='".$MessageURL."'>頭路網TaoLou,回覆去</a><br>
		----------------<br>
		<span style='font-size:9px;'>頭路網服務團隊發送，如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。</span>";

		if(!$mail->Send()){echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
		}else{}
	}else{}

	$message=array("first"=>"success");
	echo json_encode($message);
	exit;
}else if(@$_POST['method'] == "comment"){
	$comment=laout_check($_POST['seeker']['comment']);
	//print_r($_POST);
	$sql_updaetComment="UPDATE ".$obj_tmp1->memberJob." SET comment='".$comment."' WHERE ".$obj_tmp1->memberJob.".jobId='".$_POST['JOB_ID']."' AND ".$obj_tmp1->memberJob.".memberId='".$_POST['seeker']['id']."'";
	mysql_query($sql_updaetComment);

	echo "SUCCESS";
	exit;
}
else{}
?>