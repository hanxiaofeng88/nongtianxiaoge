<?php if (!defined('THINK_PATH')) exit(); echo W("Main",array('module'=>MODULE_NAME,'action'=>ACTION_NAME,'do'=>$_GET['do']));?>

<div class="layout-main">    
    <div id="breadclumb" class="box">
        <h3><strong><?php echo lang('breadclumb_colon');?></strong><?php echo lang(MODULE_NAME);?><span></span><?php if(empty($_GET["id"])): echo lang('add'); else: echo lang('action'); endif; ?></h3>
    </div>
    <div class="box clear-fix">
        <div class="layout-block-header"><h2><?php echo lang('order_info');?> <span class="order-no">（<?php echo lang('order_number_colon'); echo ($info["order_no"]); ?>）</span></h2></div>  
        <div class="AccountInfo">
            <div class="info-block">
                <table class="info-table">
                    <tbody>
                        <tr>
                            <th><?php echo lang('order_status_colon');?></th>
                            <td width="200"><?php echo status($info['status'],'',C('order_status'));?></td>
                            <th><?php echo lang('item_name_colon');?></th>
                            <td><?php echo ($info["item_name"]); if(!empty($info["item_params"])): ?>（<?php echo ($info["item_params"]); ?>）<?php endif; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo lang('extend_package_colon');?></th>
                            <td class="extends">
                                <?php $extends=json_decode($info['item_extends'],true); foreach($extends as $name=>$value){ $value = is_array($value)?implode('，',$value):$value; echo "<p><i>$name</i>：<span>$value</span></p>"; } ?>
                            </td>
                            <th><?php echo lang('amount_price_colon');?></th>
                            <td>
                                <?php echo ($info["quantity"]); ?>/<b class="alert"><?php echo ($info["order_price"]); ?></b><?php echo lang('yuan');?> + <?php echo ($info["shipping_price"]); echo lang('yuan');?> = <b class="alert"><?php echo ($info["total_price"]); ?></b><?php echo lang('yuan');?>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo lang('date_colon');?></th>
                            <td valign="top"><?php echo (substr($info["datetime"],0,10)); ?></td>
                            <th><?php echo lang('payment_colon');?></th>
                            <td><?php $payment = C('PAYMENT');echo $payment[$info['payment']]['name']; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo lang('channel_colon');?></th>
                            <td><?php echo ($info["channel_id"]); ?></td>
                            <th><?php echo lang('设备_colon');?></th>
                            <td><?php if(($info["device"]) == "2"): ?>M<?php else: ?>PC<?php endif; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo lang('下单地址_colon');?></th>
                            <td valign="top"><a href="<?php echo ($info["url"]); ?>" target="_blank"><?php echo ($info["url"]); ?></a></td>
                            <th><?php echo lang('来路地址_colon');?></th>
                            <td valign="top"><a href="<?php echo ($info["referer"]); ?>" target="_blank"><?php echo ($info["referer"]); ?></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>  
    </div><!--.box-->
    
    <div class="box clear-fix">
        <div class="layout-block-header"><h2><?php echo lang('customer_info');?></h2></div>  
        <div class="AccountInfo">
            <div class="info-block">
                <table class="info-table">
                    <tbody>
                        <tr>
                            <th><?php echo lang('realname_colon');?></th>
                            <td width="100"><?php echo ($info["name"]); ?></td>
                            <th><?php echo lang('address_colon');?></th>
                            <td><?php echo ($info["region"]); ?> <?php echo ($info["address"]); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo lang('mobile_colon');?></th>
                            <td><?php echo ($info["mobile"]); ?></td>
                            <th><?php echo lang('remark_colon');?></th>
                            <td><?php echo ($info["remark"]); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo lang('qq_colon');?></th>
                            <td><?php echo ($info["qq"]); ?></td>
                            <th><?php echo lang('zcode_colon');?></th>
                            <td><?php echo ($info["zcode"]); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo lang('email_colon');?></th>
                            <td><?php echo ($info["mail"]); ?></td>
                            <th><?php echo lang('customer_ip_colon');?></th>
                            <td><a href="http://www.ip.cn/index.php?ip=<?php echo ($info["add_ip"]); ?>&from=http://<?php echo ($_SERVER['HTTP_HOST']); echo C('ROOT_FILE');?>" target="_blank"><?php echo ($info["add_ip"]); ?></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>  
    </div><!--.box-->
    
    
    <div class="box clear-fix">
        <div class="layout-block-header"><h2><?php echo lang('action_record');?></h2></div>  
        <div class="AccountInfo">
            <div class="ui-table-body ui-table-body-hover">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr class="ui-table-head">
                            <th class="ui-table-hcell" width="120">操作时间</th>
                            <th class="ui-table-hcell" width="80">操作类型</th>
                            <th class="ui-table-hcell" width="80">操作用户</th>
                            <th class="ui-table-hcell">操作备注</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($log)): $i = 0; $__LIST__ = $log;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo (date("Y-m-d H:i:s",$vo["add_time"])); ?></td>
                            <td><?php echo status($vo['status'],'',C('order_status'));?></td>
                            <td><?php if(empty($vo["user_id"])): echo lang('customer'); else: echo (getfields("User","username",$vo["user_id"])); endif; ?></td>
                            <td class="action"><?php echo ($vo["remark"]); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
        </div> 
    </div><!--.box-->
    
    <?php if($_SESSION['user']['role'] == 'admin'): ?><div class="box clear-fix">
        <div class="layout-block-header"><h2><?php echo lang('action');?></h2></div>  
        <div class="AccountInfo">
            <div class="info-block">
                <form method="post" action="<?php echo U(MODULE_NAME.'/status/');?>" id="ajaxform" enctype="multipart/form-data">
                <table class="info-table">
                    <tbody>
                        <tr>
                            <th><?php echo lang('express_setting_colon');?></th>
                            <td>
                                <select name="delivery_name" id="delivery_name">
                                    <option value=""><?php echo lang('please_select_express');?></option>
                                    <?php if(is_array($delivery)): $i = 0; $__LIST__ = $delivery;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($info["delivery_name"]) == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                
                                <label style="margin-left:20px;"><?php echo lang('express_number_colon');?></label>
                                <input type="text" name="delivery_no" id="delivery_no" class="ui-text" value="<?php echo ($info["delivery_no"]); ?>">
                                <button type="button" class="btn btn-ok" onclick="delivery()"><?php echo lang('save_express');?></button>
                            </td>
                        </tr>
                        <?php if(in_array($info['status'],array(0,1,2,3,8))): ?><tr>
                            <th><?php echo lang('action_remark_colon');?></th>
                            <td>
                                <textarea name="remark" id="remark" class="input-textarea editor" cols="80" rows="3"></textarea>
                            </td>
                        </tr><?php endif; ?>
                        <tr>
                            <th>&nbsp;</th>
                            <td>
                                <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" />
                                <input type="hidden" name="user_id" value="<?php echo ($user["id"]); ?>" />
                                <?php switch($info["status"]): case "0": ?><button type="submit" name="status" value="1" class="btn btn-ok">已付款</button>
                                        <button type="submit" name="status" value="2" class="btn btn-ok">确认订单</button>
                                        <button type="submit" name="status" value="6" class="btn">关闭订单</button><?php break;?>
                                    <?php case "1": ?><button type="submit" name="status" value="3" class="btn btn-ok">发货</button>
                                        <button type="submit" name="status" value="6" class="btn">关闭订单</button><?php break;?>
                                    <?php case "2": ?><button type="submit" name="status" value="3" class="btn btn-ok">发货</button>
                                        <button type="submit" name="status" value="6" class="btn">关闭订单</button><?php break;?>
                                    <?php case "3": ?><button type="submit" name="status" value="4" class="btn btn-ok">已签收</button>
                                        <button type="submit" name="status" value="5" class="btn">拒签收</button><?php break;?>
                                    <?php case "8": ?><button type="submit" name="status" value="9" class="btn btn-ok">退款</button><?php break; endswitch;?>
                                <?php if(($info["status"]) != "7"): ?><button type="submit" name="status" value="7" class="btn">订单完结</button><?php endif; ?>
                                <?php if(!empty($pre_id)): ?><a class="btn" href="<?php echo U('Order/index',array('do'=>'view','id'=>$pre_id));?>"><<上一个</a><?php endif; ?>
                                <a class="btn" href="<?php echo U('Order/index');?>"><?php echo lang('order_list');?></a>
                                <?php if(!empty($next_id)): ?><a class="btn" href="<?php echo U('Order/index',array('do'=>'view','id'=>$next_id));?>">下一个>></a><?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div>
        </div>  
    </div><!--.box--><?php endif; ?>
    
<script type="text/javascript">
$(function(){
    $('#ajaxform').ajaxForm({
        timeout: 15000,
        error:function(){ $('#ajaxLoading').hide();alert("<?php echo lang('ajaxError');?>");},
        beforeSubmit:function(){ 
            if( $('#remark').val()==''){
                $.alert('请输入备注内容',0);
                return false;
            }
            if(!confirm('确认操作？')) return false;

            $('#ajaxLoading').show();
        },
        success:function(data){ 
            $('#ajaxLoading').hide();
            if(data.status==1){
                //var redirectURL = "<?php if(empty($_GET["id"])): echo U('Order/index'); else: echo ($_SERVER['HTTP_REFERER']); endif; ?>";
                $.alert(data.info,data.status,function(){window.location.reload();});
            }else{
                $.alert(data.info,data.status);
            }
        },
        dataType: 'json'
    });
});
function delivery(){
    var id='<?php echo ($info["id"]); ?>';
    var delivery_name = $('#delivery_name').val();
    var delivery_no = $('#delivery_no').val();
    $.ajax({
        url:'<?php echo U("Order/deliveryUpdate");?>',
        type:'post',
        dataType:'json',
        data:{id:id,delivery_name:delivery_name,delivery_no:delivery_no},
        beforeSend:function(){
            if(!delivery_name){
                $.alert('请选择快递',0);return false;
            }
            if(!delivery_no){
                $.alert('请填写快递单号',0);return false;
            }
        },
        success:function(data){
            $.alert(data.info,data.status);
        }
        
    })
}

</script>     
       
<?php echo W("Foot");?>