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
		<h1><img src="asset/bs3/img/payment.png" alt=""> <?= $lang_heading_refund; ?></h1>
		<div class="pull-right"><a href="<?= $cancel; ?>" class="btn btn-default"><?= $lang_button_cancel; ?></a></div>
	</div>
	<div class="panel-body"> 
		<table class="form">
			<tr>
				<td><?= $lang_entry_transaction_reference ?></td>
				<td><?= $transaction_reference ?></td>
			</tr>
			<tr>
				<td><?= $lang_entry_transaction_amount ?></td>
				<td><?= $transaction_amount ?></td>
			</tr>
			<tr>
				<td><?= $lang_entry_refund_amount ?></td>
				<td><input type="test" value="0.00" name="amount">
					<a class="btn btn-default" onclick="refund()" id="button-refund"><?= $lang_button_refund ?></a></td>
			</tr>
		</table>
	</div>
</div>
<?= $footer; ?>