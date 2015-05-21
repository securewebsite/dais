<?= $header; ?>
<?= $breadcrumb; ?>
<?php if (!empty($error)): ?>
<div class="alert alert-danger"><?= $error; ?><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
<?php endif; ?>
<?php if (!empty($error_warning)): ?>
<div class="alert alert-danger"><?= $error_warning; ?><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
<div class="alert alert-success"><?= $success; ?><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
<?php endif; ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="pull-left h2"><i class="hidden-xs fa fa-credit-card"></i><?= $lang_heading_title; ?></div>
	</div>
	<div class="panel-body">
		<table class="form">
		<?php if(!empty($lines)) { ?>
		<tr>
			<td><?= $lang_text_product_lines; ?></td>
			<td><table class="table table-bordered table-striped table-hover">
					<?php $i = 0;	foreach($lines as	$k => $v){
						if ($i == 0) { ?>
							<thead>
								<tr>
									<?php foreach ($v as $k => $row) {
										if ($k == 'L_NAME') { echo '<td>'.$text_name.'</td>'; }
										if ($k == 'L_NUMBER') { echo '<td>'.$text_number.'</td>'; }
										if ($k == 'L_QTY') { echo '<td>'.$text_qty.'</td>'; }
										if ($k == 'L_COUPONID') { echo '<td>'.$text_coupon_id.'</td>'; }
										if ($k == 'L_COUPONAMOUNT') { echo '<td>'.$text_coupon_amount.'</td>'; }
										if ($k == 'L_COUPONAMOUNTCURRENCY') { echo '<td>'.$text_coupon_currency.'</td>'; }
										if ($k == 'L_LOYALTYCARDDISCOUNTAMOUNT') { echo '<td>'.$text_loyalty_disc_amt.'</td>'; }
										if ($k == 'L_LOYALTYCARDISCOUNTCURRENCY') { echo '<td>'.$text_loyalty_currency.'</td>'; }
										if ($k == 'L_AMT') { echo '<td>'.$text_amount.'</td>'; }
										if ($k == 'L_OPTIONSNAME') { echo '<td>'.$text_options_name.'</td>'; }
										if ($k == 'L_TAXAMT') { echo '<td>'.$text_tax_amt.'</td>'; }
										if ($k == 'L_CURRENCYCODE') { echo '<td>'.$text_currency_code.'</td>'; }
									} $i++; ?>
								</tr>
							</thead>
						<?php } ?>
						<tr>
							<?php foreach ($v as $k => $row) {
								if ($k == 'L_NAME') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_NUMBER') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_QTY') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_COUPONID') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_COUPONAMOUNT') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_COUPONAMOUNTCURRENCY') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_LOYALTYCARDDISCOUNTAMOUNT') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_LOYALTYCARDISCOUNTCURRENCY') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_AMT') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_OPTIONSNAME') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_OPTIONSVALUE') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_TAXAMT') { echo '<td>'.$row.'</td>'; }
								if ($k == 'L_CURRENCYCODE') { echo '<td>'.$row.'</td>'; }
							} $i++; ?>
						</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
		<?php } ?>
			<?php if(isset($transaction['GIFTMESSAGE'])) { ?>
			<tr>
				<td><?= $lang_text_gift_msg; ?></td>
				<td><?= $transaction['GIFTMESSAGE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['GIFTRECEIPTENABLE'])) { ?>
			<tr>
				<td><?= $lang_text_gift_receipt; ?></td>
				<td><?= $transaction['GIFTRECEIPTENABLE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['GIFTWRAPNAME'])) { ?>
			<tr>
				<td><?= $lang_text_gift_wrap_name; ?></td>
				<td><?= $transaction['GIFTWRAPNAME']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['GIFTWRAPAMOUNT'])) { ?>
			<tr>
				<td><?= $lang_text_gift_wrap_amt; ?></td>
				<td><?= $transaction['GIFTWRAPAMOUNT']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['BUYERMARKETINGEMAIL'])) { ?>
			<tr>
				<td><?= $lang_text_buyer_email_market; ?></td>
				<td><?= $transaction['BUYERMARKETINGEMAIL']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SURVEYQUESTION'])) { ?>
			<tr>
				<td><?= $lang_text_survey_question; ?></td>
				<td><?= $transaction['SURVEYQUESTION']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SURVEYCHOICESELECTED'])) { ?>
			<tr>
				<td><?= $lang_text_survey_chosen; ?></td>
				<td><?= $transaction['SURVEYCHOICESELECTED']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['RECEIVERBUSINESS'])) { ?>
			<tr>
				<td><?= $lang_text_receiver_business; ?></td>
				<td><?= $transaction['RECEIVERBUSINESS']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['RECEIVEREMAIL'])) { ?>
			<tr>
				<td><?= $lang_text_receiver_email; ?></td>
				<td><?= $transaction['RECEIVEREMAIL']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['RECEIVERID'])) { ?>
			<tr>
				<td><?= $lang_text_receiver_id; ?></td>
				<td><?= $transaction['RECEIVERID']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['EMAIL'])) { ?>
			<tr>
				<td><?= $lang_text_buyer_email; ?></td>
				<td><?= $transaction['EMAIL']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['PAYERID'])) { ?>
			<tr>
				<td><?= $lang_text_payer_id; ?></td>
				<td><?= $transaction['PAYERID']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['PAYERSTATUS'])) { ?>
			<tr>
				<td><?= $lang_text_payer_status; ?></td>
				<td><?= $transaction['PAYERSTATUS']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['COUNTRYCODE'])) { ?>
			<tr>
				<td><?= $lang_text_country_code; ?></td>
				<td><?= $transaction['COUNTRYCODE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['PAYERBUSINESS'])) { ?>
			<tr>
				<td><?= $lang_text_payer_business; ?></td>
				<td><?= $transaction['PAYERBUSINESS']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SALUTATION'])) { ?>
			<tr>
				<td><?= $lang_text_payer_salute; ?></td>
				<td><?= $transaction['SALUTATION']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['FIRSTNAME'])) { ?>
			<tr>
				<td><?= $lang_text_payer_firstname; ?></td>
				<td><?= $transaction['FIRSTNAME']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['MIDDLENAME'])) { ?>
			<tr>
				<td><?= $lang_text_payer_middlename; ?></td>
				<td><?= $transaction['MIDDLENAME']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['LASTNAME'])) { ?>
			<tr>
				<td><?= $lang_text_payer_lastname; ?></td>
				<td><?= $transaction['LASTNAME']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SUFFIX'])) { ?>
			<tr>
				<td><?= $lang_text_payer_suffix; ?></td>
				<td><?= $transaction['SUFFIX']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['ADDRESSOWNER'])) { ?>
			<tr>
				<td><?= $lang_text_address_owner; ?></td>
				<td><?= $transaction['ADDRESSOWNER']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['ADDRESSSTATUS'])) { ?>
			<tr>
				<td><?= $lang_text_address_status; ?></td>
				<td><?= $transaction['ADDRESSSTATUS']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSECONDARYNAME'])) { ?>
			<tr>
				<td><?= $lang_text_ship_sec_name; ?></td>
				<td><?= $transaction['SHIPTOSECONDARYNAME']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTONAME'])) { ?>
			<tr>
				<td><?= $lang_text_ship_name; ?></td>
				<td><?= $transaction['SHIPTONAME']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSTREET'])) { ?>
			<tr>
				<td><?= $lang_text_ship_street1; ?></td>
				<td><?= $transaction['SHIPTOSTREET']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSECONDARYADDRESSLINE1'])) { ?>
			<tr>
				<td><?= $lang_text_ship_sec_add1; ?></td>
				<td><?= $transaction['SHIPTOSECONDARYADDRESSLINE1']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSTREET2'])) { ?>
			<tr>
				<td><?= $lang_text_ship_street2; ?></td>
				<td><?= $transaction['SHIPTOSTREET2']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSECONDARYADDRESSLINE2'])) { ?>
			<tr>
				<td><?= $lang_text_ship_sec_add2; ?></td>
				<td><?= $transaction['SHIPTOSECONDARYADDRESSLINE2']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOCITY'])) { ?>
			<tr>
				<td><?= $lang_text_ship_city; ?></td>
				<td><?= $transaction['SHIPTOCITY']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSECONDARYCITY'])) { ?>
			<tr>
				<td><?= $lang_text_ship_sec_city; ?></td>
				<td><?= $transaction['SHIPTOSECONDARYCITY']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSTATE'])) { ?>
			<tr>
				<td><?= $lang_text_ship_state; ?></td>
				<td><?= $transaction['SHIPTOSTATE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSECONDARYSTATE'])) { ?>
			<tr>
				<td><?= $lang_text_ship_sec_state; ?></td>
				<td><?= $transaction['SHIPTOSECONDARYSTATE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOZIP'])) { ?>
			<tr>
				<td><?= $lang_text_ship_zip; ?></td>
				<td><?= $transaction['SHIPTOZIP']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSECONDARYZIP'])) { ?>
			<tr>
				<td><?= $lang_text_ship_sec_zip; ?></td>
				<td><?= $transaction['SHIPTOSECONDARYZIP']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOCOUNTRYCODE'])) { ?>
			<tr>
				<td><?= $lang_text_ship_country; ?></td>
				<td><?= $transaction['SHIPTOCOUNTRYCODE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSECONDARYCOUNTRYCODE'])) { ?>
			<tr>
				<td><?= $lang_text_ship_sec_country; ?></td>
				<td><?= $transaction['SHIPTOSECONDARYCOUNTRYCODE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOPHONENUM'])) { ?>
			<tr>
				<td><?= $lang_text_ship_phone; ?></td>
				<td><?= $transaction['SHIPTOPHONENUM']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SHIPTOSECONDARYPHONENUM'])) { ?>
			<tr>
				<td><?= $lang_text_ship_sec_phone; ?></td>
				<td><?= $transaction['SHIPTOSECONDARYPHONENUM']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['TRANSACTIONID'])) { ?>
			<tr>
				<td><?= $lang_text_trans_id; ?></td>
				<td><?= $transaction['TRANSACTIONID']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['PARENTTRANSACTIONID'])) { ?>
			<tr>
				<td><?= $lang_text_parent_trans_id; ?></td>
				<td><a href="<?= $view_link.'&transaction_id='.$transaction['PARENTTRANSACTIONID']; ?>"><?= $transaction['PARENTTRANSACTIONID']; ?></a></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['RECEIPTID'])) { ?>
			<tr>
				<td><?= $lang_text_receipt_id; ?></td>
				<td><?= $transaction['RECEIPTID']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['TRANSACTIONTYPE'])) { ?>
			<tr>
				<td><?= $lang_text_trans_type; ?></td>
				<td><?= $transaction['TRANSACTIONTYPE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['PAYMENTTYPE'])) { ?>
			<tr>
				<td><?= $lang_text_payment_type; ?></td>
				<td><?= $transaction['PAYMENTTYPE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['ORDERTIME'])) { ?>
			<tr>
				<td><?= $lang_text_order_time; ?></td>
				<td><?= $transaction['ORDERTIME']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['AMT'])) { ?>
			<tr>
				<td><?= $lang_text_amount; ?></td>
				<td><?= $transaction['AMT']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['CURRENCYCODE'])) { ?>
			<tr>
				<td><?= $lang_text_currency_code; ?></td>
				<td><?= $transaction['CURRENCYCODE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['FEEAMT'])) { ?>
			<tr>
				<td><?= $lang_text_fee_amount; ?></td>
				<td><?= $transaction['FEEAMT']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SETTLEAMT'])) { ?>
			<tr>
				<td><?= $lang_text_settle_amount; ?></td>
				<td><?= $transaction['SETTLEAMT']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['TAXAMT'])) { ?>
			<tr>
				<td><?= $lang_text_tax_amount; ?></td>
				<td><?= $transaction['TAXAMT']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['EXCHANGERATE'])) { ?>
			<tr>
				<td><?= $lang_text_exchange; ?></td>
				<td><?= $transaction['EXCHANGERATE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['PAYMENTSTATUS'])) { ?>
			<tr>
				<td><?= $lang_text_payment_status; ?></td>
				<td><?= $transaction['PAYMENTSTATUS']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['PENDINGREASON'])) { ?>
			<tr>
				<td><?= $lang_text_pending_reason; ?></td>
				<td><?= $transaction['PENDINGREASON']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['REASONCODE'])) { ?>
			<tr>
				<td><?= $lang_text_reason_code; ?></td>
				<td><?= $transaction['REASONCODE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['PROTECTIONELIGIBILITY'])) { ?>
			<tr>
				<td><?= $lang_text_protect_elig; ?></td>
				<td><?= $transaction['PROTECTIONELIGIBILITY']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['PROTECTIONELIGIBILITYTYPE'])) { ?>
			<tr>
				<td><?= $lang_text_protect_elig_type; ?></td>
				<td><?= $transaction['PROTECTIONELIGIBILITYTYPE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['STOREID'])) { ?>
			<tr>
				<td><?= $lang_text_store_id; ?></td>
				<td><?= $transaction['STOREID']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['TERMINALID'])) { ?>
			<tr>
				<td><?= $lang_text_terminal_id; ?></td>
				<td><?= $transaction['TERMINALID']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['INVNUM'])) { ?>
			<tr>
				<td><?= $lang_text_invoice_number; ?></td>
				<td><?= $transaction['INVNUM']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['CUSTOM'])) { ?>
			<tr>
				<td><?= $lang_text_custom; ?></td>
				<td><?= $transaction['CUSTOM']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['NOTE'])) { ?>
			<tr>
				<td><?= $lang_text_note; ?></td>
				<td><?= $transaction['NOTE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['SALESTAX'])) { ?>
			<tr>
				<td><?= $lang_text_sales_tax; ?></td>
				<td><?= $transaction['SALESTAX']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['BUYERID'])) { ?>
			<tr>
				<td><?= $lang_text_buyer_id; ?></td>
				<td><?= $transaction['BUYERID']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['CLOSINGDATE'])) { ?>
			<tr>
				<td><?= $lang_text_close_date; ?></td>
				<td><?= $transaction['CLOSINGDATE']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['MULTIITEM'])) { ?>
			<tr>
				<td><?= $lang_text_multi_item; ?></td>
				<td><?= $transaction['MULTIITEM']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['AMOUNT'])) { ?>
			<tr>
				<td><?= $lang_text_sub_amt; ?></td>
				<td><?= $transaction['AMOUNT']; ?></td>
			</tr>
			<?php } ?>
			<?php if(isset($transaction['PERIOD'])) { ?>
			<tr>
				<td><?= $lang_text_sub_period; ?></td>
				<td><?= $transaction['PERIOD']; ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>
<?= $footer; ?>