<?php
include_once '../share.php';
require('../include/sendMail.php');

//page default

$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->message="taolou_member_message";

$obj_tmp1->userNotification="taolou_member_notification_user";
$obj_tmp1->hrNotification="taolou_member_notification_hr";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

$userId=$_SESSION['user']['id'];

if(@$_POST['method'] == "message"){

	$sql_deleteSys="DELETE FROM ".$obj_tmp1->message." WHERE ".$obj_tmp1->message.".sendUserId='".$userId."' AND ".$obj_tmp1->message.".receiveUserId='".$_POST['reveicer']."' AND status='n'";
	mysql_query($sql_deleteSys);

	//
	$messageContent=laout_check($_POST['messagecontent']);
	$sql_insertMessage="INSERT INTO ".$obj_tmp1->message." VALUES (NULL,'".$userId."','".$_POST['reveicer']."','".$messageContent."','y',CURRENT_TIMESTAMP)";
	mysql_query($sql_insertMessage);

	//mail alert
		//check receiver mailAlert
	$sql_check="SELECT ".$obj_tmp1->member.".*
				FROM ".$obj_tmp1->member."
				WHERE ".$obj_tmp1->member.".id='".$_POST['reveicer']."'";
	$obj_tmp1->laout_arr['checkUser']=array();
	$obj_tmp1->basic_select('laout_arr','checkUser',$sql_check);
		//echo $sql_check;
		//print_r($obj_tmp1->laout_arr['checkUser']);
	//==========================

	//new notitifications
		//1. find message ID
	$sql_finID="SELECT ".$obj_tmp1->message.".* ,".$obj_tmp1->member.".companyHr as TYPE 
				FROM ".$obj_tmp1->message.", ".$obj_tmp1->member."
				WHERE ".$obj_tmp1->message.".sendUserId='".$userId."'
				AND ".$obj_tmp1->message.".receiveUserId='".$_POST['reveicer']."'
				AND ".$obj_tmp1->message.".message='".$messageContent."'
				AND ".$obj_tmp1->member.".id='".$_POST['reveicer']."'";
	$obj_tmp1->laout_arr['finID']=array();
	$obj_tmp1->basic_select('laout_arr','finID',$sql_finID);
		//echo $sql_finID;
		//print_r($obj_tmp1->laout_arr['finID']);
		//2. input into notification
	if(!empty($obj_tmp1->laout_arr['finID'])){
		if($obj_tmp1->laout_arr['finID'][0]['TYPE']=='n'){
			$sql_notiS="INSERT INTO ".$obj_tmp1->userNotification." VALUES(NULL,'".$_POST['reveicer']."','message','".$obj_tmp1->laout_arr['finID'][0]['id']."','y',CURRENT_TIMESTAMP)";
		}else if($obj_tmp1->laout_arr['finID'][0]['TYPE']=='y'){
			$sql_notiS="INSERT INTO ".$obj_tmp1->hrNotification." VALUES(NULL,'".$_POST['reveicer']."','message','".$obj_tmp1->laout_arr['finID'][0]['id']."','y',CURRENT_TIMESTAMP)";
		}
		mysql_query($sql_notiS);
	}
	// end notitifications===============

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
		<br><span style='background:#eceef1;padding:10px;border-radius:3px;'>".$obj_tmp1->laout_arr['sender'][0]['name']."：".$_POST['messagecontent']."</span><br><br><br><br>
		趕緊回信給他吧！<a href='".$MessageURL."'>頭路網TaoLou,回覆去</a><br>
		----------------<br>
		<span style='font-size:9px;'>頭路網服務團隊發送，如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。</span>";

		if(!$mail->Send()){echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
		}else{}
	}else{}

	$message=array('first'=>"success");
	echo json_encode($message);
	
}
else{echo "no Message";}
?>