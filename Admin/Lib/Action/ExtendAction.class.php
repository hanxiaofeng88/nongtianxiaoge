<?php 
class ExtendAction extends AliziAction {
	public function _initialize(){
        parent::_init();
    }
	function index($module=''){
		if(isset($_GET['do'])){
			$this->edit($module);exit;
		}
		$Model = M(ucfirst($module));
		import('ORG.Util.Page');
		$where = "1=1";
		$count = $Model->where($where)->count();
		$page  = new Page($count,15);
		$list  = $Model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('sort_order ASC')->select();
		$show  = $page->show();
		$this->assign('page',$show);
		$this->assign('list',$list);
	}
	
	function edit($module =''){
		$id = (int)$_GET['id'];
		if($id){
			$Model = M(ucfirst($module));
			$info  = $Model->where('id='.$id)->find();
			$this->assign('info',$info);
		}
		$this->display('Extend:'.$module.'Edit');
	}
	
	function delete(){
		$id    = (int)$_GET['id'];
		$Model = M(ucfirst($_GET['module']));
		
		if(empty($id) || !is_numeric($id)) $this->ajaxReturn(null,'非法操作！',0);
		$Model->delete($id);
		$this->ajaxReturn(null,'删除成功！',1);
	}
	
	public function __call($name,$arguments) {
        $this->index($name);
    }
	 
}
?><?php 