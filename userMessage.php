<?php
include_once 'share.php';

//page default

$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->message="taolou_member_message";


$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_REQUEST['action']!=""){@$action=$obj_tmp1->decode(laout_check($_REQUEST['action']));}
else {@$action='rule';}
//===================






//$action表示跟另外一人的對話
if(@$action=='none'){
	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/404.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================
}
else{

	//連結所有對話人物
	$sql_contentUser="SELECT distinct ".$obj_tmp1->message.".sendUserId, ".$obj_tmp1->message.".receiveUserId
					  FROM ".$obj_tmp1->message."
					  WHERE ".$obj_tmp1->message.".receiveUserId LIKE '%".$userId."%' 
					  OR ".$obj_tmp1->message.".sendUserId LIKE '%".$userId."%'
					  ORDER BY ".$obj_tmp1->message.".createDate ASC";
	$obj_tmp1->laout_arr['contentUser']=array();
    $obj_tmp1->basic_select('laout_arr','contentUser',$sql_contentUser);
        //echo $sql_contentUser;
        //print_r($obj_tmp1->laout_arr['contentUser']);
    //==========================


    //儲存User into $ConUserList
    $ConUserList=array("0"=>"0");
    if(!empty($obj_tmp1->laout_arr['contentUser'])){
    	foreach($obj_tmp1->laout_arr['contentUser'] as $ConUserKey => $ConUserValue){
    		if($ConUserValue['sendUserId'] == $userId){
    			if(array_search($ConUserValue['receiveUserId'],$ConUserList) == "")
    			{array_push($ConUserList,$ConUserValue['receiveUserId']);}
    		}
    		else if($ConUserValue['receiveUserId'] == $userId){
    			if(array_search($ConUserValue['sendUserId'],$ConUserList) == "")
    			{array_push($ConUserList,$ConUserValue['sendUserId']);}
    		}
    	}
    }
    	//print_r($ConUserList);
    //===========================


    //存入USERMENU
    $obj_tmp1->UserMenu=array();
    if(!empty($ConUserList)){
    	foreach($ConUserList as $UserKey => $UserValue){
    		//echo $UserValue;
    		$sql_user="SELECT ".$obj_tmp1->member.".*
    				   FROM ".$obj_tmp1->member."
    				   WHERE ".$obj_tmp1->member.".id='".$UserValue."'";
    		$obj_tmp1->laout_arr['userMenu']=array();
		    $obj_tmp1->basic_select('laout_arr','userMenu',$sql_user);
		        //echo $sql_user;
		        //print_r($obj_tmp1->laout_arr['userMenu']);
		    //==========================

		    array_push($obj_tmp1->UserMenu,$obj_tmp1->laout_arr['userMenu']);
    	}
    }
    	//print_r($obj_tmp1->UserMenu);



	$obj_tmp1->showad=false;
	if($action=="rule"){
	    $obj_tmp1->content_html='content/user/messageRule.html';
	}
	else{

		//抓取所有對話內容
		$sql_MessageCon="SELECT ".$obj_tmp1->message.".*
						 FROM ".$obj_tmp1->message."
						 WHERE (".$obj_tmp1->message.".receiveUserId='".$userId."' AND ".$obj_tmp1->message.".sendUserId ='".$action."' AND status='y')
						 OR (".$obj_tmp1->message.".receiveUserId='".$action."' AND ".$obj_tmp1->message.".sendUserId ='".$userId."' AND status='y')
						 ORDER BY ".$obj_tmp1->message.".createDate";
		$obj_tmp1->laout_arr['MessageCont']=array();
	    $obj_tmp1->basic_select('laout_arr','MessageCont',$sql_MessageCon);
	        //echo $sql_MessageCon;
	        //print_r($obj_tmp1->laout_arr['MessageCont']);
	    //UserId
	    $obj_tmp1->receiveUserId=$action;
	    //==========================

	    //抓取與企業對話者資訊
	    $sql_UserInfo="SELECT ".$obj_tmp1->member.".*, ".$obj_tmp1->companyTable.".companyName
	    			   FROM ".$obj_tmp1->member."
	    			   LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->member.".companyId
	    			   WHERE ".$obj_tmp1->member.".id='".$action."'
	    			   AND ".$obj_tmp1->member.".companyHr='y'";
	    $obj_tmp1->laout_arr['UserInfo']=array();
	    $obj_tmp1->basic_select('laout_arr','UserInfo',$sql_UserInfo);
	        //echo $sql_UserInfo;
	        //print_r($obj_tmp1->laout_arr['UserInfo']);
	    //==========================

	    //抓取與使用者對話資訊
	    $sql_ComToUser="SELECT ".$obj_tmp1->member.".*
	    				FROM ".$obj_tmp1->member."
	    				WHERE ".$obj_tmp1->member.".id='".$action."'
	    				AND ".$obj_tmp1->member.".companyHr='n'";
	    $obj_tmp1->laout_arr['ComToUser']=array();
	    $obj_tmp1->basic_select('laout_arr','ComToUser',$sql_ComToUser);
	        //echo $sql_ComToUser;
	        //print_r($obj_tmp1->laout_arr['ComToUser']);
	    //==========================
	    

	    $obj_tmp1->content_html='content/user/message.html';
	}
	$obj_tmp1->subMenu='content/user/Menumessage.html';

	//設定版面
	$obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
	$obj_tmp1->footer_html="footer.html";
	$obj_tmp1->laout('templates.html');
	//=======================================
}



?>