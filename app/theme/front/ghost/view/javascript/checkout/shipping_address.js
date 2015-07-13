<script>
$(document).on('change','#shipping-address input[name="shipping_address"]',function(e){
	if (this.value == 'new'){
		$('#shipping-existing').slideUp('fast');
		$('#shipping-new').slideDown(function(){
			$(this).find('#firstname').select();
			$(this).find('select[name="country_id"]').change();
		});
	} else {
		$('#shipping-existing').slideDown('fast');
		$('#shipping-new').slideUp('fast');
	}
});
</script>