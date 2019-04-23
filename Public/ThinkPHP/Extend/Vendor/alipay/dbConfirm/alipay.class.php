<?php

require_once("lib/alipay_notify.class.php");
require_once("lib/alipay_submit.class.php");

class alipay
{
        //传递进来的的配置
        private $config        = array();
        
        //提交到支付宝的配置
        private $alipay_config = array();
        
        function __construct($config){

                //↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                //合作身份者id，以2088开头的16位纯数字
                $alipay_config['partner']               = $config['alipay_pid'];
                //收款支付宝账号
                $alipay_config['seller_email']  = $config['alipay_mail'];
                //安全检验码，以数字和字母组成的32位字符
                $alipay_config['key']                   = $config['alipay_key'];
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
                $notify_url = $param['notify_url'];
                //需http://格式的完整路径，不能加?id=123这类自定义参数

                //页面跳转同步通知页面路径
                $return_url = $param['return_url'];
                //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
                
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

                $out_trade_no = $param['out_trade_no'];
                //商户网站订单系统中唯一订单号，必填        //订单名称
                 $subject = $param['subject'];
                //付款金额
                $price = $param['price'];

                //商品数量 //必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
                $quantity = "1";
                $logistics_fee = "0.00"; //必填，即运费
                //物流类型
                $logistics_type = "EXPRESS";
                //必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
                //物流支付方式
                $logistics_payment = "SELLER_PAY";
                //必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）


                /************************************************************/
                 //收货人姓名
                $receive_name = $param['name'];
                //收货人地址。如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号
                $receive_address = $param['address'];
                //收货人邮编
                $receive_zip = $param['zcode'];
                //收货人电话号码。如：0571-88158090
                $receive_phone = $param['receive_phone'];
                //收货人手机号码。如：13312341234
                $receive_mobile = $param['receive_mobile'];

                //构造要请求的参数数组，无需改动
                $parameter = array(
                        "service" => "create_partner_trade_by_buyer",
                        "partner" => trim($this->alipay_config['partner']),
                        "seller_email" => trim($this->alipay_config['seller_email']),
                        "payment_type"  => $payment_type,
                        "notify_url"    => $notify_url,
                        "return_url"    => $return_url,
                        "out_trade_no"  => $out_trade_no,
                        "subject"       => $subject,
                        "price" => $price,
                        "quantity"      => $quantity,
                        "logistics_fee" => $logistics_fee,
                        "logistics_type"        => $logistics_type,
                        "logistics_payment"     => $logistics_payment,
                        "body"  => $body,
                        "show_url"      => $show_url,
                        "receive_name"  => $receive_name,
                        "receive_address"       => $receive_address,
                        "receive_zip"   => $receive_zip,
                        "receive_phone" => $receive_phone,
                        "receive_mobile"        => $receive_mobile,
                        "_input_charset"        => trim(strtolower($this->alipay_config['input_charset']))
                );

                //建立请求
                $alipaySubmit = new AlipaySubmit($this->alipay_config);
                $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "提交到支付宝");
                echo $html_text;

        }
}

?>