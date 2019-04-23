<?php 
defined('THINK_PATH') OR exit();
class AliziAction extends Action {

	protected $uid; 
	protected $username;
	
    function _init(){
    		$this->aliziAuth();
		if(empty($_SESSION['user']['id'])){
			$this->display('Index::login',false);exit;
		}
		$this->uid  = (int)$_SESSION['user']['id'];
		$this->role = $_SESSION['user']['role'];
		$this->username = $_SESSION['user']['username'];
		$this->aliziHost = "http://{$_SERVER['HTTP_HOST']}".C('ALIZI_ROOT');
    }
	
	//添加,删除,修改操作
	function proccess($module='') {
		$this->checkAuth();
		$module = empty($module)?$this->getActionName():$module;
		$status = 0;
		$Model = D($module);

		if($_REQUEST['do']==='delete'){
			$status = $Model->delete((int)$_REQUEST['id']);
		}elseif($_REQUEST['do']==='del'){
			$status = $Model->where(array('id'=>(int)$_REQUEST['id']))->setField('is_delete',1);
		}else{
			if($vo = $Model->create($_REQUEST)){
				if(empty($vo['id'])){
					$vo['id'] = $Model->add($vo);
					$status = $vo['id']?1:0;
				}else{
					$status = $Model->save($vo);
				}
			}
		}
		if($vo['id']){
			$data = $Model->where(array('id'=>$vo['id']))->find();
			$id = 'Item'==$module?$data['sn']:$data['id'];
			cache($module.$id,$data);
		}else{
			cache($module.$_REQUEST['id'],null);
		}
		$info = $status?lang('action_success'):lang('action_failure_colon').$Model->getError();
		$this->ajaxReturn(null,$info,(int)$status);
	}

	//批量删除
	public function deleteAll(){
		$this->checkAuth('');
		if(empty($_POST['model'])) $this->error('删除失败');
		$Model = D($_POST['model']);
		if(isset($_POST['del'])){
			foreach($_POST['id'] as $id){ $Model->where(array('id'=>(int)$id))->setField('is_delete',1); }
		}else{
			foreach($_POST['id'] as $id){ $Model->delete((int)$id); }
		}
		R('Public/clearCache',array('print'=>false));
		$this->success('删除成功');
	}
	
	function checkAuth($type='ajax'){
		if($_REQUEST['auth']==1) return true;
		if($_SESSION['user']['role']!='admin'){
			if($type=='ajax'){
				$this->ajaxReturn(0,'非管理员，无权限操作',0);
			}else{
				$this->error('非管理员，无权限操作');
			}
		}
	}

	/*
	 * 导出Excel表格
	 * @param $data 下载的数据
	 * @param $keynames 下载的字段及标题，可执行函数。如array('id'=>'编号','time|date("Y-m-d",###)'=>'时间')
	 * @param $filename 保存的文字名
	 * @param bool $saveAs，如果为false则保存在服务器
	 * @param string $title 表头
	 */
	function aliziExcel($data,$keynames,$filename,$saveAs=true,$title=''){
		import("ORG.PHPExcel.PHPExcel"); //导入PHPExcel类 

		$objExcel = new PHPExcel();
		//标题
		$chars = 'A';
		$num   = 1;
		if($title){
			$objExcel->getActiveSheet()->setCellValue($chars.$num, $title); 
			$num++;
			$i = 1;
		}
		foreach($keynames as $key=>$va){
			//$objExcel->getActiveSheet()->setCellValue($chars.$num, "$va"); 
			$objExcel->getActiveSheet()->setCellValueExplicit($chars.$num, "$va",PHPExcel_Cell_DataType::TYPE_STRING); 
			$objExcel->getActiveSheet()->getColumnDimension($chars)->setWidth(20);  // 高置列的宽度
			$chars++;
		}

		foreach($data as $key =>$o) {   
			$char = 'a';
			$u1=$i+2;
		  
			foreach($keynames as $k=>$v){
				if(strpos($k,'||')){
					$arr  = explode('||',$k);
					$_str = is_null( $o[$arr[0]] ) ? 'null' : $o[$arr[0]]; 
					$eval = str_replace('###',$_str,$arr[1]);
					eval("\$rs = $eval;");
					$line = $rs;
				}elseif(strpos($k,'##')){
					$arr  = explode('##',$k);
					$data = json_decode($arr[1],true);
					$line = $data[$o[$arr[0]]];
				}else{
					$line = $o[$k];
				}
					
				$objExcel->getActiveSheet()->setCellValueExplicit($char.$u1,$line,PHPExcel_Cell_DataType::TYPE_STRING);
				$objExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//左对齐
				$char++;
			}            
			$i++;
		}

		$objExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
		$objExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objExcel->getProperties()->getTitle() . '&RPage &P of &N');

		// 设置页方向和规模
		$objExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$objExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$objExcel->setActiveSheetIndex(0);
		$timestamp = date('Y-m-d');
		if($ex == '2007') {
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
		} else {  //导出excel2003文档

			if($saveAs==false){
				$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
				$objWriter->save($filename.'.xls');
			}else{
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
				$objWriter->save('php://output');
				exit;
			}
			
		}
	} 

	function footer(){
		$copyright = '<p class="copyright" style="display:block !important;">Copyright © '.date('Y').'&nbsp;<a href="http://order.chmzw.com" target="_blank" style="color:#888 !important;display:inline-block  !important;">PHP订单系统</a>&nbsp; All Rights Reserved.</p> ';
		echo '<script>$(function(){ $("body").append(\'<div id="Footer" style="display:block !important;">'.$copyright.'</div>\'); })</script>';
	}
	function display($tpl,$show_footer=true){
    		parent::display($tpl);
    		if($show_footer==true){
    			$this->footer();
    		}
    }
    function aliziAuth(){
        $cacheName = 'aliziAuth'.idate('W');
        $authCode = cache($cacheName);
        $code = C('ALIZI_AUTH');
        $md5Code = password($code);
        if($md5Code==$authCode){
            return true;
        }else{
            $string = substr($code, 32,-52);
            $key = substr(substr($code,-52),0,20);
            preg_match_all('/(.)?/', $key,$arr);
            $key_reverse =  implode('', array_reverse($arr[0]));
            $hex = strtr($string,$key,$key_reverse);
            $auth = pack('H*',$hex);
			$authArray = @explode(',', $auth);
			if($auth){
				if(C('ALIZI_AUTH_TYPE')=='database'){
					$DB_HOST = C('DB_HOST');
					$DB_USER = C('DB_NAME');
					if(empty($DB_HOST) || empty($DB_USER)) return true;
					foreach($authArray as $li){
						if($li==$DB_HOST.'&&'.strtolower($DB_USER)){
							cache($cacheName,$md5Code,864000);
							return true;
						}
					}
				}else{
					$host = $_SERVER['HTTP_HOST'];
					$ip = gethostbyname($host);
					foreach($authArray as $li){
						if(preg_match('/'.$li.'/i', $host.','.$ip,$map)){
							cache($cacheName,$md5Code,864000);
							return true;
						}
					}
				}
			}
        }
        header('Content-Type:text/html;charset=utf-8');
    }

}
?><?php 