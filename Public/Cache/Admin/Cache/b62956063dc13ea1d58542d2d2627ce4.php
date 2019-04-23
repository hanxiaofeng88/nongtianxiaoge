<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME,'do'=>$_GET['do']));?>
<link  href="__PUBLIC__/Assets/js/uploadify/uploadify.css" rel="stylesheet" type="text/css">
<script src="__PUBLIC__/Assets/js/uploadify/jquery.uploadify.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#file_upload').uploadify({
		'formData'     : {
			'timestamp' : '<?php echo ($_SERVER["REQUEST_TIME"]); ?>',
			'token'     : '<?php echo (md5($_SERVER["REQUEST_TIME"])); ?>'
		},
		'onUploadSuccess' : function(file, data, response) {
			$('#image').val(data);
		},
		'swf'         : '__PUBLIC__/Assets/js/uploadify/uploadify.swf',
		'uploader'    : '<?php echo U("Public/upload");?>',
		'buttonImage' : '__PUBLIC__/Assets/js/uploadify/swfBnt.png',
		'fileTypeExts': '*.bmp;*.jpg;*.jpeg;*.gif;*.png'//文件格式限制

	});
});
function upload(btn,input){
	$(btn).uploadify({
		'formData'     : {
			'timestamp' : '<?php echo ($_SERVER["REQUEST_TIME"]); ?>',
			'token'     : '<?php echo (md5($_SERVER["REQUEST_TIME"])); ?>'
		},
		'onUploadSuccess' : function(file, data, response) {
			$(input).val(data);
		},
		'swf'         : '__PUBLIC__/Assets/js/uploadify/uploadify.swf',
		'uploader'    : '<?php echo U("Public/upload");?>',
		'buttonImage' : '__PUBLIC__/Assets/js/uploadify/swfBnt.png',
		'fileTypeExts': '*.bmp;*.jpg;*.jpeg;*.gif;*.png'//文件格式限制

	});	
}
</script>

<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3><strong><?php echo lang('breadclumb_colon');?></strong><?php echo lang(MODULE_NAME);?><span></span><?php if(empty($_GET["id"])): echo lang('add'); else: echo lang('edit'); endif; ?></h3>
    </div>
    <div class="box clear-fix">
		
        <div class="layout-block-header"><h2><?php echo lang('details_info');?></h2></div>  
        <div id="AccountInfo">
            <div class="info-block">
                <form method="post" action="<?php echo U(MODULE_NAME.'/proccess/');?>" id="ajaxform" enctype="multipart/form-data">
                <table class="info-table">
                    <tbody>
                    	<tr>
                            <th><b class="verifing">*</b><?php echo lang('name_colon');?></th>
                            <td><input name="name" type="text" class="ui-text validate[required,minSize[2]]" size="40" value="<?php echo ($info["name"]); ?>"></td>
                        </tr>
						<tr>
                            <th><b class="verifing">*</b><?php echo lang('category_colon');?></th>
                            <td>
								<select name="category_id" class="validate[required]">
									<?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($info["category_id"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
							</td>
                        </tr>
						
                        <tr>
                            <th><?php echo lang('status_colon');?></th>
                            <td>
								<select name="status"><?php echo (status($info["status"],"select")); ?></select>
							</td>
                        </tr>
						
						<tr>
                            <th><?php echo lang('image_colon');?></th>
                            <td>
                                <input name="image" id="image" type="text" class="ui-text" value="<?php echo ($info["image"]); ?>" size="40" style="float:left">
                                <input id="file_upload" name="file_upload" type="file" multiple="true" value="<?php echo lang('upload');?>" onclick="upload('#file_upload','#image')">
								<span class="ui-validityshower-info">（图片大小为450x450）</span>
                            </td>
                        </tr>
						<tr>
                            <th><?php echo lang('brief_colon');?></th>
                            <td>
								<textarea name="brief" class="ui-text" cols="80" rows="3" style="height:4em;"><?php echo ($info["brief"]); ?></textarea>
                            </td>
                        </tr>
						<tr>
                            <th><?php echo lang('标签_colon');?></th>
                            <td>
                                <input name="tags" type="text" class="ui-text" value="<?php echo ($info["tags"]); ?>" size="80">
								<span class="ui-validityshower-info">（多个标签请用#分开）</span>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo lang('content_colon');?></th>
                            <td>
                            	<textarea name="content" id="content" class="input-textarea editor" cols="80" rows="6"><?php echo ($info["content"]); ?></textarea>
                            </td>
                        </tr>
						
				
                        <tr>
                            <th>&nbsp;</th>
                            <td>
                                <?php if(!empty($_GET['id'])): ?><input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" /><?php endif; ?>
                                <input type="hidden" name="user_id" value="<?php echo ($_SESSION["user"]["id"]); ?>" />
                                <input type="submit" class="btn btn-ok" value="<?php echo lang('confirm');?>" />
                                <a class="btn" href="<?php if(empty($_GET["id"])): echo U('Article/index'); else: echo ($_SERVER['HTTP_REFERER']); endif; ?>"><?php echo lang('goback');?></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div>
        </div>  
    </div><!--.box-->
<link href="__PUBLIC__/Assets/js/validation/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/Assets/js/validation/jquery.validationEngine.js"></script>
<script type="text/javascript" src="__PUBLIC__/Assets/js/validation/jquery.validationEngine-zh_CN.js"></script>
<script type="text/javascript">
$(function(){
	$("#ajaxform").validationEngine('attach', {promptPosition : "centerRight", autoPositionUpdate : true}); 
    $('#ajaxform').ajaxForm({
        timeout: 15000,
        error:function(){ $('#ajaxLoading').hide();alert("<?php echo lang('ajaxError');?>");},
        beforeSubmit:function(){ $('#ajaxLoading').show();},
        success:function(data){ 
            $('#ajaxLoading').hide();
            if(data.status==1){
                var redirectURL = "<?php if(empty($_GET["id"])): echo U('Article/index'); else: ?>#<?php endif; ?>";
                $.alert(data.info,data.status,function(){window.location.href=redirectURL});
            }else{
                $.alert(data.info,data.status);
            }
        },
        dataType: 'json'
    });
});

</script>     
<link href="__PUBLIC__/Assets/js/umeditor/themes/default/css/umeditor.min.css" type="text/css" rel="stylesheet">
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Assets/js/umeditor/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Assets/js/umeditor/umeditor.min.js"></script>
<script type="text/javascript">  var um = UM.getEditor('content');</script>         
<?php echo W("Foot");?>