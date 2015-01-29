<?php
session_start();

define('APP_PATH', str_replace('\\', '/', substr(dirname(__FILE__),0,strlen(dirname(__FILE__))-8 )));
define('WEB_PATH',"http://".$_SERVER['SERVER_NAME']."/");

include_once APP_PATH.'/include/db_config.php';
include_once APP_PATH.'/include/config.php';

//pubic func  
include_once APP_PATH.'/include/function/pubilc_fun.php';
//end pubic func

include_once APP_PATH.'/include/function/db_fun.php';
include_once APP_PATH.'/Class/basic/basic_class.php';

?>