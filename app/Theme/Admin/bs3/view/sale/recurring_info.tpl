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
		<div class="clearfix">
			<div class="pull-left h2"><i class="hidden-xs fa fa-user"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<a class="btn btn-warning" href="<?= $return; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-bordered">
			<tr>
				<td><?= $lang_entry_order_recurring; ?></td>
				<td><?= $order_recurring_id; ?></td>
			</tr>
			<tr>
				<td><?= $lang_entry_order_id; ?></td>
				<td><a href="<?= $order_href; ?>"><?= $order_id; ?></a></td>
			</tr>
			<tr>
				<td><?= $lang_entry_customer; ?></td>
				<td>
					<?php if ($customer_href) { ?>
					<a href="<?= $customer_href ?>"><?= $customer; ?></a>
					<?php } else { ?>
					<?= $customer; ?>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td><?= $lang_entry_email; ?></td>
				<td><?= $email; ?></td>
			</tr>
			<tr>
				<td><?= $lang_entry_status; ?></td>
				<td><?= $status; ?></td>
			</tr>
			<tr>
				<td><?= $lang_entry_date_added; ?></td>
				<td><?= $date_added; ?></td>
			</tr>
			<tr>
				<td><?= $lang_entry_reference; ?></td>
				<td><?= $reference; ?></td>
			</tr>
			<tr>
				<td><?= $lang_entry_payment_method; ?></td>
				<td><?= $payment_method; ?></td>
			</tr>
			<tr>
				<td><?= $lang_entry_recurring; ?></td>
				<td>
					<?php if ($recurring) { ?>
					<a href="<?= $recurring; ?>"><?= $recurring_name; ?></a>
					<?php } else { ?>
					<?= $recurring_name; ?>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td><?= $lang_entry_description; ?></td>
				<td><?= $recurring_description; ?></td>
			</tr>
			<tr>
				<td><?= $lang_entry_product; ?></td>
				<td><?= $product; ?></td>
			</tr>
			<tr>
				<td><?= $lang_entry_quantity; ?></td>
				<td><?= $quantity; ?></td>
			</tr>
		</table>
		<?= $buttons; ?>
		<h2><?= $lang_text_transactions; ?></h2>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<td class="text-left"><?= $lang_entry_date_added; ?></td>
					<td class="text-left"><?= $lang_entry_amount; ?></td>
					<td class="text-left"><?= $lang_entry_type; ?></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($transactions as $transaction) { ?>
				<tr>
					<td class="text-left"><?= $transaction['date_added']; ?></td>
					<td class="text-left"><?= $transaction['amount']; ?></td>
					<td class="text-left"><?= $transaction['type']; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?= $footer; ?>