<?php
$order['item_extends'] = json_decode($order['item_extends'],true);
$order['add_time'] = date('Y-m-d H:i:s',$order['add_time']);
foreach($order['item_extends'] as $k=>$v){ 
	$v = is_array($v)?implode('，', $v):$v;
	$item_extends .= "<span>{$k} ：{$v}</span><br>";
}
$aliziSendContent = <<<EOF
<h1 style="margin:20px 0;padding:10px 0;font-size:20px;color:#f60;border-bottom:2px solid #ccc;">下单通知</h1>
<div>
	<p>【订单编号】{$order['order_no']}</p>
	<p>【产品名称】{$order['item_name']}</p>
	<p>【产品套餐】{$order['item_params']}</p>
	<p>【扩展套餐】{$item_extends}</p>
	<p>【订单总数】{$order['quantity']}</p>
	<p>【订单总价】<b style="color:#f60;">{$order['total_price']}元</b></p>
	<p>【支付方式】{$payment[$order['payment']]['name']}</p>

	<p>【客户姓名】{$order['name']}</p>
	<p>【客户手机】{$order['mobile']}</p>
	<p>【客户电话】{$order['phone']}</p>
	<p>【客户地址】{$order['region']} {$order['address']}</p>
	<p>【邮政编码】{$order['zcode']}</p>
	<p>【客户QQ】{$order['qq']}</p>
	<p>【客户邮箱】{$order['mail']}</p>
	<p>【下单备注】{$order['remark']}</p>

	<p>【下单时间】{$order['add_time']}</p>
	<p>【下单IP】{$order['add_ip']}</p>
	<p>【下单地址】{$order['url']}</p>
</div>
EOF;
return $aliziSendContent;
?>