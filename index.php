<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';



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
	$obj_tmp1->tmp_where="";

		//==========================

		//職位顯示
	$sql_showJob="SELECT ".$obj_tmp1->jobtable.".* 
				  FROM ".$obj_tmp1->jobtable."
				  LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->companyTable.".companyId 
				  ".$obj_tmp1->tmp_where;
    $obj_tmp1->basic_select('laout_arr','showJob',$sql_showJob);
	   //===========================


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