<?= '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?= $direction; ?>" lang="<?= $language; ?>" xml:lang="<?= $language; ?>">
<head>
<title><?= $title; ?></title>
<base href="<?= $base; ?>">
<link rel="stylesheet" href="<?= $css_link; ?>">
</head>
<body>
<?php foreach ($orders as $order) { ?>
<div style="page-break-after:always;">
	<h1><?= $lang_text_invoice; ?></h1>
	<table class="store">
		<tr>
			<td width="50%"><?= $order['store_name']; ?><br>
				<?= $order['store_address']; ?><br>
				<?= $lang_text_telephone; ?> <?= $order['store_telephone']; ?><br>
				<?= $order['store_email']; ?><br>
				<?= $order['store_url']; ?></td>
			<td>
				<b><?= $lang_text_date_added; ?></b> <?= $order['date_added']; ?><br>
				<?php if ($order['invoice_no']) { ?>
					<b><?= $lang_text_invoice_no; ?></b> <?= $order['invoice_no']; ?><br>
				<?php } ?>
				<b><?= $lang_text_order_id; ?></b> <?= $order['order_id']; ?><br>
				<b><?= $lang_text_payment_method; ?></b> <?= $order['payment_method']; ?><br>
				<?php if ($order['shipping_method']) { ?>
				<b><?= $lang_text_shipping_method; ?></b> <?= $order['shipping_method']; ?><br>
				<?php } ?>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<th width="50%"><?= $lang_text_to; ?></th>
			<th><?= $lang_text_ship_to; ?></th>
		</tr>
		<tr>
			<td><?= $order['payment_address']; ?><br/>
				<?= $order['email']; ?><br/>
				<?= $order['telephone']; ?>
				<?php if ($order['payment_company_id']) { ?>
				<br/>
				<br/>
				<?= $lang_text_company_id; ?> <?= $order['payment_company_id']; ?>
				<?php } ?>
				<?php if ($order['payment_tax_id']) { ?>
				<br/>
				<?= $lang_text_tax_id; ?> <?= $order['payment_tax_id']; ?>
				<?php } ?></td>
			<td><?= $order['shipping_address']; ?></td>
		</tr>
	</table>
	<table class="product">
		<tr>
			<th><?= $lang_column_product; ?></th>
			<th><?= $lang_column_model; ?></th>
			<th class="text-right"><?= $lang_column_quantity; ?></th>
			<th class="text-right"><?= $lang_column_price; ?></th>
			<th class="text-right"><?= $lang_column_total; ?></th>
		</tr>
		<?php foreach ($order['product'] as $product) { ?>
		<tr>
			<td><?= $product['name']; ?>
				<?php foreach ($product['option'] as $option) { ?>
				<br>
				&nbsp;<small> - <?= $option['name']; ?>: <?= $option['value']; ?></small>
				<?php } ?></td>
			<td><?= $product['model']; ?></td>
			<td class="text-right"><?= $product['quantity']; ?></td>
			<td class="text-right"><?= $product['price']; ?></td>
			<td class="text-right"><?= $product['total']; ?></td>
		</tr>
		<?php } ?>
		<?php foreach ($order['gift_card'] as $gift_card) { ?>
		<tr>
			<td><?= $gift_card['description']; ?></td>
			<td></td>
			<td class="text-right">1</td>
			<td class="text-right"><?= $gift_card['amount']; ?></td>
			<td class="text-right"><?= $gift_card['amount']; ?></td>
		</tr>
		<?php } ?>
		<?php foreach ($order['total'] as $total) { ?>
		<tr>
			<td class="text-right" colspan="4"><b><?= $total['title']; ?>:</b></td>
			<td class="text-right"><?= $total['text']; ?></td>
		</tr>
		<?php } ?>
	</table>
	<?php if ($order['comment']) { ?>
	<table class="comment">
		<tr>
			<th><?= $lang_column_comment; ?></th>
		</tr>
		<tr>
			<td><?= $order['comment']; ?></td>
		</tr>
	</table>
	<?php } ?>
</div>
<?php } ?>
</body>
</html>