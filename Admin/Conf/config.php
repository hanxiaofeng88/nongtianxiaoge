<?php
$config = include("Public/Common/config.php");
$config['TOKEN_ON'] = false;  // 是否开启令牌验证
$config['URL_MODEL']       = 0;
$config['URL_HTML_SUFFIX'] = '';    // 静态后缀
return $config;
?>