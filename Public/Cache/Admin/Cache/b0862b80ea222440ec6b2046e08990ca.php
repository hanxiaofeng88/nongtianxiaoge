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
			var thumb = $('#thumb');
			if(!thumb.val()) thumb.val(data);
		},
		'swf'         : '__PUBLIC__/Assets/js/uploadify/uploadify.swf',
		'uploader'    : '<?php echo U("Public/upload");?>',
		'buttonImage' : '__PUBLIC__/Assets/js/uploadify/swfBnt.png',
		'fileTypeExts': '*.bmp;*.jpg;*.jpeg;*.gif;*.png'//文件格式限制

	});
	$('#file_upload_thumb').uploadify({
		'onUploadSuccess' : function(file, data, response) {
			$('#thumb').val(data);
		},
		'swf'         : '__PUBLIC__/Assets/js/uploadify/uploadify.swf',
		'uploader'    : '<?php echo U("Public/upload");?>',
		'buttonImage' : '__PUBLIC__/Assets/js/uploadify/swfBnt.png',
		'fileTypeExts': '*.bmp;*.jpg;*.jpeg;*.gif;*.png'//文件格式限制

	});
});
function upload(btn,input){
	$(btn).uploadify({
		'onUploadSuccess' : function(file, data, response) {
			$(input).val(data);
		},
		'swf'         : '__PUBLIC__/Assets/js/uploadify/uploadify.swf',
		'uploader'    : '<?php echo U("Public/upload");?>',
		'buttonImage' : '__PUBLIC__/Assets/js/uploadify/swfBnt.png',
		'fileTypeExts': '*.bmp;*.jpg;*.jpeg;*.gif;*.png'
	});	
}
</script>

<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3><strong><?php echo lang('breadclumb_colon');?></strong><?php echo lang(MODULE_NAME);?><span></span><?php if(empty($_GET["id"])): echo lang('add'); else: echo lang('edit'); endif; ?></h3>
    </div>
    <div class="box clear-fix">
		
        <div class="layout-block-header">
			<h2><?php echo lang('details_info'); if(($_GET['do']) == "copy"): ?><b class="alert">【<?php echo lang('item_copy');?>】</b><?php endif; ?></h2>
		</div>  
        <div id="AccountInfo">
            <div class="info-block">
                <form method="post" action="<?php echo U(MODULE_NAME.'/proccess/');?>" id="ajaxform" enctype="multipart/form-data">
                <table class="info-table">
                    <tbody>
						<tr>
                            <th><b class="verifing">*</b><?php echo lang('item_number');?></th>
                            <td>
								<?php if(!empty($_GET['id']) && $_GET['do'] != 'copy'): ?><input name="sn" type="text" class="ui-text validate[required,minSize[4]]" size="30" value="<?php echo ($info["sn"]); ?>" readonly>
								<?php else: ?>
								<input name="sn" type="text" class="ui-text validate[required,minSize[4],custom[onlyLetterNumber]]" size="30" value="<?php echo randCode(8,'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0987654321');?>">
								<span class="ui-validityshower-info">（只能填写字母和数字）</span><?php endif; ?>
							</td>
                        </tr>
                    	<tr>
                            <th><b class="verifing">*</b><?php echo lang('name_colon');?></th>
                            <td><input name="name" type="text" class="ui-text validate[required,minSize[2]]" size="100" value="<?php echo ($info["name"]); ?>"></td>
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
                            <th><?php echo lang('qrcode_payment_colon');?></th>
                            <td>
								<select name="qrcode_pay" id="qrcode_pay" onchange="qrcodepay(this.value)">
									<option value="0">不使用二维码</option>
									<option value="1" <?php if(($info["qrcode_pay"]) == "1"): ?>selected="selected"<?php endif; ?>>固定金额二维码</option>
									<option value="2" <?php if(($info["qrcode_pay"]) == "2"): ?>selected="selected"<?php endif; ?>>不定金额二维码</option>
								</select>
								<span class="ui-validityshower-info">（可使用个人微信二维码或支付宝二维码收款）</span>
							</td>
                        </tr>
						<tr class="qrcode <?php if(!empty($info["qrcode_pay"])): ?>show<?php endif; ?>">
                            <th><?php echo lang('payment_说明_colon');?></th>
                            <td>
								<input name="qrcode_pay_info" class="ui-text" size="50" id="qrcode_pay_info" type="text" value="<?php echo ($info["qrcode_pay_info"]); ?>" >
								<span class="ui-validityshower-info">（换行请用&lt;br&gt;）</span>
							</td>
                        </tr>
						<tr>
                            <th><?php echo lang('price_colon');?></th>
                            <td>
								<div class="left" style="margin-right: 20px;">
									<label>原价：</label>
									<input name="original_price" class="ui-text" size="4" type="text" value="<?php echo ($info["original_price"]); ?>">
									<span class="ui-validityshower-info"><?php echo lang('yuan');?></span>
								</div>

								<label class="left"><b class="verifing">*</b>现价：</label>
								<div class="left">
									<input name="price" type="text" class="ui-text validate[required]" value="<?php echo ($info["price"]); ?>" size="4">
									<span class="ui-validityshower-info"><?php echo lang('yuan');?></span>
								</div>
								<div class="left qrcode <?php if(!empty($info["qrcode_pay"])): ?>show<?php endif; ?>" style="margin-left:20px;">
									<label class="left"><?php echo lang('qrcode_colon');?></label>
									<div class="left">
										<input name="qrcode" type="text" class="ui-text left" value="<?php echo ($info["qrcode"]); ?>" id="qrcode"><button id="btn-qrcode" type="button" class="btn-upload left" onclick="upload('#btn-qrcode','#qrcode')"></button>
										<span class="ui-validityshower-info">（收款二维码）</span>
									</div>
								</div>
							</td>
                        </tr>

						<tr>
                            <th><?php echo lang('sale_quantity_colon');?></th>
                            <td>
								<input name="salenum" class="ui-text" size="4" type="text" value="<?php echo ($info["salenum"]); ?>">
							</td>
                        </tr>
						<tr>
                            <th><?php echo lang('price_package_colon');?></th>
                            <td>
								<div>
									<input type="button" class="ui-button" value="<?php echo lang('add_package');?>" onclick="itemAdd()" />
									<select name="params_type">
										<option value="radio">单选项</option>
										<option value="select" <?php if(($info["params_type"]) == "select"): ?>selected="selected"<?php endif; ?>>下拉框</option>
									</select>
								</div>
                                <div class="item-list">
									<?php if(!empty($info["params"])): if(is_array($info["params"])): $i = 0; $__LIST__ = $info["params"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="rows clearfix"><label><?php echo lang('name_colon');?></label><input name="title[]" type="text" class="ui-text" value="<?php echo ($vo["title"]); ?>" size="15"><label><?php echo lang('price_colon');?></label><input name="params_price[]" type="text" class="ui-text" value="<?php echo ($vo["price"]); ?>" size="4"><div class="image"><label><?php echo lang('image_colon');?></label><input name="params_image[]" type="text" class="ui-text" value="<?php echo ($vo["image"]); ?>" id="image-<?php echo ($key); ?>" size="15"><button id="btn-image-<?php echo ($key); ?>" type="button" class="btn-upload" onclick="upload('#btn-image-<?php echo ($key); ?>','#image-<?php echo ($key); ?>')"></button></div><div class="qrcode <?php if(!empty($info["qrcode_pay"])): ?>show<?php endif; ?>"><label><b class="verifing">*</b><?php echo lang('qrcode_colon');?></label><input name="params_qrcode[]" type="text" class="ui-text  validate[required]" value="<?php echo ($vo["qrcode"]); ?>" id="qrcode-<?php echo ($key); ?>" size="15"><button id="btn-<?php echo ($key); ?>" type="button" class="btn-upload" onclick="upload('#btn-<?php echo ($key); ?>','#qrcode-<?php echo ($key); ?>')"></button></div><input type="button" class="ui-button" value="<?php echo lang('delete');?>" onclick="itemDel($(this))" /></div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
								</div>
                            </td>
                        </tr>
						<tr>
                            <th>商品属性：</th>
                            <td>
                                <p>
									<input type="button" class="ui-button" value="添加属性" onclick="itemForm()" />
									<span class="ui-validityshower-info">（多个选项内容用#分隔开，如：红色#白色#紫色）</span>
								</p>
								<div class="extend-list">
									<?php if(!empty($info["extends"])): if(is_array($info["extends"])): $i = 0; $__LIST__ = $info["extends"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="rows clearfix"><label><?php echo lang('name_colon');?></label><input name="extend_title[]" type="text" class="ui-text" value="<?php echo ($vo["title"]); ?>" size="6"><label> <?php echo lang('内容_colon');?></label><input name="extend_value[]" type="text" class="ui-text" value="<?php echo ($vo["value"]); ?>" size="40"><select name='extend_type[]'><option value='text' <?php if(($vo["type"]) == "text"): ?>selected<?php endif; ?>>文本框</option><option value='radio' <?php if(($vo["type"]) == "radio"): ?>selected<?php endif; ?>>单选项</option><option value='checkbox' <?php if(($vo["type"]) == "checkbox"): ?>selected<?php endif; ?>>多选项</option><option value='select' <?php if(($vo["type"]) == "select"): ?>selected<?php endif; ?>>下拉框</option></select><input type="button" class="ui-button" value="<?php echo lang('delete');?>" onclick="itemDel($(this))" /></div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
								</div>
                            </td>
                        </tr>

						<tr>
							<th>倒计时：</th>
							<td>
								<input name="timer" type="text" class="ui-text" value="<?php echo ($info["timer"]); ?>" size="10">
								<span class="ui-validityshower-info">（ 秒。为空或0则不显示）</span>
							</td>
						</tr>
                        <tr>
                            <th><?php echo lang('status_colon');?></th>
                            <td>
								<select name="status"><?php echo (status($info["status"],"select")); ?></select>
								<span class="ui-validityshower-info">（禁用则前台不显示）</span>
							</td>
                        </tr>
						<tr>
                            <th><?php echo lang('hot_colon');?></th>
                            <td>
                                <input name="is_hot" type="checkbox" value="1" <?php if(!empty($info["is_hot"])): ?>checked="checked"<?php endif; ?>>
                            </td>
                        </tr>
                        
						<tr>
                            <th><?php echo lang('pc_image_colon');?></th>
                            <td>
                                <input name="image" id="image" type="text" class="ui-text" value="<?php echo ($info["image"]); ?>" size="80" style="float:left">
                                <input id="file_upload" name="file_upload" type="file" multiple="true" value="<?php echo lang('upload');?>" onclick="upload('#file_upload','#image')">
                            </td>
                        </tr>
						<tr>
                            <th><?php echo lang('wap_image_colon');?></th>
                            <td>
                                <input name="thumb" id="thumb" type="text" class="ui-text" value="<?php echo ($info["thumb"]); ?>" size="80" style="float:left">
                                <input id="file_upload_thumb" name="file_upload_thumb" type="file" multiple="true" value="<?php echo lang('upload');?>" onclick="upload('#file_upload_thumb','#thumb')">
                            </td>
                        </tr>
						<tr>
                            <th><?php echo lang('brief_colon');?></th>
                            <td>
                                <input name="brief" type="text" class="ui-text" value="<?php echo ($info["brief"]); ?>" size="80">
								<span class="ui-validityshower-info">（一句话的简介）</span>
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
								<div>
									<label class="alert">点击向内容框插入以下标签内容：</label>
									<a href="javascript:;" onclick="setContent('{[AliziOrder]}','【订单标签】')">【订单标签】</a> 
									<a href="javascript:;" onclick="setContent('<button type=\'button\' class=\'alizi-btn alizi-btn-share\'>立即分享</button>','【分享按钮】')">【分享按钮】</a>
									<a href="javascript:;" onclick="insertHtml()">【插入代码】</a> 
								</div>
                            	<textarea name="content" id="content" class="input-textarea editor" cols="80" rows="6"><?php echo ($info["content"]); ?></textarea>
                            </td>
                        </tr>
						
						
						<?php $aliziConfig = S('aliziConfig');$payment = C('PAYMENT');$itemPayment=json_decode($info['payment']); ?>
						<?php if(empty($aliziConfig["payment_global"])): ?><tr>
                            <th><?php echo lang('payment_colon');?></th>
                            <td>
								<?php if(is_array($payment)): $i = 0; $__LIST__ = $payment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="checkbox" name="payment[]" value="<?php echo ($key); ?>" <?php if(in_array($key,$itemPayment)): ?>checked="checked"<?php endif; ?>>
								<label class="ui-group-label"><?php echo ($vo["name"]); ?></label><?php endforeach; endif; else: echo "" ;endif; ?>
                            </td>
                        </tr><?php endif; ?>
						
						<tr>
                            <th><?php echo lang('附加内容_colon');?></th>
                            <td>
								<p><span class="ui-validityshower-info">附加内容可以添加JS/CSS</span></p>
                                <textarea name="remark" id="remark" class="input-textarea" cols="125" rows="3"><?php echo ($info["remark"]); ?></textarea>
                            </td>
                        </tr>
						<tr>
                            <th><?php echo lang('运费模板_colon');?></th>
                            <td>
                                <select name="shipping_id" id="shipping_id">
									<option value="0">卖家承担运费</option>
									<?php if(is_array($shipping)): $i = 0; $__LIST__ = $shipping;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($vo["id"]) == $info["shipping_id"]): ?>selected="selected"<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
								<button type="button" class="btn" onclick="shipping()">添加模板</button>
								<a href="<?php echo U('Setting/shipping');?>">管理运费模板</a>
                            </td>
                        </tr>
						<tr>
                            <th><?php echo lang('自动发货_colon');?></th>
                            <td>
								<input name="is_auto_send" id="is_auto_send" type="checkbox" value="1" <?php if(!empty($info["is_auto_send"])): ?>checked="checked"<?php endif; ?> onclick="isShow(this,'.inform')">
								<span class="ui-validityshower-info">（选择自动发货，则用户支付后将自动发送内容）</span>
							</td>
                        </tr>
						<tr class="inform <?php if(!empty($info["is_auto_send"])): ?>show<?php endif; ?>">
                            <th><?php echo lang('发送内容_colon');?></th>
                            <td>
								<textarea name="send_content" id="send_content" class="input-textarea" cols="125" rows="3"><?php echo ($info["send_content"]); ?></textarea>
							</td>
                        </tr>
						
						<?php $aliziConfig = S('aliziConfig');if($aliziConfig['sms_send']==1){ ?>
						<tr>
                            <th><?php echo lang('sms_send_colon');?></th>
                            <td>
								<input name="sms_send[0][status]" type="checkbox" value="1" <?php if(!empty($info['sms_send'][0]['status'])): ?>checked="checked"<?php endif; ?> onclick="isShow(this,'.sms_send_0')">
								<span class="ui-validityshower-info">下单通知</span>
								
								<input name="sms_send[1][status]" type="checkbox" value="1" <?php if(!empty($info['sms_send'][1]['status'])): ?>checked="checked"<?php endif; ?> onclick="isShow(this,'.sms_send_1')">
								<span class="ui-validityshower-info">支付通知</span>
								
								<input name="sms_send[3][status]" type="checkbox" value="1" <?php if(!empty($info['sms_send'][3]['status'])): ?>checked="checked"<?php endif; ?> onclick="isShow(this,'.sms_send_3')">
								<span class="ui-validityshower-info">发货通知</span>
								
								<p>内容替换标签：标题{[AliziTitle]}，套餐{[AliziParams]}，姓名{[AliziName]}，数量{[AliziQuantity]}，价格{[AliziPrice]}，快递名称{[AliziExpress]}，快递单号{[AliziExpressNum]}</p>
							</td>
                        </tr>
						<tr class="smsSend sms_send_0 <?php if(!empty($info['sms_send'][0]['status'])): ?>show<?php endif; ?>">
                            <th><?php echo lang('下单通知内容_colon');?></th>
                            <td>
								<textarea name="sms_send[0][content]"class="input-textarea" cols="125" rows="3"><?php if(!empty($info['sms_send'][0]['content'])): echo ($info['sms_send'][0]['content']); else: ?>{[AliziName]}，您好！您已成功订购【{[AliziTitle]}】，数量{[AliziQuantity]}件，我们将尽快安排发货，感谢您的支持<?php endif; ?></textarea>
							</td>
                        </tr>
						<tr class="smsSend sms_send_1 <?php if(!empty($info['sms_send'][1]['status'])): ?>show<?php endif; ?>">
                            <th><?php echo lang('支付通知内容_colon');?></th>
                            <td>
								<textarea name="sms_send[1][content]" class="input-textarea" cols="125" rows="3"><?php if(!empty($info['sms_send'][1]['content'])): echo ($info['sms_send'][1]['content']); else: ?>{[AliziName]}，您好！您已成功订购【{[AliziTitle]}】，价格{[AliziPrice]}元，我们将尽快安排发货，敬请留意<?php endif; ?></textarea>
							</td>
                        </tr>
						<tr class="smsSend sms_send_3 <?php if(!empty($info['sms_send'][3]['status'])): ?>show<?php endif; ?>">
                            <th><?php echo lang('发货通知内容_colon');?></th>
                            <td>
								<textarea name="sms_send[3][content]" class="input-textarea" cols="125" rows="3"><?php if(!empty($info['sms_send'][3]['content'])): echo ($info['sms_send'][3]['content']); else: ?>{[AliziName]}，您好！您订购的【{[AliziTitle]}】，已经发货，快递：{[AliziExpress]}，单号：{[AliziExpressNum]}，请注意查收<?php endif; ?></textarea>
							</td>
                        </tr>
						<?php } ?>
						
                        <tr>
                            <th>&nbsp;</th>
                            <td>
								<?php if(!empty($_GET['id']) && $_GET['do'] != 'copy'): ?><input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" /><?php endif; ?>
                                <input type="hidden" name="user_id" value="<?php echo ($_SESSION["user"]["id"]); ?>" />
                                <input type="submit" class="btn btn-ok" value="<?php echo lang('confirm');?>" />
                                <a class="btn" href="<?php if(empty($_GET["id"])): echo U('Item/index'); else: echo ($_SERVER['HTTP_REFERER']); endif; ?>"><?php echo lang('goback');?></a>
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
                var redirectURL = "<?php if(($_GET["do"]) == "edit"): ?>#<?php else: echo U('Item/index'); endif; ?>";
                $.alert(data.info,data.status,function(){window.location.href=redirectURL});
            }else{
                $.alert(data.info,data.status);
            }
        },
        dataType: 'json'
    });
});

function qrcodepay(id){
	id = parseInt(id);
	if(id>0){$('.qrcode').show();}else{$('.qrcode').hide();}
}
function itemAdd(){
	var show = $('#qrcode_pay').val()>0?' show':'';
	var rand = new Date().getTime();
	var item = '<div class="rows clearfix"><label><?php echo lang('name_colon');?></label><input name="title[]" type="text" class="ui-text" value="<?php echo ($info["title"]); ?>" size="15"><label><?php echo lang('price_colon');?></label><input name="params_price[]" type="text" class="ui-text" value="<?php echo ($info["price"]); ?>" size="4"><div class="image"><label><?php echo lang('image_colon');?></label><input name="params_image[]" type="text" class="ui-text" id="image-'+rand+'" size="15"><button id="btn-image-'+rand+'" type="button" class="btn-upload" onclick="upload(\'#btn-image-'+rand+'\',\'#image-'+rand+'\')"></button></div><div class="qrcode '+show+'"><label><b class="verifing">*</b><?php echo lang('qrcode_colon');?></label><input name="params_qrcode[]" type="text" class="ui-text validate[required]" id="qrcode-'+rand+'" size="15"><button id="btn-'+rand+'" type="button" class="btn-upload" onclick="upload(\'#btn-'+rand+'\',\'#qrcode-'+rand+'\')"></button></div><input type="button" class="ui-button" value="<?php echo lang('delete');?>" onclick="itemDel($(this))" /></div>';
	$('.item-list').append(item);
}
function itemDel(obj){
	obj.parent().remove();
}
function itemForm(){
	var show = $('#extend_form').attr('checked')=='checked'?' show':'';
	var rand = new Date().getTime();
	var select = "<select name='extend_type[]'><option value='text'>文本框</option><option value='radio'>单选项</option><option value='checkbox'>多选项</option><option value='select'>下拉框</option></select>";
	var item = '<div class="rows clearfix"><label><?php echo lang('name_colon');?></label><input name="extend_title[]" type="text" class="ui-text" value="<?php echo ($info["title"]); ?>" size="6"><label> <?php echo lang('内容_colon');?></label><input name="extend_value[]" type="text" class="ui-text" value="" size="40">'+select+'<input type="button" class="ui-button" value="<?php echo lang('delete');?>" onclick="itemDel($(this))" /></div>';
	$('.extend-list').append(item);
}
function isShow(_this,target){
	var target = $(target);
	if(_this.checked==true){
		target.addClass('show');
	}else{
		target.removeClass('show');
	}
}
function shipping(id){
	var url = "?m=Shipping&a=edit&page=2";
	$.open(url,{title:'运费模板',width:680,height:250});
}
</script>     
<link href="__PUBLIC__/Assets/js/umeditor/themes/default/css/umeditor.min.css" type="text/css" rel="stylesheet">
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Assets/js/umeditor/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Assets/js/umeditor/umeditor.min.js"></script>
<script type="text/javascript">  
	UM.getEditor('content');
	function setContent(content,info) {
        UM.getEditor('content').execCommand('insertHtml', content);
		$.alert(info+'添加成功',1);
    }
	function insertHtml() {
        var value = prompt('插入HTML代码', '');
		if(value){
			setContent(value,'')
		} 
    }
</script>       
<?php echo W("Foot");?>