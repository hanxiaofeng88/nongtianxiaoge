<?php  
class CategoryModel extends Model {

	protected $_validate = array(
		array('name', 'require', '标题名称不能为空！',1,'',1),
	);

}
?><?php 