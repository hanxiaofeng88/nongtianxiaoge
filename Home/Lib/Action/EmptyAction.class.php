<?php 
/*
 * 标题：设计师网址导航
 * 日期：2015-01-15
 * 作者：admin@289w.com
 * 网址：www.289w.com
 */
class EmptyAction extends AliziAction {
	
public function index(){
	header('HTTP/1.1 404 Not Found');  
	parent::_init();
	$this->display('Order:404');
}

}?><?php 