<script>
$(function(){
	$('#column-right').bind('scrollstop',function(){
		$('#column-right .btn').each(function(index,el){
			var height=$('#column-right').height();
			var offset=$(el).offset();
			if((offset.top>0)&&(offset.top<height)&&$(el).find('img').attr('src')=='<?= $no_image; ?>'){
				$.ajax({
					url:'index.php?route=common/filemanager/image&token=<?= $token; ?>&image='+encodeURIComponent('data/'+$(el).find('input[name="image"]').val()),
					dataType:'html',
					success:function(html){
						$(el).find('img').attr('src',html);
					}
				});
			}
		});
	});
	$('#column-left').tree({
		data:{opts:{url:'index.php?route=common/filemanager/directory&token=<?= $token; ?>'}},
		callback:{	
			onselect:function(a){
				$.ajax({
					url:'index.php?route=common/filemanager/files&token=<?= $token; ?>',
					type:'post',
					data:'directory='+encodeURIComponent($(a).attr('directory')),
					dataType:'json',
					success:function(json){
						html = '<div class="row text-center" data-toggle="buttons">';
						if(json){
							for(i=0;i<json.length;i++){
								html += '<div class="col-xs-6 col-sm-4 col-md-3"><label class="btn btn-default btn-block">'+
								'<input type="radio" name="image" value="'+json[i]['file']+'">'+
								'<p><img class="img-responsive center-block" src="<?= $no_image; ?>" alt=""></p>'+
								((json[i]['filename'].length>18)?(json[i]['filename'].substr(0,18)+'..'):json[i]['filename'])+
								'<br>'+json[i]['size']+'</label></div>';
							}
						}
						html += '</div>';
						html=$('<div>',{class:'container-fluid'}).html(html);
						$('#column-right').html(html).trigger('scrollstop');
					}
				});
			}
		}
	});
	$(document).on('dblclick','#column-right .btn',function(){
		parent.$('#<?= $field; ?>').val('data/'+$(this).find('input[name="image"]').val());
		parent.$('#modal').modal('hide');
	});
	$('#create').click(function(){
		var tree=$.tree.focused();
		if(tree.selected){
			openDialog('<?= $lang_button_folder; ?>','<?= $lang_entry_folder; ?>');
			$('#dialog button[type="submit"]').click(function(e){
				e.preventDefault();
				$.ajax({
					url:'index.php?route=common/filemanager/create&token=<?= $token; ?>',
					type:'post',
					data:'directory='+encodeURIComponent($(tree.selected).attr('directory'))+'&name='+encodeURIComponent($('#dialog input[name="name"]').val()),
					dataType:'json',
					success:function(json){
						if(json['success']){
							$('#dialog').modal('hide');
							tree.refresh(tree.selected);
							$('#notification').html($('<div>',{class:'alert alert-success'}).html(json['success']));
						}else{
							$('#notification').html($('<div>',{class:'alert alert-danger'}).html(json['error']));
						}
					}
				});
			});
		}else{
			$('#notification').html('<?= $lang_error_directory; ?>');
		}
	});
	$('#delete').click(function(){
		var btn=$(this),a=$('#column-right .btn.active'),path=a.find('input[name="image"]').val(),n=$('#notification');
		btn.button({
			loadingText:btn.html()
		});
		if(path){
			$.ajax({
				url:'index.php?route=common/filemanager/delete&token=<?= $token; ?>',
				type:'post',
				data:'path='+encodeURIComponent(path),
				dataType:'json',
				beforeSend:function(){
					btn.button('loading');
					btn.append($('<i>',{class:'icon-loading'}));
				},
				complete:function(){
					btn.button('reset');
				},
				success:function(json){
					if(json['success']){
						var tree=$.tree.focused();
						tree.select_branch(tree.selected);
						n.html($('<div>',{class:'alert alert-success'}).html(json['success']));
					}
					if(json['error']){
						n.html($('<div>',{class:'alert alert-danger'}).html(json['error']));
					}
				}
			});		
		}else{
			var tree=$.tree.focused();
			if(tree.selected){
				$.ajax({
					url:'index.php?route=common/filemanager/delete&token=<?= $token; ?>',
					type:'post',
					data:'path='+encodeURIComponent($(tree.selected).attr('directory')),
					dataType:'json',
					success:function(json){
						if(json['success']){
							tree.select_branch(tree.parent(tree.selected));
							tree.refresh(tree.selected);
							n.html($('<div>',{class:'alert alert-success'}).html(json['success']));
						}
						if(json['error']){
							n.html($('<div>',{class:'alert alert-danger'}).html(json['error']));
						}
					}
				});	
			}else{
				n.html('<?= $lang_error_select; ?>');
			}			
		}
	});
	$('#move').click(function(){
		$('#dialog').remove();
		html = '<div id="dialog" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">';
		html += '<div class="modal-dialog"><div class="modal-content">';
		html += '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title"><?= $lang_button_move; ?></h4></div>';
		html += '<div class="modal-body"><select name="to" class="form-control"></select></div>';
		html += '<div class="modal-footer"><button type="submit" class="btn btn-primary"><?= $lang_button_submit; ?></button></div>';
		html += '</div></div>';
		html += '</div>';
		$('body').prepend(html);
		$('#dialog').modal({backdrop:false});
		$('#dialog select[name="to"]').load('index.php?route=common/filemanager/folders&token=<?= $token; ?>');
		$('#dialog button[type="submit"]').click(function(e){
			e.preventDefault();
			path=$('#column-right .btn.active').find('input[name="image"]').val();
			if(path){												
				$.ajax({
					url:'index.php?route=common/filemanager/move&token=<?= $token; ?>',
					type:'post',
					data:'from='+encodeURIComponent(path)+'&to='+encodeURIComponent($('#dialog select[name="to"]').val()),
					dataType:'json',
					success:function(json){
						s(json);
					}
				});
			}else{
				var tree=$.tree.focused();
				$.ajax({
					url:'index.php?route=common/filemanager/move&token=<?= $token; ?>',
					type:'post',
					data:'from='+encodeURIComponent($(tree.selected).attr('directory'))+'&to='+encodeURIComponent($('#dialog select[name="to"]').val()),
					dataType:'json',
					success:function(json){
						if(json['success']){
							$('#dialog').modal('hide');
							tree.select_branch('#top');
							tree.refresh(tree.selected);
							$('#notification').html($('<div>',{class:'alert alert-success'}).html(json['success']));
						}
						if(json['error']){
							$('#notification').html($('<div>',{class:'alert alert-danger'}).html(json['error']));
						}
					}
				});		
			}
		});
	});
	$('#copy').click(function(){
		openDialog('<?= $lang_button_copy; ?>','<?= $lang_entry_copy; ?>');
		$('#dialog select[name="to"]').load('index.php?route=common/filemanager/folders&token=<?= $token; ?>');
		$('#dialog button[type="submit"]').click(function(e){
			e.preventDefault();
			path=$('#column-right .btn.active').find('input[name="image"]').val();
			if(path){												
				$.ajax({
					url:'index.php?route=common/filemanager/copy&token=<?= $token; ?>',
					type:'post',
					data:'path='+encodeURIComponent(path)+'&name='+encodeURIComponent($('#dialog input[name="name"]').val()),
					dataType:'json',
					success:function(json){
						s(json);
					}
				});
			}else{
				var tree=$.tree.focused();
				$.ajax({
					url:'index.php?route=common/filemanager/copy&token=<?= $token; ?>',
					type:'post',
					data:'path='+encodeURIComponent($(tree.selected).attr('directory'))+'&name='+encodeURIComponent($('#dialog input[name="name"]').val()),
					dataType:'json',
					success:function(json){
						if(json['success']){
							$('#dialog').modal('hide');
							tree.select_branch(tree.parent(tree.selected));
							tree.refresh(tree.selected);
							$('#notification').html($('<div>',{class:'alert alert-success'}).html(json['success']));
						}
						if(json['error']){
							$('#notification').html($('<div>',{class:'alert alert-danger'}).html(json['error']));
						}
					}
				});		
			}
		});
	});
	$('#rename').click(function(){
		openDialog('<?= $lang_button_rename; ?>','<?= $lang_entry_rename; ?>');
		$('#dialog button[type="submit"]').click(function(e){
			e.preventDefault();
			path=$('#column-right .btn.active').find('input[name="image"]').val();
			if(path){
				$.ajax({
					url:'index.php?route=common/filemanager/rename&token=<?= $token; ?>',
					type:'post',
					data:'path='+encodeURIComponent(path)+'&name='+encodeURIComponent($('#dialog input[name="name"]').val()),
					dataType:'json',
					success:function(json){
						s(json);
					}
				});	
			}else{
				var tree=$.tree.focused();
				$.ajax({ 
					url:'index.php?route=common/filemanager/rename&token=<?= $token; ?>',
					type:'post',
					data:'path='+encodeURIComponent($(tree.selected).attr('directory'))+'&name='+encodeURIComponent($('#dialog input[name="name"]').val()),
					dataType:'json',
					success:function(json){
						if(json['success']){
							$('#dialog').modal('hide');
							tree.select_branch(tree.parent(tree.selected));
							tree.refresh(tree.selected);
							$('#notification').html($('<div>',{class:'alert alert-success'}).html(json['success']));
						}
						if(json['error']){
							$('#notification').html($('<div>',{class:'alert alert-danger'}).html(json['error']));
						}
					}
				});
			}
		});
	});
});
$(function(){
	$("#upload").ajaxUpload({
		url:'index.php?route=common/filemanager/upload&token=<?= $token; ?>',
		name:'image',
		onSubmit:function(file,extension){
			var tree=$.tree.focused();
			if(tree.selected){
				this.setData({'directory':$(tree.selected).attr('directory')});
			}else{
				this.setData({'directory':''});
			}
			$("#upload").append($('<i>',{class:'icon-loading'}));
		},
		onComplete:function(json){
			json=JSON.parse(json);
			if(json['success']){
				var tree=$.tree.focused();
				tree.select_branch(tree.selected);
				$('#notification').html($('<div>',{class:'alert alert-success'}).html(json['success']));
			}
			if(json['error']){
				$('#notification').html($('<div>',{class:'alert alert-danger'}).html(json['error']));
			}
			$("#upload").find('i').removeClass('icon-loading');
		}
	});
});

function openDialog(title,entry){
	$('#dialog').remove();

	html = '<form id="dialog" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">';
	html += '<div class="modal-dialog"><div class="modal-content">';
	html += '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">'+title+'</h4></div>';
	html += '<div class="modal-body"><input type="text" name="name" value="" class="form-control" autocomplete="off" placeholder="'+entry+'" class="form-control"></div>';
	html += '<div class="modal-footer"><button type="submit" class="btn btn-primary"><?= $lang_button_submit; ?></button></div>';
	html += '</div></div>';
	html += '</form>';

	$('body').prepend(html);

	$('#dialog').modal({backdrop:false}).on('shown.bs.modal',function(){
		$(this).find('input[name="name"]').focus();
	});
}
</script>