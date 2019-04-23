<?php
require 'aliziApi.php';
$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
if($xml ){
	$result = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
	payLog($result,'wxPay');
	http( getNotifyUrl('wxPay'), 'POST',$result );
}else{
	payLog('empty','wxPay');
}
?>