<?php
include_once '../share.php';
require('../include/sendMail.php');

$obj_tmp1->account='taolou_account';
$obj_tmp1->member='taolou_member_detail';

$obj_tmp1->company='taolou_company';
$obj_tmp1->job='taolou_job';
$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

if(@$_POST['method'] == 'search'){

	$obj_tmp1->tmp_where=$_POST['keyword'];

	//開始搜尋公司
	$sql_searchC="SELECT ".$obj_tmp1->company.".*
				 FROM ".$obj_tmp1->company."
				 WHERE ".$obj_tmp1->company.".companyName LIKE '%".$obj_tmp1->tmp_where."%' ";
	$obj_tmp1->laout_arr['searchC']=array();
	$obj_tmp1->basic_select('laout_arr','searchC',$sql_searchC);
	//============================

	//開始搜尋工作
	$sql_searchJ="SELECT ".$obj_tmp1->job.".*
				 FROM ".$obj_tmp1->job."
				 WHERE ".$obj_tmp1->job.".jobName LIKE '%".$obj_tmp1->tmp_where."%' ";
	$obj_tmp1->laout_arr['searchJ']=array();
	$obj_tmp1->basic_select('laout_arr','searchJ',$sql_searchJ);
	//=============================

	echo "yes";

	exit;
}
else if(@$_POST['method']=='changeMail'){

	$id=@$_SESSION['user']['id'];
	
	$sql_updateMail="UPDATE ".$obj_tmp1->account." SET email='".$_POST['email']."' WHERE memberId='".$id."'";
	mysql_query($sql_updateMail);
	$sql_updateMail="UPDATE ".$obj_tmp1->member." SET email='".$_POST['email']."' WHERE id='".$id."'";
	mysql_query($sql_updateMail);

	echo "success";
	exit;
}
else if(@$_POST['method']=='reSendMail'){

	$id=@$_SESSION['user']['id'];
	//寄信等待認證
		//認證密碼
		$validCode=md5(uniqid(rand()));
		$homeURL=WEB_PATH."index.php";
		$validURL=WEB_PATH."mailValid.php?action=openAccount&code=".$validCode;
	$email=$_POST['email'];
	// 收件者信箱
	$name=$_POST['email'];
	// 收件者的名稱or暱稱
	$mail->AddAddress($email,$name);
	$mail->Subject = "=?UTF-8?B?".base64_encode("[頭路網 TaoLou]註冊信箱認證")."?=";//信件標題，解決亂碼問題
	// 信件標題
	$mail->Body = "Hi ".$_POST['email'].",<br><br>
	歡迎您使用<a href='".$homeURL."'>頭路網TaoLou</a>求職！<br><br>
	請您點擊以下網址來驗證<a href='mailto:".$_POST['email']."'>".$_POST['email']."</a>信箱<br><br>
	<a href='".$validURL."'>".$validURL."</a><br><br>
	一但認證完信箱後，即可立即使用<a href='".$homeURL."'>頭路網 TaoLou</a>的豐富功能求職。<br><br><br>
	-------<br>
	如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。";

	if(!$mail->Send()){echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
	}else{
		$sql_insertValid="UPDATE ".$obj_tmp1->account." SET mailValid='".$validCode."' WHERE ".$obj_tmp1->account.".memberId='".$id."'";
		mysql_query($sql_insertValid);
	}
}
else if(@$_POST['method']=='validSuccess'){

	//寄信等待認證
		//認證密碼
		$homeURL=WEB_PATH."index.php";
		$login=WEB_PATH."account.php?action=login";

	$email=$_POST['email'];
	// 收件者信箱
	$name=$_POST['name'];
	// 收件者的名稱or暱稱
	$mail->AddAddress($email,$name);
	$mail->Subject = "=?UTF-8?B?".base64_encode("[頭路網 TaoLou]公司登入成功")."?=";//信件標題，解決亂碼問題
	// 信件標題
	$mail->Body = "Hi ".$_POST['name'].",<br><br>
	".$_POST['companyName']."已經將您登錄到他們的HR嚕！<br>
	歡迎您使用<a href='".$homeURL."'>頭路網TaoLou</a>求才！<br><br>
	趕緊<a href='".$login."'>登入頭路網</a>求才吧！<br><br><br>
	-------<br>
	<span style='font-size:9px;'>頭路網服務團隊發送，如果有任何問題，可以寄信給<a href='mailto:q123wer2002@gmail.com'>q123wer2002@gmail.com</a>聯繫您的問題。</span>";

	if(!$mail->Send()){echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
	}else{}
}

?>