$(window).load(function() {
	if ($('footer').length > 0) { }
});

if (route) {
	parts = route.split('/');
	if (parts[0] == 'content' && parts[1] == 'home') {
		$('#nav-blog').addClass('active');
	} else if (parts[0] == 'shop' && parts[1] == 'home') {
		$('#nav-shop').addClass('active');
	} else if (parts[0] == 'account' && parts[1] != 'wishlist') {
		$('#nav-account').addClass('active');
	} else {
		obj = $('#nav-' + parts[1]);
		if (obj.length) {
			$(obj).addClass('active');
		}
	}
}

(function ($) {
    $.fn.stickyTabs = function() {
        context = this
        
        // get our current page url
        var href = window.location.href;

        // get the base url so we can replace it in the tab
        var url  = window.location.protocol + "//" + window.location.host;

        // Show the tab corresponding with the hash in the URL, or the first tab.
        var showTabFromHash = function() {
          var hash = window.location.hash;
          var selector = hash ? 'a[href="' + hash + '"]' : 'li:first-child a';
          $(selector, context).tab('show');
        }

        // Set the correct tab when the page loads
        showTabFromHash(context)

        // Set the correct tab when a user uses their back/forward button
        window.addEventListener('hashchange', showTabFromHash, false);

        // Change the URL when tabs are clicked
        $('a', context).on('click', function(e) {
          // replace tab base url with current page url
          var newurl = this.href.replace(url, href);
          // push to history
          history.pushState(null, null, newurl);
        });

        return this;
    };
}(jQuery));


function trackingLink() {
	var href = window.location.href;
	var url  = href.split('?z=');

	history.pushState(null, null, url[0]);
}

function searchLink() {
	var href   = window.location.href.replace(/.*?:\/\//g, "");
	var url    = href.split('/');
	var domain = url.shift(0);

	if (url[0] == 'search') {
		url.pop();

		var newurl = window.location.protocol + '//' + domain + '/' + url.join('/');
		
		history.pushState(null, null, newurl);
	}
}

$(document).ready(function(){
	// Sticky footer
	positionFooter();
	$('.container.app').css('opacity', 1);
	$(window).bind('resize', function () {
		positionFooter();
	});
	
	$('.list-group-item').filter(function(){
		return this.href===document.location.href;
	}).addClass('active');
	
	$('[data-toggle="tooltip"]').tooltip();
	
	$('.help-block.error').closest('.form-group').addClass('has-error');

	$('input[name="display"]').change(function(){
		$.cookie('display', $(this).val());
		location.reload();
	});

	if($.cookie('display')){
		$('#display-'+$.cookie('display')).addClass('active');
	}else{
		$('#display-list').addClass('active');
	}

	trackingLink();
	//searchLink();

	$('#currency a').on('click',function(e){
		e.preventDefault();
		$('#currency input[name="currency_code"]').val($(this).attr('href'));
		$('#currency').submit();
	});	

	$('form[id^="search-"]').submit(function(e){
		e.preventDefault();
		url = $('base').attr('href') + 'search';
		$.each($(this).serializeArray(), function(i, field){
			if($.trim(field.value)!=0){
				var string = field.value.replace(/\s+/g, '+');
				url += '/' + encodeURI(string);
			}
		});
		location=url;
	});

	$('input[name="payment"]').change(function(){
		$('.payment').hide();
		$('#payment-'+this.value).show();
	});

	$('input[name="payment"]:checked').change();

	$('.nav-tabs').stickyTabs();
	
	$('#review').load('catalog/product/review/product_id/'+$('input[name="product_id"]').val());
	
	if ($('#affiliate-product')) {
		var mapped={};
		$('#affiliate-product').typeahead({
			source:function(q,process){
				return $.getJSON('account/affiliate/autocomplete/filter_name/'+encodeURIComponent(q),function(json){
					var data=[];
					$.each(json,function(i,item){
						mapped[item.name]=item.link;
						data.push(item.name);
					});
					process(data);
				});
			},
			updater:function(item){
				$('#affiliate-link').val(mapped[item]);
				return item;
			}
		});
	}
	
	PluginInput.init();
	
	$('.share-bar').on("click", ".social-share", function (e) {
		e.preventDefault();
		var wLeft = window.screenLeft ? window.screenLeft : window.screenX;
		var wTop = window.screenTop ? window.screenTop : window.screenY;
		var url = $(this).attr("href");
		var width = $(this).attr("data-width");
		var height = $(this).attr("data-height");
		var left = wLeft + (window.innerWidth / 2) - (width / 2);
		var top = wTop + (window.innerHeight / 2) - (height / 2);
		windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + left + ",top=" + top + ",screenX=" + left + ",screenY=" + top + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
		window.open (url, "sharer", windowFeatures);
	});
	
});

$(document).on('click','#review .pagination a',function(e){
	e.preventDefault();
	$('#review').fadeOut('slow', function(){
		$('#review').load(this.href);
		$('html,body').animate({scrollTop:$('#review').offset().top - 100},'slow');
		$('#review').fadeIn('slow');
	});
});

$(document).delegate('.modalbox','click',function(e){
	e.preventDefault();
	
	$('#modal').remove(); 
	
	var $this=$(this);
	//alert($this.attr('href'));
	$.ajax({
		url:$this.attr('href'),
		type:'get',
		dataType:'html',
		success:function(data){
			html ='<div id="modal" class="modal">';
			html+='<div class="modal-dialog">';
			html+='<div class="modal-content">';
			html+='<div class="modal-header">'; 
			html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html+='<h3 class="modal-title">'+$this.text()+'</h3>';
			html+='</div>';
			html+='<div class="modal-body">'+data+'</div>';
			html+='</div';
			html+='</div>';
			html+='</div>';
			
			$('body').append(html);
			
			$('#modal').modal();
		}
	});
});

$(window).load(function(){
	// replace YouTube with proper video container
	// with the :not(.vjs-tech) syntax we prevent 
	// reloading videos that are already set up
	var videos = $("iframe:not(.vjs-tech)[src^='http://www.youtube.com'], iframe:not(.vjs-tech)[src^='https://www.youtube.com'], iframe:not(.vjs-tech)[src^='//www.youtube.com']");

	videos.each(function(index){
		var uri = $(this).attr('src');
		var pieces = uri.split("/");

		var poster = 'image/data/video/' + pieces[pieces.length - 1] + '.png';
		
		var html = '<video ';
			html +=	'id="video-id-' + index +'"'; 
			html +=	'	class="video-js vjs-default-skin vjs-big-play-centered flex-video"'; 
			html +=	'	controls ';
			html +=	'	preload ';
			html +=	'	width="100%" height="56.25%"'; 
			html +=	'	poster="' + poster + '"';
			html +=	'	data-setup=\'{';
			html +=	'		"techOrder": ["youtube"],'; 
			html +=	'		"quality": "720", ';
			html +=	'		"plugins": { "watermark": {';
			html +=	'			"file": "asset/ghost/img/watermark.png",';
			html +=	'			"opacity": "0.3"';
			html +=	'		}},';
			html +=	'		"src": "' + uri + '" ';
			html +=	'	}\'>';
			html +=	'</video>';

		$(this).replaceWith(html);
	});
});

function positionFooter () {
	$height = $('footer').outerHeight();
	$('#push').css('height', $height + 'px');
	$('.page-wrapper').css('margin-bottom', '-' + $height + 'px');
}

var alertMessage=function(state,msg){
	var html  = '<div class="alert alert-' + state + ' alert-dismissable" style="display:none;">';
		html += '<a class="close" data-dismiss="alert" href="#">&times;</a>' + msg;
		html += '</div>';
	
	$('#notification').html(html);
	$('#notification>.alert').fadeIn('slow').delay(6000).fadeTo(2000,0,function(){
		$(this).remove();
	});
};

$(document).on('click','button[id^="button-"],[data-cart]',function(e){
	var btn=$(this);

	btn.button({
		loadingText:btn.html()
	});

	$.ajax({
		beforeSend:function(){
			btn.button('loading');
			btn.append($('<i>',{class:'icon-loading'}));
		},	
		complete:function(){
			btn.button('reset').blur();
			$('.icon-loading').remove();
		},
		error:function(xhr,ajaxOptions,thrownError){
			alert(thrownError+"\r\n"+xhr.statusText+"\r\n"+xhr.responseText);
		}
	});
});
$(document).on('click','#button-cart',function(){
	$.ajax({
		url:'checkout/cart/add',
		type:'post',
		data:$('#product-info').serialize(),
		dataType:'json',
		success:function(json){
			$('.help-block.error').remove();
			$('.has-error').removeClass('has-error');

			if(json['error']){
				if(json['error']['option']){
					for(i in json['error']['option']){
						$('#option-'+i).append($('<div>',{class:'help-block error'}).text(json['error']['option'][i])).closest('.form-group').addClass('has-error');
					}
				}
			}
			
			if(json['success']){
				alertMessage('success',json['success']);
				$('#cart-total').html(json['total']);
				$('#cart').load('shop/cart/info #cart>*');
			}
		}
	});
});
$(document).on('click', '[data-remove]', function(e) {
	e.preventDefault();
	$.ajax({
		url: 'checkout/cart/remove',
		type: 'post',
		data: 'remove=' + $(this).attr('data-remove'),
		dataType: 'json',    			
		success: function(json) {
			$('#cart-total').html(json['total']);
			$('#cart').load('shop/cart/info #cart>*');
		}
	});	
});
$('[data-cart]').not('[data-event]').click(function(){
	$.ajax({
		url:'checkout/cart/add',
		type:'post',
		data:'product_id='+$(this).data('cart')+'&quantity=1',
		dataType:'json',
		success:function(json){
			if(json['redirect']){
				location=json['redirect'];
			}
			if(json['success']){
				alertMessage('success',json['success']);
				$('#cart-total').html(json['total']);
				$('#cart').load('shop/cart/info #cart>*');
			}
		}
	});
});
$('[data-event]').click(function(){
	$.ajax({
		url:'checkout/cart/add',
		type:'post',
		data:'product_id='+$(this).data('cart')+'&event_id='+$(this).data('event')+'quantity=1',
		dataType:'json',
		success:function(json){
			if(json['redirect']){
				location=json['redirect'];
			}
			if(json['success']){
				alertMessage('success',json['success']);
				$('#cart-total').html(json['total']);
				$('#cart').load('shop/cart/info #cart>*');
			}
		}
	});
});
$('[data-customer-product]').click(function(){
	$.ajax({
		url:'checkout/cart/add',
		type:'post',
		data:'product_id='+$(this).data('customer-product')+'&quantity=1&cp=1',
		dataType:'json',
		success:function(json){
			if(json['redirect']){
				location=json['redirect'];
			}
			if(json['success']){
				alertMessage('success',json['success']);
				$('#cart-total').html(json['total']);
				$('#cart').load('shop/cart/info #cart>*');
			}
		}
	});
});
function addToWishList(product_id){
	$.ajax({
		url:'account/wishlist/add',
		type:'post',
		data:'product_id='+product_id,
		dataType:'json',
		success:function(json){
			if(json['success']){
				alertMessage('info',json['success']);
				$('#wishlist-total').html(json['total']);
			}
		}
	});
}
function addToCompare(product_id){
	$.ajax({
		url:'catalog/compare/add',
		type:'post',
		data:'product_id='+product_id,
		dataType:'json',
		success:function(json){
			if(json['success']){
				alertMessage('info',json['success']);
				$('#compare-total').html(json['total']);
			}
		}
	});
}
function addReview(product_id,btn){
	$.ajax({
		url:'catalog/product/write/product_id/'+product_id,
		type:'post',
		dataType:'json',
		data:$('#review-form').serialize(),
		success:function(json){
			if(json['error']){
				alertMessage('danger',json['error']);
			}
			if(json['success']){
				alertMessage('success',json['success']);
				$('input[name="rating"]:checked').prop('checked',false);
				$('input[name="name"],textarea[name="text"],input[name="captcha"]').val('');
			}
		}
	});
}
$(document).on('focus','.datetime',function(){
	$(this).datetimepicker({
		todayBtn:1,
		autoclose:1,
		minView:0,
		showMeridian:1,
		format:'yyyy-mm-dd hh:mm',
		pickerPosition:'bottom-left'
	});
});

$(document).on('focus','.time',function(){
	$(this).datetimepicker({
		autoclose:1,
		startView:1,
		minView:0,
		maxView:1,
		showMeridian:1,
		format:"hh:ii",
		pickerPosition:'bottom-left'
	});
});

$(document).on('focus','.date',function(e){
	e.stopPropagation();
	$(this).datetimepicker({
		weekStart:1,
		todayBtn:1,
		autoclose:1,
		startView:2,
		minView:2,
		format:'yyyy-mm-dd',
		pickerPosition:'bottom-left'
	}).datetimepicker('show');
});

if($.isFunction($.fn.imagesLoaded)){
	var $container=$('.product-masonry');
	$container.imagesLoaded(function(){
		$container.masonry({
			itemSelector:'.brick',
			isResizeBound:true
		});
	});
}

$(document).on('change','select[name="customer_group_id"]',function(e){
	if(customer_group[this.value]){
		if(customer_group[this.value]['company_id_display']==1){
			$('#company-id-display').show();
		}else{
			$('#company-id-display').hide();
		}
		if(customer_group[this.value]['company_id_required']==1){
			$('#company-id-required').show();
		}else{
			$('#company-id-required').hide();
		}
		if(customer_group[this.value]['tax_id_display']==1){
			$('#tax-id-display').show();
		}else{
			$('#tax-id-display').hide();
		}
		if(customer_group[this.value]['tax_id_required']==1){
			$('#tax-id-required').show();
		}else{
			$('#tax-id-required').hide();
		}
	}
});

$(document).on('change','select[name="country_id"]',function(e){
	var $this=$(this),param=$this.data('param');

	$.ajax({
		url:'account/register/country/country_id/'+$this.val(),
		dataType:'json',
		beforeSend:function(){
			$this.after($('<i>',{class:'icon-loading'}));
		},
		complete:function(){
			$('.icon-loading').remove();
		},
		success:function(json){
			if(json['postcode_required']==1){
				$('#postcode-required').show();
			}else{
				$('#postcode-required').hide();
			}
			
			if(json['zone']!=''){
				html='<option value="">'+param.select+'</option>';
			
				for(i=0;i<json['zone'].length;i++){
					html+='<option value="'+json['zone'][i]['zone_id']+'"';

					if(json['zone'][i]['zone_id']==param.zone_id){
						html+=' selected=""';
					}

					html+='>'+json['zone'][i]['name']+'</option>';
				}
			}else{
				html='<option value="0" selected="">'+param.none+'</option>';
			}
			
			$('select[name="zone_id"]').html(html);
		},
		error:function(xhr,ajaxOptions,thrownError){
			alert(thrownError+"\r\n"+xhr.statusText+"\r\n"+xhr.responseText);
		}
	});
});

$(document).ready(function(){
	$('select[name="customer_group_id"]').change();
	$('select[name="country_id"]').change();
});

/* checkout */
$(document).on('keydown','#checkout-container input',function(e){
	if(e.keyCode==13){
		$(this).closest('form').find('button[id^="button-"]').click();
	}
});
$(document).on('click','#checkout-container .panel-heading a.close',function(){
	$('.panel-collapse').slideUp('slow');
	
	$(this).parent().parent().find('.panel-collapse').slideDown('slow');
});

$('.btn-social .btn').on('click',function(e){
	e.preventDefault();
	var w=580;
	var h=340;
	var left=(screen.width/2)-(w/2);
	var top=(screen.height/2)-(h/2);
	window.open($(this).attr('href'),'sharer','toolbar=0,status=0,width='+w+',height='+h+',top='+top+',left='+left);
});

$('[data-ride="carousel"]').each(function(){
	var $this=$(this);
	var $dist=Math.ceil(($this.width()/10)*2);
	$this.swipe({
		swipeStatus:function(event,phase,direction,distance,duration,fingers){
			if((distance>$dist)) {
				if(direction=='left'||direction=='up'){
					$this.carousel('next');
				}else if(direction=='right'||direction=='down'){
					$this.carousel('prev');
				}
				return false;
			}
		}
	});
});
