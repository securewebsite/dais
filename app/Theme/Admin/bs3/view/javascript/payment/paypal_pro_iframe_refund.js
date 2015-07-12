<script>
function refundAmount(){
	var valChecked = $('#refund_full').prop('checked');
	if(valChecked==true){
		$('#partial_amount_row').hide();
	}else{
		$('#partial_amount_row').show();
	}
}
</script>