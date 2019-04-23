<?php 
class RecycleAction extends AliziAction {
	public function _initialize(){
        parent::_init();
    }
	public function item(){
		$Model = M('Item');
		$keyword = isset($_GET['keyword'])?trim($_GET['keyword']):'';
		$category_id = isset($_GET['category_id'])?intval($_GET['category_id']):0;
		$where = "is_delete=1";
		if(!empty($keyword)) $where .= " AND name LIKE '%$keyword%' ";
		if(!empty($category_id)) $where .= " AND category_id=".$category_id;
		$order = "sort_order ASC,id DESC";
		
		import('ORG.Util.Page');
		$count = $Model->where($where)->count('distinct(id)');
		$page  = new Page($count,20);
		$list  = $Model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
		$show  = $page->show();

		$this->assign('category',$category);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display('Recycle:item');
	}

	public function order(){
		$Model = M('Order');
		$fields = trim($_GET['fields']);
		$status = $_GET['status'];
		$keyword = trim($_GET['keyword']);
		$category_id = intval($_GET['category_id']);
		$time_start = strtotime($_GET['time_start']);
		$time_end   = strtotime($_GET['time_end'])+86400;
		$where = "is_delete=1";
		if($this->role!='admin') $where .= " AND user_id ={$this->uid}";
		if(!empty($keyword)) $where .= " AND $fields LIKE '%$keyword%' ";
		if(is_numeric($status)) $where .= " AND status ={$status} ";
		if(!empty($time_start) && $time_start < ($time_end)) $where .= " AND (add_time BETWEEN {$time_start} AND {$time_end})";
		if(!empty($category_id)) $where .= " AND category_id={$category_id}";
		if(!empty($payment)){
			$where .= $payment==1? " AND payment =1":" AND payment !=1";//payment=1货到付款，其它为在线支付
		}
		$order = empty($orderby)?"id DESC":"{$orderby} {$sort}";
		
		import('ORG.Util.Page');
		$count = $Model->where($where)->count();
		$page  = new Page($count,20);
		$list  = $Model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
		$show  = $page->show();
	
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display('Recycle:order');
	}	

	function user(){
		
		$id = (int)$_GET['id'];
		$do = trim($_GET['do']);
		$keyword = trim($_GET['keyword']);
		
		$Model = D('User');
		import('ORG.Util.Page');
		$where = "is_delete=1";
	
		if(!empty($keyword)) $where .= " AND (username LIKE '%{$keyword}%' )";
		$order = empty($orderby)?"id desc":"{$orderby} {$sort}";
		$count = $Model->where($where)->count();
		$page  = new Page($count,15);
		
		$list  = $Model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
		$show  = $page->show();
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display('Recycle:user');
    } 

    function todo(){
	  	if(isset($_POST['recover'])){
	  		M($_POST['model'])->where('id IN('.implode(',', $_POST['id']).')')->setField('is_delete',0);
	  		$this->success(lang('恢复成功'));
	  	}else{
	  		$this->checkAuth('');
			$Model = D($_POST['model']);
			foreach($_POST['id'] as $id){
				$Model->delete((int)$id);
			}
			$this->success('删除成功');
	  	}
    }
}
?><?php 