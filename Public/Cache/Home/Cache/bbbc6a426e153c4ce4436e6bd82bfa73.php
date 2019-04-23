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

<div class="mainwidth">
	<h4 class="meminfo"><div class="infoleft "><span class="name"><?php echo lang('order_query');?></span></div></h4>
	<div class="alizi-query-wrap">
		<dl class="query_form">
			<form action="<?php echo U('Order/query');?>" method="post" id="aliziForm" class="clearfix">
				<input name="kw" required="required" class="query_text" type="text" placeholder="<?php echo lang('mobile_/_order_number');?>">
				<input type="submit" id="alizi-query-btn" class="query_button" value="<?php echo lang('order_query');?>">
			</form>
			<div class="query_result" id="alizi-query-result"></div>
		</dl>
	</div>
</div>

<script id="alizi-query" type="text/html">
<ul>
    {{each list as value i}}
        <li>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo lang('order_colon');?>{{value.order_no}}</th>
					<th width="80"><?php echo lang('status');?></th>
					<th width="100"><?php echo lang('quantity_price');?></th>
					<th width="150"><?php echo lang('booking_time');?></th>
				</tr>
				<tr>
					<td>
						<h2>{{value.title}}</h2>
						{{#value.itemExtends}}
						{{if value.address}}<?php echo lang('delivery_address_colon');?>{{value.address}}{{/if}}
						{{if value.express}}<p><?php echo lang('express_query_colon');?>{{#value.express}}</p>{{/if}}
					</td>
					<td>
						{{value.status}}
						{{if value.order_status=='0' && value.payment!='1' && value.payment!='6'}}
						<p><a href="<?php echo C('ALIZI_ROOT');?>index.php?m=Order&a=pay&order_no={{value.order_no}}" class="links" target="_blank">[<?php echo lang('pay');?>]</a></p>
						{{/if}}
					</td>
					<td>{{value.quantity}}/<span class="price">{{value.price}}<?php echo lang('yuan');?></span></td>
					<td>{{value.time}}</td>
				</tr>
			</table>
		</li>
    {{/each}}
</ul>
</script>
<script type="text/javascript">
seajs.use(['alizi','jquery/form','art/template'],function(alizi,form,template){
	$('#aliziForm').ajaxForm({
		timeout: 50000,
		dataType: 'json',
		error:function(){  layer.closeAll(); alert(lang.ajaxError); },
		beforeSubmit:function(){ layer.closeAll();layer.load(); },
		success:function(data){
			layer.closeAll();
			if(data.status=='1'){
			console.log(data.data);
				var html = template('alizi-query', data.data);
				document.getElementById('alizi-query-result').innerHTML = html;
			}else{ 
				layer.msg(data.info);
				document.getElementById('alizi-query-result').innerHTML = "<div class='alizi-rows'>"+data.info+"</div>";
			}
		}
	});
});
function delivery(order,id){
	var url = "<?php echo C('ALIZI_ROOT');?>index.php?m=Index&a=delivery&order="+order+"&id="+id+"&ord=asc&show=json",title="<?php echo lang('shipping_query');?>";
	layer.open({type: 2,shade: .2,shadeClose: true,title: title,area: ['600px', '60%'],content:url}); 
}
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