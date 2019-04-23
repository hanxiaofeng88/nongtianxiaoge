<?php
require 'aliziApi.php';
payLog($_POST,'alipay');
echo http( getNotifyUrl('alipay'), 'POST',$_POST);
?>