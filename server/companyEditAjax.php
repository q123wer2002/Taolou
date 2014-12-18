<?php
include_once '../share.php';

//page default
$obj_tmp1->companyTable="taolou_company";



//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_SESSION['user']['company']){$companyID=$_SESSION['user']['company'];}else{$companyID="";exit;}

//========================

if(@$_POST['method']=="updateCompanyPhoto"){
	if(!empty($_FILES)){
		
		$sql_company="SELECT ".$obj_tmp1->companyTable.".*
					 FROM ".$obj_tmp1->companyTable."
					 WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
		$obj_tmp1->laout_arr['company']=array();
		$obj_tmp1->basic_select('laout_arr','company',$sql_company);
			//echo $sql_company;
			//print_r($obj_tmp1->laout_arr['company']);
		//==========================

		//upload
		$file_path=APP_PATH."/userObject/companyObject/".$obj_tmp1->laout_arr['company'][0]['id']."/";
  		$type=split("/",$_FILES['file']['type']);
  		$file_name=$file_path."CompanyPhoto.".$type[1];
	  	move_uploaded_file($_FILES["file"]["tmp_name"],$file_name);

	  	$file_path="userObject/companyObject/".$obj_tmp1->laout_arr['company'][0]['id']."/"."CompanyPhoto.".$type[1];
		//end Upload

		//update user profile_photo
		$sql_updatePhoto="UPDATE ".$obj_tmp1->companyTable." SET logo='".$file_path."' WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
		mysql_query($sql_updatePhoto);
		//end update

		$message=array('first'=>"success");
		echo json_encode($message);

	}else{
		$message=array('first'=>"no file");
		echo json_encode($message);
	}
}
else if(@$_POST['method']=="updateCEOPhoto"){
	if(!empty($_FILES)){
		
		$sql_company="SELECT ".$obj_tmp1->companyTable.".*
					 FROM ".$obj_tmp1->companyTable."
					 WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
		$obj_tmp1->laout_arr['company']=array();
		$obj_tmp1->basic_select('laout_arr','company',$sql_company);
			//echo $sql_company;
			//print_r($obj_tmp1->laout_arr['company']);
		//==========================

		//upload
		$file_path=APP_PATH."/userObject/companyObject/".$obj_tmp1->laout_arr['company'][0]['id']."/";
  		$type=split("/",$_FILES['file']['type']);
  		$file_name=$file_path."ceoPhoto.".$type[1];
	  	move_uploaded_file($_FILES["file"]["tmp_name"],$file_name);

	  	$file_path="userObject/companyObject/".$obj_tmp1->laout_arr['company'][0]['id']."/"."ceoPhoto.".$type[1];
		//end Upload

		//update user profile_photo
		$sql_updatePhoto="UPDATE ".$obj_tmp1->companyTable." SET ceoPhoto='".$file_path."' WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
		mysql_query($sql_updatePhoto);
		//echo $sql_updatePhoto;
		//end update

		//$message=array('first'=>"success");
		//echo json_encode($message);

	}else{
		$message=array('first'=>"no file");
		echo json_encode($message);
	}
} 
else if(@$_POST['method']=="updateLocation"){
	
	$locationObject = split('&',$_POST['location']);
	$county = split('=',$locationObject[0]);
	$district = split('=',$locationObject[1]);
	$zipcode = split('=',$locationObject[2]);

	$location=$county[1]."/".$district[1]."/".$zipcode[1];

	$sql_updateLocation="UPDATE ".$obj_tmp1->companyTable." SET location='".$location."' WHERE ".$obj_tmp1->companyTable.".id='".$companyID."'";
	mysql_query($sql_updateLocation);

	$message=array('first'=>"success");
	echo json_encode($message);	
}

?>