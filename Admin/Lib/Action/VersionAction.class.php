<?php 
class VersionAction extends Action {

    public function index(){
		header('content-type:text/html;charset=utf-8');
		$ItemTemplate = M('ItemTemplate');
		$fields = $ItemTemplate->query('desc __TABLE__ `extend`');
		if(empty($fields)){ 
			$flag = $ItemTemplate->query("ALTER TABLE __TABLE__ add `extend` text  after redirect_uri"); 
			dump($ItemTemplate->_sql());
		}

		$Item = M('Item');
		$fields = $Item->query('desc __TABLE__ `thumb`');
		if(empty($fields)){ 
			$flag = $Item->query("ALTER TABLE __TABLE__ add `thumb` varchar(255)  after image"); 
			dump($Item->_sql());
		}
		$fields = $Item->query('desc __TABLE__ `sms_send`');
		if(empty($fields)){ 
			$flag = $Item->query("ALTER TABLE __TABLE__ add `sms_send` text after send_content"); 
			dump($Item->_sql());
		}
		$fields = $Item->query('desc __TABLE__ `timer`');
		if(empty($fields)){ 
			$flag = $Item->query("ALTER TABLE __TABLE__ add `timer` int(1) NOT NULL DEFAULT  '0'  after sms_send"); 
			dump($Item->_sql());
		}
		$fields = $Item->query('desc __TABLE__ `user_id`');
		if(empty($fields)){ 
			$flag = $Item->query("ALTER TABLE __TABLE__ add `user_id` int(12) NOT NULL DEFAULT  '1'  after id"); 
			dump($Item->_sql());
		}

		$Order = M('Order');
		$rs = $Order->query('alter table __TABLE__ modify column channel_id varchar(20);');dump($Order->_sql());
		$fields = $Order->query('desc __TABLE__ `is_sent`');
		if(empty($fields)){ 
			$flag = $Order->query("ALTER TABLE __TABLE__ add `is_sent`  tinyint(1) NOT NULL DEFAULT  '0'  after is_delete"); 
			dump($Order->_sql());
		}
		
		$User = M('User');
		$fields = $User->query('desc __TABLE__ `pid`');
		if(empty($fields)){ 
			$flag = $User->query("ALTER TABLE __TABLE__ add `pid` int(12) NOT NULL DEFAULT  '0'  after id"); 
			dump($User->_sql());
		}
		die('升级完成');
    }
}?><?php 