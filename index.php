<?php

define('APP_DEBUG',true);//调式模式
ob_start('ob_gzhandler');
define( 'RUNTIME_PATH' , './Public/Cache/Home/' );
define( 'COMMON_PATH' , './Public/Common/' );
define('ALIZI_VERSION','Alizi-V2.4.2-A');
define('APP_NAME','Home');
define('APP_PATH','./Home/');
require 'Public/ThinkPHP/ThinkPHP.php';
?>