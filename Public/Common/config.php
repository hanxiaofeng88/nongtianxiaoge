<?php
$config= array(
	'URL_MODEL' => 0,
	'ALIZI_VERSION' => 'Alizi-V2.4.3',
	'SHOW_PAGE_TRACE'     => false, // 调式跟踪信息
	'DATA_CACHE_PATH'     => './Public/Cache/', 
	'TOKEN_ON'=>false,  // 是否开启令牌验证
	'TOKEN_RESET'=>true,  //令牌验证出错后是否重置令牌 默认为true
	'TOKEN_NAME'=>'__hash__',
	'TOKEN_TYPE'=>'md5', 
	'ALIZI_API'=>'http://api.5hi.cn',
	'LANG_AUTO_DETECT'=>false,
	'DEFAULT_LANG'=>'zh-cn',

	'DEFAULT_AJAX_RETURN' => 'json', 
	'TMPL_ACTION_ERROR'   => 'Public/success.html', 
    	'TMPL_ACTION_SUCCESS' => 'Public/success.html', 
	'ROOT_FILE'   => '/',
	'ALIZI_TEMPLATE'=>array(
		'thin'=>array('name'=>'紧凑模板'),
		'alizi'=>array('name'=>'经典模板'),
	),
	'ORDER_STATUS' => array(
		0=>'<i class="statis-0">待支付</i>',
		1=>'<i class="statis-1">已付款</i>',
		2=>'<i class="statis-2">确认</i>',
		3=>'<i class="statis-3">发货</i>',
		4=>'<i class="statis-4">签收</i>',
		5=>'<i class="statis-5">拒收</i>',
		6=>'<i class="statis-6">关闭</i>',
		7=>'<i class="statis-7">完结</i>',
		//8=>'<i class="statis-8">申请退款</i>',
		//9=>'<i class="statis-9">已退款</i>',
	),
	'PAYMENT' => array(
		1=>array('name'=>'货到付款','info'=>''),
		2=>array('name'=>'支付宝','info'=>''),
		3=>array('name'=>'微信支付','info'=>''),
		4=>array('name'=>'担保交易','info'=>''),
		5=>array('name'=>'二维码','info'=>''),
		6=>array('name'=>'银行汇款','info'=>''),
	), 
	'TEMPLATE_OPTIONS'=>array(
		'salenum'=>array('name'=>'已售数量','request'=>false,'checked'=>false),
		'quantity'=>array('name'=>'订购数量','request'=>true,'checked'=>true),
		'price'=>array('name'=>'订单价格','request'=>false, 'checked'=>true),
		'datetime'=>array('name'=>'选择时间','request'=>true,'info'=>'请选择时间', 'checked'=>true),
		'name'=>array('name'=>'真实姓名','request'=>true,'info'=>'输入您的姓名或称呼','checked'=>true),
		'mobile'=>array('name'=>'手机号码','request'=>true,'info'=>'输入您的手机号码','checked'=>true),
		'phone'=>array('name'=>'联系电话','request'=>false,'info'=>'输入您的联系电话','checked'=>true),
		'region'=>array('name'=>'选择地区','request'=>true,'checked'=>true),
		'address'=>array('name'=>'详细地址','request'=>true,'info'=>'请填写您的详细地址','checked'=>true),
		'zcode'=>array('name'=>'邮政编码','request'=>false,'info'=>'请填写邮政编码','checked'=>false),
		'qq'=>array('name'=>'QQ 号码','request'=>true,'info'=>'请填写QQ 号码','checked'=>false),
		'mail'=>array('name'=>'电子邮箱','request'=>true,'info'=>'请填写您常用的电子邮箱','checked'=>false),
		'remark'=>array('name'=>'留言备注','request'=>false,'info'=>' 如备用电话、商品数量、收货时间等，额外需求请留言','checked'=>true),
		'verify'=>array('name'=>'验 证 码','request'=>true,'info'=>'请填写验证码','checked'=>true),
		'payment'=>array('name'=>'支付方式','request'=>true, 'checked'=>true),
	),
	'DEFAULT_COLOR'=>array(
		'body_bg'=>'F1F1F1','form_bg'=>'FFFFFF','title_bg'=>'666666','button_bg'=>'EE3300','font'=>'333333','border'=>'666666','nav_bg'=>'EE3300'
	),
	'ALIZI_ROUTE' => true,
	'ROUTE_RULES' => array(
		'Index'=>array(
			'a'=>':a.html',
			'order'=>array('id'=>'id/:id.html',),
			'category'=>array('id'=>'category-:id.html',),
			'article'=>array('id'=>'article-:id.html',),
			'detail'=>array('id'=>'detail-:id.html',),
			'result'=>array('order_no'=>'result/:order_no.html',),
			'pay'=>array('order_no'=>'pay-:order_no.html',),
		),
	),
	
);

$db = file_exists("./Public/Common/alizi.db.php")?include("alizi.db.php"):array();
$express = include("alizi.express.php");
$setting = include("alizi.setting.php");
$auth = include("alizi.auth.php");
return array_merge($config,$db,$express,$setting,$auth);
?>