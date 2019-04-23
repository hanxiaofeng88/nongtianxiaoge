<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<title><?php if(empty($info["name"])): echo ($aliziConfig["title"]); else: echo ($info["name"]); endif; ?></title>
<meta charset="utf-8" />
<meta content="yes" name="apple-mobile-web-app-capable"/>
<meta content="yes" name="apple-touch-fullscreen"/>
<meta content="telephone=no" name="format-detection"/>
<link rel="dns-prefetch" href="http://<?php echo ($_SERVER['SERVER_NAME']); ?>">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0, user-scalable=no" name="viewport">
<meta name="description" content="<?php if(empty($info["brief"])): echo ($aliziConfig["description"]); else: echo ($info["brief"]); endif; ?>">
<meta name="keywords" content="<?php if(!empty($info["tags"])): echo str_replace('#',' ',$info['tags']); endif; ?> <?php echo ($aliziConfig["keywords"]); ?>">
<meta name="author" content="<?php echo lang('author');?>">
<link rel="shortcut icon" href="__PUBLIC__/Assets/img/alizi.ico" />
<link href="__PUBLIC__/Alizi/alizi-order.css?v=<?php echo (ALIZI_VERSION); ?>" rel="stylesheet">
<!--[if lt IE 9]><link href="__PUBLIC__/Alizi/alizi-ie.css?v=<?php echo (ALIZI_VERSION); ?>" rel="stylesheet"><![endif]-->
<script type="text/javascript" src="__PUBLIC__/Alizi/seajs/seajs/sea.js"></script>
<script type="text/javascript">
var aliziHost = "<?php echo ($aliziHost); ?>",aliziRoot = "<?php echo C('ALIZI_ROOT');?>",aliziVersion="<?php echo (ALIZI_VERSION); ?>-<?php echo C('ALIZI_KEY');?>",lang="<?php echo C('DEFAULT_LANG');?>";
seajs.config({ base: '__PUBLIC__/Alizi/seajs/',alias: {'jquery': 'jquery/jquery','alizi': 'alizi/alizi','lang': 'alizi/lang-'+lang}, map: [['.css', '.css?v=' + aliziVersion],['.js', '.js?v=' + aliziVersion]],});
</script>


<style>
.alizi-detail-wrap{max-width:<?php echo $template['width']; ?>;}
<?php $color = $template['color'];if($color && !in_array(MODULE_NAME,array('Index','Item'))){ ?>
body{background-color:#<?php echo $color['body_bg']; ?>;}
.alizi-detail-content{padding:<?php echo $template['extend']['padding']; ?>;}
.alizi-detail-content h2{border-top-color:#<?php echo $color['body_bg']; ?>;}
.alizi-border,.alizi-side.alizi-full-row{border-color:#<?php echo $color['border']; ?>;}
.alizi-order{color:#<?php echo $color['font'] ?>;background-color:#<?php echo $color['form_bg']; ?>;}
.alizi-detail-header dt{color:#<?php echo $color['font']; ?>;}
.alizi-title{background-color:#<?php echo $color['title_bg']; ?>;}
.alizi-btn,.alizi-btn:hover, .alizi-btn:active,.alizi-badge,.alizi-params.active,.alizi-group-box input:checked + label:after{background-color:#<?php echo $color['button_bg']; ?>;border-color:#<?php echo $color['button_bg']; ?>;}
.alizi-foot-nav{background-color:#<?php echo $color['nav_bg']; ?>}
.alizi-group.alizi-params.alizi-checkbox.active:hover{background-color:#<?php echo $color['button_bg']; ?> !important;border-color:#<?php echo $color['button_bg']; ?> !important;color:#fff !important;}
<?php } ?>
</style>
</head>
<body>
<?php if(!empty($aliziConfig["notice"])): ?><div class="aliziAlert"><a class="close" onclick="$('.aliziAlert').slideUp(500);">×</a><?php echo ($aliziConfig["notice"]); ?></div><?php endif; ?>

<div class="alizi-order-wrap clearfix">
<?php echo W('Order',array_merge($_GET,array('page'=>'single')));?>
<script type="text/javascript">
seajs.use(['alizi','jquery/form','lang'],function(alizi){
	window.alizi = alizi;
	
	alizi.quantity(0);
	var btnSubmit = $('.alizi-submit');
	$('#aliziForm').ajaxForm({
		cache: true,
		timeout: 50000,
		dataType: 'json',
		error:function(){ layer.closeAll(); alert(lang.ajaxError); btnSubmit.attr('disabled',false).val(lang.submit); },
		beforeSubmit:function(){
			if(checkForm('#aliziForm')==false) return false;
			layer.closeAll();layer.load();
			btnSubmit.attr('disabled',true).val(lang.loading);
		},
		success:function(data){
			layer.closeAll();layer.closeAll();
			if(data.status=='1'){
				var redirect = "<?php echo U('Order/pay',array('order_no'=>'__orderNo__'));?>";
				top.window.location.href = redirect.replace('__orderNo__',data.data.order_no);
			}else{
				btnSubmit.attr('disabled',false).val(lang.submit);
				layer.msg(data.info);
			}
		}
	});
});
if(self!=top){
	height();window.onresize=function(){height();}
	function height(){ try{var height=parseInt(document.body.clientHeight);parent.window.document.getElementById("aliziIframe").height = height;}catch (ex){console.log(ex);}}
}
</script>	
</div>


</body>
</html>