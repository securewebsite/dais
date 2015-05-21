<p class="standard" align="left" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#333333; margin-top:0px; margin-bottom:8px;">
	<?= $lang_text_greeting; ?>.<br><br>
	<span style="color:#000000"><?= $lang_text_from; ?></span>
</p>

<?php if ($message) { ?>
	<p class="standard" align="left" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#333333; margin-top:0px; margin-bottom:8px;">
		<?= $lang_text_message; ?>:<br><br>
		<span style="color:#000000"><?= $message; ?></span>
	</p>
<?php } ?>


<p class="link" align="left" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#333333; margin-top:5px; margin-bottom:15px;">
	<?= $lang_text_redeem; ?><br><br>
	<span style="line-height:100%; font-size:120%;">&raquo;</span>
	<a href="<?= $store_url; ?>" style="text-decoration:none;" target="_blank">
		<b><?= $store_url; ?></b>
	</a>
</p>

<p class="standard" align="left" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#333333; margin-top:0px; margin-bottom:0px;">
	<?= $lang_text_footer; ?><br><br>
</p>

<p class="standard" align="left" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#333333; margin-top:0px; margin-bottom:0;">
	<a href="<?= $email_store_url; ?>" style="color:#000000; text-decoration:none; font-weight:bold" target="_blank"><?= $email_store_name; ?></a>
</p>