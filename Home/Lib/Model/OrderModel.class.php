<?php  
class OrderModel extends Model {

	protected $_validate = array(
		//array('name', 'require', '标题不能为空！',1,'',1),
	);
	protected $_auto = array(
		array('add_time', 'time', 1, 'function'),
		array('order_no', 'randCode', 1, 'function'),
		array('add_ip', 'get_client_ip', 1, 'function'),
	);

	//下单
	function order($data,$item){
		$ip = get_client_ip();
		$time = time();
		$aliziConfig = S('aliziConfig');

		//到付加价
		$shippingPrice = $data['payment']==1?$aliziConfig['payOnDelivery_fee']:0;
		
		//获取产品价格
		$params = json_decode($item['params'],true);
		if(empty($params)){
			$item_price = $item['price'];
		}else{
			$item_params = explode('-', $data['item_params']);
		    	foreach($params as $param){
				if($param['title']==trim($item_params[0])){
					$item_price = $param['price'];break;
				}
		    	}
		    	if(empty($item_price)) return array('status'=>false,'message'=>lang('error'));
		}
		

		//同一IP一小时内下单数量限制
		if(!empty($aliziConfig['safe_ip_limit'])){
			$thisHour = $time-3600;
			$map = "`add_ip`='{$ip}' AND `add_time`> {$thisHour}";
			$limit = $this->where($map)->count();
			if($limit>=$aliziConfig['safe_ip_limit']){
				return array('status'=>false,'message'=>lang('orderLimit'));
			}
		}

		$data = $this->create($data,1);
		$data['item_name'] = $item['name'];
		$data['user_id'] = $data['user_id'];
		$data['status'] = 0;
		$data['device'] = isMobile()?2:1;
		$data['quantity'] = empty($data['quantity'])?1:$data['quantity'];//订单数量
		$data['total_price'] = $data['quantity']*$item_price+$shippingPrice;//订单总价
		$data['region'] = !empty($data['region'])?implode(" ", $data['region']):"";

		$this->startTrans();
		$orderId = $this->add($data); 
		$flag = $this->orderLog($orderId,$data);
		if($orderId && $flag){
			$this->commit(); 
			$data['url'] = $_POST['url'];
			unset($_SESSION['verify']);
			cookie('aliziOrder',$data,array('expire'=>85400*30));
			
			$this->sendMail($data);
			return array('status'=>true,'data'=>$data);
		}else{
			$this->rollback(); 
			return array('status'=>false,'message'=>lang('error'));
		}
	}

	//订单操作记录
	protected function orderLog($order_id,$data){
		if(empty($order_id)) return false;
		$data = array(
			'order_id'=>$order_id,
			'status'=>$data['status'],
			'add_time'=>$data['add_time'],
			'remark'=>$data['remark'],
		);
		return M('OrderLog')->add($data);
	}
	

}
?><?php 