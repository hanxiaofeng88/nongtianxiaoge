<?php 
class IndexAction extends AliziAction {
	public function _initialize(){
        parent::_init();
    }
    public function index(){
        $Statistics = new StatisticsAction();
        $today = $Statistics->byDate();
        $yesterday = $Statistics->byDate(date('Y-m-d',strtotime('-1 days')));

        $this->assign('today',$today);
        $this->assign('yesterday',$yesterday);
        $this->display();
    }
	
    //用户信息
    function account(){
            R('User/info',array('id'=>$this->uid));
            $this->display();
    }


    //魔术棒解析扩展工具
    public function __call($name,$arguments) {
        $extend = 'Extend/'.$name;
        R($extend);
        $this->display($extend);
    }

    public function smsBalance(){
    	header('Content-type: application/json');  
    	$aliziConfig = S('aliziConfig');
            if(empty($aliziConfig['sms_account']) || empty($aliziConfig['sms_password'])){
                $json = json_encode(array('status'=>0,'data'=>0));
            }else{
                $data = array(
                    'method'=>'balance',
                    'account'=>$aliziConfig['sms_account'],
                    'password'=>$aliziConfig['sms_password'],
                );
                $json = http( C('ALIZI_API').'/sms/', 'POST', $data );
            }
    	die($json);
    }
}
?><?php 