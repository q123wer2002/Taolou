<?php
include_once '../share.php';

//page default

$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->member='taolou_member_detail';


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
	if(!empty($obj_tmp1->laout_arr['checkCom'][0]['id'])){
		$_SESSION['user']['company']=$obj_tmp1->laout_arr['checkCom'][0]['id'];
		$sql_update="UPDATE ".$obj_tmp1->member." SET companyId='".$obj_tmp1->laout_arr['checkCom'][0]['id']."', companyValid='n', facebook='".$_POST['facebook']."', google='".$_POST['google']."', name='".$_POST['userName']."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->member.".id='".$userId."'";
		mysql_query($sql_update);

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

		$sql_update="UPDATE ".$obj_tmp1->member." SET companyId='".$obj_tmp1->laout_arr['checkCom'][0]['id']."', companyValid='Host', facebook='".$_POST['facebook']."', google='".$_POST['google']."', name='".$_POST['userName']."', updateDate=CURRENT_TIMESTAMP WHERE ".$obj_tmp1->member.".id='".$userId."'";
		mysql_query($sql_update);

		$message=array('first'=>"success");
		echo json_encode($message);
	}
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
	$sql_nor_host="UPDATE ".$obj_tmp1->member." SET companyValid='Host' WHERE ".$obj_tmp1->member.".id='".$obj_tmp1->laout_arr['changeUser'][0]['id']."'";
	mysql_query($sql_nor_host);

	$message=array('first'=>"success");
	echo json_encode($message);	
}
else{echo "no Page";}
?>