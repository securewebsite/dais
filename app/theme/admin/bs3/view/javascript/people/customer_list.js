<script>

	$(document).on('change', '.login-selector', function (e){
		if (this.value !== '') {
			var link = 'people/customer/login/customer_id/' + $(this).data('customer') + '/store_id/' + this.value;
			if (confirm('<?= $lang_text_confirm_login; ?>')) {
				$.ajax({
					url: link,
					type: 'get',
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = 'common/logout';
							window.open(json['redirect']);
						} else {
							location = link;
						}
					}
				});
			}
		}

		this.value = '';
	});

</script>