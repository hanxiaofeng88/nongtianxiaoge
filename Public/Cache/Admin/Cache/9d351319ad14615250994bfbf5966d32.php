<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME));?>
<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3>
        	<strong><?php echo lang('breadclumb_colon');?></strong>
            <?php echo lang('index');?><span></span><?php echo lang('advert_slideshow');?>
        </h3>
    </div>
    <div id="CooperationMain" class="box clear-fix">   
        <div class="layout-block-header"><a class="btn btn-ok" href="<?php echo U(MODULE_NAME.'/advert',array('do'=>'edit'));?>"><?php echo lang('add');?></a></div>
        
        <div class="ui-table">
            <div class="ui-table-body ui-table-body-hover">
                <table cellpadding="0" cellspacing="0" width="100%" >
                    <thead>
                        <tr class="ui-table-head">
                            <th class="ui-table-hcell ui-table-hcell-sort" width="40"><?php echo lang('id');?></th>
                            <th class="ui-table-hcell ui-table-hcell-sort"><?php echo lang('name');?></th>
                            <th class="ui-table-hcell ui-table-hcell-sort">PC<?php echo lang('image');?></th>
                            <th class="ui-table-hcell ui-table-hcell-sort">WAP<?php echo lang('image');?></th>
                            <th class="ui-table-hcell ui-table-hcell-sort" width="60"><?php echo lang('status');?></th>
                            <th class="ui-table-hcell ui-table-hcell-sort" width="80"><?php echo lang('time');?></th>
                            <th class="ui-table-hcell ui-table-hcell-sort" width="100"><?php echo lang('action');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="row-<?php echo ($vo["id"]); ?>">
                            <td><?php echo ($vo["id"]); ?></td>
                            <td><?php echo ($vo["name"]); ?></td>
                            <td><a href="__PUBLIC__/Uploads<?php echo ($vo["banner"]); ?>" target="_blank"><img src="__PUBLIC__/Uploads<?php echo ($vo["banner"]); ?>" height="40" /></a></td>
                            <td><a href="__PUBLIC__/Uploads<?php echo ($vo["image"]); ?>" target="_blank"><img src="__PUBLIC__/Uploads<?php echo ($vo["image"]); ?>" height="40" /></a></td>
                            <td><?php echo (status($vo["status"],"image")); ?></td>
                            <td><?php echo (date("Y-m-d",$vo["create_time"])); ?></td>
                            <td class="action">
                                <a href="<?php echo U(MODULE_NAME.'/advert',array('do'=>'edit','id'=>$vo['id']));?>"><?php echo lang('edit');?></a> |
                                <q onclick="javascript:Delete('<?php echo ($vo["id"]); ?>','<?php echo U('Extend/delete/',array('module'=>'Advert','id'=>$vo['id']));?>')"><?php echo lang('delete');?></q>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
          
        <div class="ui-pager-bar"><div class="ui-pager"><?php echo ($page); ?></div></div>
    </div><!--.box-->
<?php echo W("Foot");?>