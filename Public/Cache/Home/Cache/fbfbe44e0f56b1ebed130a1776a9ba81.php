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


<?php if(!empty($slider)): ?><div class="newbanner">
  <div class="newflexslider">
    <ul class="newslides">
		<?php if(is_array($slider)): $i = 0; $__LIST__ = $slider;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($vo["link"]); ?>" target="<?php echo ($vo["target"]); ?>"><img src="<?php echo (imageurl($vo["image"])); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  </div>
</div>
<script type="text/javascript">
seajs.use(['jquery/newflexslider'], function(){ $('.newflexslider').newflexslider({ directionNav: true, pauseOnAction: false });});
</script><?php endif; ?>
 
<?php echo W('Item',$hot);?>
<?php echo W('Tabs',array('status'=>$aliziConfig['item_category_show'],'id'=>$aliziConfig['item_category_id'],'num'=>$aliziConfig['item_category_num']));?>


	<div class="newmain footer"><?php echo ($aliziConfig["footer"]); ?></div>
	<div class="clear ptop"></div>
	<?php if(!empty($aliziConfig["show_bottom_nav"])): ?><div class="nav2">
		<li><a href="<?php echo U('/');?>"><span><img src="__PUBLIC__/Alizi/Item/icon-home.png"></span><p><?php echo lang('index');?></p></a></li>
		<li><a href="<?php echo U('Item/category');?>"><span><img src="__PUBLIC__/Alizi/Item/icon-menu.png"></span><p><?php echo lang('item_category');?></p></a></li>
		<li><a href="<?php echo U('Item/query');?>"><span><img src="__PUBLIC__/Alizi/Item/icon-newspaper.png"></span><p><?php echo lang('order_query');?></p></a></li>
		<li>
			<a href="<?php echo U('Item/article');?>"><span><img src="__PUBLIC__/Alizi/Item/icon-newspaper.png"></span><p><?php echo lang('articleList');?></p></a>
		</li>
	</div><?php endif; ?>
<script type="text/javascript">
seajs.use(['jquery/scrollup'], function(){ $.scrollUp({scrollName: 'aliziUp'}); });
</script>
</body>
</html>