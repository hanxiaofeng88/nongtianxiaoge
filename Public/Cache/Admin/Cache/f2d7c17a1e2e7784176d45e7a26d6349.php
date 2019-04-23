<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME,'do'=>$_GET['do']));?>

<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3><strong><?php echo lang('breadclumb_colon');?></strong><?php echo lang(MODULE_NAME);?><span></span><?php echo lang('database_manage');?></h3>
    </div>
    <div id="CooperationMain" class="box clear-fix">   
		<div class="layout-block-header"><h2><?php echo lang('database_manage');?></h2></div>
		<ul class="ui-tab-group">
			<li class="active"><q>数据库备份</q></li>
			<li <?php if(($i) == "1"): ?>class="active"<?php endif; ?>><q>数据库恢复</q></li>
		</ul>
        
		<div class="tabs-block">
			<form action="<?php echo U('Setting/databaseBackup');?>" method="post" id="backupForm">
			<div class="ui-table">
				<div class="ui-table-body ui-table-body-hover">
					<table cellpadding="0" cellspacing="0" width="100%" >
						<thead>
							<tr class="ui-table-head">
								<th class="ui-table-hcell" width="20"><input type="checkbox" id="check_box" onclick="$.Select.All(this,'id[]');" ></th>
								<th class="ui-table-hcell">表名</th>
								<th class="ui-table-hcell" width="120">类型</th>
								<th class="ui-table-hcell" width="120">编码</th>
								<th class="ui-table-hcell" width="120">记录数</th>
								<th class="ui-table-hcell" width="120">数据长度</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="row-<?php echo ($vo["id"]); ?>">
								<td><input type="checkbox" name="id[]" value="<?php echo ($vo["Name"]); ?>" onclick="$.Select.This(this);"></td>
								<td><?php echo ($vo["Name"]); ?></td>
								<td><?php echo ($vo["Engine"]); ?></td>
								<td><?php echo ($vo["Collation"]); ?></td>
								<td><?php if(empty($vo["Auto_increment"])): echo ($vo["Rows"]); else: echo ($vo["Auto_increment"]); endif; ?></td>
								<td><?php echo ceil($vo['Data_length']/1024); ?>KB</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			  
			<div class="ui-pager-bar clearfix" style="padding-left:10px;">
				<div class="float-left">
					<input type="hidden" name="model" value="<?php echo (MODULE_NAME); ?>">
					<input type="checkbox" id="check_box" onclick="$.Select.All(this,'id[]');" >选择/反选 
					<input type="submit" value="开始备份" class="btn btn-ok">
				</div>
				<div class="ui-pager" style="float:right"><?php echo ($page); ?></div>
			</div>
			
			</form>
		</div>	
		
		<div class="tabs-block">
			<form action="<?php echo U('Setting/databaseDelete');?>" method="post" id="deleteForm">
				<div class="ui-table">
					<div class="ui-table-body ui-table-body-hover">
						<table cellpadding="0" cellspacing="0" width="100%" >
							<thead>
								<tr class="ui-table-head">
									<th class="ui-table-hcell" width="20"><input type="checkbox" id="check_box" onclick="$.Select.All(this,'id[]');" ></th>
									<th class="ui-table-hcell">文件名称</th>
									<th class="ui-table-hcell" width="120">文件大小</th>
									<th class="ui-table-hcell" width="120">备份时间</th>
									<th class="ui-table-hcell" width="120">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php if(is_array($sql)): $i = 0; $__LIST__ = $sql;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="row-<?php echo ($vo["id"]); ?>">
									<td><input type="checkbox" name="id[]" value="<?php echo ($vo["name"]); ?>" onclick="$.Select.This(this);"></td>
									<td><?php echo ($vo["name"]); ?></td>
									<td><?php echo ($vo["size"]); ?>KB</td>
									<td><?php echo ($vo["time"]); ?></td>
									<td>
										<q onclick="importConfirm('<?php echo ($vo["name"]); ?>')">恢复</q>
									</td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table>
					</div>
					
				</div>
				<div class="ui-pager-bar clearfix" style="padding-left:10px;">
					<div class="float-left">
						<input type="checkbox" id="check_box" onclick="$.Select.All(this,'id[]');" >选择/反选 
						<input type="button" name="delete" value="删除备份" class="btn btn-ok" onclick="delConfirm()">
					</div>
					<div class="ui-pager" style="float:right"><?php echo ($page); ?></div>
				</div>
			</form>
		</div>
	</div><!--.box-->
<script type="text/javascript">
$(function(){
	$('#CooperationMain').tabs({tabsContents:".tabs-block"});	
})
function delConfirm(){
	$.confirm('是否要删除备份？',function(){ 
		$('#deleteForm').submit();
	},true)
}
function importConfirm(file){
	var loading = $('#ajaxLoading');
	$.confirm('此操作有风险！<br />是否确认要恢复？',function(){ 
		$.ajax({
			type:'get',
			url:"<?php echo U('Setting/databaseImport');?>",
			data:{file:file},
			dataType:'json',
			beforeSend:function(){ loading.show();},
			success:function(data){
				loading.hide();
				$.alert(data.info);
			}
		})
	},true)
}
</script>
<?php echo W("Foot");?>