<p class="heading1" align="<?= $lang_text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:18px; line-height:22px; color:<?= $body_font_color; ?>; margin-top:0px; margin-bottom:10px;">
	<strong><?= $title; ?></strong>
</p>

<p class="standard" align="<?= $lang_text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?= $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
	<?= $lang_text_greeting; ?>
</p>

<table cellpadding="0" cellspacing="0" width="100%" style="width:100%; margin:0; color:#666; table-layout:fixed; border-collapse:separate; -moz-border-radius:3px; -moz-box-shadow:0 1px 2px #d1d1d1; -webkit-border-radius:3px; -webkit-box-shadow:0 1px 2px #d1d1d1; background:#eaebec; border:1px solid #e0e0e0; border-radius:3px; box-shadow:0 1px 2px #d1d1d1; text-shadow:1px 1px 0px #fff;">
<thead>
	<tr>
    	<th colspan="2" style="font-size:14px; padding:6px 5px 4px; background:#ededed; font-weight:bold;"><?= $lang_text_return_detail; ?></th>
   	</tr>
</thead>
<tbody>
	<tr>
    	<td style="font-size:12px; line-height:18px; padding:4px 5px; border-bottom:1px solid #e0e0e0; background:#fafafa;">
          	<b><?= $lang_text_firstname; ?></b> <?= $firstname; ?>
          	<br /><b><?= $lang_text_lastname; ?></b> <?= $lastname; ?>
			<?php if($email){ ?><br /><b><?= $lang_text_email; ?></b> <a href="mailto:<?= $email; ?>" style="color:<?= $body_link_color; ?>; text-decoration:none; word-wrap:break-word;"><?= $email; ?></a><?php } ?>
			<?php if($telephone){ ?><br /><b><?= $lang_text_telephone; ?></b> <?= $telephone; ?><?php } ?>
        </td>
        <td style="font-size:12px; line-height:18px; padding:4px 5px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0; background:#fafafa;">
        	<b><?= $lang_text_order_id; ?></b> <?= $order_id; ?>
          	<?php if($order_date){ ?><br /><b><?= $lang_text_order_date; ?></b> <?= $order_date; ?><?php } ?>
        </td>
	</tr>
</tbody>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%" style="width:100%; table-layout:fixed; border-collapse:separate;">
<tr><td style="line-height: 0; font-size: 0;" height="15">&nbsp;</td></tr>
</table>

<?php if($comment){ ?>
<p class="standard" align="<?= $lang_text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?= $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
	<strong><?= $lang_text_comment; ?></strong><br />
	<?= $comment; ?>
</p>
<?php } ?>

<p class="standard" align="<?= $lang_text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?= $body_font_color; ?>; margin-top:0px; margin-bottom:8px;">
	<?= $lang_text_product; ?>
</p>

<table cellpadding="0" cellspacing="0" width="100%" style="width:100%; margin:0; color:#666; table-layout:auto; border-collapse:separate; -moz-border-radius:3px; -moz-box-shadow:0 1px 2px #d1d1d1; -webkit-border-radius:3px; -webkit-box-shadow:0 1px 2px #d1d1d1; background:#eaebec; border:1px solid #e0e0e0; border-radius:3px; box-shadow:0 1px 2px #d1d1d1; text-shadow:1px 1px 0px #fff;">
<thead>
	<tr>
        <th style="text-align:center; font-size:14px; padding:6px 5px 4px; background:#ededed; font-weight:bold;">
        	<?= $lang_text_product_name; ?>
        </th>
        <th style="text-align:center; font-size:14px; padding:6px 5px 4px; background:#ededed; font-weight:bold;">
        	<?= $lang_text_reason; ?>
        </th>
        <th style="text-align:center; font-size:14px; padding:6px 5px 4px; background:#ededed; font-weight:bold;">
        	<?= $lang_text_opened; ?>
        </th>
	</tr>
</thead>
<tbody>
	<?php $row_style_background = "background:#f6f6f6; "; ?>
    <tr>
		<td style="word-wrap:break-word; padding:4px 5px; font-size:12px; border-bottom:1px solid #e0e0e0; <?= $row_style_background; ?>" valign="top">
			<?= $return_product['name']; ?>
			
			<?php if(isset($return_product['model']) || isset($return_product['quantity'])){ ?>
			<ul style="margin:5px 0 0; padding:0 0 0 15px; font-size:<?= $body_product_option_size; ?>px; line-height:1;">
				<?php if(isset($return_product['model'])){ ?>
					<li>
						<strong><?= $lang_text_model; ?>:</strong>
						<?= $return_product['model']; ?>
					</li>
				<?php } ?>
				<?php if(isset($return_product['quantity'])){ ?>
					<li>
						<strong><?= $lang_text_quantity; ?>:</strong>
						<?= $return_product['quantity']; ?>
					</li>
				<?php } ?>
			</ul>
			<?php } ?>
		</td>
		<td style="padding:4px 5px; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0; <?= $row_style_background; ?>" valign="top"><?= $return_product['reason']; ?></td>
		<td style="text-align:center; padding:4px 5px; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0; <?= $row_style_background; ?>" valign="top"><?= $return_product['opened']; ?></td>
	</tr>
</tbody>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%" style="width:100%; table-layout:fixed; border-collapse:separate;">
<tr><td style="line-height: 0; font-size: 0;" height="10">&nbsp;</td></tr>
</table>

<table cellpadding="0" cellspacing="0" width="100%" style="width:100%; margin:0; color:#666; table-layout:auto; border-collapse:separate; -moz-border-radius:3px; -moz-box-shadow:0 1px 2px #d1d1d1; -webkit-border-radius:3px; -webkit-box-shadow:0 1px 2px #d1d1d1; background:#eaebec; border:1px solid #e0e0e0; border-radius:3px; box-shadow:0 1px 2px #d1d1d1; text-shadow:1px 1px 0px #fff;">
<thead>
	<tr>
        <th style="text-align:center; font-size:14px; padding:6px 5px 4px; background:#ededed; font-weight:bold;">
        	<?= $lang_text_comment; ?>
        </th>
	</tr>
</thead>
<tbody>
	<?php $row_style_background = "background:#fafafa; "; ?>
    <tr>
		<td style="padding:4px 5px; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0; word-wrap:break-word; <?= $row_style_background; ?>" valign="top"><?= $return_product['comment']; ?></td>
	</tr>
</tbody>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%" style="width:100%; table-layout:fixed; border-collapse:separate;">
<tr><td style="line-height: 0; font-size: 0;" height="15">&nbsp;</td></tr>
</table>

<p class="link" align="<?= $lang_text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:<?= $body_font_color; ?>; margin-top:5px; margin-bottom:0px;">
	<?= $lang_text_action; ?>:<br />
	<span style="line-height:100%; font-size:120%;">&raquo;</span>
	<a href="<?= $return_link; ?>" style="color:<?= $body_link_color; ?>; text-decoration:none; word-wrap:break-word;" target="_blank">
		<b><?= $return_link; ?></b>
	</a>
</p>