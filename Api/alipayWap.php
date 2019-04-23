<?php
require 'aliziApi.php';
payLog($_POST,'alipayWap');
echo http( getNotifyUrl('alipayWap'), 'POST',$_POST );
?>