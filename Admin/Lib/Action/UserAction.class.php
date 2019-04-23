<?php 
class UserAction extends AliziAction {
	public function _initialize(){
        parent::_init();
    }
	function index($role='admin'){
		
		$id = (int)$_GET['id'];
		$do = trim($_GET['do']);
		if(!empty($do)){
			$this->info($id);
			$this->display($do);exit;
		}
		$keyword = trim($_GET['keyword']);
		
		$Model = D('User');
		import('ORG.Util.Page');
		$where = "is_delete=0 AND role='{$role}' ";
	
		if(!empty($keyword)) $where .= " AND (username LIKE '%{$keyword}%' )";
		$order = empty($orderby)?"id desc":"{$orderby} {$sort}";
		$count = $Model->where($where)->count();
		$page  = new Page($count,15);
		
		$list  = $Model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
		$show  = $page->show();
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display(__FUNCTION__);
    } 

    function member(){
    	$this->index('member');
    }
	
	//查看用户信息
	function info($user_id){
		$info = M('User')->where('id='.$user_id)->find();
		$this->assign('info',$info);
	}
	
	
}
?><?php 