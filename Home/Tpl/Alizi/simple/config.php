<?php
return array(
	'name'=>'简洁模板',
	'options'=>array(
		'price'=>array('name'=>'价格','request'=>false, 'checked'=>true),
		'salenum'=>array('name'=>'已售数量','request'=>false,'checked'=>false),
		'quantity'=>array('name'=>'订购数量','request'=>true,'checked'=>true),
		'datetime'=>array('name'=>'选择时间','request'=>true,'info'=>'请选择时间', 'checked'=>true),
		'name'=>array('name'=>'真实姓名','request'=>true,'info'=>'收货人姓名','checked'=>true),
		'mobile'=>array('name'=>'手机号码','request'=>true,'info'=>'联系手机','checked'=>true),
		'phone'=>array('name'=>'联系电话','request'=>false,'info'=>'输入您的联系电话','checked'=>true),
		'region'=>array('name'=>'选择地区','request'=>true,'checked'=>true),
		'address'=>array('name'=>'详细地址','request'=>true,'info'=>'详细地址 (重要) 请填写详细地址如街道门牌信息','checked'=>true),
		'zcode'=>array('name'=>'邮政编码','request'=>false,'info'=>'请填写邮政编码','checked'=>false),
		'qq'=>array('name'=>'QQ 号码','request'=>true,'info'=>'请填写QQ 号码','checked'=>false),
		'mail'=>array('name'=>'电子邮箱','request'=>true,'info'=>'请填写您常用的电子邮箱','checked'=>false),
		'remark'=>array('name'=>'留言备注','request'=>false,'info'=>'如果有额外需求请留言','checked'=>true),
		'verify'=>array('name'=>'验 证 码','request'=>true,'info'=>'请填写验证码','checked'=>true),
		'payment'=>array('name'=>'支付方式','request'=>true, 'checked'=>true),
	),
	'template'=>array(
		'template'=>'simple', 
		'default_color'=>array('body_bg'=>'CCCCCC','form_bg'=>'FFFFFF','title_bg'=>'FFFFFF','button_bg'=>'EE3300','font'=>'333333','border'=>'CC9900','nav_bg'=>'EE3300')
	),
	'verify'=>array(
		'height'=>50,
	),
);
