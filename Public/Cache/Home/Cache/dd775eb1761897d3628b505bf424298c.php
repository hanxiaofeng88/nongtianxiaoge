<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(!empty($info["name"])): echo ($info["name"]); ?> -<?php endif; ?> <?php echo ($aliziConfig["title"]); ?></title>
<meta content="yes" name="apple-mobile-web-app-capable"/>
<meta content="yes" name="apple-touch-fullscreen"/>
<meta content="telephone=no" name="format-detection"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0, user-scalable=no" name="viewport">
<meta name="MobileOptimized" content="640">
<meta name="description" content="<?php if(!empty($info["brief"])): echo ($info["brief"]); else: echo ($aliziConfig["description"]); endif; ?>">
<meta name="keywords" content="<?php if(!empty($info["name"])): echo ($info["name"]); ?>|<?php endif; echo ($aliziConfig["keywords"]); ?>">
<meta name="author" content="<?php echo lang('author');?>">
<link rel="shortcut icon" href="__PUBLIC__/Assets/img/alizi.ico" />
<link href="__PUBLIC__/Alizi/Item/style.css?v=<?php echo (ALIZI_VERSION); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/Alizi/seajs/seajs/sea.js"></script>
<script type="text/javascript">
var aliziHost = "<?php echo ($aliziHost); ?>",aliziRoot = "<?php echo C('ALIZI_ROOT');?>",lang="<?php echo C('DEFAULT_LANG');?>";
seajs.config({ base: '__PUBLIC__/Alizi/seajs/',alias: {'jquery': 'jquery/jquery','alizi': 'alizi/alizi','lang': 'alizi/lang-'+lang}});
seajs.use(['jquery'], function($){ 
$('.search_button').click(function(){ $('.search_submit').show(); $('.search_input').show().animate({width:'100%'}).focus();})
$('.search_input').blur(function(){ $(this).animate({width:'0'},500,function(){ $(this).hide();$('.search_submit').hide();}); })
});
</script>
<?php if(!empty($aliziConfig["theme_color"])): ?><style> 
	.header,.btn{background-color: #<?php echo $aliziConfig['theme_color']; ?>;}
	.tabs-nav a.active {color:#<?php echo $aliziConfig['theme_color']; ?>;border-bottom-color:#<?php echo $aliziConfig['theme_color']; ?>;}
	.side-menu a.active{border-left-color:#<?php echo $aliziConfig['theme_color']; ?>;}
	.btn-buy,.alizi-foot-nav{background-color:#<?php echo $aliziConfig['theme_color']; ?> !important;}
</style><?php endif; ?>
</head>

<body class="<?php echo ($aliziConfig["system_theme"]); ?>">
<?php if(!empty($aliziConfig["notice"])): ?><div class="aliziAlert"><a class="close" onclick="$('.aliziAlert').slideUp(500);">×</a><?php echo ($aliziConfig["notice"]); ?></div><?php endif; ?>
<?php if(!empty($aliziConfig["show_header"])): ?><div class="header">
	<div class="back"><a href="javascript:history.go(-1)"><img src="__PUBLIC__/Alizi/Item/goback.png"></a></div> 
	<div class="wrap">
		<a class="logo" href="<?php echo U('Item/index');?>"><img src="<?php if(empty($aliziConfig["logo"])): ?>__PUBLIC__/Assets/img/logo.png<?php else: echo (imageurl($aliziConfig["logo"])); endif; ?>" alt="<?php echo ($aliziConfig["title"]); ?>" /></a>
	</div>
	<div class="search">
		<form method="get" action="<?php echo U('Item/category');?>" class="searchform">
			<input type="hidden" name="m" value="Item">
			<input type="hidden" name="a" value="category">
			<input type="text" name="kw" class="search_input" value="<?php echo (trim($_GET['kw'])); ?>" placeholder="<?php echo lang('search');?>">
			<button type="button" class="search_button"></button>
			<button type="submit" class="search_submit"></button>
		</form>
	</div> 
</div>

<?php else: ?>
<style>.tab_menu{top:0;}</style><?php endif; ?>

<link href="__PUBLIC__/Alizi/alizi-order.css?v=<?php echo (ALIZI_VERSION); ?>" rel="stylesheet"><!--[if lt IE 9]><link href="__PUBLIC__/Alizi/alizi-ie.css?v=<?php echo (ALIZI_VERSION); ?>" rel="stylesheet"><![endif]--><script type="text/javascript">seajs.use(['jquery'], function(){ 	var elm = $('#nav');	var startPos = $(elm).offset().top;	$.event.add(window, "scroll", function() {		var p = $(window).scrollTop();		if(((p) > startPos)){ elm.addClass('alizi-fixed'); }else{ elm.removeClass('alizi-fixed'); }	});});</script><?php if(!empty($aliziConfig["lazyload"])): ?><script type="text/javascript">seajs.use(['jquery/lazyload'], function() {	$(".alizi-detail-content img").lazyload({ placeholder : "__PUBLIC__/Alizi/alizi.gif",effect : "fadeIn",threshold:500});});</script><?php endif; ?><div class="subnav" id="nav">	<a href="<?php echo U('/');?>" class="nav-home"><?php echo lang('index');?></a>	<a href="<?php echo U('Item/category');?>" class="nav-category"><?php echo lang('item_category');?></a>	<a href="<?php echo U('Item/query');?>" class="nav-query"><?php echo lang('order_query');?></a></div><div class="alizi-margin"></div><div class="wrapper alizi-detail-wrap">	<div class="alizi-detail-header clearfix">		<?php if(!empty($info["image"])): ?><h1 class="title"><img src="<?php echo (imageurl($info["image"])); ?>"></h1><?php endif; ?>		<dl>			<dt class="ellipsis"><?php echo ($info["name"]); ?></dt>			<dd class="ellipsis"><?php if(!empty($info["tags"])): $_result=explode('#',$info['tags']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="alizi-badge"><?php echo ($vo); ?></span><?php endforeach; endif; else: echo "" ;endif; endif; ?></dd>		</dl>	</div>			<div class="alizi-page">		<?php if(!empty($info["image"])): ?><div class="box-image">			<img src="<?php echo (imageurl($info["image"])); ?>" class="image" />		</div><?php endif; ?>				<?php if(floatval($info['original_price']) > 0): ?><div class="alizi-plug clearfix">			<div class="price" <?php if(empty($info["timer"])): ?>style="width:100%;"<?php endif; ?>>				<span class="symbol"><?php echo lang('symbol');?></span>				<span class="current-price"><?php echo (floatval($info["price"])); ?></span>				<span class="group">					<del class="original-price"><?php echo ($info["original_price"]); echo lang('yuan');?></del>					<span class="salenum"><?php echo ($info["salenum"]); ?> 件已售</span>				</span>			</div>			<?php if(!empty($info["timer"])): ?><div class="timer">				<p class="tt">活动倒计时</p>				<div id="alizi-timer" class="alizi-timer">00天01时00分00秒</div>				<script type="text/javascript">					seajs.use(['alizi','jquery/form','lang'],function(alizi) {						alizi.timer('#alizi-timer', '<?php echo ($info["timer"]); ?>');					})				</script>			</div><?php endif; ?>		</div><?php endif; ?>				<div class="alizi-detail-content">		<?php if(strstr($info['content'],'{[AliziOrder]}')){ $aliziOrder = true; $info['content'] = str_replace('{[AliziOrder]}','',$info['content']); } echo $info['content']; ?>		</div>				<?php if(!empty($aliziOrder)): ?><div class="box">			<div class="box-content">				<?php echo W('Order',array_merge($_GET,array('page'=>'system')));?>			</div>		</div><?php endif; ?>	</div>		<div class='alizi-remark'><?php echo ($info['remark']); ?></div>	<script type="text/javascript">	seajs.use(['alizi','jquery/form','lang'],function(alizi){		window.alizi = alizi;		alizi.quantity(0);		var btnSubmit = $('.alizi-submit');		$('#aliziForm').ajaxForm({			cache: true,			timeout: 50000,			dataType: 'json',			error:function(){ layer.closeAll(); alert(lang.ajaxError); btnSubmit.attr('disabled',false).val(lang.submit); },			beforeSubmit:function(){				if(checkForm('#aliziForm')==false) return false;				layer.closeAll();layer.load();				btnSubmit.attr('disabled',true).val(lang.loading);			},			success:function(data){				layer.closeAll();layer.closeAll();				if(data.status=='1'){					var redirect = "<?php echo U('Order/pay',array('order_no'=>'__orderNo__'));?>";					top.window.location.href = redirect.replace('__orderNo__',data.data.order_no);				}else{					btnSubmit.attr('disabled',false).val(lang.submit);					layer.msg(data.info);				}			}		});	});	</script></div><div class="alizi-footer" style="padding-bottom:50px;"><?php echo ($aliziConfig["footer"]); ?></div><div class="alizi-foot-nav"><a class="alizi-up" href="#"><?php echo lang('top');?></a><ul><li class="foot-nav-1" style="width:50%"><a href="#aliziOrder"><strong class="icon cart"><?php echo lang('bookingNow');?></strong></a></li><li class="foot-nav-2" style="width:50%"><a href="<?php echo U('Item/query');?>"><strong class="icon query"><?php echo lang('order_query');?></strong></a></li></ul></body></html>