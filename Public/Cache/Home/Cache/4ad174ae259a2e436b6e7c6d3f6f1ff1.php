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

<?php if(!empty($aliziConfig["lazyload"])): ?><script type="text/javascript">
seajs.use(['jquery/lazyload'], function() {
	$(".alizi-detail-content img").lazyload({ placeholder : "__PUBLIC__/Alizi/alizi.gif",effect : "fadeIn",threshold:500});
});
</script><?php endif; ?>
<div class="alizi-detail-wrap clearfix">
	<div class="alizi-detail-header clearfix">
		<?php if(!empty($info["image"])): ?><h1 class="title"><img src="<?php echo (imageurl($info["image"])); ?>"></h1><?php endif; ?>
		<dl>
			<dt class="ellipsis"><?php echo ($info["name"]); ?>
				<?php if(!empty($info["tags"])): $_result=explode('#',$info['tags']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="alizi-badge"><?php echo ($vo); ?></span><?php endforeach; endif; else: echo "" ;endif; endif; ?>
			</dt>
			<dd class="ellipsis"><?php echo ($info["brief"]); ?></dd>
		</dl>
	</div>

	<div class="alizi-detail-content">
	<?php if(strstr($info['content'],'{[AliziOrder]}')){ $info['content'] = explode('{[AliziOrder]}',$info['content']); foreach($info['content'] as $key=>$content){ echo $content;if($key==0){ W('Order',array_merge($_GET,array('page'=>'single_detail','id'=>$info['sn'])));} } }else{ echo $info['content']; } ?>
	</div>
	
	
<div class='alizi-remark'><?php echo ($info['remark']); ?></div>
<div class="alizi-footer"><?php echo ($aliziConfig["footer"]); ?></div>
<?php $showNav = (int)$template['extend']['bottom_nav']; if(!empty($showNav)){ if($showNav==1){ $style = "style='width:100%'"; }elseif($showNav==2){ $style = "style='width:49%'"; }else{ $style = '';} $html = '<div class="alizi-foot-nav"><a class="alizi-up" href="#">'.lang('top').'</a><ul>'; for($i=1;$i<=$showNav;$i++){ $nav = explode('||',$template['extend']['bottom_nav_list'][$i]); $class = isset($nav[2])?'icon '.$nav[2]:''; $html .= '<li class="foot-nav-'.$i.'" '.$style.'><a href="'.$nav[1].'"><strong class="'.$class.'">'.$nav[0].'</strong></a></li>'; } echo $html.'</ul></div>'; } ?>
<?php if(isMobile() == false): ?><div id="qrcode"><div class="qrcode"><img src="<?php echo C('ALIZI_ROOT');?>Api/qrcode.php?margin=2&data=http://<?php echo ($_SERVER['HTTP_HOST']); echo (urlencode($_SERVER['REQUEST_URI'])); ?>"><span><?php echo lang('qrcodeAddress');?></span></div></div><?php endif; ?>

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
</script>
</div>
<?php if(isWeixin()): ?><script type="text/javascript">
seajs.use(['jquery'], function($) {
	$(function(){
	  $('body').delegate('.alizi-btn-share','click',function(){
		wxShare();
	  })
  })
});
function wxShare(){
	window.location.href = "<?php echo U('Order/wx',array('id'=>$info['sn'],'uid'=>$_GET['uid'],'c'=>$_GET['c']));?>";
}
</script><?php endif; ?>



</body>
</html>