<script>
$('#button-confirm').click(function(){
	$.ajax({
		type:'get',
		url:'payment/bank_transfer/confirm',
		success:function(){
			location='<?= $continue; ?>';
		}		
	});
});
</script>
