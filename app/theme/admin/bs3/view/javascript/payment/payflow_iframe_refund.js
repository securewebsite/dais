<script>
function refund(){
	var amount = $('input[name="amount"]').val();
	
	$.ajax({
		type:'POST',
		dataType:'json',
		data: {'transaction_reference': '<?= $transaction_reference; ?>', 'amount' : amount },
		url:'payment/payflow_iframe/do_refund',
		beforeSend:function(){
			$('#button-refund').after('<img src="asset/default/img/loading.gif" class="loading">');
			$('#button-refund').hide();
		},
		success:function(data){
			if(!data.error){
				alert(data.success);
				$('input[name="amount"]').val('0.00');
			}
			if(data.error){
				alert(data.error);
			}
			$('#button-refund').show();
			$('.icon-loading').remove();
		}
	});
}
</script>