<?php  
class ArticleModel extends Model {

	protected $_validate = array(
		array('name', 'require', '标题不能为空！',1,'',1),
	);
	protected $_auto = array(
		array('add_time', 'time', 1, 'function'),
		array('update_time', 'time', 2, 'function'),
	);
	
}
?><?php 