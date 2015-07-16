function getURLVar(a){
	var b=String(document.location).toLowerCase().split('?'),c='';
	if(b[1]){
		var d=b[1].split('&');
		for(var i=0;i<=d.length;i++){
			if(d[i]){
				var e=d[i].split('=');
				if(e[0]&&e[0]==a.toLowerCase()){
					c=e[1];
				}
			}
		}
	}
	return c;
}
route=getURLVar('route');

if(!route){
	$('#dashboard').addClass('active');
}else{
	part=route.split('/');
	if(part[1]){
		$('a[href*="'+part[0]+'/'+part[1]+'"]').parents('li[id]').addClass('active');
	}
}

function filter(){
	url='index.php?route='+getURLVar('route');
	$('#filter').find('select,:text').each(function(){
		var a=$(this).val();
		if(a&&a!='*'){
			url+='&'+$(this).attr('name')+'='+encodeURIComponent(a);
		}
	});
	
	location=url;
}
!function(d){
	var c=function(a,f){
		f=d.extend({},d.fn.rowlink.defaults,f);
		var e=a.nodeName.toLowerCase()=="tr"?d(a):d(a).find("tr:not(#filter):has(td)").not(".rowlink-skip");
		e.each(function(){
			var g=d(this).find(f.target).first();
			if(!g.length){
				return
			}
			var h=g.attr("href");
			d(this).find("td").not(".rowlink-skip").click(function(e){
				if(e.target.className!='rowlink-skip'){
					window.location=h
				}
			}),d(this).addClass("rowlink")
		})
	};
	d.fn.rowlink=function(a){
		return this.each(function(){
			var f=d(this),b=f.data("rowlink");
			b||f.data("rowlink",b=new c(this,a))
		})
	},d.fn.rowlink.defaults={
		target:"a:not([target]):not([onclick])"
	},d.fn.rowlink.Constructor=c,d(function(){
		d('[data-link="row"]').each(function(){
			d(this).rowlink(d(this).data())
		})
	})
}(window.jQuery);

$(document).ajaxError(function(event,xhr,ajaxSettings,thrownError){
	$('#notification').html($('<div>',{class:'alert alert-danger'}).html(thrownError+"\r\n"+xhr.statusText));
});

$(document).ready(function(){
	$('.summernote').summernote({
		height: 200,
		minHeight: null,
		maxHeight: null,
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline']],
			['fontname', ['fontname']],
			['fontsize', ['fontsize']], // Still buggy
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['table', ['table']],
			['insert', ['link', 'picture', 'video', 'hr']],
			['view', ['codeview']],
			['help', ['help']]
		 ],
		 onImageUpload: function(files, editor, $editable) {
			sendFile(files[0], editor, $editable);
		  }
	});
	
	function sendFile(file, editor, welEditable) {
		var data = new FormData();
		data.append("image", file);
		data.append("directory", 'content');
		
		$.ajax({
			url:'index.php?route=common/file_manager/editor_upload',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			type: 'POST',
			success: function(json){
				if (json['success']) {
					editor.insertImage(welEditable, json['success']);
				} else {
					alert(json['error']);	
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus+" "+errorThrown);
			}
		});
	}
	
	$(document).on('click', '.note-editor .dropdown-menu a', function(e){
		e.preventDefault();
	});
	
	$('.dropdown-submenu a').on('touchstart click',function(e){
		e.stopPropagation();
	});

	$('#btn-delete').on('click',function(e){
		e.preventDefault();
		if(confirm(text_confirm)){
			$('#form').attr('action',$(this).attr('formaction')).submit();
		}
	});

	$('a').click(function(){
		if($(this).attr('href')!=null&&$(this).attr('href').indexOf('uninstall',1)!=-1){
			if(!confirm(text_confirm)){
				return false;
			}
		}
	});

	$('[data-toggle="selected"]').click(function(){
		$('input[name^="selected"]').prop('checked',this.checked);
	});

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
			format:"H:ii P",
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

	$('input[readonly]').click(function(){
		$(this).select();
	});
	
	$('[rel="tooltip"]').tooltip();

	$('#filter select').change(function(){
		filter();
	});
	$('.nav-collapse a[data-toggle]').click(function(){
		$('.nav-collapse').height('100%');
	});
	
	$('[data-toggle="tab"]').on('click',function(e){
		e.preventDefault();
		$(this).tab('show');
	}).on('shown.bs.tab',function(e){
//		$($(this).attr('href')).find(':text,:password').first().select();
	});
	
	$('.nav-tabs,.nav-pills').each(function(){
		$(this).find('[data-toggle="tab"]:first').tab('show');
	});
	$('.help-block.error').closest('.form-group').addClass('has-error');
	
	$(document).on('click','.list-group .label-trash',function(){
		$(this).parent().remove();
	});

	$('[name="filter_username"],[name="filter_name"],[name="filter_email"],[name="filter_product"],[name="filter_model"],[name="filter_customer"]').each(function(){
		var a=$(this),b=a.data('target');
		a.typeahead({
			source:function(q,process){
				return $.getJSON('index.php?route='+a.data('url')+'/autocomplete&filter_'+b+'='+encodeURIComponent(q),function(json){
					var data=[];
					$.each(json,function(){
						data.push(this[b]);
					});
					return process(data);
				});
			},
			updater:function(item){
				a.val(item);
				filter();
				return item;
			}
		}).attr('autocomplete','off').click(function(){
			a.select();
		});
	}).first().select();
	
	var a=$('input[name="path"]'),mapped={};
	a.typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/category/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.category_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="parent_id"]').val(mapped[item]);
			return item;
		}
	}).click(function(){
		this.select();
	});

	var a=$('input[name="event_path"]'),mapped={};
	a.typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=calendar/category/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.category_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="parent_id"]').val(mapped[item]);
			return item;
		}
	}).click(function(){
		this.select();
	});
	
	var mapped={};
	$('#return-customer').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=people/customer/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="customer"]').val(item);
			$('input[name="customer_id"]').val(mapped[item].customer_id);
			$('input[name="firstname"]').val(mapped[item].firstname);
			$('input[name="lastname"]').val(mapped[item].lastname);
			$('input[name="email"]').val(mapped[item].email);
			$('input[name="telephone"]').val(mapped[item].telephone);
			return item;
		}
	}).click(function(){
		this.select();
	});
	
	var mapped={};
	$('#return-product').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/product/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="product_id"]').val(mapped[item].product_id);
			$('input[name="model"]').val(mapped[item].model);
			return item;
		}
	}).click(function(){
		this.select();
	});
	
	var mapped={};
	$('#review-product').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/product/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.product_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="product_id"]').val(mapped[item]);
			return item;
		}
	}).click(function(){
		this.select();
	});
	
	var mapped={};
	$('input[name="manufacturer"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/manufacturer/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.manufacturer_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="manufacturer_id"]').val(mapped[item]);
			return item;
		}
	});
	
	$('input[name="category"]').each(function(){
		var a=$(this),b=a.data('target'),mapped={};
		a.typeahead({
			source:function(q,process){
				return $.getJSON('index.php?route=catalog/category/autocomplete&filter_name='+encodeURIComponent(q),function(json){
					var data=[];
					$.each(json,function(i,item){
						mapped[item.name]=item.category_id;
						data.push(item.name);
					});
					process(data);
				});
			},
			updater:function(item){
				$('#'+b+'-category'+mapped[item]).remove();
				$('#'+b+'-category').append('<div class="list-group-item" id="'+b+'-category'+mapped[item]+'">'+item+'<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><input type="hidden" name="'+b+'_category[]" value="'+mapped[item]+'"></div>');
				return null;
			}
		});
	});
	
	var a=$('input[name="filter"]'),b=a.data('target'),mapped={};
	a.typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/filter/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.filter_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('#'+b+'-filter'+mapped[item]).remove();
			$('#'+b+'-filter').append('<div class="list-group-item" id="'+b+'-filter'+mapped[item]+'">'+item+'<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><input type="hidden" name="'+b+'_filter[]" value="'+mapped[item]+'"></div>');
			return null;
		}
	});
	var mapped={};
	$('input[name="download"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/download/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.download_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('#product-download'+mapped[item]).remove();
			$('#product-download').append('<div class="list-group-item" id="product-download'+mapped[item]+'">'+item+'<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><input type="hidden" name="product_download[]" value="'+mapped[item]+'"></div>');
			return null;
		}
	});
	
	var mapped={};
	$('input[name="related"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/product/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.product_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('#product-related'+mapped[item]).remove();
			$('#product-related').append('<div class="list-group-item" id="product-related'+mapped[item]+'">'+item+'<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><input type="hidden" name="product_related[]" value="'+mapped[item]+'"></div>');
			return null;
		}
	});
	
	var mapped={};
	$('input[name="postrelated"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=content/post/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.post_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('#post-related'+mapped[item]).remove();
			$('#post-related').append('<div class="list-group-item" id="post-related'+mapped[item]+'">'+item+'<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><input type="hidden" name="post_related[]" value="'+mapped[item]+'"></div>');
			return null;
		}
	});
	
	var mapped={};
	$('input[name="post"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=content/post/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.post_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="post_id"]').val(mapped[item]);
			return item;
		}
	});
	
	var mapped={};
	$('input[name="products"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/product/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.product_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('#product'+mapped[item]).remove();
			$('#product').find('.list-group').append('<div class="list-group-item" id="product'+mapped[item]+'">'+item+'<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><input type="hidden" name="product[]" value="'+mapped[item]+'"></div>');
			return null;
		}
	});
	
	var mapped={};
	$('input[name="coupon_products"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/product/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.product_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('#coupon-product'+mapped[item]).remove();
			$('#coupon-product').append('<div class="list-group-item" id="coupon-product'+mapped[item]+'">'+item+'<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><input type="hidden" name="coupon_product[]" value="'+mapped[item]+'"></div>');
			return null;
		}
	});
	
	var mapped={};
	$('input[name="affiliates"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=people/customer/autocomplete&filter_username='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.username]=item.customer_id;
					data.push(item.username);
				});
				process(data);
			});
		},
		updater:function(item){
			$('#affiliate'+mapped[item]).remove();
			$('#affiliate').find('.list-group').append('<div class="list-group-item" id="affiliate'+mapped[item]+'">'+item+'<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><input type="hidden" name="affiliate[]" value="'+mapped[item]+'"></div>');
			return null;
		}
	});
});
function attributeautocomplete(attribute_row){
	var mapped={};
	$('input[name="product_attribute['+attribute_row+'][name]"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/attribute/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.attribute_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="product_attribute['+attribute_row+'][attribute_id]"]').val(mapped[item]);
			return item;
		}
	}).click(function(){
		this.select();
	});
}
function image_upload(field,thumb){
	$('#modal .modal-body').html('<iframe src="index.php?route=common/file_manager&field='+encodeURIComponent(field)+'" frameborder="no" scrolling="auto"></iframe>');
	$('#modal').on('hidden.bs.modal',function(e){
		if($('#'+field).val()){
			$.ajax({
				url:'index.php?route=common/file_manager/image&image='+encodeURIComponent($('#'+field).val()),
				dataType:'text',
				success:function(text){
					$('#'+thumb).attr({'src':text,'id':thumb});
				}
			});
		}
	}).modal('show');
};
$(function(){
	$('#attribute tr').each(function(i){
		attributeautocomplete(i);
	});
	$('#button-history').click(function(){
		var a=$(this),b=a.data('action'),c=a.data('id');
		$.ajax({
			url:'index.php?route=sale/'+b+'/history&'+b+'_id='+c,
			type:'post',
			dataType:'html',
			data:b+'_status_id='+encodeURIComponent($('select[name="'+b+'_status_id"]').val())+'&notify='+encodeURIComponent($('input[name="notify"]').attr('checked') ? 1 :0)+'&append='+encodeURIComponent($('input[name="append"]').attr('checked') ? 1 :0)+'&comment='+encodeURIComponent($('textarea[name="comment"]').val()),
			beforeSend:function(){
				a.button('loading').append($('<i>',{class:'icon-loading'}));
			},
			complete:function(){
				a.button('reset');
			},
			success:function(html){
				$('#history').html(html);
				$('textarea[name="comment"]').val(''); 
				$('#'+b+'-status').html($('select[name="'+b+'_status_id"] option:selected').text());
			}
		});
	});

	$('#button-history-returns').click(function(){
		var a=$(this),b=a.data('action'),c=a.data('id');
		$.ajax({
			url:'index.php?route=sale/'+b+'/history&return_id='+c,
			type:'post',
			dataType:'html',
			data:'return_status_id='+encodeURIComponent($('select[name="return_status_id"]').val())+'&notify='+encodeURIComponent($('input[name="notify"]').attr('checked') ? 1 :0)+'&append='+encodeURIComponent($('input[name="append"]').attr('checked') ? 1 :0)+'&comment='+encodeURIComponent($('textarea[name="comment"]').val()),
			beforeSend:function(){
				a.button('loading').append($('<i>',{class:'icon-loading'}));
			},
			complete:function(){
				a.button('reset');
			},
			success:function(html){
				$('#history').html(html);
				$('textarea[name="comment"]').val(''); 
				$('#return-status').html($('select[name="return_status_id"] option:selected').text());
			}
		});
	});
	
	var a=$('#history');
	$(document).on('click','#history .pagination a',function(e){
		e.preventDefault();
		$('#history').load(this.href);
	});
	a.load(a.data('href'));
	
	var a=$('#credit');
	$(document).on('click','#credit .pagination a',function(e){
		e.preventDefault();
		$('#credit').load(this.href);
	});
	a.load(a.data('href'));

	var a=$('#commission');
	$(document).on('click','#commission .pagination a',function(e){
		e.preventDefault();
		$('#commission').load(this.href);
	});
	a.load(a.data('href'));
	
	$('#tab-credit input,#tab-reward input,#tab-commission input').on('keypress',function(e){
		if (e.keyCode==13){               
			e.preventDefault();
			$(this).closest('.tab-pane').find('button[type="button"]').click();
		}
	});
	$(document).on('click','#button-credit',function(e){
		var a=$(this),b=a.data('target');
		$.ajax({
			url:'index.php?route=people/'+b+'/credit&'+b+'_id='+a.data('id'),
			type:'post',
			dataType:'html',
			data:'description='+encodeURIComponent($('#tab-credit input[name="description"]').val())+'&amount='+encodeURIComponent($('#tab-credit input[name="amount"]').val()),
			beforeSend:function(){
				a.button('loading').append($('<i>',{class:'icon-loading'}));
			},
			complete:function(){
				a.button('reset');
			},
			success:function(html){
				$('#credit').html(html);
				$('#tab-credit input[name="amount"],#tab-credit input[name="description"]').val('');
			}
		});
	});
	$(document).on('click','#button-commission',function(e){
		var a=$(this),b=a.data('target');
		$.ajax({
			url:'index.php?route=people/'+b+'/commission&'+b+'_id='+a.data('id'),
			type:'post',
			dataType:'html',
			data:'description='+encodeURIComponent($('#tab-commission input[name="description"]').val())+'&amount='+encodeURIComponent($('#tab-commission input[name="amount"]').val()),
			beforeSend:function(){
				a.button('loading').append($('<i>',{class:'icon-loading'}));
			},
			complete:function(){
				a.button('reset');
			},
			success:function(html){
				$('#commission').html(html);
				$('#tab-commission input[name="amount"],#tab-commission input[name="description"]').val('');
			}
		});
	});
	var a=$('#reward');
	$(document).on('click','#reward .pagination a',function(e){
		e.preventDefault();
		a.load(this.href);
	});
	a.load(a.data('href'));
	
	$(document).on('click', '#info-slug-btn', function(){
		var page_id = getURLVar('page_id');
		var name = $('#language1 input[name="page_description[1][title]"]').val().toLowerCase();
		var slug = $('#slug').val().toLowerCase();
		var send = (name == slug || slug == '') ? name : slug;
		$url = 'index.php?route=content/page/slug&name='+encodeURIComponent(send);
		if (page_id) {
			$url += '&page_id='+page_id;
		}
		$.ajax({
			url: $url,
			type: 'get',
			dataType: 'json',
			success: function (json) {
				if (json['error']) {
					alertMessage('danger', json['error']);
				} else {
					$('#slug').val(json['slug']);
				}
			}
		});
	});
	
	$(document).on('click', '#cat-slug-btn', function(){
		var category_id = getURLVar('category_id');
		var name = $('#language1 input[name="category_description[1][name]"]').val().toLowerCase();
		var slug = $('#slug').val().toLowerCase();
		var send = (name == slug || slug == '') ? name : slug;
		$url = 'index.php?route=catalog/category/slug&name='+encodeURIComponent(send);
		if (category_id) {
			$url += '&category_id='+category_id;
		}
		$.ajax({
			url: $url,
			type: 'get',
			dataType: 'json',
			success: function (json) {
				if (json['error']) {
					alertMessage('danger', json['error']);
				} else {
					$('#slug').val(json['slug']);
				}
			}
		});
	});
	
	$(document).on('click', '#product-slug-btn', function(){
		var product_id = getURLVar('product_id');
		var name = $('#language1 input[name="product_description[1][name]"]').val().toLowerCase();
		var slug = $('#slug').val().toLowerCase();
		var send = (name == slug || slug == '') ? name : slug;
		$url = 'index.php?route=catalog/product/slug&name='+encodeURIComponent(send);
		if (product_id) {
			$url += '&product_id='+product_id;
		}
		$.ajax({
			url: $url,
			type: 'get',
			dataType: 'json',
			success: function (json) {
				if (json['error']) {
					alertMessage('danger', json['error']);
				} else {
					$('#slug').val(json['slug']);
				}
			}
		});
	});
	
	$(document).on('click', '#man-slug-btn', function(){
		var manufacturer_id = getURLVar('manufacturer_id');
		var name = $('input[name="name"]').val().toLowerCase();
		var slug = $('#slug').val().toLowerCase();
		var send = (name == slug || slug == '') ? name : slug;
		$url = 'index.php?route=catalog/manufacturer/slug&name='+encodeURIComponent(send);
		if (manufacturer_id) {
			$url += '&manufacturer_id='+manufacturer_id;
		}
		$.ajax({
			url: $url,
			type: 'get',
			dataType: 'json',
			success: function (json) {
				if (json['error']) {
					alertMessage('danger', json['error']);
				} else {
					$('#slug').val(json['slug']);
				}
			}
		});
	});
	
	$(document).on('click', '#blog-cat-slug-btn', function(){
		var blog_category_id = getURLVar('category_id');
		var name = $('#language1 input[name="category_description[1][name]"]').val().toLowerCase();
		var slug = $('#slug').val().toLowerCase();
		var send = (name == slug || slug == '') ? name : slug;
		$url = 'index.php?route=content/category/slug&name='+encodeURIComponent(send);
		if (blog_category_id) {
			$url += '&category_id='+blog_category_id;
		}
		$.ajax({
			url: $url,
			type: 'get',
			dataType: 'json',
			success: function (json) {
				if (json['error']) {
					alertMessage('danger', json['error']);
				} else {
					$('#slug').val(json['slug']);
				}
			}
		});
	});
	
	$(document).on('click', '#post-slug-btn', function(){
		var post_id = getURLVar('post_id');
		var name = $('#language1 input[name="post_description[1][name]').val().toLowerCase();
		var slug = $('#slug').val().toLowerCase();
		var send = (name == slug || slug == '') ? name : slug;
		$url = 'index.php?route=content/post/slug&name='+encodeURIComponent(send);
		if (post_id) {
			$url += '&post_id='+post_id;
		}
		$.ajax({
			url: $url,
			type: 'get',
			dataType: 'json',
			success: function (json) {
				if (json['error']) {
					alertMessage('danger', json['error']);
				} else {
					$('#slug').val(json['slug']);
				}
			}
		});
	});
});
var alertMessage=function(state,msg){
	var html = '<div class="alert alert-'+state+' alert-dismissable" style="display:none;"><a class="close" data-dismiss="alert" href="#">&times;</a>'+msg+'</div>';
	
	$('#notification').html(html);
	$('#notification>.alert').fadeIn('slow').delay(8000).fadeTo(2000,0,function(){
		$(this).remove();
	});
};
function sendGiftcard(gift_card_id,b){
	$.ajax({
		url:'index.php?route=sale/gift_card/send&gift_card_id='+gift_card_id,
		type:'post',
		dataType:'json',
		beforeSend:function(){
			alertMessage('warning',b);
		},
		success:function(json){
			if(json['error']){
				alertMessage('danger',json['error']);
			}
			if(json['success']){
				alertMessage('success',json['success']);
			}		
		}
	});
}
/*--- order_info.tpl ---*/
$(function(){
	$('#invoice-generate').click(function(){
		$.ajax({
			url:'index.php?route=sale/order/createinvoiceno&order_id='+getURLVar('order_id'),
			dataType:'json',
			beforeSend:function(){
				$('#invoice-generate').button('loading').append($('<i>',{class:'icon-loading'}));
			},
			success:function(json){
				if(json['error']){
					$('#invoice-generate').button('reset');
					alertMessage('danger',json['error']);
				}
				if (json['invoice_no']){
					$('#invoice').html(json['invoice_no']);
				}
			}
		});
	});
});
/*--- order_form.tpl ---*/
$(function(){
	var mapped={};
	$('#order-customer').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=people/customer/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="customer"]').val(item);
			$('input[name="customer_id"]').val(mapped[item].customer_id);
			$('input[name="firstname"]').val(mapped[item].firstname);
			$('input[name="lastname"]').val(mapped[item].lastname);
			$('input[name="email"]').val(mapped[item].email);
			$('input[name="telephone"]').val(mapped[item].telephone);
			html = '<option value="0">&mdash;</option>'; 
			for(i in mapped[item].address){
				html += '<option value="'+mapped[item].address[i]['address_id']+'">'+mapped[item].address[i]['firstname']+' '+mapped[item].address[i]['lastname']+','+mapped[item].address[i]['address_1']+','+mapped[item].address[i]['city']+','+mapped[item].address[i]['country']+'</option>';
			}
			$('select[name="shipping_address"]').html(html);
			$('select[name="payment_address"]').html(html);
			$('select[id="customer_group_id"]').button('reset').val(mapped[item]['customer_group_id']).change().button('loading'); 
			return item;
		}
	}).click(function(){
		this.select();
	});
	
	$('select[data-param]').on('change',function(e){
		var $this=$(this),param=$this.data('param');

		$.ajax({
			url:'index.php?route=people/customer/country&country_id='+$this.val(),
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
					html = '<option value="">'+param.select+'</option>';
					for(i=0;i<json['zone'].length;i++){
						html += '<option value="'+json['zone'][i]['zone_id']+'"';
						if(json['zone'][i]['zone_id']==param.zone_id){
							html += ' selected=""';
						}
						html += '>'+json['zone'][i]['name']+'</option>';
					}
				}else{
					html = '<option value="0" selected="">'+param.none+'</option>';
				}
				$('select[name="zone_id"]').html(html);
			}
		});
	});

	$('select[name="country_id"]').change();

	var text_select=$('#text_select').val();
	var text_none=$('#text_none').val();
	var text_no_results=$('#text_no_results').val();
	var button_remove=$('#button_remove').val();
	$('[data-provide="countries"]').on('change',function(){
		var a=$(this),b=a.data('target');
		$.ajax({
			url:'index.php?route=sale/order/country&country_id='+this.value,
			dataType:'json',
			beforeSend:function(){
				a.after($('<i>',{class:'icon-loading'}));
			},
			complete:function(){
				$('.icon-loading').remove();
			},
			success:function(json){
				$('.icon-loading').remove();
				if(json['postcode_required']=='1'){
					$('#'+b+'-postcode-required').show();
				}else{
					$('#'+b+'-postcode-required').hide();
				}
				html = '<option value="">'+text_select+'</option>';
				if(json!=''&&json['zone']!=''){
					for(i=0;i<json['zone'].length;i++){
						html += '<option value="'+json['zone'][i]['zone_id']+'"';
						if(json['zone'][i]['zone_id']==a.data('selected')){
							html += ' selected=""';
						}
						html += '>'+json['zone'][i]['name']+'</option>';
					}
				}else{
					html += '<option value="0" selected="">'+text_none+'</option>';
				}
				$('select[name="'+b+'_zone_id"]').html(html);
			}
		});
	});
	
	$('[data-provide="countries"]').change();

	$('select[name="config_country_id"]').on('change',function(e){
		var a=$(this);
		$.ajax({
			url:'index.php?route=setting/setting/country&country_id='+this.value,
			dataType:'json',
			beforeSend:function(){
				a.after($('<i>',{class:'icon-loading'}));
			},
			complete:function(){
				$('.icon-loading').remove();
			},
			success:function(json){
				html = '<option value="">&ndash;</option>';
				if((typeof(json['zone'])+'undefined')&&json['zone']+''){
					for(i=0;i<json['zone'].length;i++){
						html += '<option value="'+json['zone'][i]['zone_id']+'"';
						if(json['zone'][i]['zone_id']==a.data('id')){
							html += ' selected=""';
						}
						html += '>'+json['zone'][i]['name']+'</option>';
					}
				}else{
					html += '<option value="0" selected="">'+a.data('none')+'</option>';
				}
				$('select[name="config_zone_id"]').html(html);
			}
		});
	});

	$('select[name="config_country_id"]').change();
	$('select[name="config_theme"]').change();
	$('select[name="config_admin_theme"]').change();

	$(document).on('change','select[name="payment_address"]',function(){
		$.ajax({
			url:'index.php?route=people/customer/address&address_id='+this.value,
			dataType:'json',
			success:function(json){
				if(json!=''){
					$('input[name="payment_firstname"]').val(json['firstname']);
					$('input[name="payment_lastname"]').val(json['lastname']);
					$('input[name="payment_company"]').val(json['company']);
					$('input[name="payment_company_id"]').val(json['company_id']);
					$('input[name="payment_tax_id"]').val(json['tax_id']);
					$('input[name="payment_address_1"]').val(json['address_1']);
					$('input[name="payment_address_2"]').val(json['address_2']);
					$('input[name="payment_city"]').val(json['city']);
					$('input[name="payment_postcode"]').val(json['postcode']);
					$('select[name="payment_country_id"]').val(json['country_id']);
					$('select[name="payment_country_id"]').data('selected',json['zone_id']).change();
				}
			}
		});
	});
	$(document).on('change','select[name="shipping_address"]',function(){
		$.ajax({
			url:'index.php?route=people/customer/address&address_id='+this.value,
			dataType:'json',
			success:function(json){
				if(json!=''){
					$('input[name="shipping_firstname"]').val(json['firstname']);
					$('input[name="shipping_lastname"]').val(json['lastname']);
					$('input[name="shipping_company"]').val(json['company']);
					$('input[name="shipping_address_1"]').val(json['address_1']);
					$('input[name="shipping_address_2"]').val(json['address_2']);
					$('input[name="shipping_city"]').val(json['city']);
					$('input[name="shipping_postcode"]').val(json['postcode']);
					$('select[name="shipping_country_id"]').val(json['country_id']);
					$('#shipping_zone_id').val(json['zone_id']);
					$('select[name="shipping_country_id"]').data('selected',json['zone_id']).change();
				}
			}
		});
	});
	
	$('select[name="payment"]').bind('change',function(){
		if(this.value){
			$('input[name="payment_method"]').val($('select[name="payment"] option:selected').text());
		}else{
			$('input[name="payment_method"]').val('');
		}
		$('input[name="payment_code"]').val(this.value);
	});
	$('select[name="shipping"]').bind('change',function(){
		if(this.value){
			$('input[name="shipping_method"]').val($('select[name="shipping"] option:selected').text());
		}else{
			$('input[name="shipping_method"]').val('');
		}
		$('input[name="shipping_code"]').val(this.value);
	});
	var mapped={};
	$('input[name="affiliate"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=people/customer/autocomplete&filter_username='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.username]=item.customer_id;
					data.push(item.username);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="affiliate_id"]').val(mapped[item]);
			return item;
		}
	});
	
	var a=$('#order-product'),mapped={};
	a.typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=catalog/product/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="product_id"]').val(mapped[item].product_id);
			if(mapped[item]['option']!=''){
				var html = '',s=$('#text_select').val();
				for(i=0;i<mapped[item]['option'].length;i++){
					var o=mapped[item]['option'][i];
					html += '<div class="form-group" id="option-'+o['product_option_id']+'">';
					html += '<label class="control-label col-sm-2">';
					if(o['required']==1){
						html += '<b class="required">*</b> ';
					}
					html += o['name']+':</label>';
					html += '<div class="control-field col-sm-4">';
					if(o['type']=='select'){
						html += '<select name="option['+o['product_option_id']+']" class="form-control">';
						html += '<option value="">'+s+'</option>';
						for(j=0;j<o['option_value'].length;j++){
							ov=o['option_value'][j];
							html += '<option value="'+ov['product_option_value_id']+'">'+ov['name'];
							if(ov['price']){
								html += ' ('+ov['price_prefix']+ov['price']+')';
							}
							html += '</option>';
						}
						html += '</select>';
					}else if(o['type']=='radio'){
						for(j=0;j<o['option_value'].length;j++){
							ov=o['option_value'][j];
							html += '<div class="radio"><label for="option-value-'+ov['product_option_value_id']+'">';
							html += '<input type="radio" name="option['+o['product_option_id']+'][]" value="'+ov['product_option_value_id']+'" id="option-value-'+ov['product_option_value_id']+'">';
							html += ov['name'];
							if(ov['price']){
								html += ' ('+ov['price_prefix']+ov['price']+')';
							}
							html += '</label></div>';
						}
					}else if(o['type']=='checkbox'){
						for(j=0;j<o['option_value'].length;j++){
							ov=o['option_value'][j];
							html += '<div class="checkbox"><label for="option-value-'+ov['product_option_value_id']+'">';
							html += '<input type="checkbox" name="option['+o['product_option_id']+'][]" value="'+ov['product_option_value_id']+'" id="option-value-'+ov['product_option_value_id']+'">';
							html += ov['name'];
							if(ov['price']){
								html += ' ('+ov['price_prefix']+ov['price']+')';
							}
							html += '</label></div>';
						}
					}else if(o['type']=='image'){
						html += '<select name="option['+o['product_option_id']+']" class="form-control">';
						html += '<option value="">'+s+'</option>';
						for(j=0;j<o['option_value'].length;j++){
							ov=o['option_value'][j];
							html += '<option value="'+ov['product_option_value_id']+'">'+ov['name'];
							if(ov['price']){
								html += ' ('+ov['price_prefix']+ov['price']+')';
							}
							html += '</option>';
						}
						html += '</select>';
					}else if(o['type']=='text'){
						html += '<input type="text" name="option['+o['product_option_id']+']" value="'+o['option_value']+'" class="form-control">';
					}else if(o['type']=='textarea'){
						html += '<textarea name="option['+o['product_option_id']+']" class="form-control" rows="4">'+o['option_value']+'</textarea>';
					}else if(o['type']=='file'){
						html += '<button type="button" id="button-option-'+o['product_option_id']+'" class="btn btn-default"><i class="fa fa-upload"></i> '+$('#button_upload').val()+'</button>';
						html += '<input type="hidden" name="option['+o['product_option_id']+']" value="'+o['option_value']+'" id="input-option-'+o['product_option_id']+'">';
					}else if(o['type']=='date'){
						html += '<label class="input-group">';
						html += '<input type="text" name="option['+o['product_option_id']+']" value="'+o['option_value']+'" data-provide="datetimepicker" class="form-control" autocomplete="off">';
						html += '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>';
						html += '</label>';
					}else if(o['type']=='datetime'){
						html += '<label class="input-group">';
						html += '<input type="text" name="option['+o['product_option_id']+']" value="'+o['option_value']+'" data-provide="datetimepicker" class="form-control" data-show-meridian="1" data-date-today-btn="1" data-min-view="0" data-date-format="yyyy-mm-dd hh:mm" autocomplete="off">';
						html += '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>';
						html += '</label>';
					}else if(o['type']=='time'){
						html += '<label class="input-group">';
						html += '<input type="text" name="option['+o['product_option_id']+']" value="'+o['option_value']+'" data-provide="datetimepicker" class="form-control" data-max-view="1" data-start-view="1" data-show-meridian="1" data-min-view="0" data-date-format="hh:ii" autocomplete="off">';
						html += '<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>';
						html += '</label>';
					}
					html += '</div>';		
					html += '</div>';				
				}
				$('#option').html(html);
				for(i=0;i<mapped[item].option.length;i++){
					o=mapped[item].option[i];
					if(o['type']=='file'){
						$('#option').delegate('button[id^="button-option-"]','click',function(){
							var a=$(this);
							$('#form-upload').remove();
							$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display:none;"><input type="file" name="file"></form>');
							$('#form-upload input[name="file"]').on('change',function(){
								$.ajax({
									url:'index.php?route=sale/order/upload',
									type:'post',
									dataType:'json',
									data:new FormData($(this).parent()[0]),
									cache:false,
									contentType:false,
									processData:false,
									beforeSend:function(){
										a.button('loading').append($('<i>',{class:'icon-loading'}));
									},
									complete:function(){
										a.button('reset');
									},
									success:function(json){
										$('.alert,.help-block.error').remove();
										$('.has-error').removeClass('has-error');
										if (json['error']){
											a.after('<div class="help-block error">'+json['error']+'</div>').closest('.form-group').addClass('has-error');
										}
										if (json['success']){
											alert(json['success']);
											a.parent().find('input[name^="option"]').val(json['file']);
										}
									}
								});
							}).click();
						});
					}
				}			
			}else{
				$('#option .form-group').remove();
			}
			return item;
		}
	}).click(function(){
		this.select();
	});
	$('#button-product,#button-gift_card,#button-update').on('click',function(){
		var a=$(this);
		data='#tab-customer input[type="text"],#tab-customer input[type="hidden"],#tab-customer input[type="radio"]:checked,#tab-customer input[type="checkbox"]:checked,#tab-customer select,#tab-customer textarea,';
		data+='#tab-payment input[type="text"],#tab-payment input[type="hidden"],#tab-payment input[type="radio"]:checked,#tab-payment input[type="checkbox"]:checked,#tab-payment select,#tab-payment textarea,';
		data+='#tab-shipping input[type="text"],#tab-shipping input[type="hidden"],#tab-shipping input[type="radio"]:checked,#tab-shipping input[type="checkbox"]:checked,#tab-shipping select,#tab-shipping textarea,';
		if (a.attr('id')=='button-product'){
			data+='#tab-product input[type="text"],#tab-product input[type="hidden"],#tab-product input[type="radio"]:checked,#tab-product input[type="checkbox"]:checked,#tab-product select,#tab-product textarea,';
		}else{
			data+='#product input[type="text"],#product input[type="hidden"],#product input[type="radio"]:checked,#product input[type="checkbox"]:checked,#product select,#product textarea,';
		}
		if (a.attr('id')=='button-gift_card'){
			data+='#tab-gift_card input[type="text"],#tab-gift_card input[type="hidden"],#tab-gift_card input[type="radio"]:checked,#tab-gift_card input[type="checkbox"]:checked,#tab-gift_card select,#tab-gift_card textarea,';
		}else{
			data+='#gift_card input[type="text"],#gift_card input[type="hidden"],#gift_card input[type="radio"]:checked,#gift_card input[type="checkbox"]:checked,#gift_card select,#gift_card textarea,';
		}
		data+='#tab-total input[type="text"],#tab-total input[type="hidden"],#tab-total input[type="radio"]:checked,#tab-total input[type="checkbox"]:checked,#tab-total select,#tab-total textarea';
		
		$.ajax({
			url:$('#store_url').val()+'index.php?route=checkout/manual',
			type:'post',
			data: $(data),
			dataType:'json',
			beforeSend:function(){
				$('.alert,.text-error').remove();
				a.button('loading').append($('<i>',{class:'icon-loading'}));
			},
			success:function(json){
				$('.alert,.help-block.error').remove();
				$('.has-error').removeClass('has-error');
				a.button('reset');
				if(json['error']){
					if(json['error']['warning']){
						alertMessage('danger',json['error']['warning']);
					}
					if(json['error']['customer']){
						alertMessage('danger',json['error']['customer']);
					}
					if(json['error']['firstname']){
						$('input[name="firstname"]').after('<div class="help-block error">'+json['error']['firstname']+'</div>');
					}
					if(json['error']['lastname']){
						$('input[name="lastname"]').after('<div class="help-block error">'+json['error']['lastname']+'</div>');
					}
					if(json['error']['email']){
						$('input[name="email"]').after('<div class="help-block error">'+json['error']['email']+'</div>');
					}
					if(json['error']['telephone']){
						$('input[name="telephone"]').after('<div class="help-block error">'+json['error']['telephone']+'</div>');
					}
					if(json['error']['payment']){
						$.each(json['error']['payment'],function(key,val){
							$('[name^="payment_'+key+'"]').after('<div class="help-block error">'+val+'</div>');
						});		
					}
					if(json['error']['shipping']){
						$.each(json['error']['shipping'],function(key,val){
							$('[name^="shipping_'+key+'"]').after('<div class="help-block error">'+val+'</div>');
						});
					}
					if(json['error']['product']){
						if(json['error']['product']['option']){
							for(i in json['error']['product']['option']){
								$('#option-'+i+' .controls').append('<div class="help-block error">'+json['error']['product']['option'][i]+'</div>');
							}					
						}
						if(json['error']['product']['stock']){
							alertMessage('danger',json['error']['product']['stock']);
						}
						if(json['error']['product']['minimum']){
							for(i in json['error']['product']['minimum']){
								alertMessage('danger',json['error']['product']['minimum'][i]);
							}					
						}
					}else{
						$('input[name="product"],input[name="product_id"]').val('');
						$('#option .form-group').remove();		
						$('input[name="quantity"]').val('1');		
					}
					if(json['error']['gift_cards']){
						$.each(json['error']['gift_cards'],function(key,val){
							$('input[name="'+key+'"]').after('<div class="help-block error">'+val+'</div>');
						});
					}else{
						$('input[name="from_name"],input[name="from_email"],input[name="to_name"],input[name="to_email"],textarea[name="message"]').val('');
						$('input[name="amount"]').val('25.00');
					}
					$('.help-block.error').closest('.form-group').addClass('has-error');
					if(json['error']['shipping_method']){
						alertMessage('danger',json['error']['shipping_method']);
					}
					if(json['error']['payment_method']){
						alertMessage('danger',json['error']['payment_method']);
					}
					if(json['error']['coupon']){
						alertMessage('danger',json['error']['coupon']);
					}
					if(json['error']['gift_card']){
						alertMessage('danger',json['error']['gift_card']);
					}
					if(json['error']['reward']){
						alertMessage('danger',json['error']['reward']);
					}
				}else{
					$('input[name="product"],input[name="product_id"],input[name="from_name"],input[name="from_email"],input[name="to_name"],input[name="to_email"],textarea[name="message"]').val('');
					$('#option .form-group').remove();
					$('input[name="quantity"]').val('1');
					$('input[name="amount"]').val('25.00');
				}
				if(json['success']){
					alertMessage('success',json['success']);
				}
				if(json['order_product']!=''){
					var product_row=0,option_row=0,download_row=0;
					html = '';
					for(i=0;i<json['order_product'].length;i++){
						product=json['order_product'][i];
						html += '<tr id="product-row'+product_row+'">';
						html += '<td class="text-center"><a class="label label-danger" title="'+button_remove+'" id="remove'+product_row+'"><i class="fa fa-trash-o fa-lg"></i></a></td>';
						html += '<td>'+product['name']+'<br><input type="hidden" name="order_product['+product_row+'][order_product_id]" value=""><input type="hidden" name="order_product['+product_row+'][product_id]" value="'+product['product_id']+'"><input type="hidden" name="order_product['+product_row+'][name]" value="'+product['name']+'">';
						if (product['option']){
							for(j=0;j<product['option'].length;j++){
								option = product['option'][j];
								
								html += '<div class="help">'+option['name']+':'+option['value']+'</div>';
								html += '<input type="hidden" name="order_product['+product_row+'][order_option]['+option_row+'][order_option_id]" value="'+option['order_option_id']+'">';
								html += '<input type="hidden" name="order_product['+product_row+'][order_option]['+option_row+'][product_option_id]" value="'+option['product_option_id']+'">';
								html += '<input type="hidden" name="order_product['+product_row+'][order_option]['+option_row+'][product_option_value_id]" value="'+option['product_option_value_id']+'">';
								html += '<input type="hidden" name="order_product['+product_row+'][order_option]['+option_row+'][name]" value="'+option['name']+'">';
								html += '<input type="hidden" name="order_product['+product_row+'][order_option]['+option_row+'][value]" value="'+option['value']+'">';
								html += '<input type="hidden" name="order_product['+product_row+'][order_option]['+option_row+'][type]" value="'+option['type']+'">';
								
								option_row++;
							}
						}
						if (product['download']){
							for(j=0;j<product['download'].length;j++){
								download = product['download'][j];
								
								html += '<input type="hidden" name="order_product['+product_row+'][order_download]['+download_row+'][order_download_id]" value="'+download['order_download_id']+'">';
								html += '<input type="hidden" name="order_product['+product_row+'][order_download]['+download_row+'][name]" value="'+download['name']+'">';
								html += '<input type="hidden" name="order_product['+product_row+'][order_download]['+download_row+'][filename]" value="'+download['filename']+'">';
								html += '<input type="hidden" name="order_product['+product_row+'][order_download]['+download_row+'][mask]" value="'+download['mask']+'">';
								html += '<input type="hidden" name="order_product['+product_row+'][order_download]['+download_row+'][remaining]" value="'+download['remaining']+'">';
								
								download_row++;
							}
						}
						html += '</td>';
						html += '<td>'+product['model']+'<input type="hidden" name="order_product['+product_row+'][model]" value="'+product['model']+'"></td>';
						html += '<td class="text-right">'+product['quantity']+'<input type="hidden" name="order_product['+product_row+'][quantity]" value="'+product['quantity']+'"></td>';
						html += '<td class="text-right">'+product['price']+'<input type="hidden" name="order_product['+product_row+'][price]" value="'+product['price']+'"></td>';
						html += '<td class="text-right">'+product['total']+'<input type="hidden" name="order_product['+product_row+'][total]" value="'+product['total']+'"><input type="hidden" name="order_product['+product_row+'][tax]" value="'+product['tax']+'"><input type="hidden" name="order_product['+product_row+'][reward]" value="'+product['reward']+'"></td>';
						html += '</tr>';

						$(document).on('click', '#remove'+product_row, function(e){
							e.preventDefault();
							$('#product-row'+(product_row-1)).remove();
							$('#button-update').trigger('click');
						});

						product_row++;		
					}
					$('#product').html(html);
				}else{
					$('#product').html('<tr><td colspan="6" class="text-center">'+text_no_results+'</td></tr>');
				}
				if(json['order_gift_card']!=''){
					var gift_card_row=0;
					html = '';
					for(i in json['order_gift_card']){
						gift_card=json['order_gift_card'][i];
						html += '<tr id="gift_card-row'+gift_card_row+'">';
						html += '<td class="text-center"><a title="'+button_remove+'" onclick="$("#gift_card-row'+gift_card_row+'").remove();$("#button-update").trigger("click");"><i class="fa fa-trash-o fa-lg"></i></a></td>';
						html += '<td>'+gift_card['description'];
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][order_gift_card_id]" value="">';
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][gift_card_id]" value="'+gift_card['gift_card_id']+'">';
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][description]" value="'+gift_card['description']+'">';
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][code]" value="'+gift_card['code']+'">';
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][from_name]" value="'+gift_card['from_name']+'">';
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][from_email]" value="'+gift_card['from_email']+'">';
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][to_name]" value="'+gift_card['to_name']+'">';
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][to_email]" value="'+gift_card['to_email']+'">';
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][gift_card_theme_id]" value="'+gift_card['gift_card_theme_id']+'">';
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][message]" value="'+gift_card['message']+'">';
						html += '<input type="hidden" name="order_gift_card['+gift_card_row+'][amount]" value="'+gift_card['amount']+'">';
						html += '</td>';
						html += '<td></td>';
						html += '<td class="text-right">1</td>';
						html += '<td class="text-right">'+gift_card['amount']+'</td>';
						html += '<td class="text-right">'+gift_card['amount']+'</td>';
						html += '</tr>';
						gift_card_row++;
					}
					$('#gift_card').html(html);			
				}else{
					$('#gift_card').html('<tr><td colspan="6" class="text-center">'+text_no_results+'</td></tr>');
				}
				if(json['order_product']!=''||json['order_gift_card']!=''||json['order_total']!=''){
					html = '';
					if(json['order_product']!=''){
						for(i=0;i<json['order_product'].length;i++){
							product=json['order_product'][i];
							html += '<tr>';
							html += '<td>'+product['name'];
							if (product['option']){
								for(j=0;j<product['option'].length;j++){
									option = product['option'][j];
									
									html += '<div class="help">'+option['name']+':'+option['value']+'</div>';
								}
							}
							html += '</td>';
							html += '<td>'+product['model']+'</td>';
							html += '<td class="text-right">'+product['quantity']+'</td>';
							html += '<td class="text-right">'+product['price']+'</td>';
							html += '<td class="text-right">'+product['total']+'</td>';
							html += '</tr>';
						}			
					}
					if(json['order_gift_card']!=''){
						for(i in json['order_gift_card']){
							gift_card=json['order_gift_card'][i];
							html += '<tr>';
							html += '<td>'+gift_card['description']+'</td>';
							html += '<td></td>';
							html += '<td class="text-right">1</td>';
							html += '<td class="text-right">'+gift_card['amount']+'</td>';
							html += '<td class="text-right">'+gift_card['amount']+'</td>';
							html += '</tr>';
						}
					}
					var total_row=0;
					for(i in json['order_total']){
						total=json['order_total'][i];
						html += '<tr id="total-row'+total_row+'">';
						html += '<td class="text-right" colspan="4"><input type="hidden" name="order_total['+total_row+'][order_total_id]" value=""><input type="hidden" name="order_total['+total_row+'][code]" value="'+total['code']+'"><input type="hidden" name="order_total['+total_row+'][title]" value="'+total['title']+'"><input type="hidden" name="order_total['+total_row+'][text]" value="'+total['text']+'"><input type="hidden" name="order_total['+total_row+'][value]" value="'+total['value']+'"><input type="hidden" name="order_total['+total_row+'][sort_order]" value="'+total['sort_order']+'">'+total['title']+':</td>';
						html += '<td class="text-right">'+total['value']+'</td>';
						html += '</tr>';
						total_row++;
					}
					$('#total').html(html);
				}else{
					$('#total').html('<tr><td colspan="6" class="text-center">'+text_no_results+'</td></tr>');				
				}
				if(json['shipping_method']){
					html = '<option value="">'+text_select+'</option>';
					for(i in json['shipping_method']){
						html += '<optgroup label="'+json['shipping_method'][i]['title']+'">';
						if (!json['shipping_method'][i]['error']){
							for (j in json['shipping_method'][i]['quote']){
								if(json['shipping_method'][i]['quote'][j]['code']==$('input[name="shipping_code"]').val()){
									html += '<option value="'+json['shipping_method'][i]['quote'][j]['code']+'" selected="">'+json['shipping_method'][i]['quote'][j]['title']+'</option>';
								}else{
									html += '<option value="'+json['shipping_method'][i]['quote'][j]['code']+'">'+json['shipping_method'][i]['quote'][j]['title']+'</option>';
								}
							}	
						}else{
							html += '<option value="" class="text-error" disabled="">'+json['shipping_method'][i]['error']+'</option>';
						}
						html += '</optgroup>';
					}
					$('select[name="shipping"]').html(html);
					if ($('select[name="shipping"] option:selected').val()){
						$('input[name="shipping_method"]').val($('select[name="shipping"] option:selected').text());
					}else{
						$('input[name="shipping_method"]').val('');
					}
					$('input[name="shipping_code"]').val($('select[name="shipping"] option:selected').val());
				}
				if(json['payment_method']){
					html = '<option value="">'+text_select+'</option>';
					for(i in json['payment_method']){
						if(json['payment_method'][i]['code']==$('input[name="payment_code"]').val()){
							html += '<option value="'+json['payment_method'][i]['code']+'" selected="">'+json['payment_method'][i]['title']+'</option>';
						}else{
							html += '<option value="'+json['payment_method'][i]['code']+'">'+json['payment_method'][i]['title']+'</option>';
						}	
					}
					$('select[name="payment"]').html(html);
					if ($('select[name="payment"] option:selected').val()){
						$('input[name="payment_method"]').val($('select[name="payment"] option:selected').text());
					}else{
						$('input[name="payment_method"]').val('');
					}
					$('input[name="payment_code"]').val($('select[name="payment"] option:selected').val());
				}
			}
		});
	});
});

// Download Form
$(document).on('click','#button-upload',function(){
	var a=$(this);
	$('#form-upload').remove();
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display:none;"><input type="file" name="file"></form>');
	$('#form-upload input[name="file"]').on('change',function(){
		$.ajax({
			url:'index.php?route=catalog/download/upload',
			type:'post',
			dataType:'json',
			data:new FormData($(this).parent()[0]),
			cache:false,
			contentType:false,
			processData:false,
			beforeSend:function(){
				a.button('loading').append($('<i>',{class:'icon-loading'}));
			},	
			complete:function(){
				a.button('reset');
			},
			success:function(json){
				if (json['error']){
					alert(json['error']);
				}
				if (json['success']){
					alert(json['success']);
					$('input[name="filename"]').val(json['filename']);
					$('input[name="mask"]').val(json['mask']);
				}
			}
		});
	}).click();
});
// Contact
$(document).on('click','#button-send',function(){
	var a=$(this);

	$('textarea[name="contact_html"]').val($('#contact-html').code());

	$data = $('#contact-form').serialize();

	$.ajax({
		url:a.data('url'),
		type:'post',
		data:$data,
		dataType:'json',
		beforeSend:function(){
			a.button('loading').append($('<i>',{class:'icon-loading'}));
		},
		complete:function(){
			a.button('reset');
		},
		success:function(json){
			$('.alert,.help-block.error').remove();
			$('.has-error').removeClass('has-error');
			if(json['error']){
				if(json['error']['warning']){
					alertMessage('danger',json['error']['warning']);
				}
				if(json['error']['subject']){
					$('input[name="subject"]').after('<span class="help-block error">'+json['error']['subject']+'</span>').closest('.form-group').addClass('has-error');
				}
				if(json['error']['text']){
					$('#contact-text').parent().append('<span class="help-block error">'+json['error']['text']+'</span>').closest('.form-group').addClass('has-error');
				}
				if(json['error']['html']){
					$('#contact-html').parent().append('<span class="help-block error">'+json['error']['html']+'</span>').closest('.form-group').addClass('has-error');
				}			
			}
			if(json['success']){
				if(json['next']){
					alertMessage('success',json['success']);
					send(json['next']);
				} else {
					if(json['redirect']) {
						location = json['redirect'];
					}
				}
			}
		}
	});
});
$(function(){
	$('select[name="to"]').bind('change',function(){
		$('#mail .to').hide();
		$('#mail #to-'+$(this).val().replace('_','-')).show().find('input[type="text"]').select();
	});
	$('select[name="to"]').change();
	var mapped={};
	$('input[name="customers"]').typeahead({
		source:function(q,process){
			return $.getJSON('index.php?route=people/customer/autocomplete&filter_name='+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.name]=item.customer_id;
					data.push(item.name);
				});
				process(data);
			});
		},
		updater:function(item){
			$('#customer'+mapped[item]).remove();
			$('#customer').find('.list-group').append('<div class="list-group-item" id="customer'+mapped[item]+'"><a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a>'+item+'<input type="hidden" name="customer[]" value="'+mapped[item]+'"></div>');
			return null;
		}
	});
});
$.fn.tabs=function(){
	var b=$(this);
	this.each(function(){
		var a=$(this);
		$(a.attr("href")).hide();
		a.click(function(){
			b.removeClass("selected").each(function(c,d){
				$($(d).attr("href")).hide()
			});
			$(this).addClass("selected");
			$($(this).attr("href")).show();
			return false
		})
	});
	b.show().first().click()
}