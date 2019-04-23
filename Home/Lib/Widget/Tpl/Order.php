<?php
$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$show_notice = $template['show_notice']<2?'alizi-full-row':'';
$user_id = isset($_SESSION['member']['id'])?$_SESSION['member']['id']:$_GET['uid'];
echo "<div class='alizi-order alizi-theme-".($template['template']?$template['template']:'thin')." alizi-lang-".C('DEFAULT_LANG')." alizi-border clearfix' id='aliziOrder'>",
	"<div class='alizi-main alizi-border {$show_notice}'>",
		"<div class='alizi-title alizi-border ellipsis'><i class='icon-cart'></i>{$info['name']}</div>";
		
		echo "<div class='alizi-content alizi-border'>",
			"<form action='".U('Order/aliziBooking')."' method='post' id='aliziForm'>",
				"<input type='hidden' name='user_id' value='{$user_id}'>",
				"<input type='hidden' name='sn' value='{$info['sn']}'>",
				"<input type='hidden' name='item_id' value='{$info['id']}'>",
				"<input type='hidden' name='item_name' value='{$info['name']}'>",
				"<input type='hidden' name='item_price' id='item_price' value='".($product?$product[0]['price']:$info['price'])."'>",
				"<input type='hidden' name='url' value='{$url}'>",
				"<input type='hidden' name='redirect' value='".($template['redirect_uri']?$template['redirect_uri']:$url)."'>",
				"<input type='hidden' name='referer' value='{$_SERVER['HTTP_REFERER']}'>",
				"<input type='hidden' name='alizi_page' value='{$request['page']}'>",
				"<input type='hidden' name='channel_id' value='{$cookie['ac']}'>",
				"<input type='hidden' name='qrcode_pay' value='{$info['qrcode_pay']}'>",
				"<input type='hidden' name='math' value='{$paymentDefault['math']}'>";

				echo "<div class='alizi-box' id='alizi-box-1'>";	
				if(!empty($template['info']) && $request['page'] == 'single'){
					echo "<div class='alizi-brief clearfix'>{$template['info']}</div>";
				}
				if(!empty($product)){
				echo "<div class='alizi-rows clearfix rows-id-params rows-id-params-{$info['params_type']}'>",
					"<label class='rows-head'>".lang('itemPackage_request')."</label>",
					"<div class='rows-params'>";
						switch ($info['params_type']) {
							case 'select':
								echo "<select class='alizi-params-change' name='item_params' alizi-fx='alizi.quantity' alizi-fx-params='0'>";
									foreach($product as $vo){
										echo "<option value='{$vo['price']}'>{$vo['title']}</option>";
									}
								echo "</select>";
							break;
							default:
								$i=0;
								foreach($product as $vo){
									$i++;
									echo "<label alizi-value='{$vo['price']}' alizi-target='#item_price' alizi-fx='alizi.quantity' alizi-fx-params='0' class='".($vo['image']?' alizi-params-image':'')." ellipsis alizi-params ".($i==1?' active ':'')."' title='{$vo['title']}'>";
									if($vo['image']){
										echo "<p class='item-image'><img src='".imageUrl($vo['image'])."' /></p>";
									}
									echo "<input type='radio' name='item_params' value='{$vo['title']}' ".($i==1?'checked':'').">{$vo['title']}</label>";
								}
							break;
						}
					echo "</div></div>";
				}
				
				if(!empty($extends)){
					foreach($extends as $k=>$vo){
						//if($vo['type']=='text'){continue;}
							echo "<div class='alizi-rows clearfix rows-id-extends'><label class='rows-head'>{$vo['title']}".lang('request')."</label><div class='rows-params'>";
							switch ($vo['type']) {
								case 'text':
									echo "<input type='text' name='extends[{$vo['title']}]' placeholder='{$vo['value']}' autocomplete='off' class='alizi-input-text'>";
								break;
								case 'select':
									echo "<select name='extends[{$vo['title']}]'>";
										foreach(explode('#',$vo['value']) as $li){
											if(empty($li)){
												echo "<option value=''>".lang('pleaseSelect')."</option>";
											}else{
												echo "<option value='{$li}'>{$li}</option>";
											}
										}
									echo "</select>";
								break;
								default:
									$i=0;
									foreach(explode('#',$vo['value']) as $li){
										$i++;
										$hidden = empty($li)?'style="display:none;"':'';
										echo "<label class='alizi-group alizi-params alizi-{$vo['type']} ".($i==1?'active':'')."' {$hidden}><span class='alizi-group-box'>",
										"<input alizi-value='{$li}' id='{$vo['title']}{$key}' name='extends[{$vo['title']}]".($vo['type']=='checkbox'?'[]':'')."' type='{$vo['type']}' value='{$li}' ".($i==1?'checked':'').">",
										"<label class='selected-icon' for='{$vo['title']}{$key}'></label></span>{$li}</label>";
									}
								break;
							}
						echo "</div></div>";	
					}		
				}
				if($params['quantity']['checked']==false){
					echo "</div><!--.alizi-box--><div class='alizi-box' id='alizi-box-2'>";
				}
				foreach($params as $key=>$vo){
					if(empty($vo['checked'])){ continue;}
					echo "<div class='alizi-rows clearfix rows-id-{$key}'><label class='rows-head'>{$vo['name']}<span class='alizi-request ".($vo['request']?'':'alizi-request-none')."'>*</span></label><div class='rows-params'>";
					switch ($key) {
						case 'price':
							echo "<span class='alizi-shipping' ".($info['shipping_id']?'':"style='display:none;'").">",
								"<strong class='alizi-order-price'>0.00</strong>+<strong class='alizi-shipping-price'>0.00</strong>(".lang('shippingPrice').")=</span><strong class='alizi-total-price'>".($product?$product[0]['price']:$info['price'])."</strong>".lang('yuan').$vo['info'];

							echo "</div></div>";	
							echo "</div><!--.alizi-box--><div class='alizi-box' id='alizi-box-2'><div><div>";
						break;
						case 'payment':
							echo "<div class='alizi-payment clearfix'>";
								$i=0;
								$firstPayment =1;
								foreach($payment as $key=>$vo){
									$i++;
									if($i==1) $firstPayment=$key;
									if($key == 5 && empty($info['qrcode_pay'])){ continue;}
									echo "<a alizi-value='{$key}' alizi-target=':payment' alizi-fx='alizi.payment' alizi-fx-params='{$key}' class='ellipsis alizi-params alizi-payment-{$key} ".($i==1?'active':'')."' href='javascript:;'><input type='radio' name='payment' value='{$key}' ".($i==1?'checked':'').">{$vo['name']}</a>";
								}
							echo "</div><div id='alizi-payment-info' class='alizi-alert clearfix' ".($payment[$firstPayment]['info']?'':"style='display:none;'")."><div class='payment-info'>{$payment[$firstPayment]['info']}</div></div>";
						break;
						case 'mobile':
							echo "<input type='tel' name='{$key}' placeholder='{$vo['info']}' autocomplete='off' class='alizi-input-text' alizi-request='{$vo['request']}' value='{$cookie[$key]}'>";
						break;
						case 'salenum':
							//$totals = M('Order')->query("SELECT SUM(quantity) AS quantity,SUM(total_price) AS total_price FROM __TABLE__ WHERE item_id={$info['id']} AND status IN(1,2,3,4,5)");
							//echo "<span>".intval($totals[0]['quantity'])."</span><b class='sale-total-price'>(".lang('totalPrice_colon').number_format($totals[0]['total_price'],2).L('yuan').")</b>";	
							echo "<span>{$info['salenum']}</span>";
						break;
						case 'quantity':
							echo "<div class='alizi-quantity-group'>",
								"<a class='quantity-dec' href='javascript:;' onclick='alizi.quantity(-1)'>-</a>",
								"<input type='tel' class='alizi-quantity' size='4' value='1' name='quantity' onkeyup='alizi.quantity(0)'>",
								"<a class='quantity-inc' href='javascript:;' onclick='alizi.quantity(1)'>+</a></div>";
						break;
						case 'datetime':
							echo "<input type='text' name='{$key}' placeholder='{$vo['info']}' autocomplete='off' class='alizi-input-text Wdate' alizi-request='{$vo['request']}' style='width:50%;' onfocus='WdatePicker()' value='{$cookie[$key]}'>
								<script type='text/javascript' src='__PUBLIC__/Assets/js/My97DatePicker/WdatePicker.js'></script>";
						break;
						case 'region':
							echo "<select name='region[province]' id='province' class='alizi-region alizi-region-province' alizi-request='{$vo['request']}'></select>
								<select name='region[city]' id='city' class='alizi-region alizi-region-city' alizi-request='{$vo['request']}'></select>
								<select name='region[area]' id='area' class='alizi-region alizi-region-area' alizi-request='{$vo['request']}'></select>
								<script type='text/javascript'>var lang='".C('DEFAULT_LANG')."';seajs.use(['alizi/region-'+lang],function(region){ new PCAS('region[province]','region[city]','region[area]','{$cookie['region'][0]}','{$cookie['region'][1]}','{$cookie['region'][2]}');});</script>";
						break;
						case 'remark':
							echo "<textarea name='{$key}' placeholder='{$vo['info']}' class='alizi-input-text' alizi-request='{$vo['request']}' rows='2'></textarea>";
						break;
						case 'verify':
							$verify='http://'.$_SERVER['HTTP_HOST'].C('ALIZI_ROOT').'index.php?m=Alizi&a=verify';
							if(!empty($request['verify'])) $verify .= '&'.http_build_query($request['verify']);
							echo "<input type='tel' name='{$key}' placeholder='{$vo['info']}' class='alizi-input-text' autocomplete='off' alizi-request='{$vo['request']}' style='width:30%;'>
								<img class='verify' src='{$verify}' onclick=\"$(this).attr('src','{$verify}&t='+new Date().getTime())\" />
								<a href='javascript:;' class='bright' onclick=\"$('.verify').attr('src','{$verify}&t='+new Date().getTime())\" />".lang('changeVerifyCode')."</a>";
						break;
						
						default:
							echo "<input type='text' name='{$key}' placeholder='{$vo['info']}' autocomplete='off' alizi-request='{$vo['request']}' class='alizi-input-text' value='{$cookie[$key]}'>";
						break;
					}
					echo "</div></div>";			
				}
				/*
				if($extends){
					foreach ($extends as $k => $vo) {
						if($vo['type']!=='text'){continue;}
						echo "<div class='alizi-rows clearfix rows-id-extends'>",
						"<label class='rows-head'>{$vo['title']}".lang('request')."</label>",
						"<div class='rows-params'>";
							if($vo['type']=='text'){
								echo "<input type='text' name='extends[{$vo['title']}]' placeholder='{$vo['value']}' autocomplete='off' class='alizi-input-text'>";
							}else{
								foreach (explode('#',$vo['value']) as $key=>$li) {
									echo "<span class='alizi-group'>",
										"<span class='alizi-group-box alizi-{$vo['type']}'>",
											"<input alizi-value='{$li}' id='{$vo['title']}{$key}' name='extends[{$vo['title']}]<eq name='vo.type' value='checkbox'>[]</eq>' type='{$vo['type']}' value='{$li}' ".($vo['type']=='checkbox'?'[]':'').">",
											"<label for='{$vo['title']}{$key}'></label>",
										"</span>{$li}</span>";
								}
							}
						echo "</div></div>";
					}
				}
				*/
				echo "</div><!--.alizi-box-->";
				echo "<div class='alizi-rows alizi-id-btn clearfix'><input type='submit' id='alizi-sumit' class='alizi-btn alizi-submit' value='".lang('confirm_submit')."' /></div>",
				"</form>",	
		"</div></div>";

		if($template['show_notice']){
			echo "<div class='alizi-side alizi-border {$show_notice}'>",
				"<div class='alizi-title alizi-border ellipsis'><i class='icon-shipping'></i>".lang('orderNotification')."</div>",
				"<div class='alizi-delivery'>",
					"<div class='alizi-scroll {$show_notice}'><ul>";
						
						$item = json_decode($info['params'],true);
						$province = explode(',','江苏,浙江,山东,宁夏,青海,广西,海南,江西,湖南,上海,湖北,福建,广东,云南,北京,河北,贵州,黑龙江,吉林,辽宁,四川');
						$name = explode(',','赵,钱,孙,李,周,吴,郑,王,朱,刘,柳,黄,陈,杨,张,钟,谢,符,仲,方');
						$mobile = explode(',','131,132,133,135,136,137,138,139,152,158,159,188,189');
						for($i=0;$i<50;$i++){
							$num = rand(0,3);
							$pro = empty($item)?'':' - '.$item[array_rand($item,1)]['title'];
							$pp = $province[array_rand($province,1)];
							$nn = $name[array_rand($name,1)];
							$mm = $mobile[array_rand($mobile,1)].'****'.randCode(4);
							//$time = strtotime('-$num day')-61200;
							$time= array('1分钟前','2分钟前','3分钟前','4分钟前','5分钟前','半小时前');
							$rand = array_rand($time);
							echo "<li ".($i%2 == 0?"class='even'":'').">",
								"<p><span class='alizi-badge'>{$pp}</span>{$nn}*[{$mm}]</p>",
								"<p><span class='alizi-date'>{$time[$rand]}</span>{$info['name']}{$pro}</p></li>";
						}	
						echo "</ul></div>",
				"</div>",
			"</div>",
			"<script type='text/javascript'>",
			"seajs.use(['jquery','alizi','alizi/scroll'], function(jQuery,alizi,scroll) {",
				"alizi.resize('{$template['show_notice']}');",
				"jQuery(window).resize(function(){ alizi.resize('{$template['show_notice']}');});",
				"var scrollHeight = jQuery('.alizi-scroll li').innerHeight();",
				"jQuery('.alizi-scroll').aliziScroll({speed:40,rowHeight:scrollHeight});",
			"});</script>";
		}
echo "</div>";

echo "<script type='text/javascript'>define('payment',".json_encode($payment).");define('shipping',".json_encode($shipping).");</script>";
