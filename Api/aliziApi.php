<?php
@ini_set( "display_errors","Off" );
function getNotifyUrl($payment){
	return  "http://{$_SERVER['HTTP_HOST']}".substr(dirname($_SERVER['SCRIPT_NAME']), 0,-3)."index.php?m=Api&a={$payment}Notify";
}
function payCallbak($out_trade_no){
	$url = "../index.php?m=Order&a=result&order_no={$out_trade_no}";
	header('location:'.$url);
}
function payLog($data,$name=''){
	$logFile = "../Public/Cache/pay-{$name}".date('Ym').".log";
	@file_put_contents($logFile,var_export($data,true)."\n",FILE_APPEND);
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
function cache($name){
	$filename = "../Public/Cache/".md5($name).".php";
	$content    =   file_get_contents($filename);
	if( false !== $content) {
		$expire  =  (int)substr($content,8, 12);
		if($expire != 0 && time() > filemtime($filename) + $expire) {
			//缓存过期删除缓存文件
			unlink($filename);
			return false;
		}
		$content   =  substr($content,20, -3);
		$content    =   unserialize($content);
		return $content;
	}
	else {
		return false;
	}
}
?>