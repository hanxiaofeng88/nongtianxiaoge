<?php  
class ItemModel extends Model {

	protected $fields = 'id,sn,category_id,name,original_price,price,image,thumb,is_hot,brief,timer';

	public function _initialize($aliziConfig){
 		parent::_initialize();
 		$this->aliziConfig = R('Alizi/aliziConfig');
	}

	public function hotList(){
    		$list   = array();
                    $list['title'] = lang('hotItem');
    		$where = "is_delete=0 AND status=1 AND image!='' ";
    		if($this->aliziConfig['item_hot_show']==1 && $this->aliziConfig['item_hot_num']>0){
    			$list['list']  = $this->field($this->fields)->where($where)->order('is_hot DESC,sort_order ASC,id DESC')->limit($this->aliziConfig['item_hot_num'])->select();
    		}
    		return $list['list']?$list:array();
    }

    public function categoryList(string $item_category_id,$num=5 ){
    	$data   = array();
            $category = is_array($item_category_id)?$item_category_id:explode(',', $item_category_id);
            $CategoryModel = M('Category');
            foreach($category as $cid){
                $title = $CategoryModel->where(array('type'=>1,'id'=>$cid))->getField('name');
                $list  = $this->field($this->fields)->where("is_delete=1 AND status=1 AND category_id={$cid}")->order('sort_order ASC,id desc')->limit($num)->select();
                $data[] = array('title'=>$title,'list'=>$list);
            }
    	return $data;
    }

}
?><?php 