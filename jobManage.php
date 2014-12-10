<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberCV='taolou_member_cv';
$obj_tmp1->memberJM="taolou_member_jobmanage";

$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';


//確認使用者是誰
if(@laout_check($_GET['action']) != ""){$getAction=laout_check($_GET['action']);}else{$getAction="";}
if(@$_SESSION['user']['id']!= ""){$userId=$_SESSION['user']['id'];}else{@$action='none';}
if(@$_SESSION['user']['userType'] != "" && @$getAction==""){
    if(@$_SESSION['user']['userType'] == '1'){$action='autosendCV';}
    else if(@$_SESSION['user']['userType'] == '2'){$action='none';}
    else{$action='none';}
}else{$action=laout_check($_GET['action']);}
//===================


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
                  AND ".$obj_tmp1->memberJM.".status <> 'collect'";
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
                          ".$obj_tmp1->companyTable.".companyName,".$obj_tmp1->companyTable.".logo,".$obj_tmp1->companyTable.".memberSize
                          FROM ".$obj_tmp1->jobtable."
                          LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->jobtable.".companyId 
                          WHERE ".$obj_tmp1->jobtable.".id='".$IValue['jobId']."' 
                          AND ".$obj_tmp1->jobtable.".status='y'
                          ORDER BY ".$obj_tmp1->jobtable.".createDate ";
                          //LIMIT ".$jobshow_start.",20";
            $obj_tmp1->laout_arr['showJob']=array();
            $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
                //echo $sql_showJob;
                //print_r($obj_tmp1->laout_arr['showJob']);
            //======================

            $obj_tmp1->saveJob[$IValue['id']]=$obj_tmp1->laout_arr['showJob'];
        }
        //print_r($obj_tmp1->saveJob);
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