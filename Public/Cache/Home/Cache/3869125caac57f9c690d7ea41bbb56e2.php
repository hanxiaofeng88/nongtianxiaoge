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

<link href="__PUBLIC__/Alizi/pc/alizi.css?v=<?php echo (ALIZI_VERSION); ?>" rel="stylesheet">
<?php if(!empty($aliziConfig["lazyload"])): ?><script type="text/javascript">
seajs.use(['jquery/lazyload'], function() {
	$(".alizi-detail-content img").lazyload({ placeholder : "__PUBLIC__/Alizi/alizi.gif",effect : "fadeIn",threshold:500});
});
</script><?php endif; ?>


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

<div class="header">
	<div class="mainwidth">
		<div class="headtop">
			<span class="place cur_city_name">
				<form action="<?php echo U('Index/category');?>" method="get" class="search_form">
					<input type="text" name="kw" class="search_input" placeholder="<?php echo lang('item_search');?>" value="<?php echo ($_GET['kw']); ?>" />
					<input type="submit" value="" class="search_button">
					<input type="hidden" name="m" value="Index" class="search_button">
					<input type="hidden" name="a" value="category" class="search_button">
				</form>
			</span>
			
			<div class="topright">
				<a href="<?php echo U('Item/index');?>" class="phone"><?php echo lang('themeMobile');?></a>
				<!--
				<?php if(empty($_SESSION['member']['username'])): ?><a href="<?php echo U('User/login');?>" class="member"><?php echo lang('login');?></a>
				<?php else: ?>
				<a href="<?php echo U('User/index');?>" class="member"><?php echo ($_SESSION['member']['username']); ?></a>
				<a href="<?php echo U('User/logout');?>" class="logout">[<?php echo lang('logout');?>]</a><?php endif; ?>
				<a href="/checkout/cartList.html" class="cart">购物车(<span id="cartCount">0</span>)</a>
				-->
			</div>
			
		</div>
		<div class="logobox">
			<a href="<?php echo ($aliziHost); ?>" class="logo">
				<img title="<?php echo ($aliziConfig["title"]); ?>" alt="<?php echo ($aliziConfig["title"]); ?>" src="<?php if(empty($aliziConfig["logo_pc"])): ?>__PUBLIC__/Alizi/pc/logo.png<?php else: echo (imageurl($aliziConfig["logo_pc"])); endif; ?>">
			</a>
		</div>
		<div class="nav">
			<ul>
				<li <?php if((ACTION_NAME) == "index"): ?>class="active"<?php endif; ?>><a href="<?php echo ($aliziHost); ?>"><span data-hover="<?php echo lang('index');?>"><?php echo lang('index');?></span></a></li>
				<li class="li_2 <?php if((ACTION_NAME) == "category"): ?>active<?php endif; ?>"><a href="<?php echo U('Index/category');?>"><span data-hover="<?php echo lang('item_category');?>"><?php echo lang('item_category');?></span></a></li>
				<li <?php if((ACTION_NAME) == "query"): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/query');?>"><span data-hover="<?php echo lang('order_query');?>"><?php echo lang('order_query');?></span></a></li>
				<li <?php if((ACTION_NAME) == "article"): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/article');?>"><span data-hover="<?php echo lang('article');?>"><?php echo lang('article');?></span></a></li>
			</ul>
		</div>
		
	</div>
</div>

<div class="mainwidth" id="alizi-show-bar">
	<div class="alizi-detail-header clearfix">
		<div class="mainwidth header-wrap">
			<a class="booking-now" href="#aliziOrder"><?php echo lang('bookingNow');?></a>
			<?php if(!empty($info["image"])): ?><h1 class="title"><img src="<?php echo (imageurl($info["image"])); ?>"></h1><?php endif; ?>
			<dl>
				<dt class="ellipsis"><?php echo ($info["name"]); ?>
					<?php if(!empty($info["tags"])): $_result=explode('#',$info['tags']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="alizi-badge"><?php echo ($vo); ?></span><?php endforeach; endif; else: echo "" ;endif; endif; ?>
				</dt>
				<dd class="ellipsis"><?php echo ($info["brief"]); ?></dd>
			</dl>
		</div>
	</div>
</div>
			
<div class="container">
	<div class="mainwidth">
		<script type="text/javascript">
		seajs.use(['jquery'], function() {
			$(window).scroll(function(){
				var winHeight = $(this).height(),orderTop = $('.alizi-order').offset().top,docTop = $(document).scrollTop(),nav=$('.alizi-foot-nav'),navHeight=nav.height();
				if(docTop+winHeight/2>=orderTop){ nav.slideUp(); }else{ nav.slideDown(); }
			})
			var elm = $('#alizi-show-bar'); 
			var startPos = $(elm).offset().top; 
			$.event.add(window, "scroll", function() { 
				var p = $(window).scrollTop(); 
				if(((p) > startPos)){ elm.addClass('alizi-fixed'); }else{ elm.removeClass('alizi-fixed'); }
			}); 
		});
		</script>
		<div class="alizi-detail-wrap clearfix">
			<div class="alizi-detail-content">
			<?php $info['content'] = explode('{[AliziOrder]}',$info['content']); foreach($info['content'] as $key=>$content){ echo $content;if($key==0){W('Order',array_merge($_GET,array('page'=>'system')));} } ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
seajs.use(['alizi','jquery/form','lang'],function(alizi){
	window.alizi = alizi;
	alizi.quantity(0);
	var btnSubmit = $('.alizi-submit');
	$('#aliziForm').ajaxForm({
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


<div class="footer">
	<div class="mainwidth">
		<ul class="footcon">
			<li>
				<div class="copyright"><?php echo ($aliziConfig["footer"]); ?></div>
			</li>
			<li>
				<div class="foottel">
					<span class="tell">全国免费客服电话：<span class="num"><?php echo ($aliziConfig["contact_tel"]); ?></span></span>
					<?php if(!empty($aliziConfig["contact_qq"])): ?><span class="online"><?php echo lang('online_service');?><span class="num"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($aliziConfig["contact_qq"]); ?>&site=qq&menu=yes" target="_blank"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo ($aliziConfig["contact_qq"]); ?>:51 &amp;r=0.22914223582483828"></a></span></span>
					<?php else: ?><br /><?php endif; ?>
				</div>
				
			</li>
		</ul>
	</div>
</div>
<div id="aliziUp"></div>
<script type="text/javascript">
seajs.use(['jquery/scrollup'], function(){ $.scrollUp({scrollName: 'aliziUp'}); });
</script>

</body>
</html>