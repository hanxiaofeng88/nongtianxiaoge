<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME,'do'=>$_GET['do']));?>

<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3><strong><?php echo lang('breadclumb_colon');?></strong><?php echo lang(MODULE_NAME);?><span></span><?php echo lang('item_list');?></h3>
    </div>
    <div id="CooperationMain" class="box clear-fix">   
        <div class="layout-block-header">
            <form action="__SELF__" method="get" id="searchform">
            	<input type="hidden" name="s" value="<?php echo (MODULE_NAME); ?>" />
				<input type="hidden" name="a" value="<?php echo (ACTION_NAME); ?>" />
                <label><?php echo lang('search_colon');?></label>
                <input type="text" name="keyword" value="<?php echo (trim($_GET['keyword'])); ?>" class="ui-text" autocomplete="off" size="40">
				<select name="category_id">
					<option value="0"><?php echo lang('select_category');?></option>
					<?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($_GET["category_id"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
                <button type="submit" class="btn btn-ok"><?php echo lang('search');?></button>
            </form>
        </div>
        
		<form action="<?php echo U('Item/todo');?>" method="post" id="deleteform">
        <div class="ui-table">
            <div class="ui-table-body ui-table-body-hover">
                <table cellpadding="0" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="ui-table-head">
                            <th class="ui-table-hcell"><?php echo lang('name');?></th>
                            <th class="ui-table-hcell"><?php echo lang('category');?></th>
                            <th class="ui-table-hcell" width="80"><?php echo lang('price');?></th>
                            <th class="ui-table-hcell" width="50"><?php echo lang('package');?></th>
							<th class="ui-table-hcell" width="50"><?php echo lang('status');?></th>
                            <th class="ui-table-hcell" width="120"><?php echo lang('time');?></th>
                            <th class="ui-table-hcell" width="180"><?php echo lang('action');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="row-<?php echo ($vo["id"]); ?>">
                            <td>
								<?php echo ($vo["name"]); ?>
								<?php if(!empty($vo["image"])): ?><a href="<?php echo (imageurl($vo["image"])); ?>" title="<?php echo lang('image');?>" target="_blank"><img src="__PUBLIC__/Assets/img/pic.jpg" /></a><?php endif; ?>
								<?php if(($vo["is_hot"]) == "1"): ?><img src="__PUBLIC__/Assets/img/hot.gif" /><?php endif; ?>
							</td>
                            <td><?php echo (getfields("Category","name",$vo["category_id"])); ?></td>
                            <td><?php echo ($vo["price"]); echo lang('yuan');?></td>
                            <td><?php echo (count(json_decode($vo["params"],true))); ?></td>
                            <td><?php echo (status($vo["status"],"image")); ?></td>
                            <td><?php echo (date("Y-m-d H:i:s",$vo["add_time"])); ?></td>
                            <td class="action">
                                <a target="_blank" href="<?php echo ($vo["url"]["order"]); ?>">模板一</a> | 
								<a target="_blank" href="<?php echo ($vo["url"]["detail"]); ?>">模板二</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
          
        <div class="ui-pager-bar clearfix" style="padding-left:10px;">
			<div class="ui-pager" style="float:right"><?php echo ($page); ?></div>
		</div>
		
		</form>
</div><!--.box-->
<?php echo W("Foot");?>