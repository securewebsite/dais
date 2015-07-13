<?php if ($options) { ?>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script>
new AjaxUpload('#button-option-<?= $option['product_option_id']; ?>',{
	action:'catalog/product/upload',
	name:'file',
	autoSubmit:true,
	responseType:'json',
	onSubmit:function(file, extension) {
		$('#button-option-<?= $option['product_option_id']; ?>').after('<i class="icon-loading"></i>');
		$('#button-option-<?= $option['product_option_id']; ?>').attr('disabled',true);
	},
	onComplete:function(file, json) {
		$('#button-option-<?= $option['product_option_id']; ?>').removeAttr('disabled');
		$('.help-inline.error').remove();
		$('.has-error').removeClass('has-error');
		
		if(json['success']) {
			alertMessage('success',json['success']);
			$('input[name=\'option[<?= $option['product_option_id']; ?>]\']').val(json['file']);
		}
		
		if(json['error']) {
			$('#option-<?= $option['product_option_id']; ?>').find('.controls').append('<span class="help-inline error">' + json['error'] + '</span>').closest('.form-group').addClass('has-error');
		}
		
		$('.icon-loading').remove();
	}
});
</script>
<?php } ?>
<?php } ?>
<?php } ?>
<script>
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=catalog/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			
			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
<?php if (isset($event_id) && $event_id > 0): ?>
$(document).on('click', '#button-waitlist', function() {
	$.ajax({
		url: 'index.php?route=catalog/product/join_wait_list',
		type: 'POST',
		dataType: 'json',
		data: 'event_id=<?= $event_id; ?>',
		beforeSend: function(xhr) {
			$('#button-waitlist').attr('disabled', true);
		},
		success: function(json) {
			if (json.success > 0) {
				$('#wait-response').html(json.message);
			} else {
				$('#button-waitlist').attr('disabled', false);
				$('#button-waitlist').before(json.message);
				$('.alert').delay(5000).fadeOut('slow', function(){
					$(this).remove();
				});
			}
		},
		error: function(xhr,j,i) {
			alert(i);
			$('#button-waitlist').attr('disabled', false);
		}
	});
});
<?php endif; ?>
</script>