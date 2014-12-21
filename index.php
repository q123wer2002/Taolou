<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->companySkill='taolou_company_skill';
$obj_tmp1->tmp_where="";
$obj_tmp1->page="0";
$obj_tmp1->max_page="0";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//分頁顯示設定
if(@laout_check($_REQUEST['page'])==''){@$obj_tmp1->page='1';}
else {$obj_tmp1->page=laout_check($_REQUEST['page']);}
$jobshow_start=($obj_tmp1->page-1)*20;
//=============

switch($action){
	default:
	//合作的公司，頁面左邊banner
	$sql_partner="SELECT ".$obj_tmp1->companyTable.".* 
				  FROM ".$obj_tmp1->companyTable."
				  WHERE ".$obj_tmp1->companyTable.".recommendation='y'
				  ORDER BY ".$obj_tmp1->companyTable.".id
				  LIMIT 10;";
	$obj_tmp1->laout_arr['partner']=array();
	$obj_tmp1->basic_select('laout_arr','partner',$sql_partner);
		//echo $sql_partner;
		//print_r($obj_tmp1->laout_arr['partner']);
	//==========================

	//職位列表
		//==篩選器
	$obj_tmp1->tmp_where=" WHERE ".$obj_tmp1->jobtable.".status='y'";

		//==========================

		//職位顯示
	$sql_showJob="SELECT distinct ".$obj_tmp1->jobtable.".*,
				  ".$obj_tmp1->companyTable.".companyName,".$obj_tmp1->companyTable.".logo,".$obj_tmp1->companyTable.".memberSize
				  FROM ".$obj_tmp1->jobtable."
				  LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->jobtable.".companyId 
				  ".$obj_tmp1->tmp_where."
				  ORDER BY ".$obj_tmp1->jobtable.".createDate
				  LIMIT ".$jobshow_start.",20";
    $obj_tmp1->laout_arr['showJob']=array();
    $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
    	//echo $sql_showJob;
		//print_r($obj_tmp1->laout_arr['showJob']);

    	//職位地點設定
    	if(!empty($obj_tmp1->laout_arr['showJob'])){
	    	foreach($obj_tmp1->laout_arr['showJob'] as $key => $value){
	    		$obj_tmp1->jobLoca=split("/",$value['location']);
	    		//print_r($jobLoca);
	    	}
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


	$obj_tmp1->showad=true;
    $obj_tmp1->content_html='content/index.html';

    //設定版面
    $obj_tmp1->top_html="top.html";
	$obj_tmp1->showad_html='showad.html';
    $obj_tmp1->footer_html="footer.html";
    $obj_tmp1->laout('templates.html');
//=======================================

	break;
}


?>