<script>
	function doSearch(){
		var html;
		$.ajax({
			type:'POST',
			dataType:'json',
			data: $('#form').serialize(),
			url:'index.php?route=payment/paypal_express/doSearch&token=<?= $token; ?>',
			beforeSend:function(){
				$('#search_input').hide();
				$('#search_box').show();
				$('#btn_search').hide();
				$('#btn_edit').show();
			},
			success:function(data){
				if(data.error==true){
					$('#searching').hide();
					$('#error').text(data.error_msg).fadeIn();
				}else{
					if(data.result != ''){
						html += '<thead><tr>';
							html += '<td><?= $lang_column_date; ?></td>';
							html += '<td><?= $lang_column_type; ?></td>';
							html += '<td><?= $lang_column_email; ?></td>';
							html += '<td><?= $lang_column_name; ?></td>';
							html += '<td><?= $lang_column_transid; ?></td>';
							html += '<td><?= $lang_column_status; ?></td>';
							html += '<td><?= $lang_column_currency; ?></td>';
							html += '<td class="text-right"><?= $lang_column_amount; ?></td>';
							html += '<td class="text-right"><?= $lang_column_fee; ?></td>';
							html += '<td class="text-right"><?= $lang_column_netamt; ?></td>';
							html += '<td class="text-center"><?= $lang_column_action; ?></td>';
						html += '</tr></thead>';
						$.each(data.result, function(k,v){
							if(!("L_EMAIL" in v)){
								v.L_EMAIL = '';
							}
							html += '<tr>';
								html += '<td>'+ v.L_TIMESTAMP+'</td>';
								html += '<td>'+ v.L_TYPE+'</td>';
								html += '<td>'+ v.L_EMAIL +'</td>';
								html += '<td>'+ v.L_NAME+'</td>';
								html += '<td>'+ v.L_TRANSACTIONID+'</td>';
								html += '<td>'+ v.L_STATUS+'</td>';
								html += '<td>'+ v.L_CURRENCYCODE+'</td>';
								html += '<td class="text-right">'+v.L_AMT+'</td>';
								html += '<td class="text-right">'+v.L_FEEAMT+'</td>';
								html += '<td class="text-right">'+v.L_NETAMT+'</td>';
								html += '<td class="text-center">';
									html += '<a class="btn btn-default" href="<?= $view_link; ?>&transaction_id='+v.L_TRANSACTIONID+'"><i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $lang_text_view; ?></span></a>';
								html += '</td>';
							html += '</tr>';
						});
						$('#searching').hide();
						$('#search_results').append(html).fadeIn();
					}
				}
			}
		});
	}
	function editSearch(){
		$('#search_box').hide();
		$('#search_input').show();
		$('#btn_edit').hide();
		$('#btn_search').show();
		$('#searching').show();
		$('#search_results').empty().hide();
		$('#error').empty().hide();
	}
</script>