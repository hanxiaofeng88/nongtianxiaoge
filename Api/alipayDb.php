<?php
require 'aliziApi.php';
payLog($_POST,'alipayDb');
echo http( getNotifyUrl('alipayDb'), 'POST',$_POST );
?>