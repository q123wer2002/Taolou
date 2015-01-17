<?php
include_once '../share.php';
require('../include/sendMail.php');

//page default
$obj_tmp1->sysJobType="taolou_system_jobtype";

$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->memberCV="taolou_member_cv";
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberJob="taolou_member_jobmanage";

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

		if($value['status']==0){$status='';continue;}
		else if($value['status']==1){$status='reject';$detail="您的履歷不被錄取，系統拒絕";}
		else if($value['status']==2){$status='download';$detail="您的履歷被下載了";}
		else if($value['status']==3){$status='wait';$detail="通知您，將要面試，或是已經面試完畢，請等候公司回覆";}
		else if($value['status']==4){
			$status='access';
			$detail="恭喜您！您錄取了";
			//更改職缺狀態
			$sql_updateJobStatus="UPDATE ".$obj_tmp1->job." SET status='F' WHERE ".$obj_tmp1->job.".id='".$_POST['JOB_ID']."'";
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

	}


	$message=array("first"=>"success");
	echo json_encode($message);
	exit;


}

?>