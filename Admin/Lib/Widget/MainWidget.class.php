<?php
class MainWidget extends Widget {
	public function render($data){
		if('admin'==$_SESSION['user']['role']){
			$menu = array(
				'Index'   => array( array('name'=>'system_info','list'=>array('index'=>'basic_info','account'=>'account_setting')), array('name'=>'extend_manage','list'=>array('advert'=>'advert_slideshow')), ),
				'Item'   => array( array('name'=>'item','list'=>array('index'=>'item_list','edit'=>'add_item')), array('name'=>'category','list'=>array('category'=>'category_list')), ),
				'Order'   => array( 
					array('name'=>'order','list'=>array('index'=>'all_order')),
					array('name'=>'order_statistics','list'=>array('statistics'=>'order_statistics','channel'=>'channel_statistics')),
				 ),
				'Article'   => array( array('name'=>'article','list'=>array('index'=>'article_list','edit'=>'add_article')), array('name'=>'category','list'=>array('category'=>'category_list')), ),
				'User'   => array( array('name'=>'user','list'=>array('index'=>'admin_list','member'=>'member_list','add'=>'add_user')), ),
				'Setting'=> array( 
					array('name'=>'setting','list'=>array('index'=>'system_setting','database'=>'database_manage','shipping'=>'shipping_manage')),
					array('name'=>'recycle','list'=>array('item'=>'item_list','order'=>'order_list','user'=>'user_list')),
				 ),
			);
		}else{
			$menu = array(
				'Index'   => array( array('name'=>'system_info','list'=>array('index'=>'basic_info','account'=>'account_setting')), ),
				'Item'   => array( array('name'=>'item','list'=>array('index'=>'item_list')), ),
				'Order'   => array( array('name'=>'order','list'=>array('index'=>'all_order')), ),
			);
		}
		
		$data['menu'] = $menu;
		$data['user'] = $_SESSION['user'];
		return $this->renderFile ("index", $data);
	}
}
?>