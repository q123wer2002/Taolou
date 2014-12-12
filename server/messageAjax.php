<?php
include_once '../share.php';

//page default

$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->message="taolou_member_message";


$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

$userId=$_SESSION['user']['id'];

if(@$_POST['method'] == "message"){
	$sql_insertMessage="INSERT INTO ".$obj_tmp1->message." VALUES (NULL,'".$userId."','".$_POST['reveicer']."','".$_POST['messagecontent']."','y',CURRENT_TIMESTAMP)";
	mysql_query($sql_insertMessage);

	$message=array('first'=>"success");
	echo json_encode($message);
	
}
else{echo "no Message";}
?>