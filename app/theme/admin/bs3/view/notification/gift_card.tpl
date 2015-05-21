<table class="contents" style="border-collapse: collapse;border-spacing: 0;width: 100%">
	<tbody>
		<tr>
			<td class="padded" style="padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px">
				<table class="divider" style="border-collapse: collapse;border-spacing: 0;width: 100%">
					<tbody>
						<tr>
							<td class="inner" style="padding: 0;vertical-align: top;padding-bottom: 24px" align="center">
								<table style="border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px">
									<tbody>
										<tr>
											<td style="padding: 0;vertical-align: top">&nbsp;</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<div class="card-center" style="text-align: center;position:relative;" align="center">
    <img src="<?= $theme_image; ?>" class="image" style="border: 0;-ms-interpolation-mode: bicubic;display: block;margin-left: auto;margin-right: auto;max-width:428px;width:100%;height:auto;" />
    <h2 class="card-store" style="position:absolute;top:40px;right:110px;"><?= $store_name; ?></h2>
    <h3 class="card-text" style="position:absolute;top:75px;right:110px;"><?= $theme_name; ?></h3>
    <h3 class="card-name" style="position:absolute;bottom:50px;right:110px;"><?= $to_name; ?></h3>
    <h3 class="card-code" style="position:absolute;bottom:25px;right:110px;"><?= $lang_text_code; ?> <?= $code; ?></h3>
</div>

<?php if ($html_message): ?>
	<p><?= $lang_text_message; ?></p>
	<div style="padding: 15px;margin-bottom: 20px;border: 2px solid #faebcc;border-radius: 4px;background-color: #fcf8e3;color: #D7A663;">
		<?= $html_message; ?>
	</div>
<?php endif; ?>
