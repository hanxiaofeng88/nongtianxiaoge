<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title><?php echo lang('admin_panel');?></title>
<link rel="dns-prefetch" href="http://<?php echo ($_SERVER['SERVER_NAME']); ?>">
<link rel="shortcut icon" href="__PUBLIC__/Assets/img/alizi.ico" />
<link href="__PUBLIC__/Assets/css/esui.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/Assets/css/union.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/Assets/js/jquery.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/Assets/js/jquery.alizi.js"></script>
<link href="__PUBLIC__/Assets/js/artDialog/skins/black.css" rel="stylesheet" type="text/css" />
<script src="__PUBLIC__/Assets/js/artDialog/jquery.artDialog.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$('.ajax').click(function(e){
		var url = $(this).attr('href');
		e.preventDefault();
		var dialog = $.dialog({lock: true,title:'操作进行中……',content: '<img src="__PUBLIC__/Assets/img/waiting.gif" />'});
		$.ajax({
			type:'get',
			url:url,
			dataType:'json',
			success:function(data){
				dialog.close();
				$.dialog({content: data.info,time:5000,ok:true});
				console.log(data);
			}
		})
	})
})
</script>
</head>
<body>
	<div id="MainPage">
		<div id="Header" class="layout-full-width">
			<div id="Logo"><a href="<?php echo U('Index/index');?>"><img src="data:image/png;base64,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" height="35" /></a></div>
			<ul id="Toolbar">
				<li><a href="http://<?php echo ($_SERVER['HTTP_HOST']); echo C('ALIZI_ROOT');?>" class="toolbar_item" target="_blank"><?php echo lang('website_index');?></a></li>
				<li><a href="<?php echo U('Public/clearCache');?>" class="toolbar_item" ><?php echo lang('delete_cache');?></a></li>
				<li class="last"><a href="<?php echo U('Public/logout');?>" class="toolbar_item" ><?php echo lang('logout');?></a></li>
			</ul>
			<!-- 主菜单 -->
            <ul id="Nav">
                <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li <?php if(($module) == $key): ?>class="active"<?php endif; ?>><a href="<?php echo U($key.'/index');?>"><?php echo (lang($key)); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
		</div>
		
		<div id="MainBody" class="layout-full-width">
        	<div class="layout-sidebar">
            	<div class="pinned">
                	<?php if(is_array($menu[$module])): $i = 0; $__LIST__ = $menu[$module];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="box sub-nav">
                            <h3><?php echo (lang($vo["name"])); ?></h3>
                            <ul class="ui-list">
                                <?php if(is_array($vo["list"])): foreach($vo["list"] as $k=>$m): ?><li <?php if(($k) == $action): ?>class="active"<?php endif; ?>>
                                    	<a href="<?php echo U(MODULE_NAME.'/'.$k);?>" title="<?php echo ($m); ?>"><?php echo (lang($m)); ?></a>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div><!--.layout-sidebar-->