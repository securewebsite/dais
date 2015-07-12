<script>
$('#button-confirm').click(function(){
	$.ajax({
		type:'get',
		url:'payment/free_checkout/confirm',
		success:function(){
			location='<?= $continue; ?>';
		}		
	});
});
</script>