<?php if ($customer_id): ?>
<p style="font-size:0.8em">
	<b><?= $lang_text_link; ?></b><br />
	<a href="<?= $link; ?>"><b><?= $link; ?></b></a>
</p>
<?php endif; ?>

<?php if ($download): ?>
<p style="font-size:0.8em">
	<b><?= $lang_text_download; ?></b><br />
	<a href="<?= $download; ?>"><b><?= $download; ?></b></a>
</p>
<?php endif; ?>

<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="100%" style="padding:0;">
			<table cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
			    	<td width="50%" style="font-size:0.8em">
			          	<?php if (isset($order_id)): ?>
			          	<b><?= $lang_text_order_id; ?></b> <?= $order_id; ?><br />
			          	<?php endif; ?>
			    		<?php if (isset($invoice_no)): ?>
			    		<b><?= $lang_text_invoice_no; ?></b> <?= $invoice_no; ?><br />
			    		<?php endif; ?>
			          	<b><?= $lang_text_date_added; ?></b> <?= $date_added; ?><br />
			          	<b><?= $lang_text_order_status; ?></b> <?= $order_status; ?><br />
						<b><?= $lang_text_payment_method; ?></b> <?= $payment_method; ?><br />
			          	<?php if ($shipping_method): ?>
			          	<b><?= $lang_text_shipping_method; ?></b> <?= $shipping_method; ?>
			          	<?php endif; ?>
			        </td>
			        <td width="50%" style="font-size:0.8em">
			        	<b><?= $lang_text_email; ?></b> <a href="mailto:<?= $email; ?>"><?= $email; ?></a><br />
			          	<b><?= $lang_text_telephone; ?></b> <?= $telephone; ?>
			        </td>
		        </tr>
	        </tbody>
			</table>
		</td>
    </tr>
</table>

<table style="width:100%; table-layout:fixed; border-collapse:separate;">
<tr><td style="line-height: 0; font-size: 0;" height="15">&nbsp;</td></tr>
</table>

<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="100%" style="padding:0;">
			<table cellpadding="0" cellspacing="0" width="100%">
			<tbody>				
				<tr>
			    	<td width="50%" style="font-size:0.8em">
			    		<strong><?= $lang_text_payment_address; ?></strong><br />
			    		<?= $html_payment_address; ?>
			    	</td>
			        <td width="50%" style="font-size:0.8em">
			        	<?php if ($html_shipping_address): ?>
			        	<strong><?= $lang_text_shipping_address; ?></strong><br />
			        	<?= $html_shipping_address; ?>
			        	<?php else: ?>
			        	&nbsp;
			        	<?php endif; ?>
			        </td>
		        </tr>
	        </tbody>
	        </table>
        </td>
	</tr>
</table>

<table style="width:100%; table-layout:fixed; border-collapse:separate;">
<tr><td style="line-height: 0; font-size: 0;" height="15">&nbsp;</td></tr>
</table>

<?php if (!empty($products) || !empty($gift_cards)): ?>
<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
        <th width="50%" align="left" style="font-size:0.8em"><?= $lang_text_product; ?></th>
        <?php if ($table_quantity): ?>
        <th width="10%" align="left" style="font-size:0.8em"><?= $lang_text_quantity; ?></th>
        <?php endif; ?>
        <th width="<?= ($table_quantity) ? 20 : 25; ?>%" align="left" style="font-size:0.8em"><?= $lang_text_price; ?></th>
        <th width="<?= ($table_quantity) ? 20 : 25; ?>%" align="right" style="font-size:0.8em"><?= $lang_text_total; ?></th>
	</tr>
	<?php $colspan = ($table_quantity) ? 3 : 2; ?>
	<?php foreach ($products as $product): ?>
    <tr>
		<td align="left" style="font-size:0.8em">
			<?php if ($product['image']): ?>
			<?php if (!empty($product['url'])): ?>
			<a href="<?= $product['url']; ?>">
				<img src="<?= $product['image']; ?>" width="50" height="50" alt="" style="float: left; margin-right: 5px;" />
			</a>
			<?php else: ?>
			<img src="<?= $product['image']; ?>" width="50" height="50" alt="" style="float: left; margin-right: 5px;" />
			<?php endif; ?>				
			<?php endif; ?>
			
			<?php if (!empty($product['url'])): ?>
			<a href="<?= $product['url']; ?>"><?= $product['name']; ?></a>
			<?php else: ?>
			<?= $product['name']; ?>
			<?php endif; ?>
			
			<?php if ($product['model']): ?>
			<br>
			<span><b><?= $lang_text_model; ?>:</b> <?= $product['model']; ?></span>
			<?php endif; ?>

			<?php if ($product['link']): ?>
			<br>
			<span><b><?= $lang_text_online; ?>:</b> <?= $product['link']; ?></span>
			<?php endif; ?>
					
			<?php if (!empty($product['option'])): ?>
			<ul>
			<?php foreach ($product['option'] as $option): ?>
				<li style="list-style-type:none;font-size:0.8em"><strong><?= $option['name']; ?>:</strong> <?= $option['value']; ?></li>
			<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</td>
		<?php if ($table_quantity): ?>
			<td align="left" style="font-size:0.8em"><?= $product['quantity']; ?></td>
			<td align="left" style="font-size:0.8em"><?= $product['price']; ?></td>
		<?php else: ?>
			<td align="left" style="font-size:0.8em"><?= ($product['quantity'] > 1) ? $product['quantity'] . '<b>x</b>' : $product['price']; ?></td>
		<?php endif; ?>
		<td align="right" style="font-size:0.8em"><?= $product['total']; ?></td>
	</tr>
	<?php endforeach; ?>
	<?php if (isset($gift_cards)): ?>
	<?php foreach ($gift_cards as $gift_card): ?>
	<tr>
        <td align="left" colspan="<?= $colspan; ?>" style="font-size:0.8em"><?= $gift_card['description']; ?></td>
		<td align="right" style="font-size:0.8em"><?= $gift_card['amount']; ?></td>
	</tr>
	<?php endforeach; ?>
	<?php endif; ?>
</table>

<table style="width:100%; table-layout:fixed; border-collapse:separate;">
<tr><td style="line-height: 0; font-size: 0;" height="15">&nbsp;</td></tr>
</table>

<?php endif; ?>

<?php if (!empty($totals)): ?>
<table cellpadding="5" cellspacing="0" width="100%">
	<?php foreach ($totals as $total): ?>
	<tr>
		<td style="font-size:0.8em" align="right"><b><?= $total['title']; ?></b></td>
		<td style="font-size:0.8em;width:15%" align="right"><?= $total['text']; ?></td>
	</tr>
	<?php endforeach; ?>
</table>

<table style="width:100%; table-layout:fixed; border-collapse:separate;">
<tr><td style="line-height: 0; font-size: 0;" height="15">&nbsp;</td></tr>
</table>

<?php endif; ?>

<?php if($comment): ?>
<p>
	<b><?= $lang_text_comment; ?></b><br />
	<?= $comment; ?>
</p>
<?php endif; ?>
<?php if ($has_link): ?>
<p><?= $lang_text_link_alert; ?><br><br></p>
<?php endif; ?>
