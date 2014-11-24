<?php
include_once 'share.php';

//page default
$obj_tmp1->jobtable="taolou_job";
$obj_tmp1->companyTable="taolou_company";
$obj_tmp1->member='taolou_member_detail';
$obj_tmp1->memberCV='taolou_member_cv';
$obj_tmp1->memberExp='taolou_member_experience';
$obj_tmp1->memberedu='taolou_member_education';
$obj_tmp1->memberwanttjob='taolou_member_wantjob';
$obj_tmp1->tmp_where="";
$obj_tmp1->laout_set=true;
$obj_tmp1->tmp_order ='order By sort Asc';

//確認使用者是誰
$userId='';

$action="";
if(@$_REQUEST['action']!=""){@$action=laout_check($_REQUEST['action']);}
else {@$action='rule';}
//===================


//$action表示跟另外一人的對話

$obj_tmp1->showad=false;
if($action=="rule"){
    $obj_tmp1->content_html='content/user/messageRule.html';
}
else{
    $obj_tmp1->content_html='content/user/message.html';
}
$obj_tmp1->subMenu='content/user/Menumessage.html';

//設定版面
$obj_tmp1->top_html="top.html";
$obj_tmp1->showad_html='showad.html';
$obj_tmp1->footer_html="footer.html";
$obj_tmp1->laout('templates.html');
//=======================================



?>