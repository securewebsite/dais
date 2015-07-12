<script>
$("input[name='shipping_method']").change( function() {
	$('#shipping_form').submit();
});
$('input[name=\'next\']').bind('change', function() {
	$('.cart-discounts > div').hide();
	$('#' + this.value).show();
});
</script>