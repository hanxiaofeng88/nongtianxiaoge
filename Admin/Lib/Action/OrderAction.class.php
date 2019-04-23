 <?php 
class OrderAction extends AliziAction {
	public function _initialize(){
        parent::_init();
    }
	function index($payment=0){
	
		if(isset($_GET['do'])){
			$this->view($_GET['id']);exit;
		}
		
		$Model = M('Order');
		$fields = trim($_GET['fields']);
		$status = $_GET['status'];
		$payment = $_GET['payment'];
		$keyword = trim($_GET['keyword']);
		$category_id = intval($_GET['category_id']);
		$time_start = strtotime($_GET['time_start']);
		$time_end   = strtotime($_GET['time_end']);
		$pageSize = empty($_GET['pageSize'])?25:intval($_GET['pageSize']);
		$where = "is_delete=0";
		if($this->role!='admin') $where .= " AND user_id ={$this->uid}";
		if(!empty($keyword)) $where .= " AND $fields LIKE '%$keyword%' ";
		if(is_numeric($status)) $where .= " AND status ={$status} ";
		if(is_numeric($payment)) $where .= " AND payment ={$payment} ";
		if(!empty($time_start) && $time_start < ($time_end)) $where .= " AND (add_time BETWEEN {$time_start} AND {$time_end})";
		if(!empty($category_id)) $where .= " AND category_id={$category_id}";
		if(!empty($payment)) $where .= $payment==1? " AND payment =1":" AND payment !=1";//payment=1货到付款，其它为在线支付
		if(!empty($_GET['channel_id'])) $where .= " AND channel_id ='{$_GET['channel_id']}'";
		if(!empty($_GET['user_id'])) $where .= " AND user_id ={$_GET['user_id']}";
		if(!empty($_GET['item_id'])) $where .= " AND item_id ={$_GET['item_id']}";

		$order = empty($orderby)?"id DESC":"{$orderby} {$sort}";

		$channel = M('Channel')->order('id asc')->select();
		$user = M('User')->where('is_delete=0')->order('id asc')->select();

		if(isset($_GET['aliziExcel'])){
	        	$list  = $Model->where($where)->order('id desc')->select();
	        	$jsonStatus = strip_tags(json_encode(C('ORDER_STATUS')));//订单状态
	        	$jsonShipping = json_encode(C('DELIVERY'));//快递信息

	        	$payment = C('PAYMENT');
			foreach ($payment as $key => $value) { $payment[$key]=$value['name'];}
			$jsonPayment = json_encode($payment);

	        	foreach($list as &$li){
	        		list($li['province'],$li['city'],$li['area']) = explode(' ', $li['region']);
	        		$li['detail_address'] = $li['region'].$li['address'];
	        		$extends= json_decode($li['item_extends'],true);
	        		$extends_params = array();
	        		foreach ($extends as $key=>$value) {
	        			$value = is_array($value)?implode(',', $value):$value;
	        			$extends_params[] = $key.lang('colon').$value;
	        		}
	        		$li['extends'] = implode('；',$extends_params);
	        	}
			$title = array(
				'id' => lang('id'),
				'order_no' => lang('order_number'),
				'item_name'  => lang('item_name'),
				'item_params'  => lang('item_package'),
				'extends'  => lang('extends_package'),
				'quantity' => lang('quantity'),
				'total_price' => lang('price'),
				'name' => lang('customer_realname'),
				'mobile' => lang('customer_mobile'),
				'province' => lang('province'),
				'city' => lang('city'),
				'area' => lang('area'),
				'address' => lang('address'),
				'detail_address' => lang('详细_address'),
				'payment##'.$jsonPayment => lang('payment'),
				'status##'.$jsonStatus => lang('order_status'),
				'delivery_name##'.$jsonShipping => lang('express_name'),
				'delivery_no' => lang('express_number'),
				'remark' => lang('remark'),
				'channel_id' => lang('channel'),
				'add_time||date("Y-m-d H:i:s",###)' => lang('booking_time'),
			);
			parent::aliziExcel($list,$title,date('Y-m-d'));exit;
	        }

		import('ORG.Util.Page');
		$count = $Model->where($where)->count();
		$page  = new Page($count,$pageSize);
		$list  = $Model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
		$show  = $page->show();
		$category  = M('Category')->order('sort_order desc')->select();
		$status = C('ORDER_STATUS');
		foreach($status as $k=>$v){ 
			$map = "is_delete=0 AND status={$k}";
			if(!empty($payment)) $map .= $payment==1? " AND payment =1":" AND payment !=1";
			if($this->role!='admin') $map .= " AND user_id ={$this->uid}";
			$status[$k] = array('name'=>$v,'count'=>$Model->where($map)->count());
		}

		$this->assign('channel',$channel);
		$this->assign('user',$user);
		$this->assign('category',$category);
		$this->assign('delivery',C('DELIVERY'));
		$this->assign('status',$status);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display($this->role=='admin'?'index':'index_user');
	}

	function cashOnDelivery(){
		$this->index(1);
	}

	function payOnLine(){
		$this->index(2);
	}
	
	//内容编辑
	function view($id=''){

		$where = array('id'=>(int)$id);
		$Order = M('Order');
		$info  = $Order->where($where)->find();
		if(!empty($info)) $log = M('OrderLog')->where(array('order_id'=>$info['id']))->order('id asc')->select();
		$pre_id = $Order->where("id<{$info['id']}")->order('id desc')->getField('id');
		$next_id = $Order->where("id>{$info['id']}")->getField('id');

		$aliziConfig = cache('aliziConfig');
		$delivery_setting = array_flip(json_decode($aliziConfig['delivery_setting'],true));
		$delivery = array_intersect_key(C('DELIVERY'),$delivery_setting);
		$this->assign('delivery',$delivery);
		$this->assign('info',$info);
		$this->assign('log',$log);
		$this->assign('pre_id',$pre_id);
		$this->assign('next_id',$next_id);
		$this->display('view');
	}

	function status(){
		$id = (int)$_POST['id'];
		$status = (int)$_POST['status'];

		$data = array(
			'order_id'=>$id,
			'status'=>$status,
			'user_id'=>(int)$this->uid,
			'remark'=>htmlspecialchars($_POST['remark']),
		);
		$data['sign'] = createSign($data,C('ALIZI_KEY'));
		$rs = http($this->aliziHost."index.php?m=Api&a=aliziUpdateStatus", 'POST', array('data'=>$data));
		$this->ajaxReturn(1,'操作成功',1);
	}

	//更新快递
	public function deliveryUpdate(){
		$data = array(
			'id'=>(int)$_POST['id'],
			'delivery_name'=>trim($_POST['delivery_name']),
			'delivery_no'=>addslashes($_POST['delivery_no']),
			'update_time'=>time(),
		);
		$rs = M('Order')->save($data);
		if($rs){
			$this->ajaxReturn(null,'保存成功',1);
		}else{
			$this->ajaxReturn(null,'操作失败',0);
		}
		
	}

	public function statistics(){
		R('Statistics/index');
	}
	public function channel(){
		R('Statistics/channel');
	}
	 
}
?>