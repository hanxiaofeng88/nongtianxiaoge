<?php
defined('THINK_PATH') OR exit();
function lang($world){
	$array = explode('_',$world);
	$lang  = '';
	foreach($array as $value){
		if($value)$lang .= L($value);
	}
	return $lang;
}

function password($password){
	$pwd = trim($password);
	return hash_hmac('md5',md5($pwd),$pwd);
}

function mbSubstr($str,$len=25,$encoding='utf-8'){
	$str = strip_tags($str);
	$string = mb_substr($str,0,$len,$encoding);
	if(mb_strlen($str,'utf8')>$len) $string .= '...';
	return $string;
}

function errorLog($data,$filename=''){
	if(empty($filename)) $filename = C('DATA_CACHE_PATH').'Error-'.date('Ym').'.log';
	$log = array(
		'userId'   => $_SESSION['user']['id'],
		'clientIP' => get_client_ip(),
		'dateTime' => date('Y-m-d H:i:s'),
		'data'     => $data,
	);
	@file_put_contents($filename,var_export($log,true)."\n",FILE_APPEND);
}

function randCode($length=12, $chars = '0123456789') {
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++) {
		do{$num = $chars[mt_rand(0, $max)];}while($i==0 && $num==0);
		$hash .= $num;
	}
	return $hash;
}

function getFields($table,$fields,$id,$str=''){
	$Model = M($table);
	if(empty($str)){
		$expression='getByid';
	}else{
		$expression='getBy'.$str;
	}
	$thisaa=$Model->field($fields)->$expression($id);

	$bb=explode(',',$fields);
	if(count($bb)<=1){
		return $thisaa[$fields];
	}else{
		return $thisaa;
	}		
}

function status($status,$type='',$data='1:启用;0:禁用',$name='status'){
	if(is_array($data)){
		$data_array = $data;
	}else{
		$arr1 = explode(';',$data);
		foreach($arr1 as $a){
			$arr2 = explode(':',$a);
			$data_array[$arr2[0]] = $arr2[1];
		}
	}
	$tags = '';
	switch($type){
		case 'select':
			$tags = '';
			foreach($data_array as $k=>$v){
				$select = ctype_alnum($status)&&$k==$status?'selected="selected"':'';
				$tags .= '<option value="'.$k.'" '.$select.'>'.$v.'</option>';
			}
		break;
		case 'radio':
			$i = 0;
			foreach($data_array as $k=>$v){
				$i++;
				$checked = '';
				if((!ctype_alnum($status) && $i==1) || (ctype_alnum($status) && $k==$status)) $checked = 'checked="checked"';
				$tags .= '<input type="radio" name="'.$name.'" value="'.$k.'" '.$checked.' /><label class="ui-group-label">'.$v.'</label>';
			}
		break;
		case 'image':
			$image = $status==1?'true.png':'false.png';
			$tags  = '<img src="Public/Assets/img/'.$image.'" />';
		break;
		default:
			$tags = $data_array[$status];
	}
	return $tags;
}

function setting(array $param,$key,$output=''){
	extract($param);
	$readonly = $readonly==1?'readonly="readonly"':'';
	switch($tags){
		case 'text':
			$html = "<input type='{$tags}' name='{$key}' size='{$width}' autocomplete='off' class='ui-text {$class}' value='{$output}' {$readonly} />";
		break;
		case 'checkbox':
			$aliziConfig = empty($output)?array():json_decode(str_replace('\\', '', $output),true);
			if(is_array($options)){
				foreach($options as $k=>$v){
					$checked = in_array($k,$aliziConfig)?"checked='checked'":"";
					$html .= "<input type='{$tags}' name='{$key}[]' class='input-checkbox {$class}' value='{$k}' {$checked} {$readonly} /><label class='ui-group-label status-radio'>{$v}</label>";
				}
				$html .= "<input type='{$tags}' name='{$key}[10000]' value='10000' checked='checked' style='display:none'>";
			}else{
				$html = "Error.";
			}
		break;
		case 'radio':
			if(is_array($options)){
				foreach($options as $k=>$v){
					$checked = $k==$output?"checked='checked'":"";
					$html .= "<input type='{$tags}' name='{$key}' class='input-radio  {$class}' value='{$k}' {$checked} /><label class='ui-group-label status-radio'>{$v}</label>";
				}
			}else{
				$html = "Error.";
			}
		break;
		case 'textarea':
			$html = "<textarea name='{$key}' class='textarea  {$class}' cols='{$width}' rows='{$height}'>{$output}</textarea>";
		break;
		case 'select':
			if(is_array($options)){
				$html  = "<select name='{$key}' class='{$class}'>";
				foreach($options as $k=>$v){
					$selected = $k==$output?"selected='selected'":"";
					$html .= "<option value='{$k}' {$selected}>{$v}</option>";
				}
				$html .= "</select>";
			}else{
				$html = "Error.";
			}
		break;
		case 'file':
			$html  = "<input type='text' size='{$width}' name='{$key}' id='image-{$key}' class='ui-text  {$class}' style='float:left;' value='{$output}' /><input id='file_upload_{$key}' type='file' multiple='true' value='上传'>";
			if(!empty($output)) $html .= '<a id="view-'.$key.'" target="_blank" href="'.__PUBLIC__.'/Uploads/'.$output.'" style="margin-left:5px;" class="ui-button" >'.lang('view_image').'</a>';
		break;
		default:
			$html = "<input type='{$tags}' size='{$width}' name='{$key}' autocomplete='off' class='ui-text  {$class}' value='{$output}' />";
		break;
	}
	return $html;
}

function isEmail($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}
function isMobileNum($mobile) {
	return strlen($mobile) > 6 && preg_match("/1[345789]{1}\d{9}$/", $mobile);
}

function http( $url, $method = 'GET', array $postfields = array(), array $headers = array() ){
    $ci = curl_init();
    curl_setopt( $ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
    curl_setopt( $ci, CURLOPT_CONNECTTIMEOUT, 30 );
    curl_setopt( $ci, CURLOPT_TIMEOUT, 30 );
    curl_setopt( $ci, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ci, CURLOPT_ENCODING, 'gzip' );
    curl_setopt( $ci, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ci, CURLOPT_MAXREDIRS, 5 );
    curl_setopt( $ci, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ci, CURLOPT_HEADER, false );

    switch( strtoupper( $method ) )
    {
        case 'POST':
            curl_setopt( $ci, CURLOPT_POST, true );
            if ( !empty( $postfields ) )
            {
                curl_setopt( $ci, CURLOPT_POSTFIELDS, http_build_query( $postfields ) );
            }
            break;
        case 'DELETE':
            curl_setopt( $ci, CURLOPT_CUSTOMREQUEST, 'DELETE' );
            if ( !empty( $postfields ) )
            {
                $url = "{$url}?" . http_build_query( $postfields );
            }
            break;
        case 'GET':
            if ( !empty( $postfields ) )
            {
                $url = "{$url}?" . http_build_query( $postfields );
            }
            break;
    }
    
    curl_setopt($ci, CURLOPT_URL, $url );
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
    curl_setopt($ci, CURLINFO_HEADER_OUT, true );
    
    $response = curl_exec( $ci );
    curl_close ($ci);
    return $response;
}

function delFiles($dir='./Public/Cache/') {
  $dh = opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          delFiles($fullpath);
      }
    }
  }
  closedir($dh);
}

function isMobile(){
	$screen = cookie('screen');
	if(in_array($screen, array('pc','m'))){
		return $screen=='pc'?false:true;
	}
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
    $is_mobile = false;
    cookie('screen','pc');
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            cookie('screen','m');
            break;
        }
    }
    return $is_mobile;
}
function isWeixin(){
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	return strstr($user_agent,"MicroMessenger")?true:false;
}

function imageUrl($image){
	if(empty($image)) return '';
	if(strpos($image, 'http://')===0 || strpos($image, 'https://')===0){
		return $image;
	}else{
		return "http://{$_SERVER['HTTP_HOST']}".C('ALIZI_ROOT')."Public/Uploads".$image;
	}
}

function ksortRecursion( array &$data ){
    foreach( $data as &$v ) {
        is_array( $v ) && ksortRecursion( $v );
    }
    ksort( $data );
}

function createSign($data,$key){
	if(isset($data['sign']))unset($data['sign']);
	ksortRecursion( $data );
    return strtoupper( md5( strtolower( md5( http_build_query( $data ) ) ) . $key ) );
}

function getCache($table,$where,$refresh=false,$time=864000){
        $Model = ucfirst($table);
        $cacheName = $Model.implode('', $where);
        $data = cache($cacheName);
        if(empty($data) || $refresh==true){
            $data = M($Model)->where($where)->find();
            cache($cacheName,$data,$time);
        }
        return $data; 
    }
    function experss($com,$num){
    		if(empty($com) || empty($num)) return false;
    		$express = C('DELIVERY');
    		return "<a href='http://m.kuaidi100.com/result.jsp?com={$com}&nu={$num}' target='_blank' class='links express-links'>{$express[$com]}【点击查看】</a>";
    }
?>