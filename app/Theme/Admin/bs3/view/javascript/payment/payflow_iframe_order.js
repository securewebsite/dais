<script>
function markAsComplete() {
	$('#complete-entry, #reauthorise-entry, #reauthorise-entry').html('-');
	$('#capture-status').html('<?= $lang_text_complete ?>');
}
	
function doVoid(){
	if (confirm('<?= $lang_text_confirm_void; ?>')) {
		$.ajax({
			type:'POST',
			dataType:'json',
			data: {'order_id': <?= $order_id; ?> },
			url:'index.php?route=payment/payflow_iframe/void&token=<?= $token; ?>',
			beforeSend:function(){
				$('#button-void').after('<img src="asset/default/img/loading.gif" class="loading">');
				$('#button-void').hide();
			},
			success:function(data){
				if(!data.error){
					$('#capture-status').text('<?= $lang_text_complete; ?>');
					var html = '';
					html += '<tr>';
					html += '<td>'+data.success.transaction_reference +'</td>';
					html += '<td>'+data.success.transaction_type +'</td>';
					html += '<td>'+data.success.amount +'</td>';
					html += '<td>'+data.success.time +'</td>';
					html += '<td></td>';
					html += '</tr>';
					$('#transaction-table tbody').append(html);
					markAsComplete();
				}
				if(data.error){
					alert(data.error);
					$('#button-void').show();
				}
				$('.icon-loading').remove();
			}
		});
	}
}
function capture(){
	var amount = $('input[name="capture-amount"]').val();
	var complete = 0;
	
	if ($('input[name="capture-complete"]').is(':checked')) {
		complete = 1;
	}
	
	$.ajax({
		type:'POST',
		dataType:'json',
		data: {'order_id': <?= $order_id; ?>, 'amount' : amount, 'complete' : complete },
		url:'index.php?route=payment/payflow_iframe/capture&token=<?= $token; ?>',
		beforeSend:function(){
			$('#button-capture').after('<img src="asset/default/img/loading.gif" class="loading">');
			$('#button-capture').hide();
		},
		success:function(data){
			if(!data.error){
				var html = '';
				html += '<tr>';
				html += '<td>'+data.success.transaction_reference +'</td>';
				html += '<td>'+data.success.transaction_type +'</td>';
				html += '<td>'+data.success.amount +'</td>';
				html += '<td>'+data.success.time +'</td>';
				html += '<td>';
				$.each(data.success.actions, function(index, value){
					html += ' [<a href="'+value.href +'">'+value.title + '</a>] ';
				});
				html += '</td>';
				html += '</tr>';
				$('#transaction-table tbody').append(html);
				if (complete == 1) {
					markAsComplete();
				}
			}
			if(data.error){
				alert(data.error);
			}
			$('#button-capture').show();
			$('.icon-loading').remove();
		}
	});
}
</script>