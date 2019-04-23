<?php
return array(
	'SESSION_AUTO_START' =>false, // 是否自动开启Session
	'ORDER_STATUS' => array(
		0=>'<i class="statis-0">待支付</i>',
		1=>'<i class="statis-1">已付款</i>',
		2=>'<i class="statis-2">確認</i>',
		3=>'<i class="statis-3">發貨</i>',
		4=>'<i class="statis-4">簽收</i>',
		5=>'<i class="statis-5">拒收</i>',
		6=>'<i class="statis-6">關閉</i>',
	), 
	'PAYMENT' => array(
		1=>array('name'=>'貨到付款','info'=>''),
		2=>array('name'=>'支付寶','info'=>''),
		3=>array('name'=>'微信支付','info'=>''),
		4=>array('name'=>'支付寶擔保交易','info'=>''),
		5=>array('name'=>'二維碼支付','info'=>''),
		6=>array('name'=>'銀行匯款','info'=>''),
	), 
	'TEMPLATE_OPTIONS'=>array(
		'price'=>array('name'=>'訂單價格','request'=>false, 'checked'=>true),
		'salenum'=>array('name'=>'已售數量','request'=>false,'checked'=>false),
		'quantity'=>array('name'=>'訂購數量','request'=>true,'checked'=>true),
		'datetime'=>array('name'=>'選擇時間','request'=>true,'info'=>'請選擇時間', 'checked'=>true),
		'name'=>array('name'=>'真實姓名','request'=>true,'info'=>'輸入您的姓名或稱呼','checked'=>true),
		'mobile'=>array('name'=>'手機號碼','request'=>true,'info'=>'輸入您的手機號碼','checked'=>true),
		'phone'=>array('name'=>'聯系電話','request'=>false,'info'=>'輸入您的聯系電話','checked'=>true),
		'region'=>array('name'=>'選擇地區','request'=>true,'checked'=>true),
		'address'=>array('name'=>'詳細地址','request'=>true,'info'=>'請填寫您的詳細地址','checked'=>true),
		'zcode'=>array('name'=>'郵政編碼','request'=>false,'info'=>'請填寫郵政編碼','checked'=>false),
		'qq'=>array('name'=>'QQ 號碼','request'=>true,'info'=>'請填寫QQ 號碼','checked'=>false),
		'mail'=>array('name'=>'電子郵箱','request'=>true,'info'=>'請填寫您常用的電子郵箱','checked'=>false),
		'remark'=>array('name'=>'留言備註','request'=>false,'info'=>'如果有額外需求請留言','checked'=>true),
		'verify'=>array('name'=>'驗 證 碼','request'=>true,'info'=>'請填寫驗證碼','checked'=>true),
		'payment'=>array('name'=>'支付方式','request'=>true, 'checked'=>true),
	),
);
?>