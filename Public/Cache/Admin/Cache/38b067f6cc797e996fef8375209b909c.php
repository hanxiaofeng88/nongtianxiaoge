<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<link href="__PUBLIC__/Assets/css/esui.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/Assets/css/union.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/Assets/js/jquery.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/Assets/js/jquery.form.js"></script>
<script type="text/javascript" src="__PUBLIC__/Assets/js/jscolor.min.js"></script>
<style>
.info-table th, .info-table td{padding:3px 5px;}
</style>
</head>
<body>
<div class="layout-main">    
    <div class="box clear-fix">
		<form method="post" action="<?php echo U('Item/template');?>" id="ajaxform" enctype="multipart/form-data">
		<table class="info-table">
			<tbody>
				<tr>
					<th><b class="verifing">*</b><?php echo lang('select_template_colon');?></th>
					<td>
						<select name="template" onchange="changeTheme(this.value)">
							<optgroup label="—系统模板—">
								<?php $template = C('ALIZI_TEMPLATE'); ?>
								<?php if(is_array($template)): $i = 0; $__LIST__ = $template;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($temp["template"]) == $key): ?>selected<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</optgroup>
							<?php if(!empty($custom)): ?><optgroup label="—自定义模板—">
								<?php if(is_array($custom)): $i = 0; $__LIST__ = $custom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($temp["template"]) == $vo["id"]): ?>selected<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</optgroup><?php endif; ?>
						</select>
						
						<span style="margin-left:60px;">模板宽度：<input type="text" class="ui-text" name="width" size="6" value="<?php if(empty($temp["width"])): ?>750px<?php else: echo ($temp["width"]); endif; ?>"></span>
						<span class="ui-validityshower-info">（单位px或%）</span>
						<span style="margin-left:60px;">边距宽度：<input type="text" class="ui-text" name="padding" size="6" value="<?php if(empty($extend["padding"])): ?>0<?php else: echo ($extend["padding"]); endif; ?>"></span>
						<span class="ui-validityshower-info">（单位px）</span>
					</td>
				</tr>
				<tr>
					<?php $color = json_decode($temp['color'],true); ?>
					<th><b class="verifing">*</b><?php echo lang('模板颜色_colon');?></th>
					<td class="colors">
						<?php if(is_array($deaultColor)): $i = 0; $__LIST__ = $deaultColor;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><label class="ui-group-label"><?php echo (lang($key)); ?><input type="text" id="color_<?php echo ($key); ?>" name="color[<?php echo ($key); ?>]" size="3" class="jscolor" value="<?php if(empty($color)): ?>#<?php echo ($value); else: echo ($color[$key]); endif; ?>"></label><?php endforeach; endif; else: echo "" ;endif; ?>
						<button type="button"class="ui-button" onclick="resetColor()" />重置</button>	
					</td>
				</tr>
				<tr>
					<th><b class="verifing">*</b><?php echo lang('表单选项_colon');?></th>
					<td>
						<?php if(is_array($options)): $i = 0; $__LIST__ = $options;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input name="options[]" type="checkbox" value="<?php echo ($key); ?>" <?php if(!empty($vo["checked"])): ?>checked<?php endif; ?>><label><?php echo ($vo["name"]); ?></label>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
					</td>
				</tr>
				<tr>
					<th>显示通知</th>
					<td>
						<?php echo status($temp['show_notice'],'radio','0:不显示;1:下方显示;2:右侧显示','show_notice');?>
					</td>
				</tr>
				<tr>
					<th>底部导航</th>
					<td class="bottom_nav">
						<?php echo status($extend['bottom_nav'],'radio','0:不显示;1:显示1个;2:显示2个;3:显示3个','bottom_nav');?>
					</td>
				</tr>
		
				<tr>
					<th>底部导航内容</th>
					<td>
						<p class="alert">填写格式为：内容||链接地址||图标</p>
						<p class="bottom_nav_list-1"><input type="text" class="ui-text"  size="60" name="bottom_nav_list[1]" value="<?php echo ($extend['bottom_nav_list'][1]); ?>" >例：立即下单||#aliziOrder||edit</p>
						<p class="bottom_nav_list-2"><input type="text" class="ui-text"  size="60" name="bottom_nav_list[2]" value="<?php echo ($extend['bottom_nav_list'][2]); ?>" >例：联系电话||tel:13888888888||call</p>
						<p class="bottom_nav_list-3"><input type="text" class="ui-text"  size="60" name="bottom_nav_list[3]" value="<?php echo ($extend['bottom_nav_list'][3]); ?>" >例：订单查询||http://<?php echo ($_SERVER['HTTP_HOST']); echo C('ALIZI_ROOT');?>?m=Order&a=query||query</p>
					</td>
				</tr>
				<!--
				<tr>
					<th>显示评论</th>
					<td>
						<?php echo status($temp['show_comments'],'radio','0:不显示;1:显示','show_comments');?>
					</td>
				</tr>
				-->
				<tr>
					<th>说明信息</th>
					<td>
						 <input type="button" value="插入html" onclick="insertHtml()" class="ui-button" />
						<textarea name="info" id="content" class="input-textarea editor" cols="80" rows="2"  style="width:600px;"><?php echo ($temp["info"]); ?></textarea>
					</td>
				</tr>
				
				<tr>
					<th>调用代码</th>
					<td>
						<textarea name="using" id="using" class="input-textarea" cols="80" rows="3"  style="width:95%;"><iframe id="aliziIframe" name="aliziIframe" src="<?php echo ($url["order"]); ?>" width="100%" height="100%" scrolling="no" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0"></iframe></textarea>
					</td>
				</tr>
				<tr>
					<th>返回页面</th>
					<td>
						<input name="redirect_uri" class="ui-text" size="50" id="redirect_uri" type="text" value="<?php echo ($temp["redirect_uri"]); ?>" >
						<span class="ui-validityshower-info">（下单成功后点击返回页面）</span>
					</td>
				</tr>
				<tr>
					<th>模板调用</th>
					<td>
						<input type="submit"class="btn btn-ok" value="保存设置" />
						<a class="url btn" href="<?php echo ($url["order"]); ?>" id="tpl1" target="_blank">推广链接一</a>
						<a class="url-detail btn" href="<?php echo ($url["detail"]); ?>" id="tpl2" target="_blank">推广链接二</a>
					</td>
				</tr>
				<tr style="display:none;">
					<th>&nbsp;</th>
					<td>
						<input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>" />
						<input type="hidden" name="user_id" value="<?php echo ($_SESSION["user"]["id"]); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
		</form>
    </div><!--.box-->
<script type="text/javascript">
$(function(){
    $('#ajaxform').ajaxForm({
        success:function(data){ 
			color = data.data;
			parent.$.alert('保存成功',1);
		},
        dataType: 'json'
    });
	bottomNav();
});
function bottomNav(){
	var nav = $("input[name=bottom_nav]:checked").val();
	console.log(nav);
}
function resetColor(color){ 
	var color = color?color:<?php echo (json_encode($deaultColor)); ?>;
	for(var key in color){ 
		var fontColor = key=='body_bg' || key=='form_bg'?'#000000':'#FFFFFF';
		$('#color_'+key).val(color[key]).css({"background-color":'#'+color[key],'color':fontColor});
	}
}

function changeTheme(theme){
	$.getJSON("?m=Item&a=getCustomColor&tpl="+theme, function(color) {
		resetColor(color.data);
	});
}
</script>   
<link href="__PUBLIC__/Assets/js/umeditor/themes/default/css/umeditor.min.css" type="text/css" rel="stylesheet">
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Assets/js/umeditor/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Assets/js/umeditor/umeditor.min.js"></script>
<script type="text/javascript">  
UM.getEditor('content',{autoHeightEnabled:true,initialFrameWidth:800,initialFrameHeight:60});
function insertHtml() {
	var value = prompt('插入HTML代码', '');
	if(value){
		UM.getEditor('content').execCommand('insertHtml', value);
		$.alert(info+'添加成功',1);
	} 
}
</script>  
</body>
</html>