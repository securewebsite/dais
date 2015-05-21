<script>
	function capture(){
		var amt = $('#paypal_capture_amount').val();
		if(amt == '' || amt == 0){
			alert('<?= $lang_error_capture_amt; ?>');
			return false;
		}else{
			var captureComplete;
			var voidTransaction = false;
			if ($('#paypal_capture_complete').prop('checked')==true){
				captureComplete = 1;
			}else{
				captureComplete = 0;
			}
			$.ajax({
				type:'POST',
				dataType:'json',
				data: {'amount':amt, 'order_id':<?= $order_id; ?>, 'complete': captureComplete},
				url:'index.php?route=payment/paypal_express/capture&token=<?= $token; ?>',
				beforeSend:function(){
					$('#btn_capture').hide();
					$('#img_loading_capture').show();
				},
				success:function(data){
					if(data.error == false){
						html = '';
						html += '<tr>';
							html += '<td>'+data.data.transaction_id+'</td>';
							html += '<td>'+data.data.amount+'</td>';
							html += '<td>'+data.data.payment_type+'</td>';
							html += '<td>'+data.data.payment_status+'</td>';
							html += '<td>'+data.data.pending_reason+'</td>';
							html += '<td>'+data.data.created+'</td>';
							html += '<td>';
								html += '<a href="<?= $view_link; ?>&transaction_id='+data.data.transaction_id+'"><?= $lang_text_view; ?></a>';
								html += '&nbsp;<a href="<?= $refund_link; ?>&transaction_id='+data.data.transaction_id+'"><?= $lang_text_refund; ?></a>';
							html += '</td>';
						html += '</tr>';
						$('#paypal_captured').text(data.data.captured);
						$('#paypal_capture_amount').val(data.data.remaining);
						$('#paypal_transactions').append(html);
						if(data.data.void != ''){
							html += '<tr>';
								html += '<td>'+data.data.void.transaction_id+'</td>';
								html += '<td>'+data.data.void.amount+'</td>';
								html += '<td>'+data.data.void.payment_type+'</td>';
								html += '<td>'+data.data.void.payment_status+'</td>';
								html += '<td>'+data.data.void.pending_reason+'</td>';
								html += '<td>'+data.data.void.created+'</td>';
								html += '<td></td>';
							html += '</tr>';
							$('#paypal_transactions').append(html);
						}
						if(data.data.status == 1){
							$('#capture_status').text('<?= $lang_text_complete; ?>');
							$('.paypal_capture').hide();
						}
					}
					if(data.error==true){
						alert(data.msg);
						if (data.failed_transaction) {
							html = '';
							html += '<tr>';
							html += '<td></td>';
							html += '<td>'+data.failed_transaction.amount +'</td>';
							html += '<td></td>';
							html += '<td></td>';
							html += '<td></td>';
							html += '<td>'+data.failed_transaction.created +'</td>';
							html += '<td><a onclick="resendTransaction(this); return false;" href="<?= $resend_link ?>&paypal_order_transaction_id='+data.failed_transaction.paypal_order_transaction_id +'"><?= $lang_text_resend ?></a></td>';
							html += '/<tr>';
							$('#paypal_transactions').append(html);
						}
					}
					$('#btn_capture').show();
					$('#img_loading_capture').hide();
				}
			});
		}
	}
	function doVoid(){
		if (confirm('<?= $lang_text_confirm_void; ?>')) {
			$.ajax({
				type:'POST',
				dataType:'json',
				data: {'order_id':<?= $order_id; ?> },
				url:'index.php?route=payment/paypal_express/void&token=<?= $token; ?>',
				beforeSend:function(){
					$('#btn_void').hide();
					$('#img_loading_void').show();
				},
				success:function(data){
					if(data.error == false){
						html = '';
						html += '<tr>';
							html += '<td></td>';
							html += '<td></td>';
							html += '<td></td>';
							html += '<td>'+data.data.payment_status+'</td>';
							html += '<td></td>';
							html += '<td>'+data.data.created+'</td>';
							html += '<td></td>';
						html += '</tr>';
						$('#paypal_transactions').append(html);
						$('#capture_status').text('<?= $lang_text_complete; ?>');
						$('.paypal_capture_live').hide();
					}
					if(data.error==true){
						alert(data.msg);
					}
					$('#btn_void').show();
					$('#img_loading_void').hide();
				}
			});
		}
	}
	
	function resendTransaction(element) {
		$.ajax({
			type:'GET',
			dataType:'json',
			url: $(element).attr('href'),
			beforeSend:function(){
				$(element).hide();
				$(element).after('<img src="<?= HTTPS_SERVER; ?>asset/default/img/loading.gif" class="loading">');
			},
			success:function(data){
				$(element).show();
				$('.icon-loading').remove();
				if (data.error) {
					alert(data.error);
				}
				if (data.success) {
					location.reload(); 
				}
			}
		});
	}
</script>