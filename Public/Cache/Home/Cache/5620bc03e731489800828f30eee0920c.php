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

<div class="result">
	<h1><?php if(empty($order["status"])): ?><img src="__PUBLIC__/Alizi/success.png"> <?php echo lang('order_submit_success'); else: echo lang('order_info'); endif; ?></h1>
    <div class="innner order_div success">
        <div class="order" style="min-height: calc(100vh - 244px);">
            <ul>
				<?php if(!empty($order["status"])): ?><li><label><?php echo lang('order_status_colon');?></label><span><?php $status=C('ORDER_STATUS'); echo ($status[$order['status']]); ?></span></li><?php endif; ?>
				<li><label><?php echo lang('order_number_colon');?></label><span><?php echo ($order["order_no"]); ?></span></li>
				<li><label><?php echo lang('item_name_colon');?></label><span><?php echo ($order["item_name"]); ?></span></li>
				<?php if(!empty($options)): if(is_array($options)): $i = 0; $__LIST__ = $options;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$name): $mod = ($i % 2 );++$i; if(in_array($name,array('verify'))){continue;} ?>
					<li>
						<label><?php echo lang($name.'_colon');?></label>
						<span>
							<?php switch($name): case "price": ?><b><?php echo ($order['total_price']); echo lang('yuan');?></b><?php break;?>
								<?php case "payment": $payment = C('PAYMENT');echo $payment[$order[$name]]['name']; break;?>
								<?php default: echo ($order[$name]); endswitch;?>
						</span>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
					<?php if(($order["status"]) == "3"): $item = M('Item')->where('id='.$order['item_id'])->field('is_auto_send,send_content')->find(); ?>
						<?php if(!empty($item["is_auto_send"])): ?><li>
							<label><?php echo lang('info_colon');?></label>
							<span><pre style="margin-top:0;color:#f00;"><?php echo ($item["send_content"]); ?></pre></span>
						</li><?php endif; endif; ?>
				<?php else: ?>
					<li><?php echo lang('paymentSubmit');?></li><?php endif; ?>
			</ul>
        </div>
        <div class="foot">
            <a href="<?php echo ($redirectUrl); ?>" class="foot_btn"><?php echo lang('goback');?></a>
			<p><?php echo ($aliziConfig["footer"]); ?></p>
        </div>
    </div>
</div>
<script type="text/javascript">
seajs.use(['jquery'],function($){ var order_id = "<?php echo ($order['id']); ?>";$.ajax({ url:"<?php echo U('Api/send');?>",timeout:100,data:{order_id:order_id} });});
</script>


</body>
</html>