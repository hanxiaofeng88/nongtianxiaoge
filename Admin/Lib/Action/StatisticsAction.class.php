<?php 
class StatisticsAction extends AliziAction {
	public function _initialize(){
        parent::_init();
    }
	function index(){
		$Model = M('Order');
		$start = !empty($_GET['start'])?strtotime($_GET['start']):0;
		$end = !empty($_GET['end'])?strtotime($_GET['end']):time();
		$map = " AND add_time BETWEEN $start AND $end ";

		$list = $Model->query("SELECT item_id,item_name,sum(total_price) as total_price,count(id) as quantity FROM __TABLE__ WHERE is_delete=0 $map GROUP BY item_id ORDER BY quantity DESC");
		$status = C('ORDER_STATUS');
		foreach ($list as $key => $value) {
			foreach($status as $k=>$v){
				$count = $Model->query("SELECT `status`,sum(total_price) as price,count(id) as quantity FROM __TABLE__ WHERE status=$k AND item_id='{$value['item_id']}' AND is_delete=0 $map");
				$list[$key]['status'][$k] = $count[0];
			}
		}

		$this->assign('list',$list);
		$this->assign('status',$status);
		$this->display('Statistics/index');
	}

	function channel(){
		$Model = M('Order');
		$start = !empty($_GET['start'])?strtotime($_GET['start']):0;
		$end = !empty($_GET['end'])?strtotime($_GET['end']):time();
		$map = " AND add_time BETWEEN $start AND $end ";
		
		$list = $Model->query("SELECT channel_id,sum(total_price) as total_price,count(id) as quantity FROM __TABLE__ WHERE is_delete=0 AND channel_id!='' AND channel_id!='0' $map GROUP BY channel_id ORDER BY quantity DESC");
		$status = C('ORDER_STATUS');
		foreach ($list as $key => $value) {
			foreach($status as $k=>$v){
				$count = $Model->query("SELECT `status`,sum(total_price) as price,count(id) as quantity FROM __TABLE__ WHERE status=$k AND channel_id='{$value['channel_id']}' AND is_delete=0 $map ");
				$list[$key]['status'][$k] = $count[0];
			}
		}
		
		$this->assign('list',$list);
		$this->assign('status',$status);
		$this->display('Statistics/channel');
	}
	public function byDate($date='',$cache=864000){
		$date = $date?$date:date('Y-m-d');
		$Order = M('Order');
		$status = C('ORDER_STATUS');

		$statistics = S('statistics-'.$date);
		if(empty($statistics)){
			foreach($status as $k=>$v){
				$map = ($this->role=='admin')?"":" AND user_id ={$this->uid}";
				$count = $Order->query("SELECT `status`,sum(total_price) as price,count(id) as quantity FROM __TABLE__ WHERE is_delete=0 AND status=$k AND FROM_UNIXTIME(add_time,'%Y-%m-%d')='{$date}' $map");
				$count[0]['name'] = $v;
				$statistics[$k] = $count[0];
			}
			if($date!=date('Y-m-d')){
				 S('statistics-'.$date,$statistics,$cache);
			}
		}
		return $statistics;
	}
	 
}
?><?php 