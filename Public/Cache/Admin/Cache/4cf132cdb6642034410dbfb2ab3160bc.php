<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME));?>

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
        
		<form action="<?php echo U('Article/todo');?>" method="post" id="deleteform">
        <div class="ui-table">
            <div class="ui-table-body ui-table-body-hover">
                <table cellpadding="0" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="ui-table-head">
                            <th class="ui-table-hcell" width="20"><input type="checkbox" id="check_box" onclick="$.Select.All(this,'id[]');" ></th>
                            <th class="ui-table-hcell" width="50"><?php echo lang('sortOrder');?></th>
                            <th class="ui-table-hcell"><?php echo lang('name');?></th>
                            <th class="ui-table-hcell"><?php echo lang('category');?></th>
                            <th class="ui-table-hcell" width="120"><?php echo lang('time');?></th>
                            <th class="ui-table-hcell" width="180"><?php echo lang('action');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="row-<?php echo ($vo["id"]); ?>">
                            <td><input type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" onclick="$.Select.This(this);"></td>
                            <td><input type="text" class="ui-text" size="2" name="sort_order[<?php echo ($vo["id"]); ?>]" value="<?php echo ($vo["sort_order"]); ?>"></td>
                            <td>
								<a href="<?php echo C('ALIZI_ROOT');?>?m=Index&a=detail&id=<?php echo ($vo["id"]); ?>" target="_blank"><?php echo ($vo["name"]); ?></a>
								<?php if(!empty($vo["image"])): ?><a href="<?php echo (imageurl($vo["image"])); ?>" title="<?php echo lang('image');?>" target="_blank"><img src="__PUBLIC__/Assets/img/pic.jpg" /></a><?php endif; ?>
								<?php if(($vo["is_hot"]) == "1"): ?><img src="__PUBLIC__/Assets/img/hot.gif" /><?php endif; ?>
							</td>
                            <td><?php echo (getfields("Category","name",$vo["category_id"])); ?></td>
                            <td><?php echo (date("Y-m-d H:i:s",$vo["add_time"])); ?></td>
                            <td class="action">
                                <a href="<?php echo U('Article/'.ACTION_NAME,array('do'=>'edit','id'=>$vo['id']));?>"><?php echo lang('edit');?></a> |
								<?php if(empty($vo["is_frozen"])): ?><q onclick="javascript:Delete('<?php echo ($vo["id"]); ?>','<?php echo U('Article/proccess/',array('do'=>'delete','id'=>$vo['id']));?>')"><?php echo lang('delete');?></q>
								<?php else: ?>
								<q class="grey"><?php echo lang('delete');?></q><?php endif; ?>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
          
        <div class="ui-pager-bar clearfix" style="padding-left:10px;">
			<div class="float-left">
				<input type="hidden" name="model" value="<?php echo (MODULE_NAME); ?>">
				<input type="checkbox" id="check_box" onclick="$.Select.All(this,'id[]');" >选择/反选 
				<input type="button" name="delete" value="批量删除" class="btn" onclick="delConfirm()">
				<input type="submit" name="sort" value="批量排序" class="btn btn-ok">
			</div>
			<div class="ui-pager" style="float:right"><?php echo ($page); ?></div>
		</div>
		
		</form>
</div><!--.box-->
<script type="text/javascript">
function delConfirm(){
	$.confirm('是否要删除？',function(){ 
		$('#deleteform').submit();
	},true)
}
</script>
<?php echo W("Foot");?>