<?php 
class SettingAction extends AliziAction {
	public function _initialize(){
        parent::_init();
    }
	//系统设置
	public function index(){
		$Model = M('Setting');
		if(IS_POST){
			$this->checkAuth();
			//print_r($_POST);exit;
			foreach($_POST as $k=>$v){
				if(isset($v[10000])) unset($v[10000]);
				$v = is_array($v)?json_encode($v):trim($v);
				$v=(!get_magic_quotes_gpc())?addslashes($v):$v;
				$where = array('name'=>$k);
				$flag = $Model->where($where)->find();
				if($flag){
					$Model->query("UPDATE __TABLE__ SET `value`='{$v}' WHERE `name`='{$k}' ");
				}else{
					$Model->query("INSERT INTO __TABLE__ (`name`,`value`) VALUES('{$k}','{$v}')");
				}
				if(in_array($k, array('URL_MODEL'))) $this->setConfig(array($k=>$v));
			}

			$list = $Model->select();
			foreach($list as $li) $aliziConfig[$li['name']] = $li['value'];
			cache('aliziConfig',$aliziConfig,8640000);
			$this->ajaxReturn(1,lang('modify_success'),1);
		}else{
			$list  = $Model->select();
			foreach($list as $vo){ $value[$vo['name']] = $vo['value']; }
			$this->assign('setting',C('setting'));
			$this->assign('value',$value);
			$this->display();
		}
	}
	
	function setConfig($config){
		$configFile = getcwd().'/Public/Common/alizi.db.php';
		$dbfile = include($configFile);
		$dbfile = array_merge($dbfile,$config);
		$fp = fopen($configFile, "w+");
		fwrite($fp, "<?php\n return ".var_export($dbfile,true)."\n?>");
		fclose($fp);
	}

	public function database(){
		$list = M()->query("SHOW TABLE STATUS FROM `".C('DB_NAME')."`");
		foreach($list as $k=>$v){
			if(!preg_match('/^'.C('DB_PREFIX').'/', $v['Name'])) unset($list[$k]);
		}
		$sqlFiles = glob('./Public/Database/Backup/*.sql');
		$sql = array();
		if(is_array($sqlFiles)) {
			asort($sqlFiles);
			foreach($sqlFiles as $sqlfile) {
				$sql[] = array(
					'file'=>$sqlfile,
					'name'=>basename($sqlfile),
					'size'=>number_format(filesize($sqlfile)/1024,2),
					'time'=>date('Y-m-d H:i:s', filemtime($sqlfile)),
				);
			}	
		}
		$this->assign('list',$list);
		$this->assign('sql',$sql);
		$this->display();
	}
	public function databaseBackup(){
		parent::checkAuth('');
		$tables = $_POST['id'];
		if(empty($tables)) $this->error('请选择备份的表');
		$Model = M();
		$strPad = str_pad('-', 50,'-');
		$sqlDump = "#{$strPad}\n#系统名称：PHP订单系统 \n#官方网址：order.chmzw.com \n#淘宝店铺：http://hiweb.taobao.com \n#备份时间：".date('Y-m-d H:i:s')."\n#{$strPad}\n\n\n";
		foreach($tables as $table){
			$create = $Model->query("SHOW CREATE TABLE `$table` ");
			$datas  = $Model->query("SELECT * FROM $table");
			$sqlDump .= "DROP TABLE IF EXISTS `$table`;\n";
			$sqlDump .= $create[0]['Create Table'].";\n\n";
			foreach ($datas as $data) {
				$sqlData = "";
				foreach($data as $k=>$li){
					$sqlData .= "'".addslashes($li)."',";
				}
				$sqlDump .= "INSERT INTO `$table` VALUES(".substr($sqlData, 0,-1).");\n";
			}
			$sqlDump .= "\n\n";
		}
		
		$rs = file_put_contents("./Public/Database/Backup/Alizi-".date('Ymdhis').".sql", $sqlDump);
		if($rs){
			$this->success('数据库备份成功');
		}else{
			$this->error('请选择备份的表');
		}
	}
	public function databaseDelete(){
		parent::checkAuth('');
		$tables = $_POST['id'];
		if(empty($tables)) $this->error('请选择要删除的备份');
		foreach($tables as $table){
			@unlink("./Public/Database/Backup/{$table}");
		}
		$this->success('备份文件删除成功');
	}
	public function databaseImport(){
		parent::checkAuth('');
		$backupFile = './Public/Database/backup.txt';
		if(!file_exists($backupFile)){
			$this->error('确认要恢复？<br />请在先Public/Database/目录添加backup.txt文件！');
		}
		@unlink($backupFile);
		$sql = file_get_contents('./Public/Database/Backup/'.trim($_GET['file']));
		$array_sql = preg_split("/;[\r\n]/", $sql);
		$Model = M();
		foreach($array_sql as $sql){
			$sql = trim($sql);
			if ($sql){ $ret = $Model->query($sql); }
		}
		$this->success('数据库恢复成功');
	}
	public function databaseDown(){
		$file = trim($_GET['file']);
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename='{$file}'");
		readfile('./Public/Database/Backup/'.$file);
	}

	public function sendMailTest(){
		$aliziConfig = cache('aliziConfig');
		$send = 'PHP订单系统-邮件测试';
		$data = array('email'=>$aliziConfig['mail_to'], 'title'=>$send,'content'=>$send);
		$data['sign'] = createSign($data,C('ALIZI_KEY'));
		$result = http($this->aliziHost.'index.php?m=Api&a=sendEmail','POST',$data);
		print_r($result);exit;
		$flag = json_decode($result,true);
		$this->ajaxReturn(1,$flag['info'],$flag['status']?1:0);
	}

	public function shipping(){ R('Shipping/index'); }
	public function channel(){ R('Channel/index'); }
	public function item(){ R('Recycle/item'); }
	public function order(){ R('Recycle/order'); }
	public function user(){ R('Recycle/user'); }
}
?><?php 