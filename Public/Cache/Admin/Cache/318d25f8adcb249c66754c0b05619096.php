<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME));?>
<script type="text/javascript" src="__PUBLIC__/Assets/js/My97DatePicker/WdatePicker.js"></script>
<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3><strong><?php echo lang('breadclumb_colon');?></strong><?php echo lang(MODULE_NAME);?><span></span><?php echo lang('order_statistics');?></h3>
    </div>
    <div id="CooperationMain" class="box clear-fix">   
        <div class="layout-block-header">
            <form action="__SELF__" method="get" id="searchform">
            	<input type="hidden" name="s" value="<?php echo (MODULE_NAME); ?>" />
				<input type="hidden" name="a" value="<?php echo (ACTION_NAME); ?>" />
                <label><?php echo lang('search_colon');?></label>
				<input type="text" name="start" value="<?php echo (trim($_GET['start'])); ?>" size="11" class="ui-text Wdate" onclick="WdatePicker();">
				至
				<input type="text" name="end" value="<?php echo (trim($_GET['end'])); ?>" size="11" class="ui-text Wdate" onclick="WdatePicker();">
                <button type="submit" class="btn btn-ok"><?php echo lang('search');?></button>
            </form>
        </div>
        
		<form action="<?php echo U('Article/todo');?>" method="post" id="deleteform">
        <div class="ui-table">
            <div class="ui-table-body ui-table-body-hover">
                <table cellpadding="0" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="ui-table-head">
                            <th class="ui-table-hcell" width="150"><?php echo lang('name');?></th>
							<?php if(is_array($status)): $i = 0; $__LIST__ = $status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><th class="ui-table-hcell"><?php echo ($vo); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
                            <th class="ui-table-hcell" width="100">总计</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="row-<?php echo ($vo["item_id"]); ?>">
                            <td><a href="<?php echo U('Order/index',array('item_id'=>$vo['item_id']));?>"><?php echo ($vo["item_name"]); ?></a></td>
                            <?php if(is_array($vo["status"])): $i = 0; $__LIST__ = $vo["status"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><td>
									<b class="alert"><?php echo (intval($li["quantity"])); ?></b>
									<p><?php echo (number_format($li["price"],2)); ?></p>
								</td><?php endforeach; endif; else: echo "" ;endif; ?>
							<td>
								<b class="alert"><?php echo ($vo["quantity"]); ?></b>
								<p><?php echo ($vo["total_price"]); ?></p>
							</td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
		
		</form>
</div><!--.box-->
<?php echo W("Foot");?>