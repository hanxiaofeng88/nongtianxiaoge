<?php  
defined('THINK_PATH') OR exit();
class ItemAction extends AliziAction {

    public function _initialize(){
        parent::_init();
        parent::systemStatus(MODULE_NAME);
        $this->assign('article',M('Article')->where('is_delete=0 and status=1')->order('sort_order ASC,id DESC')->limit(4)->select());
    }

    public function index(){
        $Model = D('Item');
		if($this->aliziConfig['slider_show']==1 && $this->aliziConfig['slider_num']>0){
			$slider  = M('Advert')->where(array('status'=>1))->order('sort_order ASC,id DESC')->limit($this->aliziConfig['slider_num'])->select();
		}

		$this->assign('slider',$slider);
		$this->assign('hot',$Model->hotList());
        $this->display('Item/index');
    }

    public function order($id){
        $info = getCache('Item',array('sn'=>$id));
        if(empty($info)) $this->error(lang('empty_item'));

        $this->assign('info',$info);
        $this->assign('aliziConfig',$this->aliziConfig);
        $this->display('Item/order');
    }

    public function category(){
          $category = M('Category')->where('type=1')->order('sort_order desc')->select();
          $this->assign('category',$category);
		$this->display('Item/category');
    }
    public function getCategoryList(){
         $Model = D('Item');
         $kw = addslashes(str_replace(' ', '', $_GET['kw']));
         $where = 'status=1 AND is_delete=0';
         if(!empty($_GET['id'])){
             $where .= " AND category_id=".intval($_GET['id']);
         }else{
            $category = M('Category')->field('id')->where('type=1')->select();
            foreach ($category as $cid) { $category_id[] = $cid['id']; }
            $where .= " AND category_id IN(".implode(',', $category_id).")";
         }
         if(!empty($kw)) $where .= " AND name LIKE '%{$kw}%' ";
          $list = $Model->field('id,sn,name,price,image,thumb,brief')->where($where)->order('is_hot desc,sort_order ASC')->select();
          foreach($list as &$li){
             $li['url'] = U('Item/order',array('id'=>$li['sn']));
             $li['image'] = imageUrl($li['image']);
             $li['thumb'] = imageUrl($li['thumb']);
          }
          $this->ajaxReturn($list,'success',$list?1:0);
    }

    public function query(){
      $this->display('Item/query');
    }
    public function article(){
      $Model = D('Article');
      $where = array('is_delete'=>0);
      if(isset($_GET['id'])) $where['category_id'] = (int)$_GET['id'];

       import('ORG.Util.Page');
      $count = $Model->where($where)->count();
      $page  = new Page($count,10);
      $list = $Model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('sort_order ASC,id ASC')->select();
      $category = M('Category')->where('type=2')->order('sort_order ASC,id ASC')->select();

      $this->assign('page',$page->show());
      $this->assign('category',$category);
      $this->assign('list',$list);
      $this->display();
    }
    public function detail(){
      $id = (int)$_GET['id'];
      $info = getCache('Article',array('id'=>$id));
      $category = M('Category')->where('type=2')->order('sort_order ASC,id ASC')->select();
      $this->assign('category',$category);
      $this->assign('info',$info);
      $this->display();
    }

}?><?php 