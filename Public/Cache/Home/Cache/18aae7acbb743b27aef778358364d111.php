<?php if (!defined('THINK_PATH')) exit();?>
<?php if(!empty($data)): ?><div class="tabs newmain background">
	<?php $width = 100/count($data); ?>
	<nav class="clearfix tabs-nav">
		<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="javascript:;" <?php if(($i) == "1"): ?>class="active"<?php endif; ?> style="width:<?php echo ($width); ?>%;"><span><?php echo ($vo["name"]); ?></span></a><?php endforeach; endif; else: echo "" ;endif; ?>
	</nav>
	<nav class="clearfix tabs-main">
		<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><dl class="list3" <?php if(($i) == "1"): ?>style="display:block"<?php endif; ?> >
			<?php if(empty($li["data"])): ?><dt class="data-empty">暂无内容...</dt>
			<?php else: ?>
				<?php if(is_array($li["data"])): $i = 0; $__LIST__ = $li["data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dd class="alizi-item-list"> 
					<a href="<?php echo U('Item/order',array('id'=>$vo['sn']));?>" title="<?php echo ($vo["name"]); ?>" class="info"> 
						<div class="img"><img  src="<?php if(empty($vo["thumb"])): echo (imageurl($vo["image"])); else: echo (imageurl($vo["thumb"])); endif; ?>" class="lazy"></div>
					</a>
					<div class="clear"></div>
					<div class="newmain_text">
					<h5 class="ellipsis"><?php echo ($vo["name"]); ?></h5>
					<em><strong><?php echo ($vo["price"]); ?></strong><?php echo lang('yuan');?></em>
					</div>
				</dd><?php endforeach; endif; else: echo "" ;endif; endif; ?>
		</dl><?php endforeach; endif; else: echo "" ;endif; ?>
	</nav>
</div>
<script type="text/javascript">
seajs.use(['jquery'], function($){
	$('.tabs-nav a').click(function(){
		var _this = $(this),index = _this.index();
		_this.addClass('active').siblings('a').removeClass('active');
		$('.tabs-main dl').eq(index).fadeIn(500).siblings('dl').hide();
	})
});
</script><?php endif; ?>