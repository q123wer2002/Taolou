<?php
include_once 'share.php'; 

//page default
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->account='taolou_account';
$obj_tmp1->tmp_where="";

$obj_tmp1->mailValid=false;
$obj_tmp1->laout_set=true;

$obj_tmp1->tmp_order ='order By sort Asc';

//確認動作
if(@$_REQUEST['action']!=""){@$action=laout_check($_REQUEST['action']);}
else{@$action='none';}
//====================

switch($action){
	case 'openAccount':
	//確認密碼
	if(@$_REQUEST['code']!=""){

		$code=laout_check($_REQUEST['code']);
		
		if($code=='y'){}
		else{
			//用密碼找人來認證
			$sql_checkUser="SELECT ".$obj_tmp1->account.".*
							FROM ".$obj_tmp1->account."
							WHERE ".$obj_tmp1->account.".mailValid='".$code."'";
			$obj_tmp1->laout_arr['checkUser']=array();
			$obj_tmp1->basic_select('laout_arr','checkUser',$sql_checkUser);
				//echo $sql_checkUser;
				//print_r($obj_tmp1->laout_arr['checkUser']);
			//==========================

			if(!empty($obj_tmp1->laout_arr['checkUser'])){
				
				//認證成功
				$sql_mailVlidOK="UPDATE ".$obj_tmp1->account." SET mailValid='y' WHERE id='".$obj_tmp1->laout_arr['checkUser'][0]['id']."'";
				mysql_query($sql_mailVlidOK);

				//再次確認
				$sql_update="SELECT ".$obj_tmp1->account.".*
							 FROM ".$obj_tmp1->account."
							 WHERE ".$obj_tmp1->account.".id='".$obj_tmp1->laout_arr['checkUser'][0]['id']."'";
				$obj_tmp1->laout_arr['update']=array();
				$obj_tmp1->basic_select('laout_arr','update',$sql_update);
					//echo $sql_update;
					//print_r($obj_tmp1->laout_arr['update']);
				//==========================

				$_SESSION['user']['mailValid']=$obj_tmp1->laout_arr['update'][0]['mailValid'];

				$obj_tmp1->mailValid=true;
			}
		}
	}

	
	$obj_tmp1->showad=true;
	$obj_tmp1->content_html='content/account/mailValid.html';
	//設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');

	break;

	case 'reSendMail':

	if(@$_SESSION['user']['id']!=""){$id=$_SESSION['user']['id'];}
	else{$id="";}

	//取得使用者資訊
	$sql_userInfo="SELECT ".$obj_tmp1->account.".*
				   FROM ".$obj_tmp1->account."
				   WHERE ".$obj_tmp1->account.".memberId='".$id."'";
	$obj_tmp1->laout_arr['userInfo']=array();
	$obj_tmp1->basic_select('laout_arr','userInfo',$sql_userInfo);
		//echo $sql_userInfo;
		//print_r($obj_tmp1->laout_arr['userInfo']);
	//==========================


	$obj_tmp1->showad=true;
	$obj_tmp1->content_html='content/account/reSendMail.html';
	//設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');

	break;
}

?>