<?php 
class ShippingAction extends AliziAction {
	public function _initialize(){
        parent::_init();
    }
	public function index(){
		$list = M('Shipping')->order('id asc')->select();
		$this->assign('list',$list);
		$this->display('Shipping:index');
	}
	public function edit(){
		$Model = M('Shipping');
		if(IS_POST){
			$data = $Model->create();
			if( isset($_POST['id']) && !empty($_POST['id']) ){
				$data['update_time'] = time();
				$data['is_free_num'] = isset($_POST['is_free_num'])?1:0;
				$data['is_free_cost'] = isset($_POST['is_free_cost'])?1:0;
				$Model->save($data);
				getCache('Shipping',array('id'=>$data['id']),true);
			}else{
				$data['id'] = $Model->add($data);
			}
			$this->ajaxReturn(array('id'=>$flag,'name'=>$data['name']),'操作成功',1);
		}else{
			$id = (int)$_GET['id'];
			if($id){
				$info = $Model->where(array('id'=>$id))->find();
				$this->assign('info',$info);
			}
			$this->display();
		}
	}
}
?><?php 