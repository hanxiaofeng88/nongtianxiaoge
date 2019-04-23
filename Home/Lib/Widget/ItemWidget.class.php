<?php 
class ItemWidget extends Widget 
{
	public function render($data)
	{	
		$list['data'] = $data;
		return $this->renderFile ("index", $list);
	}
}
?><?php 