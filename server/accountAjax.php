<?php
include_once '../share.php';
require('../include/sendMail.php');
header("Content-Type:text/html; charset=utf-8");

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->account='taolou_account';
$obj_tmp1->wantjob='taolou_member_wantjob';
$obj_tmp1->specialSkill="taolou_member_specialskill";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

if(!empty($_SESSION['user']['id'])){
	$userId=$_SESSION['user']['id'];
}

if(@$_POST['method']=='login')
{
	$account=laout_check($_POST['email']);
	$password=md5(laout_check($_POST['password']));

	//確認是否有此使用者
	$sql_checkUser="SELECT ".$obj_tmp1->account.".*
					FROM ".$obj_tmp1->account."
					WHERE ".$obj_tmp1->account.".email='".$account."'
					LIMIT 0,1";
	$obj_tmp1->laout_arr['checkUser']=array();
	$obj_tmp1->basic_select('laout_arr','checkUser',$sql_checkUser);
	//======================

	@$id=$obj_tmp1->laout_arr['checkUser'][0]['id'];

	if(@$id != NULL){
		if(@$obj_tmp1->laout_arr['checkUser'][0]['password'] == $password){
			//讀取使用者資訊
			$sql_loadUser="SELECT ".$obj_tmp1->member.".*
						   FROM ".$obj_tmp1->member."
						   WHERE ".$obj_tmp1->member.".id='".$obj_tmp1->laout_arr['checkUser'][0]['memberId']."'";
			$obj_tmp1->laout_arr['loadUser']=array();
			$obj_tmp1->basic_select('laout_arr','loadUser',$sql_loadUser);
			//=======================

			//將使用者資訊存入SESSION
			$userId=$obj_tmp1->laout_arr['loadUser'][0]['id'];
			$_SESSION['user']=array();
			$_SESSION['user']['id']=$userId;
			$_SESSION['user']['userPicture']=$obj_tmp1->laout_arr['loadUser'][0]['photo'];
			if($obj_tmp1->laout_arr['loadUser'][0]['companyHr'] == 'y'){$_SESSION['user']['userType']="2";$_SESSION['user']['company']=$obj_tmp1->laout_arr['loadUser'][0]['companyId'];}
			else if($obj_tmp1->laout_arr['loadUser'][0]['companyHr'] == 'n'){$_SESSION['user']['userType']="1";}
			
			$message=array('first'=>"success",'url'=>"index.php","actions"=>'login');
			//=======================
		}else{$message=array('first'=>"帳號密碼不正確",'url'=>"X","actions"=>'login');}
	}else{$message=array('first'=>"請先註冊後登入",'url'=>"X","actions"=>'login');}
	//=========================
	echo json_encode($message);
	
	exit;
}

else if(@$_POST['method']=='signup')
{
	$account=laout_check($_POST['email']);
	$password=md5(laout_check($_POST['password']));

	//確認是否有此使用者
	$sql_checkUser="SELECT ".$obj_tmp1->account.".*
					FROM ".$obj_tmp1->account."
					WHERE ".$obj_tmp1->account.".email='".$account."'";
	$obj_tmp1->laout_arr['checkUser']=array();
	$obj_tmp1->basic_select('laout_arr','checkUser',$sql_checkUser);
	//======================


	@$id=$obj_tmp1->laout_arr['checkUser'][0]['id'];

	if($id != NULL){@$message=array('first'=>"此帳號已經註冊過",'url'=>"X","actions"=>'signup');}
	else{
		//存入member內
		$sql_member="INSERT INTO ".$obj_tmp1->member."
					 VALUES (NULL,'".$_POST['memberType']."','0','','','".$account."','','','','','','','','','','y','y',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		mysql_query($sql_member);
		//========================

		//確認此使用者
		$sql_checkUser="SELECT ".$obj_tmp1->member.".*
						FROM ".$obj_tmp1->member."
						WHERE ".$obj_tmp1->member.".email='".$account."'";
		$obj_tmp1->laout_arr['checkUser']=array();
		$obj_tmp1->basic_select('laout_arr','checkUser',$sql_checkUser);
		$memberID=$obj_tmp1->laout_arr['checkUser'][0]['id'];
		//======================
		
		//存入account內
		$sql_account="INSERT INTO ".$obj_tmp1->account."
					  VALUES (NULL,'".$memberID."','".$account."','".$password."','',CURRENT_TIMESTAMP)";
		mysql_query($sql_account);
		//========================

		if($_POST['memberType'] == 'n'){
			//存入job_wish內
			$sql_wantjob="INSERT INTO ".$obj_tmp1->wantjob."
						  VALUES (NULL,'".$memberID."','','','','','','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
			mysql_query($sql_wantjob);
			//========================

			//存入specialskill
			$sql_specialSkill="INSERT INTO ".$obj_tmp1->specialSkill."
						  VALUES (NULL,'".$memberID."','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
			mysql_query($sql_specialSkill);
			//========================

			//創建資料夾
			$userFolder="../userObject/".$account;
			if(!file_exists($userFolder))
			{
				//新增資料夾
             	@mkdir($userFolder);
             	//存圖片
             	$userFolderPhoto=$userFolder."/profilePhoto";
             	@mkdir($userFolderPhoto);
             	//存履歷
             	$userFolderCV=$userFolder."/CV";
             	@mkdir($userFolderCV);
              	//end  新增資料夾
			}
			//========================
		}else if($_POST['memberType'] == 'y'){
			//創建資料夾
			$userFolder="../userObject/".$account;
			if(!file_exists($userFolder))
			{
				//新增資料夾
             	@mkdir($userFolder);
             	//存圖片
             	$userFolderPhoto=$userFolder."/profilePhoto";
             	@mkdir($userFolderPhoto);
              	//end  新增資料夾
			}
			//========================
		}

		//寄信等待認證
			//認證密碼
			$validCode=md5(uniqid(rand()));
			$homeURL=WEB_PATH."index.php";
			$validURL=WEB_PATH."mailValid.php?action=openAccount&code=".$validCode;
		$email=$account;
		// 收件者信箱
		$name=$account;
		// 收件者的名稱or暱稱
		$mail->AddAddress($email,$name);
		$mail->Subject = "=?UTF-8?B?".base64_encode("[頭路網 TaoLou]註冊信箱認證")."?=";//信件標題，解決亂碼問題
		// 信件標題
		$mail->Body = "Hi ".$account.",<br><br>
		歡迎您使用<a href='".$homeURL."'>頭路網TaoLou</a>求職！<br><br>
		請您點擊以下網址來驗證<a href='mailto:".$account."'>".$account."</a>信箱<br><br>
		<a href='".$validURL."'>".$validURL."</a><br><br>
		一但認證完信箱後，即可立即使用<a href='".$homeURL."'>頭路網 TaoLou</a>的豐富功能求職。<br><br><br>
		-------<br>
		如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。";

		if(!$mail->Send()){echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
		}else{
			$sql_insertValid="UPDATE ".$obj_tmp1->account." SET mailValid='".$validCode."' WHERE ".$obj_tmp1->account.".memberId='".$memberID."'";
			mysql_query($sql_insertValid);
		}


		
		//跳回登入頁面
		$message=array('first'=>"成功",'url'=>'account.php?action=login',"actions"=>'signup');
	}

	echo json_encode($message);
	exit;
}
else if(@$_POST['method'] == 'logout'){
	
	unset($_SESSION['user']);
	$message=array('first'=>"success",'url'=>"index.php","actions"=>'logout');

	echo json_encode($message);
	exit;
}//設定開始
else if(@$_POST['method'] == "changePassword"){
	
	$ex_pass=md5(laout_check($_POST['ex_pass']));
	$new_pass=md5(laout_check($_POST['new_pass']));

	$sql_checkPass="SELECT ".$obj_tmp1->account.".*
					FROM ".$obj_tmp1->account."
					WHERE ".$obj_tmp1->account.".password ='".$ex_pass."'";
	$obj_tmp1->laout_arr['checkPass']=array();
	$obj_tmp1->basic_select('laout_arr','checkPass',$sql_checkPass);
	//=======================

	if(empty($obj_tmp1->laout_arr['checkPass'])){
		$message=array("mes"=>"error",'first'=>"舊密碼輸入錯誤");
		echo json_encode($message);
		exit;
	}
	else{
		$sql_updatePass="UPDATE ".$obj_tmp1->account." SET password='".$new_pass."' WHERE memberId='".$userId."'";
		mysql_query($sql_updatePass);

		$message=array("mes"=>"OK");
		echo json_encode($message);
		exit;
	}
}
else if(@$_POST['method'] == "changeAlert"){
	if($_POST['messageAlert']){$messageEmail='y';}else{$messageEmail='n';}
	if($_POST['resumeAlert']){$CVupdateEmail='y';}else{$CVupdateEmail='n';}
	$sql_updateAlert="UPDATE ".$obj_tmp1->member." SET messageEmail='".$messageEmail."', CVupdateEmail='".$CVupdateEmail."' WHERE ".$obj_tmp1->member.".id='".$userId."'";
	mysql_query($sql_updateAlert);

	$message=array("mes"=>"OK");
	echo json_encode($message);
	exit;
}
else{

	/*$message=array('first'=>"404 Not found this page");
	echo json_encode($message);
	exit;*/
}

?>