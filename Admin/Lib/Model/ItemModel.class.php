<?php  
class ItemModel extends Model {

	protected $_validate = array(
		array('name', 'require', '标题不能为空！',1,'',1),
	);
	protected $_auto = array(
		array('add_time', 'time', 1, 'function'),
		array('update_time', 'time', 2, 'function'),
	);

	function _before_update(&$data,$options){
		$list = $extend = array();
		foreach($_POST['title'] as $k=>$v){
			if(!empty($v)) $list[] = array('title'=>$v,'price'=>$_POST['params_price'][$k],'image'=>$_POST['params_image'][$k],'qrcode'=>$_POST['params_qrcode'][$k]);
		}
		foreach($_POST['extend_title'] as $k=>$v){
			if(!empty($v)) $extend[] = array('title'=>$v,'value'=>$_POST['extend_value'][$k],'type'=>$_POST['extend_type'][$k]);
		}

		$data['extends'] = empty($extend)?'':json_encode($extend);
		$data['payment'] = empty($_POST['payment'])?'':json_encode($_POST['payment']);
		$data['is_hot'] = intval($_POST['is_hot']);
		$data['is_big'] = intval($_POST['is_big']);
		$data['is_auto_send'] = intval($_POST['is_auto_send']);
		$data['qrcode_pay'] = intval($_POST['qrcode_pay']);
		$data['params'] = json_encode($list);
		$data['sms_send'] = json_encode($_POST['sms_send']);
	}
	function _before_insert(&$data,$options){
		$data['sn'] = $data['sn']?$data['sn']:randCode(8,'abcdevghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
		$this->_before_update($data);
	}

	function _after_delete($data,$options){
		$ItemTemplate = M('ItemTemplate');
		$where = array('item_id'=>$data['id']);
		$ItemTemplate->where($where)->delete();
	}
	
	
}
?><?php 