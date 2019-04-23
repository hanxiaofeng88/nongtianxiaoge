<?php 
class OrderWidget extends Widget 
{
	public function render($request){
		$sn = trim($request['id']);
		$page = trim($request['page']);
		$Alizi = new AliziAction();
		$aliziConfig = $Alizi->aliziConfig();
		$info = getCache('Item',array('sn'=>$sn));
		$shipping = empty($info['shipping_id'])?array():getCache('Shipping',array('id'=>$info['shipping_id']));

		$cookie = array();
		if($aliziConfig['record_order']==1){ $cookie = cookie('order');$cookie['region'] = explode(' ', $cookie['region']);}
		$cookie['ac']=cookie('ac');

		if($page=='system'){
			$template['options'] = $aliziConfig['order_options'];
			$template['template'] = $aliziConfig['system_template'];
			$template['show_notice'] = $aliziConfig['show_notice'];
		}else{
			$template = getCache('ItemTemplate',array('id'=>$info['id']),true);
			if(empty($template))$template['options'] = $aliziConfig['order_options'];
			$template['extend'] = json_decode($template['extend'],true);
		}
		if(!empty($request['template'])) $template = array_merge($template,$request['template']);
		$list = array(
			'params'=>$Alizi->getItemParams($template['options'],$request['options']),
			'product'=>json_decode($info['params'],true),
			'extends'=>json_decode($info['extends'],true),
			'payment'=>$Alizi->getAliziPayment($sn),
			'aliziConfig'=>$aliziConfig,
			'cookie'=>$cookie,
			'color'=>json_decode($template['color'],true),
		);

		foreach($list['payment'] as $payment){ $list['paymentDefault'] = $payment;break; }
		extract($list);include('Tpl/Order.php');
		//return $this->renderFile ("index", $list);
	}
}
?><?php 