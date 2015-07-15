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
		<h1><img src="data:image/png;base64,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" alt=""> <?= $lang_text_transaction; ?></h1>
		<div class="pull-right">
			<?php if ($back) { ?>
				<a class="btn btn-default" href="<?= $back ?>"><?= $lang_button_back ?></a>
			<?php } ?>
		</div>
	</div>
	<div class="panel-body">
		<table class="form">
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