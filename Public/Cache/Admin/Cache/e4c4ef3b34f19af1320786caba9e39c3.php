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
				<input type="hidden" name="channel_id" value="<?php echo ($_GET['channel_id']); ?>" />
                <label><?php echo lang('order_search_colon');?></label>
				<select name="fields">
					<?php $fields=array('order_no'=>lang('order_number'),'item_name'=>lang('item_name'),'name'=>lang('customer_realname'),'mobile'=>lang('customer_mobile'),'channel_id'=>lang('channel')); ?>
					<?php if(is_array($fields)): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($_GET["fields"]) == $key): ?>selected='selected'<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
                <input type="text" name="keyword" value="<?php echo (trim($_GET['keyword'])); ?>" class="ui-text" autocomplete="off" size="40">
                <button type="submit" class="btn btn-ok"><?php echo lang('search');?></button>
				<button type="submit" class="btn" name="aliziExcel"><?php echo lang('download_order');?></button>
				
				<div class="search-list filter clear-fix">
                    <label><?php echo lang('booking_time_colon');?></label>
                    <input type="text" name="time_start" value="<?php echo (trim($_GET['time_start'])); ?>" size="20" class="ui-text Wdate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});"><?php echo lang('to');?><input type="text" name="time_end" value="<?php echo (trim($_GET['time_end'])); ?>" size="20" class="ui-text Wdate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});">
					<select name="user_id">
						<option value="0"><?php echo lang('select_user');?></option>
						<?php if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($vo["id"]) == $_GET['user_id']): ?>selected<?php endif; ?>><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
					<select name="pageSize">
						<?php $pageSize=array('25','50','100','500'); ?>
						<?php if(is_array($pageSize)): $i = 0; $__LIST__ = $pageSize;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo); ?>" <?php if(($vo) == $_GET['pageSize']): ?>selected<?php endif; ?>>每页显示<?php echo ($vo); ?>条</option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
                </div>
				
				<div class="search-list filter clear-fix">
					<div class="title"><?php echo lang('order_status_colon');?></div>
					<div class="all"><q onclick="searchButtun('#status','')" <?php if(!is_numeric($_GET['status'])): ?>class="select_item"<?php endif; ?>>所有</q></div>
					<div class="division">|</div>
					<div class="scope"><?php if(is_array($status)): $i = 0; $__LIST__ = $status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><q onclick="searchButtun('#status','<?php echo ($key); ?>')" <?php if(is_numeric($_GET['status']) && $_GET['status'] == $key): ?>class="select_item"<?php endif; ?>><?php echo (strip_tags($vo["name"])); ?>(<?php echo ($vo["count"]); ?>)</q><?php endforeach; endif; else: echo "" ;endif; ?></div>
					<input type="hidden" name="status" id="status" value="<?php echo ($_GET["status"]); ?>">
				</div>
			
				<div class="search-list filter clear-fix">
					<div class="title"><?php echo lang('payment_method_colon');?></div>
					<div class="all"><q onclick="searchButtun('#payment','')" <?php if(!is_numeric($_GET['payment'])): ?>class="select_item"<?php endif; ?>>所有</q></div>
					<div class="division">|</div>
					<div class="scope"><?php $_result=C('PAYMENT');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><q onclick="searchButtun('#payment','<?php echo ($key); ?>')" <?php if(is_numeric($_GET['payment']) && $_GET['payment'] == $key): ?>class="select_item"<?php endif; ?>><?php echo (strip_tags($vo["name"])); ?></q><?php endforeach; endif; else: echo "" ;endif; ?></div>
					<input type="hidden" name="payment" id="payment" value="<?php echo ($_GET["payment"]); ?>">
				</div>
            </form>
        </div>
        
		<form action="<?php echo U('Order/deleteAll');?>" method="post" id="deleteform">
        <div class="ui-table">
            <div class="ui-table-body ui-table-body-hover">
                <table cellpadding="0" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="ui-table-head">
                            <th class="ui-table-hcell" width="15"><input type="checkbox" id="check_box" onclick="$.Select.All(this,'id[]');" ></th>
                            <th class="ui-table-hcell" width="30"><?php echo lang('id');?></th>
                            <th class="ui-table-hcell" width="85"><?php echo lang('order_number');?></th>
                            <th class="ui-table-hcell"><?php echo lang('item_name');?></th>
                            <th class="ui-table-hcell" width="60"><?php echo lang('amount_price');?></th>
                            <th class="ui-table-hcell" width="80"><?php echo lang('customer_info');?></th>
							<th class="ui-table-hcell" width="80"><?php echo lang('payment_status');?></th>
							<th class="ui-table-hcell" width="60"><?php echo lang('express');?></th>
                            <th class="ui-table-hcell" width="80"><?php echo lang('remark');?></th>
                            <th class="ui-table-hcell" width="85"><?php echo lang('time');?></th>
                            <th class="ui-table-hcell" width="40"><?php echo lang('action');?></th>
                        </tr>
                    </thead>
                    <tbody>
						<?php $payment = C('PAYMENT'); ?>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="row-<?php echo ($vo["id"]); ?>">
                            <td><input type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" onclick="$.Select.This(this);"></td>
                            <td><?php echo ($vo["id"]); ?></td>
                            <td><?php echo ($vo["order_no"]); ?></td>
                            <td><?php echo ($vo["item_name"]); if(!empty($vo["item_params"])): ?>（<?php echo ($vo["item_params"]); ?>）<?php endif; ?></td>
                            <td><?php echo ($vo["quantity"]); ?>/<b class="alert"><?php echo ($vo["total_price"]); ?></b></td>
                            <td><?php echo ($vo["name"]); ?><br><?php echo ($vo["mobile"]); ?></td>
                            <td><?php echo ($payment[$vo['payment']]['name']); ?><br><?php echo status($vo['status'],'',C('order_status'));?></td>
                            <td><?php echo experss($vo['delivery_name'],$vo['delivery_no']);?></td>
                            <td>
								<?php if($vo['status']==0){ echo $vo['remark']; }else{ echo M('OrderLog')->where(array('order_id'=>$vo['id'],'status'=>$vo['status']))->getField('remark'); } ?>
							</td>
                            <td><?php echo (date("y-m-d H:i",$vo["add_time"])); ?></td>
                            <td class="action">
                                <a href="<?php echo U('Order/'.ACTION_NAME,array('do'=>'view','id'=>$vo['id']));?>"><?php echo lang('view');?></a>
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
<script type="text/javascript" src="__PUBLIC__/Assets/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
function delConfirm(){
	$.confirm('是否要删除？',function(){ 
		$('#deleteform').submit();
	},true)
}
</script>
<?php echo W("Foot");?>