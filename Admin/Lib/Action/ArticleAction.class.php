<?php 
class ArticleAction extends AliziAction {
	
	public function _initialize(){
        parent::_init();
    }
    
	function index($action=''){
	
		if(isset($_GET['do'])){
			$method = $_GET['do'];
			$this->$method($_GET['id']);exit;
		}
		
		$Model = M('Article');
		$keyword = isset($_GET['keyword'])?trim($_GET['keyword']):'';
		$category_id = isset($_GET['category_id'])?intval($_GET['category_id']):0;
		$where = "is_delete=0";
		if(!empty($keyword)) $where .= " AND name LIKE '%$keyword%' ";
		if(!empty($category_id)) $where .= " AND category_id=".$category_id;
		$order = "sort_order ASC,id DESC";
		
		import('ORG.Util.Page');
		$count = $Model->where($where)->count('distinct(id)');
		$page  = new Page($count,20);
		$list  = $Model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
		$show  = $page->show();
		$category = M('Category')->where('type=2')->order('sort_order desc,id asc')->select();
		$this->assign('category',$category);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display();
	}
	
	//内容编辑
	function edit($id=''){

		$where = array('id'=>(int)$id);
		$info  = M('Article')->where($where)->find();
		if($info){
			$info['params'] = json_decode($info['params'],true);
			$info['send_to'] = json_decode($info['send_to'],true);
			$info['extends'] = json_decode($info['extends'],true);
		} 
		$category = M('Category')->where('type=2')->order('sort_order desc,id asc')->select();

		$this->assign('category',$category);
		$this->assign('info',$info);
		$this->display('edit');
	}

	public function todo(){
	 	if(IS_POST){
	 		if(isset($_POST['sort'])){
	 			$Model = M('Article');
	 			foreach($_POST['sort_order'] as $k=>$v){ $Model->where(array('id'=>$k))->setField('sort_order',$v); }
	 			$this->success('排序成功');
	 		}else{
	 			parent::deleteAll();
	 		}

	 	}
	 }


	//批量删除
	public function deleteAll(){
		$this->checkAuth('');
		$Model = D('Article');
		foreach($_POST['id'] as $id){
			$Model->delete((int)$id);
		}
		$this->success('删除成功');
	}

	//分类栏目
	public function category(){
		$action = 'Category/category';
		R($action,array('type'=>2));
		$this->display($action);
	}
	 
}
?><?php 