<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->companyFin="taolou_company_finance";

$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberCV='taolou_member_cv';
$obj_tmp1->memberJM="taolou_member_jobmanage";
//resume check
$obj_tmp1->memberExp='taolou_member_experience';
$obj_tmp1->memberedu='taolou_member_education';
$obj_tmp1->memberSkill="taolou_member_specialskill";
//============
$obj_tmp1->tmp_where="";

$obj_tmp1->page="0";
$obj_tmp1->max_page="0";
if(@laout_check($_REQUEST['page'])==''){@$obj_tmp1->page='1';}
else {$obj_tmp1->page=laout_check($_REQUEST['page']);}
$jobshow_start=($obj_tmp1->page-1)*20;

@$obj_tmp1->tmp_jobsId="";
@$obj_tmp1->tmp_comanyId="";

$obj_tmp1->applyJob=true;
$obj_tmp1->applyJobYet=false;
$obj_tmp1->collectYet=false;
$obj_tmp1->mailValid=false;

$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//讀取職缺的資訊
if(@$_REQUEST["jobsid"] != ""){
	@$obj_tmp1->tmp_jobsId = $obj_tmp1->decode(laout_check($_REQUEST["jobsid"]));
}
//decode company id
if(@$_SESSION['user']['id']!= ""){
	if(@$_SESSION['user']['userType']=='1'){
		if(@$_SESSION['user']['mailValid']=='y'){
			$obj_tmp1->applyJob=true;
			$obj_tmp1->mailValid=true;
		}
	}else if(@$_SESSION['user']['userType']=='2'){$obj_tmp1->applyJob=false;}
	$userId=$_SESSION['user']['id'];
}else{}

if(@$obj_tmp1->tmp_jobsId != ""){@$action="showJob";}
else{@$action='jobList';}
//==================


switch($action){

	case"showJob":

	$sql_showJob="SELECT ".$obj_tmp1->jobtable.".*
				  FROM ".$obj_tmp1->jobtable."
				  WHERE ".$obj_tmp1->jobtable.".id='".$obj_tmp1->tmp_jobsId."'";
	$obj_tmp1->laout_arr['showJob']=array();
	$obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
		//echo $sql_showJob;
		//print_r($obj_tmp1->laout_arr['showJob']);
	//===========================

	if(!empty($obj_tmp1->laout_arr['showJob'])){
		//顯示公司
		$sql_company="SELECT ".$obj_tmp1->companyTable.".*
					  FROM ".$obj_tmp1->companyTable."
					  WHERE ".$obj_tmp1->companyTable.".id='".$obj_tmp1->laout_arr['showJob'][0]['companyId']."'";
		$obj_tmp1->laout_arr['company']=array();
		$obj_tmp1->basic_select('laout_arr','company',$sql_company);
		//echo $sql_company;
		//print_r($obj_tmp1->laout_arr['company']);

			//顯示公司地址
		$obj_tmp1->ComLoca=split("/",$obj_tmp1->laout_arr['company'][0]['location']);
			//顯示融資狀況
		$sql_financeInfo="SELECT ".$obj_tmp1->companyFin.".*
	                      FROM ".$obj_tmp1->companyFin."
	                      WHERE ".$obj_tmp1->companyFin.".companyId='".$obj_tmp1->laout_arr['showJob'][0]['companyId']."'
	                      ORDER BY ".$obj_tmp1->companyFin.".createDate DESC
	                      LIMIT 0,1";
	    $obj_tmp1->laout_arr['finInfo']=array();
	    $obj_tmp1->basic_select('laout_arr','finInfo',$sql_financeInfo);
	        //echo $sql_financeInfo;
	        //print_r($obj_tmp1->laout_arr['finInfo']);

	//===========================

		//顯示職缺地址
		$obj_tmp1->JobLoca=split("/",$obj_tmp1->laout_arr['showJob'][0]['location']);
		
		//顯示刊登職位人
		$sql_postMan="SELECT ".$obj_tmp1->member.".*
					  FROM ".$obj_tmp1->member."
					  WHERE ".$obj_tmp1->member.".id='".$obj_tmp1->laout_arr['showJob'][0]['postMemberId']."'";
		$obj_tmp1->laout_arr['postMan']=array();
		$obj_tmp1->basic_select('laout_arr','postMan',$sql_postMan);
		//echo $sql_postMan;
		//print_r($obj_tmp1->laout_arr['postMan']);
	//===========================
	
	}

	
	if(@$userId != "" && $obj_tmp1->applyJob==true){
		//讀取使用者的履歷
		$sql_CV="SELECT ".$obj_tmp1->memberCV.".*
				 FROM ".$obj_tmp1->memberCV."
				 WHERE ".$obj_tmp1->memberCV.".memberId='".$userId."'
				 AND ".$obj_tmp1->memberCV.".status='y'";
		$obj_tmp1->laout_arr['CV']=array();
		$obj_tmp1->basic_select('laout_arr','CV',$sql_CV);
			//echo $sql_CV;
			//print_r($obj_tmp1->laout_arr['CV']);
		//=========================

		//確認使用者的線上履歷是否完整
			//init 不完整
			$obj_tmp1->resumeComplete=true;
		$sql_resumeCheck="SELECT ".$obj_tmp1->memberExp.".id as EXP ,".$obj_tmp1->memberedu.".id as EDU, ".$obj_tmp1->memberSkill.".id as SKILL
						  FROM ".$obj_tmp1->memberExp.", ".$obj_tmp1->memberedu.", ".$obj_tmp1->memberSkill."
						  WHERE ".$obj_tmp1->memberExp.".memberId='".$userId."'
						  AND ".$obj_tmp1->memberedu.".memberId='".$userId."'
						  AND ".$obj_tmp1->memberSkill.".memberId='".$userId."'
						  LIMIT 0,1";
		$obj_tmp1->laout_arr['resumeCheck']=array();
		$obj_tmp1->basic_select('laout_arr','resumeCheck',$sql_resumeCheck);
			//echo $sql_resumeCheck;
			//print_r($obj_tmp1->laout_arr['resumeCheck']);
		if(!empty($obj_tmp1->laout_arr['resumeCheck'])){
			foreach($obj_tmp1->laout_arr['resumeCheck'] as $key => $value){
				if($value['EXP']==""){$obj_tmp1->resumeComplete=false;continue;}
				if($value['EDU']==""){$obj_tmp1->resumeComplete=false;continue;}
				if($value['SKILL']==""){$obj_tmp1->resumeComplete=false;continue;}
			}
		}else{$obj_tmp1->resumeComplete=false;}
		//=========================

		//確認使用者投過獲收藏的履歷
		$sql_checkApply="SELECT ".$obj_tmp1->memberJM.".*
						 FROM ".$obj_tmp1->memberJM."
						 WHERE ".$obj_tmp1->memberJM.".memberid='".$userId."'
						 AND ".$obj_tmp1->memberJM.".jobId='".$obj_tmp1->tmp_jobsId."'";
		$obj_tmp1->laout_arr['checkApply']=array();
		$obj_tmp1->basic_select('laout_arr','checkApply',$sql_checkApply);
			//echo $sql_checkApply;
			//print_r($obj_tmp1->laout_arr['checkApply']);
		//=========================
		if(!empty($obj_tmp1->laout_arr['checkApply'])){
			//被拒絕也不給下一次應徵的機會
			if($obj_tmp1->laout_arr['checkApply'][0]['status'] != "collect"){$obj_tmp1->applyJobYet=true;}
			else{$obj_tmp1->collectYet=true;}
		}
	}

	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/showJob.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;
	
	case"jobList":


	//職位列表
	//init
	$select="";
	if(@$_GET['city']!=""){
		$city=laout_check($_GET['city']);
		if(@$_GET['city']=="全部"){$city="";}
		$select=$select."AND ".$obj_tmp1->jobtable.".location LIKE '%".$city."%' ";
	}
	if(@$_GET['jobtype']!=""){
		$jobtype=laout_check($_GET['jobtype']);
		if(@$_GET['jobtype']=="全部"){$jobtype="";}
		$select=$select."AND ".$obj_tmp1->jobtable.".jobNature LIKE '%".$jobtype."%' ";
	}
	if(@$_GET['salary']!=""){//%5B + low + %2C+ High +%5D
		$salary=laout_check($_GET['salary']);
		//print_r($salary);
		$show=split('[,]',$salary);
		$low=split('[[]',$show[0]);
		$high=split(']', $show[1]);
		//print_r($low[1].$high[0]);
		if($low[1]!="" && $high[0]!=""){
			$select=$select."AND ".$obj_tmp1->jobtable.".salary >= ".$low[1]." AND ".$obj_tmp1->jobtable.".salary <= ".$high[0]."";
		}else if($low[1]=="" && $high[0]!=""){
			$select=$select."AND ".$obj_tmp1->jobtable.".salary <= ".$high[0]."";
		}else if($low[1]!="" && $high[0]==""){
			$select=$select."AND ".$obj_tmp1->jobtable.".salary >= ".$low[1]."";
		}else{}
	}
	if(@$_GET['rank']!=""){
		$rank=laout_check($_GET['rank']);
		//$select=$select."AND ".$obj_tmp1->jobtable.".jobNature LIKE '%".$jobtype."%' ";
	}

	//==篩選器
	if($select){
		$obj_tmp1->tmp_where=$select;
	}else{$obj_tmp1->tmp_where="";}

		//==========================

		//職位顯示
	$sql_showJob="SELECT distinct ".$obj_tmp1->jobtable.".*,
				  ".$obj_tmp1->companyTable.".companyName,".$obj_tmp1->companyTable.".logo,".$obj_tmp1->companyTable.".memberSize
				  FROM ".$obj_tmp1->jobtable."
				  LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->jobtable.".companyId 
				  WHERE ".$obj_tmp1->jobtable.".status='y' ".$obj_tmp1->tmp_where." 
				  ORDER BY ".$obj_tmp1->jobtable.".createDate
				  LIMIT ".$jobshow_start.",20";
    $obj_tmp1->laout_arr['showJob']=array();
    $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
    	//echo $sql_showJob;
		//print_r($obj_tmp1->laout_arr['showJob']);

    	//職位地點設定
    	$obj_tmp1->jobLoca=array();
    	if(!empty($obj_tmp1->laout_arr['showJob'])){
	    	foreach($obj_tmp1->laout_arr['showJob'] as $key => $value){
	    		$obj_tmp1->jobLoca[$value['id']]=split("/",$value['location']);
	    	}
	    	//print_r($obj_tmp1->jobLoca);
	    }
    	//=========================
    	
    	//公司技能標籤
    /*$sql_comSkill="SELECT ".$obj_tmp1->companySkill.".*
				   FROM ".$obj_tmp1->companySkill."
				   LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companySkill.".companyId=".$obj_tmp1->companyTable.".id
				   WHERE ".$obj_tmp1->companySkill.".companyId=".$obj_tmp1->jobtable.".companyId";
	$obj_tmp1->laout_arr['comskill']=array();
	$obj_tmp1->basic_select('laout_arr','comskill',$sql_comSkill);*/
		//echo $sql_comSkill;
		//print_r($obj_tmp1->laout_arr['showJob']);
	   //===========================

		//分頁設定
	$sql_count="SELECT COUNT(".$obj_tmp1->jobtable.".id) as COUNT
				FROM ".$obj_tmp1->jobtable."
				LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->jobtable.".companyId 
				".$obj_tmp1->tmp_where."";
	$obj_tmp1->laout_arr['jobcount']=array();
    $obj_tmp1->basic_select('laout_arr','jobcount',$sql_count);
    	
    @$obj_tmp1->max_page=ceil($obj_tmp1->laout_arr['jobcount'][0]['COUNT']/20);
    	//echo $obj_tmp1->max_page;
		//==========================


    //echo $obj_tmp1->encode("1"),"<BR>";
    //echo $obj_tmp1->decode($obj_tmp1->encode("1"));


	$obj_tmp1->showad=false;
    $obj_tmp1->content_html='content/jobList.html';

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