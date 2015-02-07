<?php
include_once '../share.php';
require('../include/sendMail.php');
header("Content-Type:text/html; charset=utf-8");

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->account='taolou_account';
$obj_tmp1->wantjob='taolou_member_wantjob';
$obj_tmp1->specialSkill="taolou_member_specialskill";
$obj_tmp1->education="taolou_member_education";
$obj_tmp1->experience="taolou_member_experience";

$obj_tmp1->facebook="taolou_member_facebook";
$obj_tmp1->IN="taolou_member_linkedin";

$obj_tmp1->userNotification="taolou_member_notification_user";
$obj_tmp1->hrNotification="taolou_member_notification_hr";

$obj_tmp1->sysSkill="taolou_system_specialskill";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

if(!empty(@$_SESSION['user']['id'])){
	@$userId=$_SESSION['user']['id'];
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
				//ID
			$_SESSION['user']['id']=$userId;
				//PHOTO
			if($obj_tmp1->laout_arr['loadUser'][0]['photo']==""){$_SESSION['user']['userPicture']="images/layout/user-default.jpg";}
			else{
				$_SESSION['user']['userPicture']=$obj_tmp1->laout_arr['loadUser'][0]['photo'];
			}
				//USERTYPE
			if($obj_tmp1->laout_arr['loadUser'][0]['companyHr'] == 'y'){
				$_SESSION['user']['userType']="2";
				$_SESSION['user']['company']=$obj_tmp1->laout_arr['loadUser'][0]['companyId'];
				$_SESSION['user']['companyValid']=$obj_tmp1->laout_arr['loadUser'][0]['companyValid'];
				//check notification
				$sql_notification="SELECT COUNT(".$obj_tmp1->hrNotification.".id) as NotiS
								   FROM ".$obj_tmp1->hrNotification."
								   WHERE ".$obj_tmp1->hrNotification.".status='y'
								   AND ".$obj_tmp1->hrNotification.".memberId='".$userId."'";
				$obj_tmp1->laout_arr['notification']=array();
				$obj_tmp1->basic_select('laout_arr','notification',$sql_notification);
				//======================

			}else if($obj_tmp1->laout_arr['loadUser'][0]['companyHr'] == 'n'){
				$_SESSION['user']['userType']="1";
				//check notification
				$sql_notification="SELECT COUNT(".$obj_tmp1->userNotification.".id) as NotiS 
								   FROM ".$obj_tmp1->userNotification."
								   WHERE ".$obj_tmp1->userNotification.".status='y'
								   AND ".$obj_tmp1->userNotification.".memberId='".$userId."'";
				$obj_tmp1->laout_arr['notification']=array();
				$obj_tmp1->basic_select('laout_arr','notification',$sql_notification);
				//======================
			}
				//mail valid
			$_SESSION['user']['mailValid']=$obj_tmp1->laout_arr['checkUser'][0]['mailValid'];
				//notifiacitons
			$_SESSION['user']['notification']=$obj_tmp1->laout_arr['notification'][0]['NotiS'];

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
		$sql_member="INSERT INTO ".$obj_tmp1->member." VALUES (NULL,'".$_POST['memberType']."','0','','','".$account."','','','','','','','','','','y','y',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
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
		$sql_account="INSERT INTO ".$obj_tmp1->account." VALUES (NULL,'".$memberID."','".$account."','".$password."','',CURRENT_TIMESTAMP)";
		mysql_query($sql_account);
		//========================

		if($_POST['memberType'] == 'n'){
			//存入job_wish內
			$sql_wantjob="INSERT INTO ".$obj_tmp1->wantjob." VALUES (NULL,'".$memberID."','','','','','','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
			mysql_query($sql_wantjob);
			//========================

			//存入specialskill
			$sql_specialSkill="INSERT INTO ".$obj_tmp1->specialSkill." VALUES (NULL,'".$memberID."','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
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
		<span style='font-size:9px;'>頭路網服務團隊發送，如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。</span>";

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
else if(@$_POST['method']== "checkFBuser"){

	//print_r($_POST);
	
	//facebook user
	$sql_checkFB="SELECT ".$obj_tmp1->facebook.".*
				  FROM ".$obj_tmp1->facebook."
				  WHERE ".$obj_tmp1->facebook.".facebook_id='".$_POST['FB_id']."'";
	$obj_tmp1->laout_arr['checkFB']=array();
	$obj_tmp1->basic_select('laout_arr','checkFB',$sql_checkFB);
	//=======================

	if(!empty($obj_tmp1->laout_arr['checkFB'])){

		//facebook user
		$sql_checkUser="SELECT ".$obj_tmp1->member.".*
					  FROM ".$obj_tmp1->member."
					  WHERE ".$obj_tmp1->member.".facebook='".$obj_tmp1->laout_arr['checkFB'][0]['id']."'";
		$obj_tmp1->laout_arr['checkUser']=array();
		$obj_tmp1->basic_select('laout_arr','checkUser',$sql_checkUser);

		//將使用者資訊存入SESSION
		$userId=$obj_tmp1->laout_arr['checkUser'][0]['id'];
		$_SESSION['user']=array();
			//ID
		$_SESSION['user']['id']=$userId;
			//PHOTO
		$_SESSION['user']['userPicture']=$obj_tmp1->laout_arr['checkUser'][0]['photo'];
			//USERTYPE
		if($obj_tmp1->laout_arr['checkUser'][0]['companyHr'] == 'y'){
			$_SESSION['user']['userType']="2";
			$_SESSION['user']['company']=$obj_tmp1->laout_arr['checkUser'][0]['companyId'];
			$_SESSION['user']['companyValid']=$obj_tmp1->laout_arr['checkUser'][0]['companyValid'];
			//check notification
			$sql_notification="SELECT COUNT(".$obj_tmp1->hrNotification.".id) as NotiS
							   FROM ".$obj_tmp1->hrNotification."
							   WHERE ".$obj_tmp1->hrNotification.".status='y'
							   AND ".$obj_tmp1->hrNotification.".memberId='".$userId."'";
			$obj_tmp1->laout_arr['notification']=array();
			$obj_tmp1->basic_select('laout_arr','notification',$sql_notification);
			//======================
		}else if($obj_tmp1->laout_arr['checkUser'][0]['companyHr'] == 'n'){
			$_SESSION['user']['userType']="1";
			//check notification
			$sql_notification="SELECT COUNT(".$obj_tmp1->userNotification.".id) as NotiS
							   FROM ".$obj_tmp1->userNotification."
							   WHERE ".$obj_tmp1->userNotification.".status='y'
							   AND ".$obj_tmp1->userNotification.".memberId='".$userId."'";
			$obj_tmp1->laout_arr['notification']=array();
			$obj_tmp1->basic_select('laout_arr','notification',$sql_notification);
			//======================
		}
			//mail valid
		$_SESSION['user']['mailValid']='y';
			//notifiacitons
		$_SESSION['user']['notification']=$obj_tmp1->laout_arr['notification'][0]['NotiS'];

		$message=array("mes"=>"OK");

	}else{
		$sql_insertFB="INSERT INTO ".$obj_tmp1->facebook." VALUES(NULL,'".$_POST['FB_id']."','".$_POST['userName']."','".$_POST['email']."','".$_POST['photo']."',CURRENT_TIMESTAMP)";
		mysql_query($sql_insertFB);

		//load facebook's member id
		$sql_loaduserFB="SELECT ".$obj_tmp1->facebook.".*
					   FROM ".$obj_tmp1->facebook."
					   WHERE ".$obj_tmp1->facebook.".facebook_id='".$_POST['FB_id']."'";
		$obj_tmp1->laout_arr['loaduserFB']=array();
		$obj_tmp1->basic_select('laout_arr','loaduserFB',$sql_loaduserFB);

		$sql_addUser="INSERT INTO ".$obj_tmp1->member." VALUES(NULL,'n','','','".$_POST['userName']."','".$_POST['email']."','','".$obj_tmp1->laout_arr['loaduserFB'][0]['id']."','','".$_POST['photo']."','','','','','','y','y',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		mysql_query($sql_addUser);

		//print_r($sql_addUser);

		//load user's member id
		$sql_loaduser="SELECT ".$obj_tmp1->member.".*
					   FROM ".$obj_tmp1->member."
					   WHERE ".$obj_tmp1->member.".facebook='".$obj_tmp1->laout_arr['loaduserFB'][0]['id']."'";
		$obj_tmp1->laout_arr['loaduser']=array();
		$obj_tmp1->basic_select('laout_arr','loaduser',$sql_loaduser);
		//=======================

		$sql_insertAccount="INSERT INTO ".$obj_tmp1->account." VALUES(NULL,'".$obj_tmp1->laout_arr['loaduser'][0]['id']."','".$obj_tmp1->laout_arr['loaduser'][0]['email']."','','y',CURRENT_TIMESTAMP)";
		mysql_query($sql_insertAccount);

		//將使用者資訊存入SESSION
			$userId=$obj_tmp1->laout_arr['loaduser'][0]['id'];
			$_SESSION['user']=array();
				//ID
			$_SESSION['user']['id']=$userId;
				//PHOTO
			$_SESSION['user']['userPicture']=$obj_tmp1->laout_arr['loaduser'][0]['photo'];
				//USERTYPE
			$_SESSION['user']['userType']="1";
				//mail valid
			$_SESSION['user']['mailValid']='y';

		//建立使用者資料庫

		$memberID=$_SESSION['user']['id'];
		$account=$obj_tmp1->laout_arr['loaduser'][0]['email'];

		//存入job_wish內
		$sql_wantjob="INSERT INTO ".$obj_tmp1->wantjob." VALUES (NULL,'".$memberID."','','','','','','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		mysql_query($sql_wantjob);
		//========================

		//存入specialskill
		$sql_specialSkill="INSERT INTO ".$obj_tmp1->specialSkill." VALUES (NULL,'".$memberID."','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
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

		$message=array("mes"=>"OK");
	}

	echo json_encode($message);
	exit;

}
else if(@$_POST['method'] == "checkINuser"){
	//print_r($_POST);

	//check IN user
	$sql_checkIN="SELECT ".$obj_tmp1->IN.".*
				  FROM ".$obj_tmp1->IN."
				  WHERE ".$obj_tmp1->IN.".LinkedIn_id='".$_POST['IN_id']."'";
	$obj_tmp1->laout_arr['checkIN']=array();
	$obj_tmp1->basic_select('laout_arr','checkIN',$sql_checkIN);
	//=======================

	//print_r($obj_tmp1->laout_arr['checkIN']);

	if(!empty($obj_tmp1->laout_arr['checkIN'])){

		//facebook user
		$sql_checkUser="SELECT ".$obj_tmp1->member.".*
					  FROM ".$obj_tmp1->member."
					  WHERE ".$obj_tmp1->member.".LinkedIn='".$obj_tmp1->laout_arr['checkIN'][0]['id']."'";
		$obj_tmp1->laout_arr['checkUser']=array();
		$obj_tmp1->basic_select('laout_arr','checkUser',$sql_checkUser);

		//將使用者資訊存入SESSION
		$userId=$obj_tmp1->laout_arr['checkUser'][0]['id'];
		$_SESSION['user']=array();
			//ID
		$_SESSION['user']['id']=$userId;
			//PHOTO
		$_SESSION['user']['userPicture']=$obj_tmp1->laout_arr['checkUser'][0]['photo'];
			//USERTYPE
		if($obj_tmp1->laout_arr['checkUser'][0]['companyHr'] == 'y'){
			$_SESSION['user']['userType']="2";
			$_SESSION['user']['company']=$obj_tmp1->laout_arr['checkUser'][0]['companyId'];
			$_SESSION['user']['companyValid']=$obj_tmp1->laout_arr['checkUser'][0]['companyValid'];
			//check notification
			$sql_notification="SELECT COUNT(".$obj_tmp1->hrNotification.".id) as NotiS
							   FROM ".$obj_tmp1->hrNotification."
							   WHERE ".$obj_tmp1->hrNotification.".status='y'
							   AND ".$obj_tmp1->hrNotification.".memberId='".$userId."'";
			$obj_tmp1->laout_arr['notification']=array();
			$obj_tmp1->basic_select('laout_arr','notification',$sql_notification);
				//======================
		}else if($obj_tmp1->laout_arr['checkUser'][0]['companyHr'] == 'n'){
			$_SESSION['user']['userType']="1";
			//check notification
			$sql_notification="SELECT COUNT(".$obj_tmp1->userNotification.".id) as NotiS
							   FROM ".$obj_tmp1->userNotification."
							   WHERE ".$obj_tmp1->userNotification.".status='y'
							   AND ".$obj_tmp1->userNotification.".memberId='".$userId."'";
			$obj_tmp1->laout_arr['notification']=array();
			$obj_tmp1->basic_select('laout_arr','notification',$sql_notification);
			//======================
		}
			//mail valid
		$_SESSION['user']['mailValid']='y';
			//notifiacitons
		$_SESSION['user']['notification']=$obj_tmp1->laout_arr['notification'][0]['NotiS'];

		$message=array("mes"=>"OK");

	}else{
		$sql_insertIN="INSERT INTO ".$obj_tmp1->IN." VALUES(NULL,'".$_POST['IN_id']."','".$_POST['IN_headline']."','".$_POST['IN_name']."','".$_POST['IN_email']."','".$_POST['IN_photo']."',CURRENT_TIMESTAMP)";
		mysql_query($sql_insertIN);

		//load IN's member id
		$sql_loaduserIN="SELECT ".$obj_tmp1->IN.".*
					   FROM ".$obj_tmp1->IN."
					   WHERE ".$obj_tmp1->IN.".LinkedIn_id='".$_POST['IN_id']."'";
		$obj_tmp1->laout_arr['loaduserIN']=array();
		$obj_tmp1->basic_select('laout_arr','loaduserIN',$sql_loaduserIN);

		$sql_addUser="INSERT INTO ".$obj_tmp1->member." VALUES(NULL,'n','','','".$_POST['IN_name']."','".$_POST['IN_email']."','','','".$obj_tmp1->laout_arr['loaduserIN'][0]['id']."','".$_POST['IN_photo']."','','','','','','y','y',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		mysql_query($sql_addUser);

		//print_r($sql_addUser);

		//load user's member id
		$sql_loaduser="SELECT ".$obj_tmp1->member.".*
					   FROM ".$obj_tmp1->member."
					   WHERE ".$obj_tmp1->member.".LinkedIn='".$obj_tmp1->laout_arr['loaduserIN'][0]['id']."'";
		$obj_tmp1->laout_arr['loaduser']=array();
		$obj_tmp1->basic_select('laout_arr','loaduser',$sql_loaduser);
		//=======================

		$sql_insertAccount="INSERT INTO ".$obj_tmp1->account." VALUES(NULL,'".$obj_tmp1->laout_arr['loaduser'][0]['id']."','".$obj_tmp1->laout_arr['loaduser'][0]['email']."','','y',CURRENT_TIMESTAMP)";
		mysql_query($sql_insertAccount);

		//將使用者資訊存入SESSION
			$userId=$obj_tmp1->laout_arr['loaduser'][0]['id'];
			$_SESSION['user']=array();
				//ID
			$_SESSION['user']['id']=$userId;
				//PHOTO
			$_SESSION['user']['userPicture']=$obj_tmp1->laout_arr['loaduser'][0]['photo'];
				//USERTYPE
			$_SESSION['user']['userType']="1";
				//mail valid
			$_SESSION['user']['mailValid']='y';

		//建立使用者資料庫

		$memberID=$_SESSION['user']['id'];
		$account=$obj_tmp1->laout_arr['loaduser'][0]['email'];

		//IN's educations
		foreach ($_POST['IN_educations']['values'] as $key => $value) {
			$degree=laout_check($value['degree']);
			$sql_insertINsEdu="INSERT INTO ".$obj_tmp1->education." VALUES(NULL,'".$memberID."','".$degree."','".$value['startDate']['year']."','".$value['endDate']['year']."','".$value['schoolName']."','".$value['fieldOfStudy']."',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
			mysql_query($sql_insertINsEdu);
			//echo $sql_insertINsEdu;
		}
		//IN's positions
		foreach ($_POST['IN_postions']['values'] as $key => $value) {
			$sql_insertINsExp="INSERT INTO ".$obj_tmp1->experience." VALUES(NULL,'".$memberID."','NAME','','','".$value['company']['name']."','".$value['title']."','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
			mysql_query($sql_insertINsExp);
		}
		//IN's skills
			//insert skills into system
		$userSkills="";
		foreach ($_POST['skills']['values'] as $key => $value) {
			//check exist or not
			$sql_checkSkill="SELECT ".$obj_tmp1->sysSkill.".*
							 FROM ".$obj_tmp1->sysSkill."
							 WHERE ".$obj_tmp1->sysSkill.".skill='".$value['skill']['name']."'";
			$obj_tmp1->laout_arr['checkSkill']=array();
			$obj_tmp1->basic_select('laout_arr','checkSkill',$sql_checkSkill);
			//=======================

			if(!empty($obj_tmp1->laout_arr['checkSkill'])){
				//yes, it exists
				$userSkills=$userSkills.$obj_tmp1->laout_arr['checkSkill'][0]['id']."|";
			}else{
				//no, we need push it into system
				$sql_insertINsSkill="INSERT INTO ".$obj_tmp1->sysSkill." VALUES(NULL,'0','".$value['skill']['name']."','y',CURRENT_TIMESTAMP)";
				mysql_query($sql_insertINsSkill);

				//push OK, let's get skill's id
				$sql_checkSkill="SELECT ".$obj_tmp1->sysSkill.".*
							 FROM ".$obj_tmp1->sysSkill."
							 WHERE ".$obj_tmp1->sysSkill.".skill='".$value['skill']['name']."'";
				$obj_tmp1->laout_arr['checkSkill']=array();
				$obj_tmp1->basic_select('laout_arr','checkSkill',$sql_checkSkill);
				//=======================
				$userSkills=$userSkills.$obj_tmp1->laout_arr['checkSkill'][0]['id']."|";
			}
		}$userSkills=substr($userSkills,0,-1);
		//print_r($userSkills);
			//check over, let's insert into user's skills
		$sql_insertINsSkillToUser="INSERT INTO ".$obj_tmp1->specialSkill." VALUES(NULL,'".$memberID."','".$userSkills."',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		mysql_query($sql_insertINsSkillToUser);
		//echo $sql_insertINsSkillToUser;


		//存入job_wish內
		$sql_wantjob="INSERT INTO ".$obj_tmp1->wantjob." VALUES (NULL,'".$memberID."','','','','','','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		mysql_query($sql_wantjob);
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

		$message=array("mes"=>"OK");
	}

	echo json_encode($message);
	exit;
}
else{

	/*$message=array('first'=>"404 Not found this page");
	echo json_encode($message);
	exit;*/
}

?>