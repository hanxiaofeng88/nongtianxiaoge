<?php  
defined('THINK_PATH') OR exit();
class OrderAction extends AliziAction {

    public function _initialize(){
        parent::_init();
    }

    public function index($id,$tpl='index'){
      if(empty($id) || !ctype_alnum($id))$this->error(lang('error'));
	$info  = getCache('Item',array('sn'=>$id));
      if(empty($info) || $info['is_delete']==1) $this->error(lang('empty_item'));
      $template  = getCache('ItemTemplate',array('id'=>$info['id']),true);
      $template['extend'] = unserialize($template['extend']);
      $template['color'] = json_decode($template['color'],true);
      if(isset($_GET['theme'])) $template['template']=str_replace('-', '/', $_GET['theme']);

      if(!empty($template) && preg_match('/^(Alizi\/)/i', $template['template'])){
        $tplName = ltrim(strstr($template['template'],'/'),'/').'/';
        $tpl = ($tpl=='detail' && file_exists(TMPL_PATH.$template['template'].'/detail.html'))?'detail':'index';
        $tpl = 'Alizi/'.$tplName.$tpl;
        $dir = TMPL_PATH.$template['template'];
        $this->assign('theme',TMPL_PATH.$template['template']);
        $this->assign('options',include($dir."/config.php"));
      }else{
        $tpl = "Order/".$tpl;
      }
	
      $this->assign('info',$info);
      $this->assign('template',$template);
      $this->display($tpl);
    }

    public function aliziBooking(){
        $_POST['sign'] = createSign($_POST,C('ALIZI_KEY'));
        $result = R('Api/aliziBooking',array('data'=>$_POST));
        $data  = $result['status']==1?array('order_id'=>$result['data']['order_id'],'order_no'=>$result['data']['order_no']):null;
        $this->ajaxReturn($data,$result['message'],$result['status']);
    }

    public function getAliziPrice(){
        $data = array(
            'sn'=>$_POST['sn'],
            'quantity'=>(int)$_POST['quantity'],
            'item_params'=>trim($_POST['params']),
            'payment'=>(int)$_POST['payment'],
        );
        $data['sign'] = createSign($data,C('ALIZI_KEY'));
        $result = R('Api/getAliziPrice',array('data'=>$data));
        $this->ajaxReturn($result,'success',1);
    }

    public function query(){
          if(IS_POST){
              $kw = trim($_POST['kw']);
              $Model = M('Order');
              $OrderLog = M('OrderLog');
              $status = C('ORDER_STATUS');
              $where = isMobileNum($kw)?"mobile='{$kw}'":"order_no='{$kw}'";
              $orders = $Model->where($where)->order('id desc')->limit(20)->select();
              $list = array();
              if($orders){
                 foreach($orders as $li){
                     $item_extends = json_decode($li['item_extends'],true);
                     $itemExtends = '';
                     foreach($item_extends as $k=>$v){$itemExtends.=$k.lang('colon').(is_array($v)?implode(' ', $v):$v)."<br>";}
                     $list[] = array(
                          'title'=>$li['item_name'],
                          'order_no'=>$li['order_no'],
                          'order_status'=>(int)$li['status'],
                          'status'=>strip_tags($status[$li['status']]),
                          'payment'=>$li['payment'],
                          'quantity'=>$li['quantity'],
                          'price'=>$li['total_price'],
                          'name'=>$li['name'].$li['item_params'],
                          'itemExtends'=>$itemExtends,

                          'address'=>$li['region'].$li['address'],
                          'time'=>date('Y-m-d H:i:s',$li['add_time']),
                          'express'=>experss($li['delivery_name'],$li['delivery_no']),
                          'qq'=>$li['qq'],
                     );
                  } 
              } 
              if($list){
                $this->ajaxReturn(array('title'=>'query','list'=>$list),'true',1);
              }else{
                $this->ajaxReturn(array('title'=>'query','list'=>null),lang('empty'),0);
              }
          }else{
            $this->display();
          }
    }
	public function apply(){
		if(IS_POST){
			$order_no = trim($_POST['order_no']);
			$mobile = trim($_POST['mobile']);
			$Model = M('Order');
			$where = array('order_no'=>$order_no,'mobile'=>$mobile);
			$order = $Model->where($where)->field('id,status')->find();
			
			if(empty($order)){
				$msg = lang('empty');
			}else{			
				switch($order['status']){
					case '1':
						$msg = lang('applySuccess');
						$data = array(
							'order_id'=>$order['id'],
							'status'=>8,
							'remark'=>htmlspecialchars($_POST['refund_payment'].' , '.$_POST['refund_account']),
						);
						$data['sign'] = createSign($data,C('ALIZI_KEY'));
						$rs = http($this->aliziHost."index.php?m=Api&a=aliziUpdateStatus", 'POST', array('data'=>$data));
					break;
					case '8':$msg = lang('applyIn');break;
					default: $msg = lang('status_err');
				}
			}
			$this->ajaxReturn(1,$msg,1);
		}else{
			$this->display();
		}
	}

    public function pay(){
        $order_no = $_GET['order_no'];
        $order = M('Order')->where(array('order_no'=>$order_no))->find();
        if($order['status']!=0){
          $this->redirect('Order/result',array('order_no'=>$order['order_no']));
        }
        $payment = isset($_GET['payment'])?$_GET['payment']:$order['payment'];
        
        $this->assign('order',$order);
        switch ($payment) {
          case '2':
            $this->alipayInWx($order);
            $this->display('result');
            R('Api/payAlipay',array('data'=>$order));
          break;
          case '4':
            $this->alipayInWx($order);
            $this->display('result');
            D('Pay')->alipayDb($order,$this->aliziConfig);
          break;
          case '3':
            if(isWeixin()==true && in_array(2, json_decode($this->aliziConfig['wxpay_type'],true))){
              $this->redirect('Order/payWxPayJsApi',array('order_id'=>$order['id']));exit;
            }else{
              $result = R('Api/payWxpay',array('data'=>$order)); 
              if($result['return_code']=='FAIL'){
                $this->error($result['return_msg']);
              }else{
                $this->assign('result',$result);
                $this->display('payWxpay');
              }
            }
          break;
          case '5'://二维码
            $qrcode = R('Api/payQrcode',array('data'=>$order));
            $this->assign('qrcode',$qrcode);
            $this->display('payQrcode');
          break;
          default:$this->result($order); 
        }
    }
     public function payWxPayJsApi(){

        $order_id = intval($_GET['order_id']);
        $order = M('Order')->where(array('id'=>$order_id))->find();
        $redirectUrl = $this->aliziHost."index.php?m=Order&a=payWxPayJsApi&order_id={$order_id}";
		
	
        Vendor('wxPay.WxPay#JsApiPay');
        WxPayConfig::setConfig($this->aliziConfig);
        $JsApiPay = new JsApiPay();
        $openid = $JsApiPay->GetOpenid($redirectUrl);
        $total_price = $order['total_price']*100;//价格，单位为分

        $input = new WxPayUnifiedOrder();
        $input->SetOpenid($openid);
        $input->SetBody($order['item_name']);
        $input->SetOut_trade_no($order['order_no'].'-'.time());//$order['order_no']
        $input->SetTotal_fee($total_price);
        $input->SetProduct_id($order['item_id']);
        $input->SetAttach(L('aliziSystem'));
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag('Alizi'.$order['order_no']);
        $input->SetNotify_url($this->aliziHost."Api/wxPay.php");
        $input->SetTrade_type("JSAPI");

        $param = WxPayApi::unifiedOrder($input);
		
		if(empty($param)){
			$this->error('error');exit;
		}
		if($param['result_code']=='FAIL'){
			$this->error($param['err_code_des']);exit;
		}
        $wxPayRequest = $param?$JsApiPay->GetJsApiParameters($param):array();
        $this->assign('wxPayRequest',$wxPayRequest);
        $this->assign('order',$order);
        $this->assign('config',$this->aliziConfig);
        $this->display('Order:payWxPayJsApi');
		
    }

    public function result($order=array()){
      $cookie = cookie('order');
      if(empty($order) && isset($_GET['order_no'])){
		$order = M('Order')->where(array('order_no'=>trim($_GET['order_no'])))->find();
      }
      $redirectUrl = M('ItemTemplate')->where(array('id'=>$order['item_id']))->getField('redirect_uri');
      $redirectUrl = empty($redirectUrl)?$order['url']:$redirectUrl;
      $options = json_decode($this->aliziConfig['order_options'],true);
      foreach($options as $k=>$opt){ if(in_array($opt, array('salenum'))) unset($options[$k]); }
      $this->assign('options',$options);
      $this->assign('order',$order);
      $this->assign('redirectUrl',$redirectUrl);
      $this->display('result'); 
    }
    private function alipayInWx($data){
      if(isWeixin()==true){
            $this->assign('info',$data);
            $this->display('Order:payInWx');exit;
        }
    }
    //订单轮询
  public function orderQuery($order_no){
    $status = M('Order')->where(array('order_no'=>$order_no))->getField('status');
    $this->ajaxReturn(null,null,(int)$status);
  }

  public function wx(){
    $id = $_GET['id'];
    $uid = (int)$_GET['uid'];
    $cid = (int)$_GET['c'];
    $info  = getCache('Item',array('sn'=>$id));
    $weixin = parent::weixinShare();

    if($this->aliziConfig['URL_MODEL']==2){
        $randCode = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM_";
        $url = array(
          'link'=>$this->aliziHost."detail/{$info['sn']}-{$uid}/".randCode(8,$randCode)."/".randCode(8,$randCode).".html",
          'order'=>$this->aliziHost."single/{$info['sn']}-{$uid}/".randCode(8,$randCode)."/".randCode(8,$randCode).".html",
        );
      }else{
        $url = array(
          'link'=>$this->aliziHost."index.php?m=Order&id={$info['sn']}&uid={$uid}&tpl=detail",
          'order'=>$this->aliziHost."index.php?m=Order&id={$info['sn']}&uid={$uid}",
        );
      }

    $this->assign('info',$info);
    $this->assign('weixin',$weixin);
    $this->assign('url',$url);
    $this->display();    
  }

}?><?php 