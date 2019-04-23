<?php
require 'aliziApi.php';
$url = "http://{$_SERVER['HTTP_HOST']}".substr(dirname($_SERVER['SCRIPT_NAME']), 0,-3)."index.php?m=Order&a=payWxPayJsApi&code={$_GET['code']}&state={$_GET['state']}";
Header("Location: $url");
?>