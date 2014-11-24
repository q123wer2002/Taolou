<?php
include_once '../share.php';

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->account='taolou_account';
$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

if($_POST['method']=='login')
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
			if($obj_tmp1->laout_arr['loadUser'][0]['companyHr'] == 'y'){$_SESSION['user']['userType']="2";}
			else if($obj_tmp1->laout_arr['loadUser'][0]['companyHr'] == 'n'){$_SESSION['user']['userType']="1";}
			
			$message=array('first'=>"success",'url'=>"index.php","actions"=>'login');
			//=======================
		}else{$message=array('first'=>"帳號密碼不正確",'url'=>"X","actions"=>'login');}
	}else{$message=array('first'=>"請先註冊後登入",'url'=>"X","actions"=>'login');}
	//=========================

	echo json_encode($message);
	
	exit;
}

else if($_POST['method']=='signup')
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
		//看目前有多少
		$sql_countMember="SELECT COUNT(".$obj_tmp1->member.".id) as COUNT
						  FROM ".$obj_tmp1->member;
		$obj_tmp1->laout_arr['countMember']=array();
		$obj_tmp1->basic_select('laout_arr','countMember',$sql_countMember);
		//========================
		
		$memberID=$obj_tmp1->laout_arr['countMember'][0]['COUNT']+1;
		
		//存入account內
		$sql_account="INSERT INTO ".$obj_tmp1->account."
					  VALUES (NULL,'".$memberID."','".$account."','".$password."',CURRENT_TIMESTAMP)";
		mysql_query($sql_account);
		//========================

		//存入member內
		$sql_member="INSERT INTO ".$obj_tmp1->member."
					 VALUES (NULL,'".$_POST['memberType']."','','','".$account."','','','','','','','','','','','','',CURRENT_TIMESTAMP)";
		mysql_query($sql_member);
		//========================

		//跳回登入頁面
		$message=array('first'=>"成功",'url'=>'account.php?action=login',"actions"=>'signup');
	}

	echo json_encode($message);
	exit;
}
else if($_POST['method'] == 'logout'){
	
	unset($_SESSION['user']);
	$message=array('first'=>"success",'url'=>"index.php","actions"=>'logout');

	echo json_encode($message);
	exit;
}
else{

	$message=array('first'=>"404 Not found this page");
	echo json_encode($message);
	exit;
}

?>