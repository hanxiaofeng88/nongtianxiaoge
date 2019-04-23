<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME,'do'=>$_GET['do']));?>

<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3><strong><?php echo lang('breadclumb_colon');?></strong><?php echo lang(MODULE_NAME);?><span></span><?php echo lang('shipping_manage');?></h3>
    </div>
    <div id="CooperationMain" class="box clear-fix">   
		<div class="layout-block-header"><h2><button type="buttun" class="btn btn-ok" onclick="javascript:shipping(0)">添加模板</button></h2></div>
		
        
		<div class="tabs-block">
			<div class="ui-table">
				<div class="ui-table-body ui-table-body-hover">
					<table cellpadding="0" cellspacing="0" width="100%" >
						<thead>
							<tr class="ui-table-head">
								<th class="ui-table-hcell">名称</th>
								<th class="ui-table-hcell">默认运费</th>
								<th class="ui-table-hcell">免邮条件</th>
								<th class="ui-table-hcell" width="100">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="row-<?php echo ($vo["id"]); ?>">
								<td><?php echo ($vo["name"]); ?></td>
								<td><?php echo ($vo["less_num"]); ?>件内<?php echo ($vo["less_num_cost"]); ?>元；每增加<?php echo ($vo["step_num"]); ?>件，运费增加<?php echo ($vo["step_num_cost"]); ?>元。</td>
								<td>
									<?php if(!empty($vo["is_free_num"])): ?>满<?php echo ($vo["free_num"]); ?>件包邮。<?php endif; ?>
									<?php if(!empty($vo["is_free_cost"])): ?>满<?php echo ($vo["free_cost"]); ?>元包邮。<?php endif; ?>
								</td>
								<td>
									<q onclick="javascript:shipping('<?php echo ($vo["id"]); ?>')"><?php echo lang('edit');?></q> | 
									<q onclick="javascript:Delete('<?php echo ($vo["id"]); ?>','<?php echo U('Shipping/proccess/',array('do'=>'delete','id'=>$vo['id']));?>')"><?php echo lang('delete');?></q>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>	
		
	</div><!--.box-->
<script type="text/javascript">

function delConfirm(){
	$.confirm('是否要删除？',function(){ 
		$('#deleteForm').submit();
	},true)
}
function shipping(id){
	var url = "?m=Shipping&a=edit&page=1&id="+id;
	$.open(url,{title:'运费模板',width:680,height:250});
}
</script>
<?php echo W("Foot");?>