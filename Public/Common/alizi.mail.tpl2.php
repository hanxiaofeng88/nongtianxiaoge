<?php
$order['item_extends'] = json_decode($order['item_extends'],true);
$order['add_time'] = date('Y-m-d H:i:s',$order['add_time']);
foreach($order['item_extends'] as $k=>$v){ 
	$v = is_array($v)?implode('，', $v):$v;
	$item_extends .= "<span>{$k} ：{$v}</span><br>";
}
$aliziSendContent = <<<EOF
<h1 style="margin:20px 0;padding:10px 0;font-size:20px;color:#f60;border-bottom:2px solid #ccc;">订单确认</h1>
<div>
	<p>【订单编号】{$order['order_no']}</p>
	<p>【产品名称】{$order['item_name']}</p>
	<p>【产品套餐】{$order['item_params']}</p>
	<p>【扩展套餐】{$item_extends}</p>
	<p>【订单总数】{$order['quantity']}</p>
	<p>【订单总价】<b style="color:#f60;">{$order['total_price']}元</b></p>
	<p>【支付方式】{$payment[$order['payment']]['name']}</p>
</div>
EOF;
return $aliziSendContent;
?>