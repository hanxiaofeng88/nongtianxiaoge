<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME,'do'=>$_GET['do']));?>
<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3>
            <strong><?php echo lang('breadclumb_colon');?></strong>
            <?php echo lang(MODULE_NAME);?><span></span><?php echo lang('account_setting');?>
        </h3>
    </div>
    <div id="CooperationMain" class="box clear-fix">
        <div class="layout-block-header"><h2><?php echo lang('account_info');?></h2></div>  
        <div id="AccountInfo">
            
            <div class="info-block">
                <form method="post" action="<?php echo U('User/proccess');?>" id="ajaxform-password">
                <table class="info-table" id="js-password">
                    <thead>
                        <tr><th><?php echo lang('modify_password_colon');?></th><td><q class="modify" onclick="infoEdit(this,'#js-password')"><?php echo lang('modify');?></q></td></tr>
                    </thead>
                    <tbody>
                        <tr><th><?php echo lang('password_colon');?></th><td>******</td></tr>
                    </tbody>
                    <tbody style="display:none;">
                        <tr>
                            <th><b class="verifing">*</b><?php echo lang('new_password_colon');?></th>
                            <td><input name="password" type="password" id="password" class="ui-text validate[required,minSize[6]]"></td>
                        </tr>
                        <tr>
                            <th><b class="verifing">*</b><?php echo lang('confirm_password_colon');?></th>
                            <td><input name="repassword" type="password" class="ui-text validate[required,equals[password]]"></td>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <td>  
                                <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" />
                                <input type="submit" class="btn btn-ok" value="<?php echo lang('confirm');?>" />
                                <input type="button" class="btn" value="<?php echo lang('cancel');?>" onclick="infoEdit(this,'#js-password')" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div><!--.info-block-->
            
            <div class="info-block">
                <form method="post" action="<?php echo U('User/proccess');?>" id="ajaxform-info">
                <table class="info-table" id="js-info">
                    <thead>
                        <tr><th><?php echo lang('account_info_colon');?></th><td><q class="modify" onclick="infoEdit(this,'#js-info')"><?php echo lang('modify');?></q></td></tr>
                    </thead>
                    <tbody>
                        <tr><th><?php echo lang('username_colon');?></th><td><?php echo ($info["username"]); ?>【<?php echo (lang($info["role"])); ?>】</td></tr>
                        <tr><th><?php echo lang('status_colon');?></th><td><?php echo (status($info["status"],"image")); ?></td></tr>
                        <tr><th><?php echo lang('realname_colon');?></th><td><?php echo ($info["realname"]); ?></td></tr>
                        <tr><th><?php echo lang('mobile_colon');?></th><td><?php echo ($info["mobile"]); ?></td></tr>
                        <tr><th><?php echo lang('qq_colon');?></th><td><?php echo ($info["qq"]); ?></td></tr>
                        <tr><th><?php echo lang('remark_info_colon');?></th><td><pre><?php echo ($info["info"]); ?></pre></td></tr>
                    </tbody>
                    <tbody style="display:none;">
                        <tr><th><?php echo lang('username_colon');?></th><td><?php echo ($info["username"]); ?>【<?php echo (lang($info["role"])); ?>】</td></tr>
                        <tr>
							<th><?php echo lang('status_colon');?></th>
							<td><select name="status"><option value="1">启用</option><option value="0" <?php if(empty($info["status"])): ?>selected<?php endif; ?>>禁用</option></select></td>
						</tr>
                        <tr><th><b class="verifing">*</b><?php echo lang('realname_colon');?></th><td><input name="realname" type="text" class="ui-text validate[required,minSize[2]]" value="<?php echo ($info["realname"]); ?>"></td></tr>
                        <tr><th><?php echo lang('mobile_colon');?></th><td><input name="mobile" type="text" class="ui-text" value="<?php echo ($info["mobile"]); ?>"></td></tr>
                        <tr><th><?php echo lang('qq_colon');?></th><td><input name="qq" type="text" class="ui-text" value="<?php echo ($info["qq"]); ?>"></td></tr>
                        <tr><th><?php echo lang('remark_info_colon');?></th><td><textarea name="info" class="input-textarea" cols="65" rows="5"><?php echo ($info["info"]); ?></textarea></td></tr>
                        <tr>
                            <th>&nbsp;</th>
                            <td>
                                <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" />
                                <input type="submit" class="btn btn-ok" value="<?php echo lang('confirm');?>" />
                                <input type="button" class="btn" value="<?php echo lang('cancel');?>" onclick="infoEdit(this,'#js-info')" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div><!--.info-block-->
            
            <div class="info-block" style="display:none;">
                <form method="post" action="<?php echo U('User/proccess');?>" id="ajaxform-mobile">
                <table class="info-table" id="js-mobile">
                    <thead>
                        <tr><th><?php echo lang('bind_mobile');?></th><td><q class="modify" onclick="infoEdit(this,'#js-mobile')"><?php echo lang('modify');?></q></td></tr>
                    </thead>
                    <tbody>
                        <tr><th><?php echo lang('mobile_colon');?></th><td><?php echo ($info["mobile"]); ?></td></tr>
                    </tbody>
                    <tbody style="display:none;">
                        <tr><th><?php echo lang('mobile_colon');?></th><td><input name="mobile" type="text" class="ui-text" value="<?php echo ($info["mobile"]); ?>"></td></tr>
                        <tr><th><?php echo lang('code_colon');?></th><td><input name="code" type="text" class="ui-text" size="5"> <q class="btn btn-blue-mini">获取验证码</q></td></tr>
                        <tr>
                            <th>&nbsp;</th>
                            <td>
                                <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" />
                                <input type="submit" class="btn btn-ok" value="<?php echo lang('confirm');?>" />
                                <input type="button" class="btn" value="<?php echo lang('cancel');?>" onclick="infoEdit(this,'#js-mobile')" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div><!--.info-block-->
        </div>  
    </div><!--.box-->
<link href="__PUBLIC__/Assets/js/validation/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/Assets/js/validation/jquery.validationEngine.js"></script>
<script type="text/javascript" src="__PUBLIC__/Assets/js/validation/jquery.validationEngine-zh_CN.js"></script>
<script type="text/javascript">
$(function(){
	$("form").validationEngine('attach', {promptPosition : "centerRight", autoPositionUpdate : true});	
	var ajaxParams  = {
		timeout: 5000,
		error:function(){ $('#ajaxLoading').hide();alert("<?php echo lang('ajaxError');?>");},
		beforeSubmit:function(){ $('#ajaxLoading').show();},
		success:function(data){ $('#ajaxLoading').hide();$.alert(data.info,data.status,false);},
		dataType: 'json'
	};
	$('#ajaxform-info').ajaxForm(ajaxParams);
	$('#ajaxform-password').ajaxForm(ajaxParams);
})
</script>            
<?php echo W("Foot");?>