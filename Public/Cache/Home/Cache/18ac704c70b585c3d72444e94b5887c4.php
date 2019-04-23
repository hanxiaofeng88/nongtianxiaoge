<?php if (!defined('THINK_PATH')) exit();?>
<?php if(!empty($data)): ?><div class="newmain background">
	  <h4 class="newtitle"><?php echo ($data["title"]); ?></h4>
	  <dl>
		<?php if(is_array($data["list"])): $i = 0; $__LIST__ = $data["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $type = $vo['is_hot']==1?'dt':'dd'; ?>
		<<?php echo ($type); ?> class="alizi-item-list"> 
			<a href="<?php echo U('Item/order',array('id'=>$vo['sn']));?>" title="<?php echo ($vo["name"]); ?>" class="info">
				<div class="img"><img src="<?php if(empty($vo["thumb"])): echo (imageurl($vo["image"])); else: echo (imageurl($vo["thumb"])); endif; ?>" class="lazy" /></div>
			</a>
			<div class="clear"></div>
			<div class="newmain_text">
				<h4><?php echo ($vo["name"]); ?></h4>
				<em><strong><?php echo ($vo["price"]); ?></strong><?php echo lang('yuan');?></em>
			</div>
		</<?php echo ($type); ?>><?php endforeach; endif; else: echo "" ;endif; ?>
	  </dl>
	  <div class="clear"></div>
	</div><?php endif; ?>