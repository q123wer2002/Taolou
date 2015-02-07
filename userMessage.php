<?php
include_once 'share.php';

//page default

$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->message="taolou_member_message";

$obj_tmp1->userNotification="taolou_member_notification_user";
$obj_tmp1->hrNotification="taolou_member_notification_hr";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
if(@$_SESSION['user']['id']!= ""){@$userId=$_SESSION['user']['id'];}else{@$action='none';}
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
	//查看 ""未讀"" 訊息
		//先看是 user 還是 hr
	if($_SESSION['user']['userType']==1){
		//user
		$sql_notiMessage="SELECT ".$obj_tmp1->userNotification.".itemId
						  FROM ".$obj_tmp1->userNotification."
						  WHERE ".$obj_tmp1->userNotification.".memberId='".$userId."'
						  AND ".$obj_tmp1->userNotification.".type='message'
						  AND ".$obj_tmp1->userNotification.".status='y'";
		$obj_tmp1->laout_arr['notiMessage']=array();
	    $obj_tmp1->basic_select('laout_arr','notiMessage',$sql_notiMessage);
	}
	else if($_SESSION['user']['userType']==2){
		//hr
		$sql_notiMessage="SELECT ".$obj_tmp1->hrNotification.".itemId
						  FROM ".$obj_tmp1->hrNotification."
						  WHERE ".$obj_tmp1->hrNotification.".memberId='".$userId."'
						  AND ".$obj_tmp1->hrNotification.".type='message'
						  AND ".$obj_tmp1->hrNotification.".status='y'";
		$obj_tmp1->laout_arr['notiMessage']=array();
	    $obj_tmp1->basic_select('laout_arr','notiMessage',$sql_notiMessage);
	}
		//echo $sql_notiMessage;
	    //print_r($obj_tmp1->laout_arr['notiMessage']);
	//========================== 確認完未讀訊息的ID
	//讀取未讀的聯絡人
	$obj_tmp1->noReadMesUserID=array();
	$obj_tmp1->noReadMes=array();
	if(!empty($obj_tmp1->laout_arr['notiMessage'])){
		foreach ($obj_tmp1->laout_arr['notiMessage'] as $NotiMesKey => $NotiMesValue) {
			$sql_noRead="SELECT ".$obj_tmp1->message.".sendUserId
						 FROM ".$obj_tmp1->message."
						 WHERE ".$obj_tmp1->message.".id='".$NotiMesValue['itemId']."'";
			$obj_tmp1->laout_arr['noRead']=array();
	    	$obj_tmp1->basic_select('laout_arr','noRead',$sql_noRead);

	    	if(!in_array($obj_tmp1->laout_arr['noRead'][0]['sendUserId'], $obj_tmp1->noReadMesUserID)){
	    		//確認是否以存入，否則存入 user_array
	    		array_push($obj_tmp1->noReadMesUserID, $obj_tmp1->laout_arr['noRead'][0]['sendUserId']);
	    		//存入user的專屬messageID
	    		$obj_tmp1->noReadMes[$obj_tmp1->laout_arr['noRead'][0]['sendUserId']]=array();
	    		array_push($obj_tmp1->noReadMes[$obj_tmp1->laout_arr['noRead'][0]['sendUserId']],$NotiMesValue['itemId']);
	    	}else{
	    		//僅存入user的專屬messageID
	    		array_push($obj_tmp1->noReadMes[$obj_tmp1->laout_arr['noRead'][0]['sendUserId']],$NotiMesValue['itemId']);
	    	}
		}
	}
	//print_r($obj_tmp1->noReadMesUserID);
	//print_r($obj_tmp1->noReadMes);

	//=====================================================  end 未讀訊息
	
	//取消未讀訊息
	if($action!='none'){
		//有點入聯絡人訊息
		if(in_array($action, $obj_tmp1->noReadMesUserID)){
			//有在未讀訊息內
				//確認使用者是user or hr
			if($_SESSION['user']['userType']==1){
				//user
				foreach ($obj_tmp1->noReadMes[$action] as $key => $value) {
					$sql_updaetMes="UPDATE ".$obj_tmp1->userNotification." SET status='n' WHERE ".$obj_tmp1->userNotification.".type='message' AND ".$obj_tmp1->userNotification.".itemId='".$value."' AND ".$obj_tmp1->userNotification.".memberId='".$userId."'";
					mysql_query($sql_updaetMes);
				}
				//確認剩下的 Notificarions
				$sql_notification="SELECT COUNT(".$obj_tmp1->userNotification.".id) as NotiS 
								   FROM ".$obj_tmp1->userNotification."
								   WHERE ".$obj_tmp1->userNotification.".status='y'
								   AND ".$obj_tmp1->userNotification.".memberId='".$userId."'";
				$obj_tmp1->laout_arr['notification']=array();
				$obj_tmp1->basic_select('laout_arr','notification',$sql_notification);
			}else if($_SESSION['user']['userType']==2){
				//hr
				foreach ($obj_tmp1->noReadMes[$action] as $key => $value) {
					$sql_updaetMes="UPDATE ".$obj_tmp1->hrNotification." SET status='n' WHERE ".$obj_tmp1->hrNotification.".type='message' AND ".$obj_tmp1->hrNotification.".itemId='".$value."' AND ".$obj_tmp1->hrNotification.".memberId='".$userId."'";
					mysql_query($sql_updaetMes);
				}
				//確認剩下的 Notificarions
				$sql_notification="SELECT COUNT(".$obj_tmp1->hrNotification.".id) as NotiS
								   FROM ".$obj_tmp1->hrNotification."
								   WHERE ".$obj_tmp1->hrNotification.".status='y'
								   AND ".$obj_tmp1->hrNotification.".memberId='".$userId."'";
				$obj_tmp1->laout_arr['notification']=array();
				$obj_tmp1->basic_select('laout_arr','notification',$sql_notification);
			}
				//notifiacitons
			$_SESSION['user']['notification']=$obj_tmp1->laout_arr['notification'][0]['NotiS'];
		}
	}
	

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