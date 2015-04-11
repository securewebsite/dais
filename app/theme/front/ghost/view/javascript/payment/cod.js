<script>
$(document).on('click', '#button-confirm', function(e){
	e.preventDefault();
	$.ajax({
		type:'get',
		url:'payment/cod/confirm',
		success:function(){
			location='<?= $continue; ?>';
		}		
	});
});
</script>