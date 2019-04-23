define(function(require, exports, module) {
	require('../layer/skin/layer.css');	
	var $ = require("jquery"),layer = require("layer/layer");
	
	checkForm = function(){
		var handle = $(arguments[0]);
		var name = handle.find('input[name=name]');
		var mobile = handle.find('input[name=mobile]');
		var region = handle.find('.region');
		var address = handle.find('input[name=address]');
		var zcode = handle.find('input[name=zcode]');
		var qq = handle.find('input[name=qq]');
		var mail = handle.find('input[name=mail]');
		var verify = handle.find('input[name=verify]');
		var rule = /^1[3-8][0-9]\d{4,8}$/;
	
		try{
			layer = typeof(top.layer) == "undefined"?layer:top.layer
		}catch (ex){
			layer = layer;
		}
		if(name.length!=0 && $.trim(name.val()).length<2){layer.msg(lang.emptyName);return false;}
		if(mobile.length!=0 && ($.trim(mobile.val()).length!= 11 || rule.test(mobile.val()) == false)){layer.msg(lang.invalidMobile);return false;}
		if(region.length!=0 && !region.eq(0).val()){layer.msg(lang.SelectRegion);return false;}
		if(address.length!=0 && !address.val()){layer.msg(lang.emptyAddress);return false;}
		if(zcode.length!=0 && !zcode.val()){layer.msg(lang.emptyZcode);return false;}
		//if(mail.length!=0 && !mail.val()){layer.msg(lang.emptyEmail);return false;}
		if(verify.length!=0 && verify.val().length!= 4){layer.msg(lang.invalidVerify);return false;}
	};
	
	exports.quantity = function(){
		var paymentData = require("payment"),
			amount = parseInt(arguments[0]),	
			price = parseFloat($("input[name=item_price]").val()),
			payment = $("input[name=payment]:checked").val(),
			quantiryInput = $("input[name=quantity]"),
			qrcodepay = $("input[name=qrcode_pay]").val(),
			num   = parseInt(quantiryInput.val()),
			math = $("input[name=math]").val();

	
		num = (isNaN(num) || num<0)?1:num;
		var totalNum = (amount+num)<1?1:(amount+num);
		totalNum = payment==5 && qrcodepay=='1'?1:totalNum;
		quantiryInput.val(totalNum);
		
		var data = paymentData[payment];
		var count = math.substr(0,1),fee=parseFloat(math.substr(1));
		var totalPrice = count=='+'?(price*totalNum+fee):(price*totalNum*fee);//订单总价
		var shippingCost = shipping(totalNum,totalPrice);//运费
		var subTotal=totalPrice+shippingCost;
		
		var aliziShipping =  $(".alizi-shipping");
		aliziShipping.find('.alizi-shipping-price').html(shippingCost);
		aliziShipping.find('.alizi-order-price').html(totalPrice.toFixed(2));
		$(".alizi-total-price").html(subTotal.toFixed(2));
	}
	
	exports.timer = function(elem,intDiff){
		window.setInterval(function(){
			var day=0,hour=0,minute=0,second=0;
			if(intDiff > 0){
				day = Math.floor(intDiff / (60 * 60 * 24));
				hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
				minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
				second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
			}

			var text = lang.actionEnd;
			if(day==0 && hour==0 && minute==0 && second==0){
				$('.alizi-submit').attr('disabled','disabled').val(text);
			}else{
				hour = hour<10?'0'+hour:hour;
				minute = minute<10?'0'+minute:minute;
				second = second<10?'0'+second:second;
				text = "<span class='aliziDay'><b>"+day+"</b>天</span><span class='aliziDay'><b>"+hour+"</b>时</span><span class='aliziDay'><b>"+minute+"</b>分</span><span class='aliziDay'><b>"+second+"</b>秒</span>";
			}
			$(elem).html(text);
			intDiff--;
		}, 1000);
	}
		
	exports.payment = function(){
		var paymentData = require("payment");
		var info = paymentData[arguments[0]]['info'],payment=$('#alizi-payment-info');
		$("input[name=math]").val(paymentData[arguments[0]]['math']);
		if(info){ payment.show().find('.payment-info').html(info);}else{payment.hide();}
		this.quantity(0);
	}
	exports.resize = function(){
		var show = arguments[0];
		var width = window.document.body.offsetWidth,className='alizi-full-row',main=$('.alizi-main'),side=$('.alizi-side'),scroll=$('.alizi-scroll');
		if(show=='2' && width>600){ 
			main.removeClass(className);side.removeClass(className);scroll.removeClass(className);
			$(".alizi-scroll").height(main.height()-50);
		}else{
			main.addClass(className);side.addClass(className);scroll.addClass(className);
		}
	}
	exports.scroll = function(){
		var id = arguments[0],time=arguments[1]||2500,ul=$("#"+id+" ul");
		setInterval(function(){
			var last=ul.children('li:last'),height=last.height();
			ul.prepend(last.css({height:0}).animate({height:height},'slow'));
		},time);
	}
	function shipping(quantity,totalPrice){
		var shipping = require("shipping");
		if(!shipping.id) return 0;
		if(shipping['is_free_num']==1 && quantity>=shipping['free_num']) return 0;
		if(shipping['is_free_cost']==1 && totalPrice>=shipping['free_cost']) return 0;
		if(quantity <= shipping['less_num']){
			return parseFloat(shipping['less_num_cost']);
		}else{
			var step = Math.ceil((quantity-parseInt(shipping['less_num']))/parseInt(shipping['step_num']));
			return parseFloat(shipping['less_num_cost'])+step*parseFloat(shipping['step_num_cost']);
		}
	}
	
	$('.alizi-params').bind('click',function(){
		var _this = $(this),className='active';
		var target = _this.attr('alizi-target'),value = _this.attr('alizi-value'),fx = _this.attr('alizi-fx'),params = _this.attr('alizi-fx-params');
		
		if(_this.hasClass('alizi-checkbox')){
			var isCheck = _this.find('input:checked').length;
			if(isCheck==1){
				_this.addClass(className);
			}else{
				_this.removeClass(className);
			}
		}else{
			_this.addClass(className).siblings().removeClass(className);
		}
		
		if(target){
			if(target.indexOf(':')===0){
				_this.find('input').get(0).checked=true;
			}else{
				$(target).val(value);
			}
			if(fx)eval(fx+'("'+params+'")');
		}
	})


	$('.alizi-params-change').change(function(){ 
		var _this = $(this),fx = _this.attr('alizi-fx'),params = _this.attr('alizi-fx-params');
		$("input[name=item_price]").val(_this.val())
		if(fx)eval(fx+'("'+params+'")');
	})

});