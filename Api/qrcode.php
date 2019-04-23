<?php
//error_reporting(E_ERROR);
require '../Public/ThinkPHP/Extend/Vendor/qrcode/phpqrcode.php';
$data = urldecode($_GET["data"]);
$size = isset($_GET["size"])?intval($_GET["size"]):5;
$margin = isset($_GET["margin"])?intval($_GET["margin"]):4;
QRcode::png($data,false,QR_ECLEVEL_L,$size,$margin);
?>