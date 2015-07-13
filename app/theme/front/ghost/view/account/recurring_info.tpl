<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-left" colspan="2"><?= $lang_text_recurring_detail; ?></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-left" style="width: 50%;">
						<p><b><?= $lang_text_recurring_id; ?></b> #<?= $recurring['order_recurring_id']; ?></p>
						<p><b><?= $lang_text_date_added; ?></b> <?= $recurring['date_added']; ?></p>
						<p><b><?= $lang_text_status; ?></b> <?= $status_types[$recurring['status']]; ?></p>
						<p><b><?= $lang_text_payment_method; ?></b> <?= $recurring['payment_method']; ?></p>
					</td>
					<td class="left" style="width: 50%; vertical-align: top;">
						<p><b><?= $lang_text_product; ?></b><a href="<?= $recurring['product_link']; ?>"><?= $recurring['product_name']; ?></a></p>
						<p><b><?= $lang_text_quantity; ?></b> <?= $recurring['product_quantity']; ?></p>
						<p><b><?= $lang_text_order; ?></b><a href="<?= $recurring['order_link']; ?>">#<?= $recurring['order_id']; ?></a></p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-left"><?= $lang_text_recurring_description; ?></td>
					<td class="text-left"><?= $lang_text_ref; ?></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-left" style="width: 50%;">
						<p style="margin:5px;"><?= $recurring['recurring_description']; ?></p>
					</td>
					<td class="text-left" style="width: 50%;">
						<p style="margin:5px;"><?= $recurring['reference']; ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<h2><?= $lang_text_transactions; ?></h2>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<td class="text-left"><?= $lang_column_date_added; ?></td>
					<td class="text-center"><?= $lang_column_type; ?></td>
					<td class="text-right"><?= $lang_column_amount; ?></td>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($recurring['transactions'])): ?>
				<?php foreach ($recurring['transactions'] as $transaction): ?>
				<tr>
					<td class="text-left"><?= $transaction['date_added']; ?></td>
					<td class="text-center"><?= $transaction_types[$transaction['type']]; ?></td>
					<td class="text-right"><?= $transaction['amount']; ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="3" class="text-center"><?= $lang_text_empty_transactions; ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		<div class="form-actions">
			<div class="form-actions-inner text-right">
				<?= $buttons; ?>
			</div>
		</div>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>