<script>

$(document).on('submit', '#enroll-form', function(e) {
	e.preventDefault();
	$agree = $('input[name="agree"]');

	if ($agree.is(':checked')) {
		this.submit();
	} else {
		$agree.parent().after('<span class="help-block" style="color:#d94d3f"><b><?= $js_error_agree; ?></b></span>');
	}
	
});

var radios = $('#tab-payment').find('input:radio');

radios.each(function(){
	$(this).on('change', function() {
		$('.payment').hide();
		$('#payment-' + this.value).show();
	});
});

$('input[name="payment_method"]:checked').change();

$(document).on('click', '#affiliate-slug-btn', function(){
	var $slug   = $('#slug');
	var $button = $(this);
	var name    = $slug.val().toLowerCase();
	$url = 'account/affiliate/slug/name/'+encodeURIComponent(name);
	$.ajax({
		url: $url,
		type: 'get',
		dataType: 'json',
		beforeSend: function() {
			$slug.closest('.form-group').removeClass('has-error');
			$slug.closest('.control-field').find('.help-block').remove();
			$button.removeClass('btn-danger');
		},
		success: function (json) {
			if (json['error']) {
				$slug.closest('.form-group').addClass('has-error');
				$button.addClass('btn-danger');
				$slug.parent().after('<span class="help-block" style="color:#d94d3f"><b>' + json['error'] + '</b></span>');
			} else {
				$slug.val(json['slug']);
				$('#vanity').html(json['slug']);
				$slug.parent().after('<span class="help-block" style="color:#9fbb58"><b>Perfect, good choice!</b></span>');
			}
		}
	});
});

</script>