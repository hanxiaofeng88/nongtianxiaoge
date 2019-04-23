<?php 
defined('THINK_PATH') OR exit();
class AliziAction extends Action{
    
        protected $aliziConfig="";//阿狸子配置信息
        protected $aliziHost =""; //阿狸子地址
        public function _init(){ 
			//if(empty($_SESSION['member']) && !in_array(ACTION_NAME,array('login','pass','reg'))){  header('location:'.C('ALIZI_ROOT').'index.php?m=User&a=login&goto='.urlencode("http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"));}

            $this->aliziAuth();
            if(!file_exists('./Public/Database/install.lock')){ header('location:index.php?m=Install');exit;}
            $this->aliziConfig = $this->aliziConfig();
            $this->aliziHost = "http://{$_SERVER['HTTP_HOST']}".C('ALIZI_ROOT');
            $this->assign('aliziHost',$this->aliziHost);
            $this->assign('aliziConfig',$this->aliziConfig);
            $this->ipDenied();
            
            //伪静态后参数
            if(C('URL_MODEL')==2){
                if(isset($_SERVER['HTTP_X_REWRITE_URL'])){
                    $uri = $_SERVER['HTTP_X_REWRITE_URL'];
                }else{
                    $uri = $_SERVER['REQUEST_URI'];
                }
                $url = parse_url($uri);
                if(isset($url['query'])){
                    parse_str($url['query'],$query);
                    $_GET = array_merge($_GET,$query);
                }
            }
            if(isset($_GET['ac'])){  cookie('ac',$_GET['ac']); }
        }

        public function verify(){
            import('ORG.Util.Image');
            $lenght = isset($_GET['lenght'])?$_GET['lenght']:4;
            $width = isset($_GET['width'])?$_GET['width']:55;
            $height = isset($_GET['height'])?$_GET['height']:32;
            Image::buildImageVerify($lenght,1,'png',$width,$height);
        }

    public function aliziConfig(){
        $config = cache('aliziConfig');
        if(empty($config)){
            $list = M('Setting')->select();
            foreach($list as $li) $config[$li['name']] = $li['value'];
            cache('aliziConfig',$config,8640000);
        }
        return $config;
    }
    public function getAliziPayment($item_id){
        return  R('Api/getAliziPayment',array('item_id'=>$item_id));
    }
    public function getItemParams($opt='',$options=array()){
        $checked = empty($opt)?json_decode($this->aliziConfig['order_options'],true):json_decode($opt,true);
        
        $options = $options?$options:C('TEMPLATE_OPTIONS');
        foreach($options as $k=>$v){
            $options[$k]['checked'] = in_array($k,$checked)?true:false;
        }
        return  $options;
    }

    //黑名单IP
    public function ipDenied(){
		if(!empty($this->aliziConfig['safe_ip_denied'])){
			$ip = get_client_ip();
			$this->aliziConfig['safe_ip_denied'] = str_replace('%', '#', $this->aliziConfig['safe_ip_denied']);
			$ipDenied = explode('#', $this->aliziConfig['safe_ip_denied']);
			foreach($ipDenied as $ips){
				if( (strstr($ips, '*') && preg_match('/'.$ips.'/', $ip)) || $ips==$ip){
					 header('HTTP/1.1 404 Not Found'); 
					die('Access Denied');
				}
			}
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
			
			if($auth){
				if(C('ALIZI_AUTH_TYPE')=='database'){
					$DB_HOST = C('DB_HOST');
					$DB_USER = C('DB_NAME');
					if(empty($DB_HOST) || empty($DB_USER)) return true;
					$authArray = @explode(',', $auth);
					foreach($authArray as $li){
						if($li==$DB_HOST.'&&'.strtolower($DB_USER)){
							cache($cacheName,$md5Code,864000);
							return true;
						}
					}
				}else{
					$authArray = @explode(',', $auth);
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

    public function weixinShare(){
        if(empty($this->aliziConfig['weixin_status'])) return false;
        //if(isWeixin()==false) return false;
        $options = array(
            'token'=>$this->aliziConfig['weixin_token'],
            'encodingaeskey'=>$this->aliziConfig['weixin_encodingaeskey'],
            'appid'=>$this->aliziConfig['weixin_appid'],
            'appsecret'=>$this->aliziConfig['weixin_appsecret'],
        );

        Vendor('wechat.wechat#class');
        $weObj = new Wechat($options);
        $url = "http://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}";
        $timestamp = time();
         
        $randCode = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM_";
        return $weObj->getJsSign($url, $timestamp);
    }

    public function _empty($name){
            $this->display('Order:404');
    }

    protected function systemStatus($moduleName){
        if(in_array($moduleName, array('Index','Item','Wap'))){
            $wap = 'Item';
			$get = $_GET;unset($get['_URL_']);
            switch ($this->aliziConfig['system_status']) {
                case '0':
                    if(preg_match("/^(http|https)/i", $this->aliziConfig['system_close_info'])){
                        header('location:'.$this->aliziConfig['system_close_info']);   
                    }elseif(preg_match("/^(\/)/i", $this->aliziConfig['system_close_info'])){
                        header('location:'.C('ALIZI_ROOT').ltrim($this->aliziConfig['system_close_info'],'/'));  
                    }else{
                        R('Order/index',array('id'=>$this->aliziConfig['system_close_info'],'tpl'=>'detail',));exit;    
                    }
               break;
               case '2':  
                if($moduleName=='Index'){
                    $this->redirect($wap.'/'.ACTION_NAME,$get);exit;
                }
               break;
               case '3':  
                if($moduleName==$wap){
                    $this->redirect('/');exit;
                }
               break;
               default:
                if(isMobile()==true && in_array($moduleName, array('Index'))){
                   $this->redirect($wap.'/'.ACTION_NAME,$get);exit;
                }
                break;
            }
        }
    }

}
?><?php 