<?php
return array(
	'setting' => array(
		'basic_info' => array(
			'title'=> array('name'=>'网站标题','tags'=>'text','options'=>'','decription'=>'','width'=>80,'height'=>0,'separator'=>0,),
			'keywords'=> array('name'=>'网站关键词','tags'=>'text','options'=>'','decription'=>'','width'=>80,'height'=>0,'separator'=>0,),
			'logo_pc'=> array('name'=>'PC端Logo','tags'=>'file','options'=>'','decription'=>'','width'=>50,'height'=>0,'separator'=>0,),
			'logo'=> array('name'=>'Wap端Logo','tags'=>'file','options'=>'','decription'=>'','width'=>50,'height'=>0,'separator'=>0,),
			'description'=> array('name'=>'网站描述','options'=>'','tags'=>'textarea','decription'=>'','width'=>65,'height'=>3,'separator'=>0,),
			'footer'=> array('name'=>'网站底部','options'=>'','tags'=>'textarea','decription'=>'','width'=>100,'height'=>6,'separator'=>0,),
			'notice'=> array('name'=>'顶部公告','options'=>'','tags'=>'text','decription'=>'','width'=>95,'height'=>2,'separator'=>1,),
			'contact_tel'=> array('name'=>'固定电话','options'=>'','tags'=>'text','decription'=>'','width'=>30,'height'=>25,'separator'=>0,),
			'contact_phone'=> array('name'=>'手机号码','options'=>'','tags'=>'text','decription'=>'','width'=>30,'height'=>25,'separator'=>0,),
			'contact_qq'=> array('name'=>'联系QQ','options'=>'','tags'=>'text','decription'=>'','width'=>30,'height'=>25,'separator'=>0,),
		),

		'website_setting'=>array(
			'system_status'=> array('name'=>'网站状态','options'=>array('1'=>'运行','2'=>'关闭PC站','3'=>'关闭Wap站','0'=>'关闭整站',),'tags'=>'select','decription'=>'网站关闭后将不显示前台页面，后台可以正常使用','width'=>35,'height'=>0,'separator'=>0,),
			'system_close_info'=> array('name'=>'默认首页','options'=>array('1'=>'运行','0'=>'关闭',),'tags'=>'text','decription'=>'填写【商品编号】则默认该商品为首页，填写网址则跳转，如：http://www.010xr.com','width'=>35,'height'=>0,'separator'=>0,),
			'URL_MODEL'=> array('name'=>'网站运行模式','options'=>array('0'=>'动态模式','2'=>'伪静态模式'),'tags'=>'select','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'theme_color'=> array('name'=>'主题颜色','value'=>'','options'=>'','tags'=>'text','decription'=>'手机版前台主题颜色','width'=>10,'height'=>0,'class'=>' jscolor', 'separator'=>1,),


			'system_template'=> array('name'=>'表单模板','options'=>array('thin'=>'紧凑模板','alizi'=>'经典模板',),'tags'=>'select','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'order_options'=> array('name'=>'表单选项','options'=>array('price'=>'产品价格','salenum'=>'已售数量','quantity'=>'订购数量','payment'=>'支付方式','datetime'=>'选择时间','name'=>'客户姓名','mobile'=>'客户手机','phone'=>'客户电话','region'=>'地区选择','address'=>'详细地址','zcode'=>'邮政编码','qq'=>'QQ 号码','mail'=>'电子邮箱','remark'=>'备注留言','verify'=>'验证号码',),'tags'=>'checkbox','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'show_notice'=> array('name'=>'显示发货通知','options'=>array('0'=>'不显示','1'=>'下方显示','2'=>'右侧显示',),'tags'=>'radio','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'record_order'=> array('name'=>'记录客户信息','options'=>array('0'=>'不记录','1'=>'记录'),'tags'=>'radio','decription'=>'记录则客户再次下单时不需填写信息','width'=>35,'height'=>0,'separator'=>0,),
			'repeat_order'=> array('name'=>'重复订单提交','options'=>array('0'=>'禁止重复提交','1'=>'允许重复提交'),'tags'=>'radio','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'lazyload'=> array('name'=>'图片延迟加载','options'=>array('1'=>'延迟','0'=>'不延迟'),'tags'=>'radio','decription'=>'使用延迟加载可提升网页打开速度','width'=>35,'height'=>0,'separator'=>1,),

			'slider_show'=> array('name'=>'首页幻灯片','value'=>1,'options'=>array('1'=>'显示','0'=>'关闭',),'tags'=>'select','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'slider_num'=> array('name'=>'','value'=>5,'options'=>'','tags'=>'text','decription'=>'条','width'=>5,'height'=>0,'separator'=>0,),
			'item_hot_show'=> array('name'=>'首页新品推荐','value'=>1,'options'=>array('1'=>'显示','0'=>'关闭',),'tags'=>'select','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'item_hot_num'=> array('name'=>'','value'=>5,'options'=>'','tags'=>'text','decription'=>'条','width'=>5,'height'=>0,'separator'=>0,),
			'item_category_show'=> array('name'=>'首页分类展示','value'=>1,'options'=>array('1'=>'显示','0'=>'关闭',),'tags'=>'select','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'item_category_num'=> array('name'=>'','value'=>3,'options'=>'','tags'=>'text','decription'=>'条','width'=>5,'height'=>0,'separator'=>0,),
			'item_category_id'=> array('name'=>'首页分类ID','options'=>'','tags'=>'text','decription'=>'多个ID请用英文逗号分隔开，如：1,2,3','width'=>30,'height'=>0,'separator'=>1,),

			'show_header'=> array('name'=>'显示头部信息','value'=>1,'options'=>array('1'=>'显示','0'=>'关闭',),'tags'=>'select','decription'=>'手机版头部','width'=>35,'height'=>0,'separator'=>0,),
			'show_bottom_nav'=> array('name'=>'显示底部导航','value'=>1,'options'=>array('1'=>'显示','0'=>'关闭',),'tags'=>'select','decription'=>'控制手机版和单页底部导航栏','width'=>35,'height'=>0,'separator'=>0,),
		),

		'payment_setting' => array(
			'payment_global'=> array('name'=>'全站通用','value'=>1,'options'=>array('1'=>'是','0'=>'否',),'tags'=>'select','decription'=>'非全站通用，可单独对某个产品设置支付方式','width'=>35,'height'=>0,'separator'=>0,),
			'payOnDelivery_status'=> array('name'=>'货到付款','options'=>array('1'=>'启用','0'=>'关闭',),'tags'=>'radio','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'payOnDelivery_fee'=> array('name'=>'到付额外费用','value'=>0,'options'=>'','tags'=>'text','decription'=>'元（选择货到付款需客户补交费用。0则不需要）','width'=>5,'height'=>0,'separator'=>0,),
			'payOnDelivery_info'=> array('name'=>'选择到付时提示','options'=>'','tags'=>'textarea','decription'=>'选择货到付款时的提示文字，这里为空则不提示','width'=>50,'height'=>3,'separator'=>1,),

			'bankpay_status'=> array('name'=>'银行转账','options'=>array('1'=>'启用','0'=>'关闭',),'tags'=>'radio','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'bankpay_discount'=> array('name'=>'享受折扣','value'=>0,'options'=>'','tags'=>'text','decription'=>'元（选择银行转账需客户补交费用。0则不需要，负数则减免）','width'=>5,'height'=>0,'separator'=>0,),
			'bankpay_info'=> array('name'=>'选择转账时提示','options'=>'','tags'=>'textarea','decription'=>'','width'=>50,'height'=>3,'separator'=>1,),

			'alipay_status'=> array('name'=>'支付宝','options'=>array('1'=>'启用','0'=>'关闭',),'tags'=>'radio','decription'=>'开通支付宝即时到账请到<a href="https://b.alipay.com/order/productIndex.htm" target="_blank">支付宝</a>官网申请','width'=>50,'height'=>0,'separator'=>0,),
			'alipay_type'=> array('name'=>'支付宝类型','options'=>array('1'=>'即时到账（网页版）','2'=>'即时到账（手机版）','3'=>'担保交易'),'tags'=>'checkbox','decription'=>'申请即时到账需要有企业资质','width'=>50,'height'=>0,'separator'=>0,),
			'alipay_mail'=> array('name'=>'支付宝账户','options'=>'','tags'=>'text','decription'=>'','width'=>50,'height'=>0,'separator'=>0,),
			'alipay_pid'=> array('name'=>'合作者身份(PID)','options'=>'','tags'=>'text','decription'=>'','width'=>50,'height'=>0,'separator'=>0,),
			'alipay_key'=> array('name'=>'安全校验码(KEY)','options'=>'','tags'=>'password','decription'=>'','width'=>50,'height'=>0,'separator'=>0,),
			'alipay_discount'=> array('name'=>'享受折扣','options'=>'','tags'=>'text','decription'=>'0.85为85折，1不打折','width'=>5,'height'=>0,'separator'=>0,),
			'alipay_discount_info'=> array('name'=>'选择支付宝时提示','options'=>'','tags'=>'textarea','decription'=>'为空则不提示','width'=>50,'height'=>3,'separator'=>1,),

			'wxpay_status'=> array('name'=>'微信支付','options'=>array('1'=>'启用','0'=>'关闭',),'tags'=>'radio','decription'=>'开通微信支付请到<a href="https://pay.weixin.qq.com" target="_blank">微信支付</a>官网申请','width'=>35,'height'=>0,'separator'=>0,),
			'wxpay_appid'=> array('name'=>'微信APPID','options'=>'','tags'=>'text','decription'=>'','width'=>50,'height'=>0,'separator'=>0,),
			'wxpay_mchid'=> array('name'=>'微信MCHID','options'=>'','tags'=>'text','decription'=>'微信商户号','width'=>50,'height'=>0,'separator'=>0,),
			'wxpay_key'=> array('name'=>'支付密钥KEY','options'=>'','tags'=>'text','decription'=>'微信API密钥','width'=>50,'height'=>0,'separator'=>0,),
			'wxpay_secret'=> array('name'=>'微信支付应用密钥','options'=>'','tags'=>'text','decription'=>'AppSecret(应用密钥)','width'=>50,'height'=>0,'separator'=>0,),
			'wxpay_type'=> array('name'=>'微信支付类型','options'=>array('1'=>'扫码支付','2'=>'直接支付',),'tags'=>'checkbox','decription'=>'只有在微信端才可以使用“直接支付”','width'=>50,'height'=>0,'separator'=>0,),
			'wxpay_discount'=> array('name'=>'享受折扣','options'=>'','tags'=>'text','decription'=>'0.85为85折，1不打折','width'=>5,'height'=>0,'separator'=>0,),
			'wxpay_discount_info'=> array('name'=>'选择微信支付时提示','options'=>'','tags'=>'textarea','decription'=>'为空则不提示','width'=>50,'height'=>3,'separator'=>1,),
		),

		'mail_setting' => array(
			'mail_send'=> array('name'=>'邮件发送','options'=>array('1'=>'启用','0'=>'关闭',),'tags'=>'select','decription'=>'','width'=>5,'height'=>0,'separator'=>0,),
			'mail_proxy'=> array('name'=>'','options'=>array('0'=>'不使用邮件代理','1'=>'使用邮件代理',),'tags'=>'select','decription'=>'如果服务器不支持邮件发送，请使用代理','width'=>5,'height'=>0,'separator'=>0,),
			'mail_send_status'=> array('name'=>'发送通知','options'=>array('0'=>'下单通知','1'=>'付款通知','2'=>'确认通知','3'=>'发货通知',),'tags'=>'checkbox','decription'=>'其中下单和付款通知管理员，确认及发货通知客户','width'=>5,'height'=>0,'separator'=>0,),
			'mail_smtp'=> array('name'=>'SMTP服务器','options'=>'','tags'=>'text','decription'=>'如网易163邮箱：smtp.163.com','width'=>50,'height'=>0,'separator'=>0,),
			'mail_port'=> array('name'=>'SMTP服务器端口','value'=>25,'options'=>'','tags'=>'text','decription'=>'默认为25','width'=>10,'height'=>0,'separator'=>0,),
			'mail_account'=> array('name'=>'发送邮箱','options'=>'','tags'=>'text','decription'=>'发送邮箱的帐号','width'=>50,'height'=>0,'separator'=>0,),
			'mail_password'=> array('name'=>'邮箱密码或授权码','options'=>'','tags'=>'password','decription'=>'发送邮箱的密码','width'=>50,'height'=>0,'separator'=>0,),
			'mail_to'=> array('name'=>'接收邮箱','options'=>'','tags'=>'text','decription'=>'多个邮箱请用英文逗号隔开','width'=>50,'height'=>0,'separator'=>0,),
			'mail_title'=> array('name'=>'邮件标题','options'=>'','tags'=>'text','decription'=>'[AliziStatus]订单状态，[AliziTitle]产品名，[AliziName]客户名','width'=>50,'height'=>0,'separator'=>0,),
		),

		'sms_setting' => array(
			'sms_send'=> array('name'=>'短信发送','options'=>array('0'=>'关闭','1'=>'启用',),'tags'=>'select','decription'=>'','width'=>30,'height'=>0,'separator'=>0,),
			'sms_admin'=> array('name'=>'通知对象','value'=>1,'options'=>array('0'=>'只通知客户','1'=>'只通知管理员','2'=>'同时通知管理员和客户',),'tags'=>'select','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
			'sms_admin_mobile'=> array('name'=>'','options'=>'','tags'=>'text','decription'=>'请填写管理员手机号，多个号码请用英文逗号隔开','width'=>30,'height'=>0,'separator'=>0,),
			'sms_account'=> array('name'=>'发送账号','options'=>'','tags'=>'text','decription'=>'','width'=>30,'height'=>0,'separator'=>0,),
			'sms_password'=> array('name'=>'发送密码','options'=>'','tags'=>'password','decription'=>'','width'=>30,'height'=>0,'separator'=>0,),
		),

		'safe_setting' => array(
			'safe_mobile_limit'=> array('name'=>'手机号下单限制','value'=>5,'options'=>'','tags'=>'text','decription'=>'笔（一个手机每天可对某一产品下单笔数）','width'=>5,'height'=>0,'separator'=>0,),
			'safe_order_interval'=> array('name'=>'下单间隔限制','value'=>20,'options'=>'','tags'=>'text','decription'=>'秒（对同一产品设置下单间隔，设置时长可以有效防止重复下单）','width'=>5,'height'=>0,'separator'=>0,),
			'safe_ip_limit'=> array('name'=>'IP下单限制','value'=>10,'options'=>'','tags'=>'text','decription'=>'笔（限制每个IP每小时可下单笔数，0 则不限制）','width'=>5,'height'=>0,'separator'=>0,),
			'safe_ip_denied'=> array('name'=>'黑名单IP','options'=>'','tags'=>'textarea','decription'=>'每个IP用#分隔开，IP段可用*号代替','width'=>80,'height'=>3,'separator'=>0,),
		),

		'express_setting' => array(
			'delivery_setting'=> array('name'=>'设置常用快递','options'=>$express['DELIVERY'],'tags'=>'checkbox','decription'=>'','width'=>35,'height'=>0,'separator'=>0,),
		),

		'weixin_share_setting' => array(
			'weixin_status'=> array('name'=>'微信强制分享','options'=>array('0'=>'关闭','1'=>'启用',),'tags'=>'select','decription'=>'使用微信强制分享有被微信封杀域名的风险，请谨慎使用！','width'=>50,'height'=>0,'separator'=>0,),
			'weixin_appid'=> array('name'=>'AppID(应用ID)','options'=>'','tags'=>'text','decription'=>'','width'=>50,'height'=>0,'separator'=>0,),
			'weixin_appsecret'=> array('name'=>'AppSecret(应用密钥)','options'=>'','tags'=>'text','decription'=>'','width'=>50,'height'=>0,'separator'=>0,),
			'weixin_token'=> array('name'=>'Token(令牌)','options'=>'','tags'=>'text','decription'=>'','width'=>50,'height'=>0,'separator'=>0,),
			'weixin_encodingaeskey'=> array('name'=>'EncodingAESKey(消息加解密密钥)','options'=>'','tags'=>'text','decription'=>'','width'=>50,'height'=>0,'separator'=>0,),
		),
	)
);

?>