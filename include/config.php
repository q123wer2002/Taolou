<?php

define ("PAGE_NAME", basename($_SERVER['PHP_SELF'],'.php'));
date_default_timezone_set("Asia/Taipei");
$tmp_subfix = explode("_", PAGE_NAME);


/*$_SETUP["lang"] = array('tw'=>'繁體中文','cn'=>'简体中文','en'=>'English','jp'=>'Japanese','de'=>'Deutsch');*/
$_SETUP["lang"] = array('tw'=>'繁體中文');

?>
