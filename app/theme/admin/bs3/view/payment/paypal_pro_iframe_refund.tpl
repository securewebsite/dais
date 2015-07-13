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
<?php if ($error != '') { ?>
<div class="alert alert-danger"><?= $error; ?><a class="close" data-dismiss="alert" href="#">&times;</a></div>
<?php } ?>
<?php if ($attention != '') { ?>
<div class="attention"><?= $attention; ?></div>
<?php } ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h1><img src="asset/bs3/img/payment.png" alt=""> <?= $lang_text_refund; ?></h1>
		<div class="pull-right">
		<?php if ($cancel) { ?>
			<a href="<?= $cancel; ?>" class="btn btn-default"><?= $lang_button_cancel; ?></a>
		<?php } ?> 
		</div>
	</div>
	<div class="panel-body">
		<form class="form-inline" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="form">
				<input type="hidden" name="amount_original" value="<?= $amount_original; ?>">
				<input type="hidden" name="currency_code" value="<?= $currency_code; ?>">
				<tr>
					<td><?= $lang_entry_transaction_id; ?>:</td>
					<td><input type="text" name="transaction_id" value="<?= $transaction_id; ?>" class="form-control"></td>
				</tr>
				<tr>
					<td><?= $lang_entry_full_refund; ?>:</td>
					<td><input type="hidden" name="refund_full" value="0">
						<input type="checkbox" name="refund_full" id="refund_full" value="1" <?= ($refund_available == '' ? 'checked=""' : ''); ?> onchange="refundAmount();"></td>
				</tr>
				<tr <?= ($refund_available == '' ? 'style="display:none;"' : ''); ?> id="partial_amount_row">
					<td><?= $lang_entry_amount; ?>:</td>
					<td><input type="text" name="amount" value="<?= ($refund_available != '' ? $refund_available : ''); ?>" class="form-control"></td>
				</tr>
				<tr>
					<td><?= $lang_entry_message; ?>:</td>
					<td><textarea name="refund_message" id="paypal_refund_message" cols="40" rows="5"></textarea></td>
				</tr>
			</table>
			<a style="float:right;" onclick="$('#form').submit();" class="btn btn-default"><?= $lang_button_refund; ?></a>
		</form>
	</div>
</div>
<?= $footer; ?>