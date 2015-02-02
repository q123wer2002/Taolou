<?php
include_once '../share.php';


//page default

$obj_tmp1->member="taolou_member_detail";
$obj_tmp1->memberCV="taolou_member_cv";

$obj_tmp1->job="taolou_job";

$obj_tmp1->skillList="taolou_system_specialskill";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';


//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}

//========================



if(@$_POST['method']=="uploadResume"){
	if(!empty($_FILES)){

		$sql_checkUser="SELECT ".$obj_tmp1->member.".*
						FROM ".$obj_tmp1->member."
						WHERE ".$obj_tmp1->member.".id='".$userId."'";
		$obj_tmp1->laout_arr['checkUser']=array();
		$obj_tmp1->basic_select('laout_arr','checkUser',$sql_checkUser);
			//echo $sql_checkUser;
			//print_r($obj_tmp1->laout_arr['checkUser']);
		//==========================

		//upload
			//rand
			$resumeCode=md5(uniqid(rand()));
		$file_path=APP_PATH."/userObject/".$obj_tmp1->laout_arr['checkUser'][0]['email']."/CV/";
		$sizeKB=round($_FILES['file']['size']/1024,2);
  		$type=split("[.]",$_FILES['file']['name']);
  		$file_name=$file_path.$resumeCode.".".$type[1];
	  	move_uploaded_file($_FILES["file"]["tmp_name"],$file_name);

	  	$file_path="userObject/".$obj_tmp1->laout_arr['checkUser'][0]['email']."/CV/".$resumeCode.".".$type[1];
		//end Upload

		//update user profile_photo
		$sql_insertResume="INSERT INTO ".$obj_tmp1->memberCV." VALUES(NULL,'".$userId."','".$type[0]."','".$type[1]."','','y','".$sizeKB."','".$file_path."','y',CURRENT_TIMESTAMP)";
		mysql_query($sql_insertResume);
		//end update

		$message=array('first'=>"success");
		echo json_encode($message);
	}
}
else if(@$_POST['method']=="deleteResume"){
	//print_r($_POST['resume']);
	//先找到履歷
	$sql_searchResume="SELECT ".$obj_tmp1->memberCV.".*
					   FROM ".$obj_tmp1->memberCV."
					   WHERE ".$obj_tmp1->memberCV.".src='".$_POST['resume']['src']."'";
	$obj_tmp1->laout_arr['searchResume']=array();
    $obj_tmp1->basic_select('laout_arr','searchResume',$sql_searchResume);
        //echo $sql_searchResume;
        //print_r($obj_tmp1->laout_arr['searchResume']);
    //=========================

    if(!empty($obj_tmp1->laout_arr['searchResume'])){
    	//status turn into false
   		$sql_changeStatus="UPDATE ".$obj_tmp1->memberCV." SET status='n',intelligence='n' WHERE ".$obj_tmp1->memberCV.".src='".$_POST['resume']['src']."'";
   		mysql_query($sql_changeStatus);
   	}

   	$message=array('first'=>"success");
	echo json_encode($message);
}
else if(@$_POST['method']=="checkboxIntellFun"){
	//先找到履歷
	$sql_searchResume="SELECT ".$obj_tmp1->memberCV.".*
					   FROM ".$obj_tmp1->memberCV."
					   WHERE ".$obj_tmp1->memberCV.".src='".$_POST['resume']['src']."'";
	$obj_tmp1->laout_arr['searchResume']=array();
    $obj_tmp1->basic_select('laout_arr','searchResume',$sql_searchResume);
        //echo $sql_searchResume;
        //print_r($obj_tmp1->laout_arr['searchResume']);
    //=========================

    if(!empty($obj_tmp1->laout_arr['searchResume'])){
    	//status turn into false
    		//要 點擊的狀態 相反，才會符合邏輯
    	if($_POST['resume']['intelligence']=='true'){$intelligence='n';}
    	else{$intelligence='y';}

   		$sql_changeStatus="UPDATE ".$obj_tmp1->memberCV." SET intelligence='".$intelligence."' WHERE ".$obj_tmp1->memberCV.".src='".$_POST['resume']['src']."'";
   		mysql_query($sql_changeStatus);
   	}
   	//echo $sql_changeStatus;
   	//print_r($_POST['resume']);
   	$message=array('first'=>"success");
	echo json_encode($message);
}else if(@$_POST['method']=="addNewSkill"){
	$skill=laout_check($_POST['skill']);
	$sql_addNewSkill="INSERT INTO ".$obj_tmp1->skillList." VALUES(NULL,'0','".$skill."','n',CURRENT_TIMESTAMP)";
	mysql_query($sql_addNewSkill);
	//=============

	echo "SUCCESS";
	exit;
}
else if(@$_POST['method']=="saveResumeSkill"){
	//init skill list
	$skillList="";
	foreach($_POST['resume']['skill'] as $key => $value){
		//list skill id
		$sql_listID="SELECT ".$obj_tmp1->skillList.".*
					 FROM ".$obj_tmp1->skillList."
					 WHERE ".$obj_tmp1->skillList.".skill='".$value."'";
		$obj_tmp1->laout_arr['listID']=array();
	    $obj_tmp1->basic_select('laout_arr','listID',$sql_listID);
	        //echo $sql_listID;
	        //print_r($obj_tmp1->laout_arr['listID']);
	    $skillList=$skillList.$obj_tmp1->laout_arr['listID'][0]['id']."|";
	    //=========================
	}$skillList=substr($skillList,0,-1);
	//echo $skillList;

	$sql_updateSkill="UPDATE ".$obj_tmp1->memberCV." SET skill='".$skillList."' WHERE ".$obj_tmp1->memberCV.".id='".$_POST['resume']['id']."'";
	mysql_query($sql_updateSkill);

	echo "SUCCESS";
	exit;
}
else{}

?>