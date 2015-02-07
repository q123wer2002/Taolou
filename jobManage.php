<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberCV='taolou_member_cv';
$obj_tmp1->memberJM="taolou_member_jobmanage";

$obj_tmp1->userNotification="taolou_member_notification_user";

$obj_tmp1->tmp_where="";

$obj_tmp1->mailValid=false;
$obj_tmp1->laout_set=true;

$obj_tmp1->tmp_order ='order By sort Asc';


//確認使用者是誰
if(@laout_check($_GET['action']) != ""){$getAction=laout_check($_GET['action']);}else{$getAction="";}
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_SESSION['user']['userType'] != ""){
    if(@$_SESSION['user']['userType'] == '1'){
      if(@$_SESSION['user']['mailValid']=='y'){$obj_tmp1->mailValid=true;}
    }
    else if(@$_SESSION['user']['userType'] == '2'){$action='none';}
    else{$action='none';}
}
if(@$getAction!=""){
  $action=laout_check($_GET['action']);
}else{$action='autosendCV';}
//===================

//notifications
$obj_tmp1->jobNotiS_Intell=array();
$obj_tmp1->jobNotiS_NIntell=array();
//check notifications
    $sql_Notifications="SELECT ".$obj_tmp1->userNotification.".*, ".$obj_tmp1->memberJM.".intelligence as INTEL, ".$obj_tmp1->memberJM.".jobId as JOB
                        FROM ".$obj_tmp1->userNotification."
                        LEFT JOIN ".$obj_tmp1->memberJM." 
                        ON (".$obj_tmp1->memberJM.".jobId=".$obj_tmp1->userNotification.".itemId
                        AND ".$obj_tmp1->memberJM.".memberId=".$obj_tmp1->userNotification.".memberId ) 
                        WHERE ".$obj_tmp1->userNotification.".memberId='".$userId."'
                        AND ".$obj_tmp1->userNotification.".type='JOB_APPLY'
                        OR ".$obj_tmp1->userNotification.".type='comment'
                        AND ".$obj_tmp1->userNotification.".status='y'";
    $obj_tmp1->laout_arr['Notifications']=array();
    $obj_tmp1->basic_select('laout_arr','Notifications',$sql_Notifications);
        //echo $sql_Notifications;
        //print_r($obj_tmp1->laout_arr['Notifications']);
    //==========================
    if(!empty($obj_tmp1->laout_arr['Notifications'])){
      foreach ($obj_tmp1->laout_arr['Notifications'] as $key => $value) {
        if($value['INTEL']=='n'){
          $obj_tmp1->jobNotiS_NIntell[$value['JOB']]=array();
          $obj_tmp1->jobNotiS_NIntell[$value['JOB']]['id']=$value['id'];
          $obj_tmp1->jobNotiS_NIntell[$value['JOB']]['type']=$value['type'];
        }
        else{
          $obj_tmp1->jobNotiS_Intell[$value['JOB']]=array();
          $obj_tmp1->jobNotiS_Intell[$value['JOB']]['id']=$value['id'];
          $obj_tmp1->jobNotiS_Intell[$value['JOB']]['type']=$value['type'];
        }
      }
    }
    //print_r($obj_tmp1->jobNotiS_NIntell);

switch(@$action){
	case "autosendCV":

    //找求職資訊
    $sql_Imanage="SELECT ".$obj_tmp1->memberJM.".*
                  FROM ".$obj_tmp1->memberJM."
                  LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->memberJM.".memberId
                  LEFT JOIN ".$obj_tmp1->jobtable." ON ".$obj_tmp1->jobtable.".id=".$obj_tmp1->memberJM.".jobId
                  LEFT JOIN ".$obj_tmp1->memberCV." ON ".$obj_tmp1->memberCV.".id=".$obj_tmp1->memberJM.".CVId
                  WHERE ".$obj_tmp1->memberJM.".memberId='".$userId."' 
                  AND ".$obj_tmp1->memberJM.".intelligence='y' 
                  AND ".$obj_tmp1->memberJM.".status <> 'collect'
                  AND ".$obj_tmp1->memberJM.".status <> 'access'
                  ORDER BY ".$obj_tmp1->memberJM.".updateDate DESC";
    $obj_tmp1->laout_arr['Imanage']=array();
    $obj_tmp1->basic_select('laout_arr','Imanage',$sql_Imanage);
        //echo $sql_Imanage;
        //print_r($obj_tmp1->laout_arr['Imanage']);
    //==========================

    $obj_tmp1->saveJob=array();

    //找每個求才資訊
    if(!empty($obj_tmp1->laout_arr['Imanage'])){
        foreach($obj_tmp1->laout_arr['Imanage'] as $IKey => $IValue){
            //設定變數儲存
            $obj_tmp1->saveJob[$IValue['id']]=array();

            //開始尋找
            $sql_showJob="SELECT distinct ".$obj_tmp1->jobtable.".*,
                          ".$obj_tmp1->companyTable.".id as companyId,".$obj_tmp1->companyTable.".companyName,".$obj_tmp1->companyTable.".logo,".$obj_tmp1->companyTable.".memberSize
                          FROM ".$obj_tmp1->jobtable."
                          LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->jobtable.".companyId 
                          WHERE ".$obj_tmp1->jobtable.".id='".$IValue['jobId']."' 
                          AND ".$obj_tmp1->jobtable.".status='y'
                          ORDER BY ".$obj_tmp1->jobtable.".updateDate DESC ";
                          //LIMIT ".$jobshow_start.",20";
            $obj_tmp1->laout_arr['showJob']=array();
            $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
                //echo $sql_showJob;
                //print_r($obj_tmp1->laout_arr['showJob']);
            //======================

            $obj_tmp1->saveJob[$IValue['id']]=$obj_tmp1->laout_arr['showJob'];
            @$obj_tmp1->saveJob[$IValue['id']][0]['location']=split("/", $obj_tmp1->laout_arr['showJob'][0]['location']);
            $obj_tmp1->saveJob[$IValue['id']][0]['jobstatus']=$IValue['status'];
            $obj_tmp1->saveJob[$IValue['id']][0]['jobDate']=$IValue['updateDate'];
            $obj_tmp1->saveJob[$IValue['id']][0]['comment']=$IValue['comment'];

            //cancel notidication
            $jobID=$obj_tmp1->laout_arr['showJob'][0]['id'];
            if(!empty($obj_tmp1->jobNotiS_Intell[$jobID])){
              if($obj_tmp1->jobNotiS_Intell[$jobID]['type']=='JOB_APPLY'){
                //cancel
                $sql_cancelNotiS="UPDATE ".$obj_tmp1->userNotification." SET status='n' WHERE ".$obj_tmp1->userNotification.".memberId='".$userId."' AND ".$obj_tmp1->userNotification.".type='JOB_APPLY' AND ".$obj_tmp1->userNotification.".itemId='".$obj_tmp1->jobNotiS_Intell[$jobID]['id']."'";
                mysql_query($sql_cancelNotiS);
              }else if($obj_tmp1->jobNotiS_Intell[$jobID]['type']=='comment'){
                //cancel
                $sql_cancelNotiS="UPDATE ".$obj_tmp1->userNotification." SET status='n' WHERE ".$obj_tmp1->userNotification.".memberId='".$userId."' AND ".$obj_tmp1->userNotification.".type='comment' AND ".$obj_tmp1->userNotification.".itemId='".$obj_tmp1->jobNotiS_Intell[$jobID]['id']."'";
                mysql_query($sql_cancelNotiS);
              }
            }
        }
        //print_r($obj_tmp1->saveJob);

        //check notification
        $sql_checkNotiS="SELECT COUNT(".$obj_tmp1->userNotification.".id) as COUNT 
                         FROM ".$obj_tmp1->userNotification."
                         WHERE ".$obj_tmp1->userNotification.".memberId='".$userId."'
                         AND ".$obj_tmp1->userNotification.".status='y'";
        $obj_tmp1->laout_arr['checkNotiS']=array();
        $obj_tmp1->basic_select('laout_arr','checkNotiS',$sql_checkNotiS);
            //echo $sql_checkNotiS;
            //print_r($obj_tmp1->laout_arr['checkNotiS']);
        //======================
        $_SESSION['user']['notification']=$obj_tmp1->laout_arr['checkNotiS'][0]['COUNT'];
    }
    //==========================


	  $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/user/autosendCV.html';
    $obj_tmp1->subMenu='content/user/MenujobManage.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	  $obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;

	case "aleadysend":

    //找求職資訊
    $sql_Imanage="SELECT ".$obj_tmp1->memberJM.".*
                  FROM ".$obj_tmp1->memberJM."
                  LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->memberJM.".memberId
                  LEFT JOIN ".$obj_tmp1->jobtable." ON ".$obj_tmp1->jobtable.".id=".$obj_tmp1->memberJM.".jobId
                  LEFT JOIN ".$obj_tmp1->memberCV." ON ".$obj_tmp1->memberCV.".id=".$obj_tmp1->memberJM.".CVId
                  WHERE ".$obj_tmp1->memberJM.".memberId='".$userId."' 
                  AND ".$obj_tmp1->memberJM.".intelligence='n' 
                  AND ".$obj_tmp1->memberJM.".status <> 'collect'
                  AND ".$obj_tmp1->memberJM.".status <> 'access'
                  ORDER BY ".$obj_tmp1->memberJM.".updateDate DESC";
    $obj_tmp1->laout_arr['Imanage']=array();
    $obj_tmp1->basic_select('laout_arr','Imanage',$sql_Imanage);
        //echo $sql_Imanage;
        //print_r($obj_tmp1->laout_arr['Imanage']);
    //==========================

    $obj_tmp1->saveJob=array();

    //找每個求才資訊
    if(!empty($obj_tmp1->laout_arr['Imanage'])){
        foreach($obj_tmp1->laout_arr['Imanage'] as $IKey => $IValue){
            //設定變數儲存
            $obj_tmp1->saveJob[$IValue['id']]=array();

            //開始尋找
            $sql_showJob="SELECT distinct ".$obj_tmp1->jobtable.".*,
                          ".$obj_tmp1->companyTable.".id as companyId,".$obj_tmp1->companyTable.".companyName,".$obj_tmp1->companyTable.".logo,".$obj_tmp1->companyTable.".memberSize
                          FROM ".$obj_tmp1->jobtable."
                          LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->jobtable.".companyId 
                          WHERE ".$obj_tmp1->jobtable.".id='".$IValue['jobId']."' 
                          AND ".$obj_tmp1->jobtable.".status='y'
                          ORDER BY ".$obj_tmp1->jobtable.".updateDate DESC";
                          //LIMIT ".$jobshow_start.",20";
            $obj_tmp1->laout_arr['showJob']=array();
            $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
                //echo $sql_showJob;
                //print_r($obj_tmp1->laout_arr['showJob']);
            //======================

            $obj_tmp1->saveJob[$IValue['id']]=$obj_tmp1->laout_arr['showJob'];
            @$obj_tmp1->saveJob[$IValue['id']][0]['location']=split("/", $obj_tmp1->laout_arr['showJob'][0]['location']);
            $obj_tmp1->saveJob[$IValue['id']][0]['jobstatus']=$IValue['status'];
            $obj_tmp1->saveJob[$IValue['id']][0]['jobDate']=$IValue['updateDate'];
            $obj_tmp1->saveJob[$IValue['id']][0]['comment']=$IValue['comment'];

            //cancel notidication
            $jobID=$obj_tmp1->laout_arr['showJob'][0]['id'];
            if(!empty($obj_tmp1->jobNotiS_NIntell[$jobID])){
              if($obj_tmp1->jobNotiS_NIntell[$jobID]['type']=='JOB_APPLY'){
                //cancel
                $sql_cancelNotiS="UPDATE ".$obj_tmp1->userNotification." SET status='n' WHERE ".$obj_tmp1->userNotification.".memberId='".$userId."' AND ".$obj_tmp1->userNotification.".type='JOB_APPLY' AND ".$obj_tmp1->userNotification.".itemId='".$obj_tmp1->jobNotiS_NIntell[$jobID]['id']."'";
                mysql_query($sql_cancelNotiS);
              }else if($obj_tmp1->jobNotiS_NIntell[$jobID]['type']=='comment'){
                //cancel
                $sql_cancelNotiS="UPDATE ".$obj_tmp1->userNotification." SET status='n' WHERE ".$obj_tmp1->userNotification.".memberId='".$userId."' AND ".$obj_tmp1->userNotification.".type='comment' AND ".$obj_tmp1->userNotification.".itemId='".$obj_tmp1->jobNotiS_NIntell[$jobID]['id']."'";
                mysql_query($sql_cancelNotiS);
              }
            }
        }
        //print_r($obj_tmp1->saveJob);

        //check notification
        $sql_checkNotiS="SELECT COUNT(".$obj_tmp1->userNotification.".id) as COUNT 
                         FROM ".$obj_tmp1->userNotification."
                         WHERE ".$obj_tmp1->userNotification.".memberId='".$userId."'
                         AND ".$obj_tmp1->userNotification.".status='y'";
        $obj_tmp1->laout_arr['checkNotiS']=array();
        $obj_tmp1->basic_select('laout_arr','checkNotiS',$sql_checkNotiS);
            //echo $sql_checkNotiS;
            //print_r($obj_tmp1->laout_arr['checkNotiS']);
        //======================
        $_SESSION['user']['notification']=$obj_tmp1->laout_arr['checkNotiS'][0]['COUNT'];
    }
    //==========================


    //echo $obj_tmp1->encode("1"),"<BR>";
    //echo $obj_tmp1->decode($obj_tmp1->encode("1"));


	  $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/user/aleadysend.html';
    $obj_tmp1->subMenu='content/user/MenujobManage.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	  $obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;

    case "aleadylove":

    //找求職資訊
    $sql_Imanage="SELECT ".$obj_tmp1->memberJM.".*
                  FROM ".$obj_tmp1->memberJM."
                  LEFT JOIN ".$obj_tmp1->member." ON ".$obj_tmp1->member.".id=".$obj_tmp1->memberJM.".memberId
                  LEFT JOIN ".$obj_tmp1->jobtable." ON ".$obj_tmp1->jobtable.".id=".$obj_tmp1->memberJM.".jobId
                  LEFT JOIN ".$obj_tmp1->memberCV." ON ".$obj_tmp1->memberCV.".id=".$obj_tmp1->memberJM.".CVId
                  WHERE ".$obj_tmp1->memberJM.".memberId='".$userId."' 
                  AND ".$obj_tmp1->memberJM.".status='collect'
                  ORDER BY ".$obj_tmp1->memberJM.".updateDate DESC";
    $obj_tmp1->laout_arr['Imanage']=array();
    $obj_tmp1->basic_select('laout_arr','Imanage',$sql_Imanage);
        //echo $sql_Imanage;
        //print_r($obj_tmp1->laout_arr['Imanage']);
    //==========================

    $obj_tmp1->saveJob=array();

    //找每個求才資訊
    if(!empty($obj_tmp1->laout_arr['Imanage'])){
        foreach($obj_tmp1->laout_arr['Imanage'] as $IKey => $IValue){
            //設定變數儲存
            $obj_tmp1->saveJob[$IValue['id']]=array();

            //開始尋找
            $sql_showJob="SELECT distinct ".$obj_tmp1->jobtable.".*,
                          ".$obj_tmp1->companyTable.".id as companyId,".$obj_tmp1->companyTable.".companyName,".$obj_tmp1->companyTable.".logo,".$obj_tmp1->companyTable.".memberSize
                          FROM ".$obj_tmp1->jobtable."
                          LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->jobtable.".companyId 
                          WHERE ".$obj_tmp1->jobtable.".id='".$IValue['jobId']."' 
                          AND ".$obj_tmp1->jobtable.".status='y'
                          ORDER BY ".$obj_tmp1->jobtable.".updateDate DESC";
                          //LIMIT ".$jobshow_start.",20";
            $obj_tmp1->laout_arr['showJob']=array();
            $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
                //echo $sql_showJob;
                //print_r($obj_tmp1->laout_arr['showJob']);
            //======================

            $obj_tmp1->saveJob[$IValue['id']]=$obj_tmp1->laout_arr['showJob'];
            $obj_tmp1->saveJob[$IValue['id']][0]['location']=split("/", $obj_tmp1->laout_arr['showJob'][0]['location']);
            $obj_tmp1->saveJob[$IValue['id']][0]['jobstatus']=$IValue['status'];
            $obj_tmp1->saveJob[$IValue['id']][0]['jobDate']=$IValue['updateDate'];
            $obj_tmp1->saveJob[$IValue['id']][0]['comment']=$IValue['comment'];
        }
        //print_r($obj_tmp1->saveJob);
    }
    //==========================


    //echo $obj_tmp1->encode("1"),"<BR>";
    //echo $obj_tmp1->decode($obj_tmp1->encode("1"));


    $obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/user/aleadylove.html';
    $obj_tmp1->subMenu='content/user/MenujobManage.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
    $obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

    break;

	default:

	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/404.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;
}


?>