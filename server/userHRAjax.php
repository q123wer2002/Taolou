<?php
include_once '../share.php';
require('../include/sendMail.php');
//page default

$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->companySkill="taolou_company_skill";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->facebook="taolou_member_facebook";
$obj_tmp1->IN="taolou_member_linkedin";


$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
//===================

if(@$_POST['method'] == "updatePhoto"){
	if(!empty($_FILES)){
		
		$sql_user="SELECT ".$obj_tmp1->member.".*
					 FROM ".$obj_tmp1->member."
					 WHERE ".$obj_tmp1->member.".id='".$userId."'";
		$obj_tmp1->laout_arr['user']=array();
		$obj_tmp1->basic_select('laout_arr','user',$sql_user);
			//echo $sql_user;
			//print_r($obj_tmp1->laout_arr['user']);
		//==========================

		//upload
		$file_path=APP_PATH."/userObject/".$obj_tmp1->laout_arr['user'][0]['email']."/profilePhoto/";
  		$type=split("/",$_FILES['file']['type']);
  		$file_name=$file_path."userPhoto.".$type[1];
	  	move_uploaded_file($_FILES["file"]["tmp_name"],$file_name);

	  	$file_path="userObject/".$obj_tmp1->laout_arr['user'][0]['email']."/profilePhoto/userPhoto.".$type[1];
		//end Upload

		//update user profile_photo
		$sql_updatePhoto="UPDATE ".$obj_tmp1->member." SET photo='".$file_path."' WHERE ".$obj_tmp1->member.".id='".$userId."'";
		mysql_query($sql_updatePhoto);
		//end update

		$_SESSION['user']['userPicture']=$file_path;

		$message=array('first'=>"success");
		echo json_encode($message);

	}else{
		$message=array('first'=>"no file");
		echo json_encode($message);
	}
	
}
else if(@$_POST['method'] == "saveUserHR"){

	//先確認公司是否存在
	$sql_checkCom="SELECT ".$obj_tmp1->companyTable.".*
				   FROM ".$obj_tmp1->companyTable."
				   WHERE ".$obj_tmp1->companyTable.".companyName='".$_POST['companyName']."'";
	$obj_tmp1->laout_arr['checkCom']=array();
	$obj_tmp1->basic_select('laout_arr','checkCom',$sql_checkCom);
		//echo $sql_checkCom;
		//print_r($obj_tmp1->laout_arr['checkCom']);

	//確認使用者
	$sql_user="SELECT ".$obj_tmp1->member.".*
			   FROM ".$obj_tmp1->member."
			   WHERE ".$obj_tmp1->member.".id='".$userId."'";
	$obj_tmp1->laout_arr['user']=array();
	$obj_tmp1->basic_select('laout_arr','user',$sql_user);
		//echo $sql_user;
		//print_r($obj_tmp1->laout_arr['user']);

	if(!empty($obj_tmp1->laout_arr['checkCom'][0]['id'])){
		//找到公司的聯絡人
		$sql_ComContect="SELECT ".$obj_tmp1->member.".*
				   FROM ".$obj_tmp1->member."
				   WHERE ".$obj_tmp1->member.".companyId='".$obj_tmp1->laout_arr['checkCom'][0]['id']."'
				   AND ".$obj_tmp1->member.".companyValid='Host'";
		$obj_tmp1->laout_arr['ComContect']=array();
		$obj_tmp1->basic_select('laout_arr','ComContect',$sql_ComContect);
			//echo $sql_ComContect;
			//print_r($obj_tmp1->laout_arr['ComContect']);

		$_SESSION['user']['company']=$obj_tmp1->laout_arr['checkCom'][0]['id'];
		
		$sql_update="UPDATE ".$obj_tmp1->member." SET companyId='".$obj_tmp1->laout_arr['checkCom'][0]['id']."', companyValid='n', facebook='".$_POST['facebook']."', google='".$_POST['google']."', name='".$_POST['userName']."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->member.".id='".$userId."'";
		mysql_query($sql_update);

		//send mail to check company host
		//寄信等待認證
			$homeURL=WEB_PATH."index.php";
			$validCode=md5(uniqid(rand()));
			$validURL=WEB_PATH."mailValid.php?action=chechHR&code=".$validCode;
			// user photo
			if($obj_tmp1->laout_arr['user'][0]['photo']!=''){
				$userPhoto=WEB_PATH.$obj_tmp1->laout_arr['user'][0]['photo'];
			}else{$userPhoto="";}

		$email=$obj_tmp1->laout_arr['ComContect'][0]['email'];
		// 收件者信箱
		$name=$obj_tmp1->laout_arr['ComContect'][0]['name'];
		// 收件者的名稱or暱稱
		$mail->AddAddress($email,$name);
		$mail->Subject = "=?UTF-8?B?".base64_encode("[頭路網 TaoLou]公司認證,".$obj_tmp1->laout_arr['user'][0]['name']."是貴公司的人資")."?=";//信件標題，解決亂碼問題
		// 信件標題
		$mail->Body = "Hi ".$name.",<br><br>
		歡迎您使用<a href='".$homeURL."'>頭路網TaoLou</a>徵才！<br><br>
		請確認".$obj_tmp1->laout_arr['user'][0]['name']."是否為你們的HR ?<br>
		<table>
			<tr>
		    	<td><img src='".$userPhoto."' height='100px'></td>
		    	<td>".$obj_tmp1->laout_arr['user'][0]['name']."</td>		
		    	<td>".$obj_tmp1->laout_arr['user'][0]['email']."</td>
		  	</tr>
		</table><br><br>
		如果他是您公司的HR，請您點擊以下網址來驗證<br>
		<a href='".$validURL."'>".$validURL."</a><br><br>
		一但認證完信箱後，".$obj_tmp1->laout_arr['user'][0]['name']."即可使用<a href='".$homeURL."'>頭路網 TaoLou</a>豐富求才功能。<br><br><br>
		-----------<br>
		<span style='font-size:9px;'>頭路網服務團隊發送，如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。</span>";

		if(!$mail->Send()){echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
		}else{
			$sql_insertValid="UPDATE ".$obj_tmp1->member." SET companyValid='".$validCode."' WHERE ".$obj_tmp1->member.".id='".$userId."'";
			mysql_query($sql_insertValid);
		}

		$message=array('first'=>"success");
		echo json_encode($message);
	}
	else{
		$sql_insertCom="INSERT INTO ".$obj_tmp1->companyTable." VALUES(NULL,'n','','".$_POST['companyName']."','','','','','','','','','',CURRENT_TIMESTAMP)";
		mysql_query($sql_insertCom);

		//讀取公司ID
		$sql_checkCom="SELECT ".$obj_tmp1->companyTable.".*
					   FROM ".$obj_tmp1->companyTable."
					   WHERE ".$obj_tmp1->companyTable.".companyName='".$_POST['companyName']."'";
		$obj_tmp1->laout_arr['checkCom']=array();
		$obj_tmp1->basic_select('laout_arr','checkCom',$sql_checkCom);
			//echo $sql_checkCom;
			//print_r($obj_tmp1->laout_arr['checkCom']);
		$_SESSION['user']['company']=$obj_tmp1->laout_arr['checkCom'][0]['id'];

		//建立公司技能
		$sql_companySkill="INSERT INTO ".$obj_tmp1->companySkill." VALUES(NULL,'".$obj_tmp1->laout_arr['checkCom'][0]['id']."','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		mysql_query($sql_companySkill);

		//存入HR帳號
		$sql_update="UPDATE ".$obj_tmp1->member." SET companyId='".$obj_tmp1->laout_arr['checkCom'][0]['id']."', companyValid='Host', facebook='".$_POST['facebook']."', google='".$_POST['google']."', name='".$_POST['userName']."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->member.".id='".$userId."'";
		mysql_query($sql_update);

		//建立公司資料夾
		$cmpFolder="../userObject/companyObject/".$obj_tmp1->laout_arr['checkCom'][0]['id'];
		if(!file_exists($cmpFolder))
		{
			//新增資料夾
         	@mkdir($cmpFolder);
          	//end  新增資料夾
		}
		//========================

		//send mail to check company host
		//寄信等待認證
			$homeURL=WEB_PATH."index.php";

		$email=$obj_tmp1->laout_arr['user'][0]['email'];
		// 收件者信箱
		$name=$obj_tmp1->laout_arr['user'][0]['name'];
		// 收件者的名稱or暱稱
		$mail->AddAddress($email,$name);
		$mail->Subject = "=?UTF-8?B?".base64_encode("[頭路網 TaoLou]恭喜您登入您的公司")."?=";//信件標題，解決亂碼問題
		// 信件標題
		$mail->Body = "Hi ".$name.",<br><br>
		歡迎您使用<a href='".$homeURL."'>頭路網TaoLou</a>求才！<br><br>
		立即使用<a href='".$homeURL."'>頭路網 TaoLou</a>豐富的求才功能吧！<br><br><br>
		-------<br>
		<span style='font-size:9px;'>頭路網服務團隊發送，如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。</span>";

		if(!$mail->Send()){echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
		}else{
			$sql_insertValid="UPDATE ".$obj_tmp1->account." SET mailValid='".$validCode."' WHERE ".$obj_tmp1->account.".memberId='".$memberID."'";
			mysql_query($sql_insertValid);
		}

		$message=array('first'=>"success");
		echo json_encode($message);
	}
}
else if(@$_POST['method'] == "saveName"){
	$sql_updateUser="UPDATE ".$obj_tmp1->member." SET name='".$_POST['userName']."' WHERE ".$obj_tmp1->member.".id='".$userId."'";
	mysql_query($sql_updateUser);

	$message=array('first'=>"success");
	echo json_encode($message);
}
else if(@$_POST['method'] == "changeUser"){

	$sql_changeUser="SELECT ".$obj_tmp1->member.".*
					 FROM ".$obj_tmp1->member."
					 WHERE ".$obj_tmp1->member.".name='".$_POST['userName']."'";
	$obj_tmp1->laout_arr['changeUser']=array();
	$obj_tmp1->basic_select('laout_arr','changeUser',$sql_changeUser);
		//echo $sql_changeUser;
		//print_r($obj_tmp1->laout_arr['changeUser']);

	//set host→normal
	$sql_host_nor="UPDATE ".$obj_tmp1->member." SET companyValid='y' WHERE ".$obj_tmp1->member.".id='".$userId."'";
	mysql_query($sql_host_nor);

	//set normal→host

	//send mail to check company host
	//寄信告知
		$homeURL=WEB_PATH."index.php";

	$email=$obj_tmp1->laout_arr['changeUser'][0]['email'];
	// 收件者信箱
	$name=$obj_tmp1->laout_arr['changeUser'][0]['name'];
	// 收件者的名稱or暱稱
	$mail->AddAddress($email,$name);
	$mail->Subject = "=?UTF-8?B?".base64_encode("[頭路網 TaoLou]恭喜您成為公司的聯絡人")."?=";//信件標題，解決亂碼問題
	// 信件標題
	$mail->Body = "Hi ".$name.",<br><br>
	歡迎您使用<a href='".$homeURL."'>頭路網TaoLou</a>求才！<br><br>
	您已經成為公司的<span style='color:red'>主要聯絡人</span>了喔！<br>
	舉凡有人註冊貴公司，都需要您的認證！趕緊上<a href='".$homeURL."'>頭路網TaoLou</a>確認吧<br><br>
	-------<br>
	<span style='font-size:9px;'>頭路網服務團隊發送，如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。</span>";

	if(!$mail->Send()){echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
	}else{
		$sql_nor_host="UPDATE ".$obj_tmp1->member." SET companyValid='Host' WHERE ".$obj_tmp1->member.".id='".$obj_tmp1->laout_arr['changeUser'][0]['id']."'";
		mysql_query($sql_nor_host);
	}

	$message=array('first'=>"success");
	echo json_encode($message);	
}
else if(@$_POST['method'] == "reCompanyValid"){

	//先確認公司是否存在
	$sql_checkCom="SELECT ".$obj_tmp1->companyTable.".*
				   FROM ".$obj_tmp1->companyTable."
				   WHERE ".$obj_tmp1->companyTable.".companyName='".$_POST['companyName']."'";
	$obj_tmp1->laout_arr['checkCom']=array();
	$obj_tmp1->basic_select('laout_arr','checkCom',$sql_checkCom);
		//echo $sql_checkCom;
		//print_r($obj_tmp1->laout_arr['checkCom']);
	
	//確認使用者
	$sql_user="SELECT ".$obj_tmp1->member.".*
			   FROM ".$obj_tmp1->member."
			   WHERE ".$obj_tmp1->member.".id='".$userId."'";
	$obj_tmp1->laout_arr['user']=array();
	$obj_tmp1->basic_select('laout_arr','user',$sql_user);
		//echo $sql_user;
		//print_r($obj_tmp1->laout_arr['user']);

	//找到公司的聯絡人
	$sql_ComContect="SELECT ".$obj_tmp1->member.".*
			   FROM ".$obj_tmp1->member."
			   WHERE ".$obj_tmp1->member.".companyId='".$obj_tmp1->laout_arr['checkCom'][0]['id']."'
			   AND ".$obj_tmp1->member.".companyValid='Host'";
	$obj_tmp1->laout_arr['ComContect']=array();
	$obj_tmp1->basic_select('laout_arr','ComContect',$sql_ComContect);
		//echo $sql_ComContect;
		//print_r($obj_tmp1->laout_arr['ComContect']);


	//send mail to check company host
	//寄信等待認證
		$homeURL=WEB_PATH."index.php";
		$validCode=md5(uniqid(rand()));
		$validURL=WEB_PATH."mailValid.php?action=chechHR&code=".$validCode;
		// user photo
		if($obj_tmp1->laout_arr['user'][0]['photo']!=''){
			$userPhoto=WEB_PATH.$obj_tmp1->laout_arr['user'][0]['photo'];
		}else{$userPhoto="";}

	$email=$obj_tmp1->laout_arr['ComContect'][0]['email'];
	// 收件者信箱
	$name=$obj_tmp1->laout_arr['ComContect'][0]['name'];
	// 收件者的名稱or暱稱
	$mail->AddAddress($email,$name);
	$mail->Subject = "=?UTF-8?B?".base64_encode("[頭路網 TaoLou]公司認證,".$obj_tmp1->laout_arr['user'][0]['name']."是貴公司的人資")."?=";//信件標題，解決亂碼問題
	// 信件標題
	$mail->Body = "Hi ".$name.",<br><br>
	歡迎您使用<a href='".$homeURL."'>頭路網TaoLou</a>徵才！<br><br>
	請確認".$obj_tmp1->laout_arr['user'][0]['name']."是否為你們的HR ?<br>
	<table>
		<tr>
	    	<td><img src='".$userPhoto."' height='100px'></td>
	    	<td>".$obj_tmp1->laout_arr['user'][0]['name']."</td>		
	    	<td>".$obj_tmp1->laout_arr['user'][0]['email']."</td>
	  	</tr>
	</table><br><br>
	如果他是您公司的HR，請您點擊以下網址來驗證<br>
	<a href='".$validURL."'>".$validURL."</a><br><br>
	一但認證完信箱後，".$obj_tmp1->laout_arr['user'][0]['name']."即可使用<a href='".$homeURL."'>頭路網 TaoLou</a>豐富求才功能。<br><br><br>
	-----------<br>
	<span style='font-size:9px;'>頭路網服務團隊發送，如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。</span>";

	if(!$mail->Send()){echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
	}else{
		$sql_insertValid="UPDATE ".$obj_tmp1->member." SET companyValid='".$validCode."' WHERE ".$obj_tmp1->member.".id='".$userId."'";
		mysql_query($sql_insertValid);
	}
}
else if(@$_POST['method'] == "linkFB"){
	$sql_insertFB="INSERT INTO ".$obj_tmp1->facebook." VALUES(NULL,'".$_POST['FB_id']."','".$_POST['userName']."','".$_POST['email']."','".$_POST['photo']."',CURRENT_TIMESTAMP)";
	mysql_query($sql_insertFB);

	//facebook user
	$sql_checkFB="SELECT ".$obj_tmp1->facebook.".*
				  FROM ".$obj_tmp1->facebook."
				  WHERE ".$obj_tmp1->facebook.".facebook_id='".$_POST['FB_id']."'";
	$obj_tmp1->laout_arr['checkFB']=array();
	$obj_tmp1->basic_select('laout_arr','checkFB',$sql_checkFB);

	$sql_update="UPDATE ".$obj_tmp1->member." SET facebook='".$obj_tmp1->laout_arr['checkFB'][0]['id']."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->member.".id='".$userId."'";
	mysql_query($sql_update);

	$message=array('first'=>"success");
	echo json_encode($message);	
}
else if(@$_POST['method'] == "linkIN"){
	$sql_insertIN="INSERT INTO ".$obj_tmp1->IN." VALUES(NULL,'".$_POST['IN_id']."','".$_POST['IN_headline']."','".$_POST['IN_name']."','".$_POST['IN_email']."','".$_POST['IN_photo']."',CURRENT_TIMESTAMP)";
	mysql_query($sql_insertIN);

	//IN's user
	$sql_checkIN="SELECT ".$obj_tmp1->IN.".*
				  FROM ".$obj_tmp1->IN."
				  WHERE ".$obj_tmp1->IN.".LinkedIn_id='".$_POST['IN_id']."'";
	$obj_tmp1->laout_arr['checkIN']=array();
	$obj_tmp1->basic_select('laout_arr','checkIN',$sql_checkIN);

	$sql_update="UPDATE ".$obj_tmp1->member." SET LinkedIn='".$obj_tmp1->laout_arr['checkIN'][0]['id']."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->member.".id='".$userId."'";
	mysql_query($sql_update);

	$message=array('first'=>"success");
	echo json_encode($message);	
}
else{echo "no Page";}
?>