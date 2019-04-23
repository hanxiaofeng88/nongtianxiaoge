<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME,'do'=>$_GET['do']));?>

<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3><strong><?php echo lang('breadclumb_colon');?></strong><?php echo lang(MODULE_NAME);?><span></span><?php echo lang('user_list');?></h3>
    </div>
    <div id="CooperationMain" class="box clear-fix">   
        <div class="layout-block-header">
            <form action="__SELF__" method="get" id="searchform">
				<input type="hidden" name="s" value="<?php echo (MODULE_NAME); ?>" />
				<input type="hidden" name="a" value="<?php echo (ACTION_NAME); ?>" />
                <label><?php echo lang('search_colon');?></label>
                <input type="text" name="keyword" value="<?php echo (trim($_GET['keyword'])); ?>" class="ui-text" autocomplete="off" size="40">
                <button type="submit" class="btn btn-ok"><?php echo lang('search');?></button>
            </form>
        </div>
        
		<form action="<?php echo U('User/deleteAll');?>" method="post" id="deleteform">
        <div class="ui-table">
            <div class="ui-table-body ui-table-body-hover">
                <table cellpadding="0" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="ui-table-head">
                            <th class="ui-table-hcell" width="20"><input type="checkbox" id="check_box" onclick="$.Select.All(this,'id[]');" ></th>
                            <th class="ui-table-hcell"><?php echo lang('username');?></th>
                            <th class="ui-table-hcell" width="120"><?php echo lang('mobile');?></th>
                            <th class="ui-table-hcell" width="80"><?php echo lang('status');?></th>
                            <th class="ui-table-hcell" width="120"><?php echo lang('add_time');?></th>
                            <th class="ui-table-hcell" width="180"><?php echo lang('action');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="row-<?php echo ($vo["id"]); ?>">
                            <td><input type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" onclick="$.Select.This(this);"></td>
                            <td><?php echo ($vo["username"]); ?></td>
                            <td><?php echo ($vo["mobile"]); ?></td>
                            <td><?php echo (status($vo["status"],"image")); ?></td>
                            <td><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></td>
                            <td class="action">
                                <a href="<?php echo U('User/'.ACTION_NAME,array('do'=>'edit','id'=>$vo['id']));?>"><?php echo lang('edit');?></a> |
								<q onclick="javascript:Delete('<?php echo ($vo["id"]); ?>','<?php echo U('User/proccess/',array('do'=>'delete','id'=>$vo['id']));?>')"><?php echo lang('delete');?></q>
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
				<input type="button" name="del" value="批量删除" class="btn btn-ok" onclick="delConfirm()">
				<input type="hidden" name="del" value="1">
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