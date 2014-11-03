<?php
include_once 'share.php';

//page default
$obj_tmp1->table_name="taolou_job";
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->tmp_where="";
$obj_tmp1->tmp_comanyId;
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';


//==========================================

switch($action){
	default:
	//合作的公司，頁面左邊banner
	$sql_partner="SELECT ".$obj_tmp1->companyTable.".companyName FROM company
				  WHERE ".$obj_tmp1->companyTable.".recommendation='y'";

	$obj_tmp1->basic_select('laout_arr','partner',$sql_partner);
	//==========================

	//職位列表
		//==篩選器
	$obj_tmp1->tmp_where="";

		//==========================

		//職位顯示
	$obj_tmp1->showJob="SELECT ".$obj_tmp1->table_name.".* FROM job
						LEFT JOIN ".$obj_tmp1->companyTable." ON ".$obj_tmp1->companyTable.".id=".$obj_tmp1->companyTable.".companyId 
						WHERE ".$obj_tmp1->tmp_where".";
	$sql_rank = "SELECT carry_hotline.*,carry_company.*
				 FROM carry_hotline
             LEFT JOIN carry_company ON carry_company.id=carry_hotline.company_id
             WHERE carry_hotline.rank BETWEEN 1 AND 31
             AND carry_hotline.start_up='y'
             AND carry_hotline.year='$obj_tmp1->nowYear'
             ORDER BY carry_hotline.rank ASC";
    $obj_tmp1->basic_select('laout_arr','rankhotline1_21',$sql_rank);

    $sql_rank = "SELECT carry_hotline.*,carry_company.*
                 FROM carry_hotline
                 LEFT JOIN carry_company ON carry_company.id=carry_hotline.company_id
                 WHERE carry_hotline.rank BETWEEN 32 AND 61
                 AND carry_hotline.start_up='y'
                 AND carry_hotline.year='$obj_tmp1->nowYear'
                 ORDER BY carry_hotline.rank ASC";
    $obj_tmp1->basic_select('laout_arr','rankhotline22_44',$sql_rank);

    $sql_rank = "SELECT carry_hotline.*,carry_company.*
                 FROM carry_hotline
                 LEFT JOIN carry_company ON carry_company.id=carry_hotline.company_id
                 WHERE carry_hotline.rank BETWEEN 62 AND 93
                 AND carry_hotline.start_up='y'
                 AND carry_hotline.year='$obj_tmp1->nowYear'
                 ORDER BY carry_hotline.rank ASC";
    $obj_tmp1->basic_select('laout_arr','rankhotline45_66',$sql_rank);


    //echo $obj_tmp1->encode("1"),"<BR>";
    //echo $obj_tmp1->decode($obj_tmp1->encode("1"));
    $obj_tmp1->top_htm="top.html";
	$obj_tmp1->onloadFun='top'.$obj_tmp1->rankAll.'()';
    $obj_tmp1->content_htm='content/index.html';
    $obj_tmp1->laout('templates.html');


	break;
}


?>