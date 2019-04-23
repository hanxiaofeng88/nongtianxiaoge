<?php

require_once("lib/alipay_notify.class.php");
require_once("lib/alipay_submit.class.php");

class Alipay
{
	//传递进来的的配置
	private $config        = array();
	
	//提交到支付宝的配置
	private $alipay_config = array();
	
	function __construct($config){

		//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
		//合作身份者id，以2088开头的16位纯数字
		$alipay_config['partner']		= $config['alipay_pid'];
		//安全检验码，以数字和字母组成的32位字符
		$alipay_config['key']			= $config['alipay_key'];
		//卖家支付宝帐户，必填

		//签名方式 不需修改
		$alipay_config['sign_type']    = strtoupper('MD5');

		//字符编码格式 目前支持 gbk 或 utf-8
		$alipay_config['input_charset']= strtolower('utf-8');

		//ca证书路径地址，用于curl中ssl校验
		//请保证cacert.pem文件在当前文件夹目录中
		$alipay_config['cacert']    = getcwd().'\\cacert.pem';

		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$alipay_config['transport']    = 'http';

		$this->alipay_config = $alipay_config;
	}
	
	function getConfig(){
		return $this->alipay_config;
	}
	function submit($param=array()){
		header("Content-type:text/html;charset=utf-8");
		$alipay_config = $this->getConfig();
		
		
		/**************************请求参数**************************/

		//支付类型
		$payment_type = "1";
		//必填，不能修改
		//服务器异步通知页面路径
		$notify_url = $param['notify_url'];//"http://".$_SERVER['HTTP_HOST'].$param['notify_url'];
		//需http://格式的完整路径，不能加?id=123这类自定义参数        //页面跳转同步通知页面路径
		$return_url = $param['return_url'];//"http://".$_SERVER['HTTP_HOST'].$param['return_url'];
		//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/        //卖家支付宝帐户
		$seller_email = $param['seller_email'];
		//必填        //商户订单号
		$out_trade_no = $param['out_trade_no'];
		//商户网站订单系统中唯一订单号，必填        //订单名称
		$subject = $param['subject'];
		//必填        //付款金额
		$total_fee = $param['total_fee'];
		//必填        //订单描述        
		$body = $param['body'];
		//商品展示地址
		$show_url = $param['show_url'];
		//需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html        //防钓鱼时间戳
		$anti_phishing_key = "";
		//若要使用请调用类文件submit中的query_timestamp函数        //客户端的IP地址
		$exter_invoke_ip = "";
		//非局域网的外网IP地址，如：221.0.0.1


		/************************************************************/

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "正在提交到支付宝，请稍候……");
		echo $html_text;

	}
}



?>