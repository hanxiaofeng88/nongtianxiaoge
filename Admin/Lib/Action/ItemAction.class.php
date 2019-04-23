<?php 
class ItemAction extends AliziAction {
	public function _initialize(){
        parent::_init();
    }
	function index($action=''){
		if(isset($_GET['do'])){
			$method = $_GET['do'];
			$this->$method($_GET['id']);exit;
		}
		
		$Model = M('Item');
		$keyword = isset($_GET['keyword'])?trim($_GET['keyword']):'';
		$category_id = isset($_GET['category_id'])?intval($_GET['category_id']):0;
		$where = "is_delete=0";
		if(!empty($keyword)) $where .= " AND (name LIKE '%$keyword%'  OR sn='{$keyword}')";
		if(!empty($category_id)) $where .= " AND category_id=".$category_id;
		if($this->role!='admin') $where .= " AND status=1";
		$order = "sort_order ASC,id DESC";
		
		import('ORG.Util.Page');
		$count = $Model->where($where)->count('distinct(id)');
		$page  = new Page($count,20);
		$list  = $Model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
		$show  = $page->show();
		$category = M('Category')->where('type=1')->order('sort_order desc,id asc')->select();

		
		$aliziConfig = cache('aliziConfig');
		foreach ($list as $key => $value) {
			if($aliziConfig['URL_MODEL']==2){
				$url = array(
					'url'=>$this->aliziHost."id/{$value['sn']}.html",
					'order'=>$this->aliziHost."single/{$value['sn']}-{$this->uid}.html",
					'detail'=>$this->aliziHost."detail/{$value['sn']}-{$this->uid}.html",
				);
			}else{
				$url = array(
					'url'=>$this->aliziHost."index.php?m=Index&a=order&id={$value['sn']}",
					'order'=>$this->aliziHost."index.php?m=Order&id={$value['sn']}&uid={$this->uid}",
					'detail'=>$this->aliziHost."index.php?m=Order&id={$value['sn']}&uid={$this->uid}&tpl=detail",
				);
			}
			$list[$key]['url']=$url;
		}

		$this->assign('category',$category);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->assign('aliziHost',$this->aliziHost);
		$this->display($this->role=='admin'?'index':'itemList');
	}
	
	//内容编辑
	function edit($id=''){

		$where = array('id'=>(int)$id);
		$info  = M('Item')->where($where)->find();
		if($info){
			$info['params'] = json_decode($info['params'],true);
			$info['send_to'] = json_decode($info['send_to'],true);
			$info['extends'] = json_decode($info['extends'],true);
			$info['sms_send'] = json_decode($info['sms_send'],true);
		} 
		$category = M('Category')->where('type=1')->order('sort_order desc,id asc')->select();
		$shipping = M('Shipping')->order('id asc')->select();
		$this->assign('shipping',$shipping);
		$this->assign('category',$category);
		$this->assign('info',$info);
		$this->display('edit');
	}
	function copy($id=''){
		$this->edit($id);
	}

	function using($id){
		$where = array('id'=>(int)$id);
		$info  = M('Item')->where($where)->find();
		$ItemTemplate = M('ItemTemplate');
		$template  = $ItemTemplate->where(array('id'=>$id))->find();

		$aliziConfig = cache('aliziConfig');
		$options = C('TEMPLATE_OPTIONS');
		$checked = !empty($template['options'])? json_decode($template['options'],true):json_decode($aliziConfig['order_options'],true);
		foreach($options as $k=>$v){
			$options[$k]['checked'] = in_array($k,$checked)?true:false;
		}
		$customColor = $this->getCustomColor($template['template'],'array');
		$this->assign('deaultColor',$customColor);
		$this->assign('channel',M('Channel')->order('id asc')->select());
		$this->assign('url',$this->getUrl($info['sn']));
		$this->assign('info',$info);
		$this->assign('temp',$template);
		$this->assign('options',$options);
		$this->assign('extend',unserialize($template['extend']));
		$this->assign('custom',$this->getCustom());
		$this->display('using');
	}

	function template(){
		if(empty($_POST['options'])) $this->ajaxReturn(0,'请选择表单选项',0);
		$_POST['options'] = json_encode($_POST['options']);
		
		$extend = array(
			'padding'=>$_POST['padding'],
			'bottom_nav'=>$_POST['bottom_nav'],
			'bottom_nav_list'=>$_POST['bottom_nav_list'],
		);

		$Model = M('ItemTemplate');
		$data = $Model->create();
		$data['color'] = json_encode($_POST['color']);
		$data['extend'] = serialize($extend);
		foreach ($data as &$v) { $v=(!get_magic_quotes_gpc())?addslashes($v):$v; }
		
		$Model->query("REPLACE INTO __TABLE__(`".implode('`,`',array_keys($data))."`) VALUES('".implode("','",array_values($data))."')");

		cache('ItemTemplate'.$data['id'],$data);
		$this->ajaxReturn(null,1,1);
	}
	public function getUrl($id){
		$aliziConfig = cache('aliziConfig');
		if($aliziConfig['URL_MODEL']==2){
			$url = array(
				'order'=>$this->aliziHost."single/{$id}-{$this->uid}.html",
				'detail'=>$this->aliziHost."detail/{$id}-{$this->uid}.html",
			);
		}else{
			$url = array(
				'order'=>$this->aliziHost."index.php?m=Order&id={$id}&uid={$this->uid}",
				'detail'=>$this->aliziHost."index.php?m=Order&id={$id}&uid={$this->uid}&tpl=detail",
			);
		}
		return $url;
		
	}


	//分类栏目
	public function category(){
		$action = 'Category/category';
		R($action);
		$this->display($action);
	}
	 
	 public function todo(){
	 	if(IS_POST){
	 		if(isset($_POST['sort'])){
	 			$Model = M('Item');
	 			foreach($_POST['sort_order'] as $k=>$v){ $Model->where(array('id'=>$k))->setField('sort_order',$v); }
	 			$this->success('排序成功');
	 		}else{
	 			parent::deleteAll();
	 		}

	 	}
	 }

	 function getCustom($name=''){
	 	$dir = 'Home/Tpl/Alizi';
	 	$list = scandir($dir);
	 	$dirList = array();
	 	foreach($list as $li){
	 		$customDir = $dir.'/'.$li;
	 		if(is_dir($customDir) && !strstr($li,'.')){
	 			if(file_exists($customDir.'/config.php')){
		 			$config = include($customDir.'/config.php');
		 			$dirList[$li] = array('id'=>'Alizi/'.$li)+$config;
	 			}
	 		}
	 	}
	 	return empty($name)?$dirList:$dirList[$name];
	 }
	 function getCustomColor($tpl,$format='json'){
	 	$color = C('DEFAULT_COLOR');
	 	if(preg_match('/^Alizi\/(.*)/', $tpl,$map)){
			$tpl = $this->getCustom($map[1]);
			if(!empty($tpl['template']['default_color'])) $color=$tpl['template']['default_color'];
		}
		if($format=='json'){
			$this->ajaxReturn($color,'',1);
		}else{
			return $color;
		}
	 }
	 
}
?><?php 