<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME,'do'=>$_GET['do']));?>

<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3><strong><?php echo lang('breadclumb_colon');?></strong><?php echo lang(MODULE_NAME);?><span></span><?php echo lang('order_list');?></h3>
    </div>
    <div id="CooperationMain" class="box clear-fix">   
        <div class="layout-block-header">
            <form action="__SELF__" method="get" id="searchform">
            	<input type="hidden" name="s" value="<?php echo (MODULE_NAME); ?>" />
				<input type="hidden" name="a" value="<?php echo (ACTION_NAME); ?>" />
                <label><?php echo lang('order_search_colon');?></label>
				<select name="fields">
					<?php $fields=array('order_no'=>lang('order_number'),'item_name'=>lang('item_name'),'name'=>lang('customer_realname'),'mobile'=>lang('customer_mobile')); ?>
					<?php if(is_array($fields)): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($_GET["fields"]) == $key): ?>selected='selected'<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
                <input type="text" name="keyword" value="<?php echo (trim($_GET['keyword'])); ?>" class="ui-text" autocomplete="off" size="40">
                <button type="submit" class="btn btn-ok"><?php echo lang('search');?></button>
				
				<div class="search-list filter clear-fix">
                    <label><?php echo lang('booking_time_colon');?></label>
                    <input type="text" name="time_start" value="<?php echo (trim($_GET['time_start'])); ?>" size="11" class="ui-text Wdate" onclick="WdatePicker();"><?php echo lang('to');?><input type="text" name="time_end" value="<?php echo (trim($_GET['time_end'])); ?>" size="11" class="ui-text Wdate" onclick="WdatePicker();">
                </div>
				
            </form>
        </div>
        
		<form action="<?php echo U('Recycle/todo');?>" method="post" id="deleteform">
        <div class="ui-table">
            <div class="ui-table-body ui-table-body-hover">
                <table cellpadding="0" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="ui-table-head">
                            <th class="ui-table-hcell" width="15"><input type="checkbox" id="check_box" onclick="$.Select.All(this,'id[]');" ></th>
                            <th class="ui-table-hcell"><?php echo lang('item_name');?></th>
                            <th class="ui-table-hcell" width="50"><?php echo lang('amount_price');?></th>
                            <th class="ui-table-hcell" width="60"><?php echo lang('customer_realname');?></th>
                            <th class="ui-table-hcell" width="80"><?php echo lang('customer_mobile');?></th>
							<th class="ui-table-hcell" width="50"><?php echo lang('payment');?></th>
							<th class="ui-table-hcell" width="50"><?php echo lang('status');?></th>
                            <th class="ui-table-hcell" width="100"><?php echo lang('time');?></th>
                        </tr>
                    </thead>
                    <tbody>
						<?php $payment = C('PAYMENT'); ?>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="row-<?php echo ($vo["id"]); ?>">
                            <td><input type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" onclick="$.Select.This(this);"></td>
                            <td><?php echo ($vo["item_name"]); if(!empty($vo["item_params"])): ?>（<?php echo ($vo["item_params"]); ?>）<?php endif; ?></td>
                            <td><?php echo ($vo["quantity"]); ?>/<b class="alert"><?php echo ($vo["total_price"]); ?></b></td>
                            <td><?php echo ($vo["name"]); ?></td>
                            <td><?php echo ($vo["mobile"]); ?></td>
                            <td><?php echo ($payment[$vo['payment']]['name']); ?></td>
                            <td><?php echo status($vo['status'],'',C('order_status'));?></td>
                            <td><?php echo (date("Y-m-d H:i",$vo["add_time"])); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
          
        <div class="ui-pager-bar clearfix" style="padding-left:10px;">
			<div class="float-left">
				<input type="hidden" name="model" value="Order">
				<input type="checkbox" id="check_box" onclick="$.Select.All(this,'id[]');" >选择/反选 
				<input type="submit" name="recover" value="恢复" class="btn btn-ok">
				<input type="button" name="delete" value="批量删除" class="btn" onclick="delConfirm()">
			</div>
			<div class="ui-pager" style="float:right"><?php echo ($page); ?></div>
		</div>
		
		</form>
</div><!--.box-->
<script type="text/javascript" src="__PUBLIC__/Assets/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
function Open(id,title){
	var url = "?m=Order&a=todo&id="+id;
	$.open(url,{title:'订单操作 - '+title,width:550,height:220})
}
function delConfirm(){
	$.confirm('是否要删除？',function(){ 
		$('#deleteform').submit();
	},true)
}
</script>
<?php echo W("Foot");?>