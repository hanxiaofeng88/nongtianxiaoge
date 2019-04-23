<?php 
class TabsWidget extends Widget 
{
	public function render($data)
	{
		if(empty($data['status'])) return false;
		$ids = is_array($data['id'])?implode(',', $data['id']):$data['id'];
		$category = M('Category')->where("id IN($ids)")->select();
		$Item = M('Item');
		foreach($category as &$cat){
			$where = "is_delete=0 AND status=1 AND image!='' AND category_id={$cat['id']}";
			$cat['data'] = $Item->where($where)->field('id,sn,name,brief,price,image,thumb')->limit($data['num'])->order('sort_order ASC')->select();
		}
		$list['data'] = $category;
		return $this->renderFile ("index", $list);
	}
}
?><?php 