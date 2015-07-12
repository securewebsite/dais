<script>
$('#button-confirm').click(function(){
	$.ajax({
		type:'get',
		url:'payment/check/confirm',
		success:function(){
			location='<?= $continue; ?>';
		}		
	});
});
</script>