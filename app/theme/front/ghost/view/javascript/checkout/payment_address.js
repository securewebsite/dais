<script>
$(document).on('change','#payment-address input[name="payment_address"]',function(e){
	if (this.value=='new'){
		$('#payment-existing').slideUp('fast');
		$('#payment-new').slideDown(function(){
			$(this).find('#firstname').select();
			$(this).find('select[name="country_id"]').change();
		});
	} else {
		$('#payment-existing').slideDown('fast');
		$('#payment-new').slideUp('fast');
	}
});
</script>