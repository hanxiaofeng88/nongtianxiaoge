<?php 
set_time_limit(300);
defined('THINK_PATH') OR exit();
class ApiAction extends Action{
    
    private $aliziConfig = array();
    public function _initialize(){
        $this->aliziConfig = $this->aliziConfig();
    }
    private function auth($data){
        $sign = createSign($data,C('ALIZI_KEY'));
        if($sign!=$data['sign']){
            return array('status'=>0,'message'=>lang('illegal_sign'));
        }else{
            return array('status'=>1,'message'=>lang('success'));
        }
    }

    public function aliziBooking(array $data){
        session_commit();
        $sign = $this->auth($data);
        if($sign['status']==0) return $sign;
        $data['item_id']  = (int)$data['item_id'];
        $data['quantity'] = empty($data['quantity'])?1:intval($data['quantity']);
        $data['payment'] = empty($data['payment'])?1:intval($data['payment']);
        $data['item_params'] = $data['item_params']?$data['item_params']:'';
        
        $itemMap = array('sn'=>trim($_POST['sn']));
        $item = getCache('Item',$itemMap);
        $data['quantity'] = $data['payment']==5 && $item['qrcode_pay']==1?1:$data['quantity'];
        if(empty($item)) return array('status'=>0,'message'=>lang('empty_item'));
        if(json_decode($item['params'],true) && empty($data['item_params'])){
             return array('status'=>0,'message'=>lang('pleaseSelect_package'));
        }
        
        $check = $this->aliziCheck($data,json_decode($item['extends'],true));
        if($check['status']==0) return $check;
        $safe = $this->aliziSafe( $data['item_id'],$data['mobile']);
         if($safe['status']==0) return $safe;
         $same = $this->aliziSameOrderCheck( $data);
         if($same['status']==0) return $same;

        $Order = M('Order');
        $price = $this->getAliziPrice($data);
        if($alizi=$Order->create($data)){
            $code = date('ymd').randCode(6);
            $orderData = array(
                'status'=>0,
                'item_name'=>$item['name'],
                'item_params'=>$data['item_params'],
                'item_extends'=>json_encode($data['extends']),
                'item_price'=>$item['price'],
                'order_price'=>floatval($price['order_price']),
                'shipping_price'=>floatval($price['shipping_price']),
                'total_price'=>floatval($price['total_price']),
                'device'=>isMobile()?2:1,
                'add_time'=>$_SERVER['REQUEST_TIME'],
                'order_no'=>$code,
                'add_ip'=>get_client_ip(),
            );
            $orderData = array_merge($alizi,$orderData);
            $order_id = $Order->add($orderData);

            if($order_id){
                M('Item')->where($itemMap)->setInc('salenum',$data['quantity']);
                $item = getCache('Item',$itemMap,true);

                if($this->aliziConfig['record_order']==1){ cookie('order',$orderData,array('expire'=>2592000)); }
                unset($_SESSION['verify']);
                $this->aliziOrderLog($order_id,0,$data['remark']);
                $orderData['order_id'] = $order_id;
                return array('status'=>1,'message'=>lang('success'),'data'=>$orderData);
            }else{
                return array('status'=>0,'message'=>lang('error_colon_01'));
            }
        }else{
            return array('status'=>0,'message'=>lang('error'));
        }    
    }

    public function aliziUpdateStatus(array $data){

        $sign = $this->auth($data);
        if($sign['status']==0) return $sign;

        $Model = M('Order');
        $order_id = (int)$data['order_id'];
        $status = (int)$data['status'];
        $user_id = isset($data['user_id'])?(int)$data['user_id']:0;
        $remark = strip_tags($data['remark']);
        $order = M('Order')->where(array('id'=>$order_id))->find();
        if($order && $status!=$order['status']){
            $update = array(
                'id'=>$order_id,
                'status'=>$status,
                'update_time'=>$_SERVER['REQUEST_TIME'],
            );
            $flag = $Model->save($update);
            if($flag){
                $this->aliziOrderLog($order_id,$status,$remark,$user_id);

                //自动发货
                if($data['status']==1 && $order['status']==0){
                    $item = M('Item')->where('id='.$order['item_id'])->field('id,is_auto_send,send_content')->find();
                    if(!empty($item['is_auto_send'])){ 
                        $data['status'] = 3;
                        $data['remark'] = $item['send_content'];
                        $data['sign'] = createSign($data,C('ALIZI_KEY'));
                        $this->aliziUpdateStatus($data); 
                     }
                }

                return array('status'=>1,'message'=>lang('success'));
            }
        }else{
            return array('status'=>0,'message'=>lang('error'));
        }
    }

    public function getAliziPayment($sn,$payment_id=''){
        $item = getCache('Item',array('sn'=>$sn));
        $payment = C('PAYMENT');
        $paymentInfo=array(
            1=>array( 'info'=> preg_replace('/\r\n/', '',nl2br($this->aliziConfig['payOnDelivery_info'])), 'math'=>'+'.$this->aliziConfig['payOnDelivery_fee'] ),
            2=>array('info'=> preg_replace('/\r\n/', '',nl2br($this->aliziConfig['alipay_discount_info'])),'math'=>'*'.$this->aliziConfig['alipay_discount'],),
            3=>array('info'=> preg_replace('/\r\n/', '',nl2br($this->aliziConfig['wxpay_discount_info'])),'math'=>'*'.$this->aliziConfig['wxpay_discount'],),
            4=>array('info'=> preg_replace('/\r\n/', '',nl2br($this->aliziConfig['alipay_discount_info'])),'math'=>'*'.$this->aliziConfig['alipay_discount'],),
            5=>array('info'=> preg_replace('/\r\n/', '',nl2br($item['qrcode_pay_info'])),'math'=>'+0',),
            6=>array('info'=> preg_replace('/\r\n/', '',nl2br($this->aliziConfig['bankpay_info'])),'math'=>'+'.$this->aliziConfig['bankpay_discount'],),
        );
        foreach($payment as $k=>$v){
            $payment[$k] = array_merge($payment[$k],$paymentInfo[$k]);
        }
        if($this->aliziConfig['payment_global']==1){
            if(empty($this->aliziConfig['payOnDelivery_status'])) unset($payment[1]);
            if(empty($this->aliziConfig['bankpay_status'])) unset($payment[6]);
            if(empty($this->aliziConfig['alipay_status'])){
                unset($payment[2]); unset($payment[4]);
            }
            $alipayType = json_decode(str_replace('\\', '', $this->aliziConfig['alipay_type']),true);
            if(isMobile()==true){
                if(!in_array('2', $alipayType))unset($payment[2]);
            }else{
                if(!in_array('1', $alipayType))unset($payment[2]);
            }
            if(!in_array('3', $alipayType)) unset($payment[4]);
            if(empty($this->aliziConfig['wxpay_status'])) unset($payment[3]);
        }else{
            $itemPayment = json_decode($item['payment'],true);
            if($itemPayment){
                foreach($payment as $k=>$v){  if(!in_array($k, $itemPayment)) unset($payment[$k]);  } 
            }
         }
        return $payment_id?$payment[$payment_id]:$payment; 
    }

    public function getAliziPrice(array $data){
        $sn  = trim($data['sn']);
        $quantity = empty($data['quantity'])?1:intval($data['quantity']);
        $params  = trim($data['item_params']);
        $payment_id  = (int)$data['payment'];

        $item = getCache('Item',array('sn'=>$data['sn']));
        $item_price = $item['price'];
        $item_params = json_decode($item['params'],true);
        if($item_params){
            foreach($item_params as $param){
                 if(trim($param['title'])==trim($params)){  $item_price = $param['price'];break; }
            }
            if(empty($item_price)) return array('status'=>0,'message'=>lang('error'));
        }

        $order_price = $quantity*$item_price;
        $payment = $this->getAliziPayment($sn,$payment_id);
        $num = substr($payment['math'], 1);
        switch (substr($payment['math'], 0,1)) {
            case '+': $order_price += $num; break;
            case '*': $order_price *= $num; break;
        }
        $shipping_price = $this->getAliziShipping($item['shipping_id'],$quantity,$order_price);

        return array(
            'status'=>1,
            'order_price'=>$order_price,
            'shipping_price'=>$shipping_price,
            'total_price' =>$order_price+$shipping_price,
        );
    }

    public function aliziSafe($item_id,$mobile=''){
        $Model = M('Order');
        $ip = get_client_ip();
        $today = date('Y-m-d');
        
        $lastOrderTime = $Model->where("item_id={$item_id} AND status=0 AND  add_ip='{$ip}' ")->limit(1)->order('id DESC')->getField('add_time');
        if(($lastOrderTime+$this->aliziConfig['safe_order_interval'])>$_SERVER['REQUEST_TIME']) return array('status'=>0,'message'=>lang('intervalLimit'));

        $mobileCount = $Model->where("item_id={$item_id} AND status=0 AND mobile='{$mobile}' AND FROM_UNIXTIME(add_time,'%Y-%m-%d')='{$today}' ")->count();
        if($mobileCount>=$this->aliziConfig['safe_mobile_limit']) return array('status'=>0,'message'=>lang('mobileLimit'));
      
        if(!empty($this->aliziConfig['safe_ip_limit'])){
             $ipCount = $Model->where("status=0 AND add_ip='{$ip}' AND add_time >".($_SERVER['REQUEST_TIME']-3600))->count();
            if($ipCount>=$this->aliziConfig['safe_ip_limit']) return array('status'=>0,'message'=>lang('orderLimit'));
        }
        return array('status'=>1,'message'=>lang('success'));
    }

    private function aliziOrderLog($order_id,$status=1,$remark='',$user_id=0){
        $this->sendSMS($order_id);
        if($status>0) $this->send($order_id,$status,$remark);//发送信息

        $OrderLog = M('OrderLog');    
        $flag = $OrderLog->where(array('order_id'=>$order_id,'status'=>$status))->find('id');
        if($flag) return false;
        $data = array(
            'order_id' => $order_id,
            'user_id' => $user_id,
            'status'=>$status,
            'add_time'=>$_SERVER['REQUEST_TIME'],
            'remark'=>$remark,
        );
        return $OrderLog->add($data);
    }
    public function send($order_id,$status=0,$remark='',$print=false){
        if(empty($this->aliziConfig['mail_send'])) return array('status'=>0);
        $status = intval($status);
        $order = M('Order')->where(array('id'=>$order_id))->find();
        if(empty($order)) return array('status'=>0);
        if($order['is_sent']==1) return array('status'=>0);//已发送
        $item = $item = M('Item')->where('id='.$order['item_id'])->field('id,is_auto_send,send_content')->find();
        $send_status = json_decode($this->aliziConfig['mail_send_status'],true);
        $orderStatus  = C('ORDER_STATUS');
        if(in_array($status, $send_status) || ($status==3 && $item['is_auto_send']==1)){
            $payment = C('PAYMENT');
            $content = include(COMMON_PATH."alizi.mail.tpl{$status}.php");
            //$content .= "<div style='display:block !important;font-family:MicroSoft Yahei;padding-top:80px;text-align:right;font-size:12px;color:#888;'>&copy; 2015-".date('Y')." <a href='http://order.chmzw.com' target='_blank'>PHP订单系统</a> All Rights Reserved.</div>";

            $email = in_array($status, array(2,3))?$order['mail']:explode(',', $this->aliziConfig['mail_to']);
            if(empty($email)) return array('status'=>0);
            $title  = str_replace(array('[AliziStatus]','[AliziTitle]','[AliziName]'), array(strip_tags($orderStatus[$status]),$order['item_name'],$order['name']), $this->aliziConfig['mail_title']);
            $send = $this->sendMail($email,$title,$content);
            if($send['status']==1 && $status==0){
                M('Order')->where(array('id'=>$order_id))->setField('is_sent',1);
            }
            if($print){
                print_r($send);
            }else{
                return $send;
            }  
        }
        return array('status'=>0);
    }
    private function sendSMS($order_id){
        if(empty($this->aliziConfig['sms_send'])){
             return array('status'=>0);
        }
        $order = M('Order')->where(array('id'=>$order_id))->find();
        if(empty($order)) return array('status'=>0);

        if(!empty($this->aliziConfig['sms_admin_mobile'])){
            switch ($this->aliziConfig['sms_admin']) {
                case '1': $order['mobile'] = $this->aliziConfig['sms_admin_mobile'];break;
                case '2': $order['mobile'] .= ','.$this->aliziConfig['sms_admin_mobile'];break;
            }
        }
        $item = M('Item')->where('id='.$order['item_id'])->field('id,sms_send')->find();
        $sms = json_decode($item['sms_send'],true);
        $status=$order['status'];
        if($sms[$status]['status']==1 && !empty($sms[$status]['content'])){
            //发送内容替换
            $express = C('DELIVERY');
            $replace = array(
                '{[AliziTitle]}'     => $order['item_name'],
                '{[AliziParams]}'     => $order['item_params'],
                '{[AliziName]}'     => $order['name'],
                '{[AliziQuantity]}'     => $order['quantity'],
                '{[AliziPrice]}'     => $order['total_price'],
                '{[AliziExpress]}'     => $express[$order['delivery_name']],
                '{[AliziExpressNum]}'     => $order['delivery_no'],
            );
            $content = str_replace(array_keys($replace),array_values($replace),$sms[$status]['content']);

            $data = array(
                'method'=>'send',
                'account'=>$this->aliziConfig['sms_account'],
                'password'=>$this->aliziConfig['sms_password'],
                'mobile'=>$order['mobile'],
                'content'=>$content,
            );
            $rs = http(C('ALIZI_API').'/sms/','POST',$data);
        }
    }
    private function aliziCheck(&$data,$extends){
        $alizi_page  = trim($data['alizi_page']);
        if('system'==$alizi_page){
            $options = $this->aliziConfig['order_options'];
        }else{
            $template = getCache('ItemTemplate',array('id'=>(int)$data['item_id']));
            $options = $template['options'];
        }
        $options = json_decode($options,true);
        $template_options = C('TEMPLATE_OPTIONS');
       
        if(!empty($extends)){
            foreach($extends as $ext){
                $key = $ext['title'];
                if(empty($data['extends'][$key]))  return array('status'=>0,'message'=>lang($key.'_notEmpty'));
            }
        }
        foreach($options as $opt){
            $options_value = is_array($data[$opt])?implode(' ',$data[$opt]):$data[$opt];
            $data[$opt] = strip_tags(trim($options_value));
            if($template_options[$opt]['request'] && empty($data[$opt])){
                 return array('status'=>0,'message'=>lang($opt.'_notEmpty'));
            }
        }
        foreach ($data as $key => $value) {
             switch ($key) {
                case 'mobile':  if(isMobileNum($value)==false)  return array('status'=>0,'message'=>lang('invalid_'.$key)); break;
                case 'mail': if(!empty($value) && isEmail($value)==false)   return array('status'=>0,'message'=>lang('invalid_'.$key)); break;
                case 'name':  if(mb_strlen($value,'utf8')<2)   return array('status'=>0,'message'=>lang('invalid_'.$key)); break;
                case 'address':  if(mb_strlen($value,'utf8')<3)   return array('status'=>0,'message'=>lang('invalid_'.$key)); break;
                case 'verify':  if(md5($value)!=$_SESSION['verify'])   return array('status'=>0,'message'=>lang('invalid_'.$key)); break;
            }
        }
        return array('status'=>1);
    }
    private function aliziSameOrderCheck($data){
        if($this->aliziConfig['repeat_order']==1) return array('status'=>1);
        $data['item_extends'] = json_encode($data['extends']);
        $check = array('item_id','item_params','item_extends','name','mobile','region','address','quantity','payment');
        $cookie = cookie('order');
        foreach($check as $ck){
            if($data[$ck]!=$cookie[$ck]){ return array('status'=>1); }
        }
        return array('status'=>0,'message'=>lang('sameOrder'));
    }
    public function getAliziShipping($shipping_id,$quantity,$total_price){
        $cost = 0;
        if(!empty($shipping_id)){
            $shipping = getCache('Shipping',array('id'=>$shipping_id));
            if($shipping){
                if($shipping['is_free_num'] && $quantity>=$shipping['free_num']) return $cost;//达到一定数量免运费
                if($shipping['is_free_cost'] && $total_price>=$shipping['free_cost']) return $cost;//达到一定金额免运费
                if($quantity <= $shipping['less_num']){
                    $cost = $shipping['less_num_cost'];
                }else{
                    $step = ceil(($quantity-$shipping['less_num'])/$shipping['step_num']);
                    $cost = $shipping['less_num_cost']+$step*$shipping['step_num_cost'];
                }
            }
        }
        return $cost;
    }
    private function aliziConfig(){
        $config = cache('aliziConfig');
        if(empty($config)){
            $list = M('Setting')->select();
            foreach($list as $li) $config[$li['name']] = $li['value'];
            cache('aliziConfig',$config,8640000);
        }
        return $config;
    }

    public function payQrcode($data=array()){
        $item = getCache('Item',array('id'=>$data['item_id']));
        $params = json_decode($item['params'],true);
        if(empty($params)){
          $qrcode = $item['qrcode'];
        }else{
          $itemParams = explode(' - ', $data['item_params']);
          foreach($params as $k=>$v){  if($v['title']==$itemParams[0]){ $qrcode = $v['qrcode'];break;} }
        }
        return $qrcode;
    }
    public function payWxpay($data=array()){
        Vendor('wxPay.WxPay#NativePay');
        WxPayConfig::setConfig($this->aliziConfig);
        $notify = new NativePay();

        $order_no = $data['order_no'];
        $total_price = $data['total_price']*100;//价格，单位为分
        $item_id = $data['item_id'];
        $item_name = $data['item_name'];

        $input = new WxPayUnifiedOrder();
        $input->SetBody($item_name);
        $input->SetOut_trade_no($order_no);
        $input->SetTotal_fee($total_price);
        $input->SetProduct_id($item_id);
        $input->SetAttach(L('aliziSystem'));
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 3000));
        $input->SetGoods_tag(L('aliziSystem'));
        $input->SetNotify_url($this->aliziHost."Api/wxPay.php");
        $input->SetTrade_type("NATIVE");
        return $notify->GetPayUrl($input);
    }
   
    Public function payAlipay($data=array()){
        $Model = D('Pay');
        $alipayType = json_decode($this->aliziConfig['alipay_type'],true);
        if(isMobile() && in_array('2', $alipayType)){
             $Model->alipayWap($data,$this->aliziConfig);
        }else{
            $Model->alipay($data,$this->aliziConfig);
        }
    }
    public function sendEmail(){
        $sign = $this->auth($_POST);
        if($sign['status']==0){
            $json = array('status'=>0,'info'=>lang('illegal_sign'));
        }else{
            $json = $this->sendMail($_POST['email'],$_POST['title'],$_POST['content']);
        }
        echo json_encode($json);
    }
    public function alipayNotify(){
        D('Pay')->alipayNotify($this->aliziConfig);
    }
    public function alipayDbNotify(){
        D('Pay')->alipayDbNotify($this->aliziConfig);
    }
    public function alipayWapNotify(){
        D('Pay')->alipayWapNotify($this->aliziConfig);
    }
    public function wxPayNotify(){
        D('Pay')->wxPayNotify();
    }
    private function sendMail($email,$title,$content){
        $aliziConfig = S('aliziConfig');
        $email = is_array($email)?$email:explode(',', $email);

        if($aliziConfig['mail_proxy']){
            $data = array(
                'email'=>$aliziConfig['mail_to'],
                'title'=>$title,
                'content'=>$content,
                'mail_smtp'=>$aliziConfig['mail_smtp'],
                'mail_port'=>$aliziConfig['mail_port'],
                'mail_account'=>$aliziConfig['mail_account'],
                'mail_password'=>$aliziConfig['mail_password'],
            );
           $result =  http(C('ALIZI_API').'/mail/', 'POST', $data );  
           return json_decode($result,true);
        }

        import("ORG.PHPMailer.PHPMailer");
        $mail  = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->WordWrap = 50;
        $mail->IsHTML(true);
        $mail->AltBody = "";
        $mail->CharSet = "UTF-8";

        $mail->Host = $aliziConfig['mail_smtp'];
        $mail->Port     = $aliziConfig['mail_port'];
        $mail->Username =  $aliziConfig['mail_account'];
        $mail->Password = $aliziConfig['mail_password'];
        $mail->From     =$aliziConfig['mail_account']; 
        $mail->FromName = $aliziConfig['title'];
        $mail->Subject = $title;
        $mail->Body = $content;
        $mail->AddReplyTo($aliziConfig['mail_account'], "Information");
        $mailaddress = array_shift($email);
        $mail->AddAddress($mailaddress);
        if(count($email)>0){
            foreach($email as $m){
                if(isEmail($m)){ $mail->AddBCC($m);}
            }
        }
        //$mail->SMTPDebug = 1;
        $status =  $mail->Send();
        return array('status'=>$status,'info'=>$mail->ErrorInfo);
    }

    public function smsReceive(){
        if($_POST){
            $data = $_POST['data'];
        }
    }

}
?>