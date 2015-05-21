<?php if (!isset($redirect)) { ?>
<div class="panel-body">
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?= $lang_column_name; ?></th>
				<th><?= $lang_column_model; ?></th>
				<th class="text-right"><?= $lang_column_quantity; ?></th>
				<th class="text-right"><?= $lang_column_price; ?></th>
				<th class="text-right"><?= $lang_column_total; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($products as $product) { ?>
			<tr>
				<td><a href="<?= $product['href']; ?>"><?= $product['name']; ?></a>
					<?php foreach ($product['option'] as $option) { ?>
					<br>
					<div class="help">- <?= $option['name']; ?>: <?= $option['value']; ?></div>
					<?php } ?>
					<?php if ($product['recurring']) { ?>
					<br />
					<div class="help">- <?= $lang_text_recurring_item; ?>: <?= $product['recurring']; ?></div>
					<?php } ?>
				</td>
				<td><?= $product['model']; ?></td>
				<td class="text-right"><?= $product['quantity']; ?></td>
				<td class="text-right"><?= $product['price']; ?></td>
				<td class="text-right"><?= $product['total']; ?></td>
			</tr>
			<?php } ?>
			<?php foreach ($gift_cards as $gift_card) { ?>
			<tr>
				<td><?= $gift_card['description']; ?></td>
				<td></td>
				<td class="text-right">1</td>
				<td class="text-right"><?= $gift_card['amount']; ?></td>
				<td class="text-right"><?= $gift_card['amount']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<?php foreach ($totals as $total) { ?>
			<tr>
				<td colspan="4" class="text-right"><?= $total['title']; ?>:</td>
				<td class="text-right"><b><?= $total['text']; ?></b></td>
			</tr>
			<?php } ?>
		</tfoot>
	</table>
	<div class="payment"><?= $payment; ?></div>
</div>
<div class="panel-footer clearfix">
	<div class="pull-right">
		<button id="button-confirm" class="btn btn-warning btn-lg"><?= $lang_button_confirm; ?></button>
	</div>
</div>
<?php } else { ?>
<script>
	window.top.location.href = '<?= $redirect; ?>';
</script>
<?php } ?>