<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<?php if ($warning): ?>
		<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $warning; ?></div>
		<?php endif; ?>
		<div class="page-header"><h1><?= $lang_text_affiliate; ?></h1></div>
		<?php if (!$is_affiliate): ?>
		<div>
			<form action="<?= $enroll; ?>" method="post" enctype="multipart/form-data" id="enroll-form" class="form-horizontal">
				<input type="hidden" name="customer" value="<?= $customer_id; ?>">
				<div class="col-sm-12">
					<p><?= $lang_text_enroll_now; ?></p>
				
					<?php if ($text_agree): ?>
					<div class="form-group">
						<div class="col-sm-10">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="agree" value="1"<?= $agree ? ' checked' : ''; ?>><?= $text_agree; ?>
								</label>
								<?php if ($error_agree): ?>
								<span class="help-block error"><?= $error_agree; ?></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endif; ?>

				</div>
				<br style="clear:both">
				<div class="form-actions">
					<div class="form-actions-inner text-right">
						<input type="submit" class="btn btn-warning" value="Enroll">
					</div>
				</div>
			</form>
		</div>
		<?php else: ?>
		<div>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li>
			<li><a href="#tab-tracking" data-toggle="tab"><?= $lang_tab_tracking; ?></a></li>
			<li><a href="#tab-payment" data-toggle="tab"><?= $lang_tab_payment; ?></a></li>
			<li><a href="#tab-commission" data-toggle="tab"><?= $lang_tab_commission; ?></a></li>
		</ul>
		<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
			<div class="tab-content">
				<div class="tab-pane active" id="tab-general">
					<fieldset>
						<legend><?= $lang_text_general; ?></legend>
						<div class="form-group">
							<label class="control-label col-sm-3"><?= $lang_entry_status; ?></label>
							<div class="control-field col-sm-6">
								<?php if ($affiliate_status): ?>
									<div class="radio radio-inline">
										<label><input type="radio" name="affiliate_status" value="1" checked><?= $lang_text_enabled; ?></label>
									</div>
									<div class="radio radio-inline">
										<label><input type="radio" name="affiliate_status" value="0"><?= $lang_text_disabled; ?></label>
									</div>
								<?php else: ?>
									<div class="radio radio-inline">
										<label><input type="radio" name="affiliate_status" value="1"><?= $lang_text_enabled; ?></label>
									</div>
									<div class="radio radio-inline">
										<label><input type="radio" name="affiliate_status" value="0" checked><?= $lang_text_disabled; ?></label>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3"><b class="required"></b> <?= $lang_entry_slug; ?></label>
							<div class="control-field col-sm-6">
								<p class="form-control-static"><?= $vanity_base; ?><span id="vanity"><?= $slug; ?></span></p>
								<div class="input-group">
									<input type="text" name="slug" value="<?= $slug; ?>" id="slug" class="form-control">
									<span class="input-group-btn">
										<button class="btn btn-default" style="padding:5px 12px;margin-left:-2px;" id="affiliate-slug-btn" type="button"><?= $lang_text_build; ?></button>
									</span>
								</div>
								<?php if ($error_slug): ?>
								<span class="help-block error"><?= $error_slug; ?></span>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="company"><?= $lang_entry_company; ?></label>
							<div class="col-sm-6">
								<input type="text" name="company" value="<?= $company; ?>" class="form-control" id="company">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="website"><?= $lang_entry_website; ?></label>
							<div class="col-sm-6">
								<input type="text" name="website" value="<?= $website; ?>" class="form-control" id="website">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="tax_id"><span class="required">*</span> <?= $lang_entry_tax_id; ?></label>
							<div class="col-sm-6">
								<input type="text" name="tax_id" value="<?= $tax_id; ?>" class="form-control" id="tax_id">
								<?php if ($error_tax_id): ?>
									<div class="help-block error"><?= $error_tax_id; ?></div>
								<?php endif; ?>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="tab-pane" id="tab-tracking">
					<fieldset>
						<div class="alert alert-info"><?= $lang_text_description; ?></div>
						<div class="form-group">
							<label class="control-label col-sm-3"><?= $lang_text_code; ?></label>
							<div class="col-sm-6">
								<input type="text" value="<?= $code; ?>" class="form-control" id="code" disabled>
								<input type="hidden" name="code" value="<?= $code; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3"><?= $lang_text_generator; ?></label>
							<div class="col-sm-6">
								<input type="text" name="product" value="" class="form-control" id="affiliate-product" autocomplete="off">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3"><?= $lang_text_link; ?></label>
							<div class="col-sm-9">
								<textarea name="link" class="form-control" rows="2" id="affiliate-link" spellcheck="false"></textarea>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="tab-pane" id="tab-payment">
					<fieldset>
						<div class="form-group">
							<label class="control-label col-sm-3"><span class="required">*</span> <?= $lang_entry_payment; ?></label>
							<div class="col-sm-6">
								<div class="radio radio-inline">
									<?php if (!$payment_method) $payment_method = 'cheque'; ?>
									<label>
										<input type="radio" name="payment_method" value="cheque"<?= ($payment_method == 'cheque') ? ' checked' : ''; ?>> <?= $lang_text_cheque; ?>
									</label>
								</div>
								<div class="radio radio-inline">
									<label>
										<input type="radio" name="payment_method" value="paypal"<?= ($payment_method == 'paypal') ? ' checked' : ''; ?>> <?= $lang_text_paypal; ?>
									</label>
								</div>
								<div class="radio radio-inline">
									<label>
										<input type="radio" name="payment_method" value="bank"<?= ($payment_method == 'bank') ? ' checked' : ''; ?>> <?= $lang_text_bank; ?>
									</label>
								</div>
							</div>
						</div>
						<div class="form-group payment" id="payment-cheque">
							<label class="control-label col-sm-3" for="check"><span class="required">*</span> <?= $lang_entry_cheque; ?></label>
							<div class="col-sm-6">
								<input type="text" name="cheque" value="<?= $cheque; ?>" class="form-control" id="cheque">
								<?php if ($error_cheque): ?>
									<div class="help-block error"><?= $error_cheque; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group payment" id="payment-paypal">
							<label class="control-label col-sm-3" for="paypal"><span class="required">*</span> <?= $lang_entry_paypal; ?></label>
							<div class="col-sm-6">
								<input type="text" name="paypal" value="<?= $paypal; ?>" class="form-control" id="paypal">
								<?php if ($error_paypal): ?>
								<div class="help-block error"><?= $error_paypal; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div class="payment" id="payment-bank">
							<div class="form-group">
								<label class="control-label col-sm-3" for="bank_name"><span class="required">*</span> <?= $lang_entry_bank_name; ?></label>
								<div class="col-sm-6">
									<input type="text" name="bank_name" value="<?= $bank_name; ?>" class="form-control" id="bank_name">
									<?php if ($error_bank_name): ?>
									<div class="help-block error"><?= $error_bank_name; ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="bank_branch_number"><?= $lang_entry_bank_branch_number; ?></label>
								<div class="col-sm-6">
									<input type="text" name="bank_branch_number" value="<?= $bank_branch_number; ?>" class="form-control" id="bank_branch_number">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="bank_swift_code"><?= $lang_entry_bank_swift_code; ?></label>
								<div class="col-sm-6">
									<input type="text" name="bank_swift_code" value="<?= $bank_swift_code; ?>" class="form-control" id="bank_swift_code">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="bank_account_name"><span class="required">*</span> <?= $lang_entry_bank_account_name; ?></label>
								<div class="col-sm-6">
									<input type="text" name="bank_account_name" value="<?= $bank_account_name; ?>" class="form-control" id="bank_account_name">
									<?php if ($error_bank_account_name): ?>
									<div class="help-block error"><?= $error_bank_account_name; ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="bank_account_number"><span class="required">*</span> <?= $lang_entry_bank_account_number; ?></label>
								<div class="col-sm-6">
									<input type="text" name="bank_account_number" value="<?= $bank_account_number; ?>" class="form-control" id="bank_account_number">
									<?php if ($error_bank_account_number): ?>
									<div class="help-block error"><?= $error_bank_account_number; ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="tab-pane" id="tab-commission">
					<?php if ($commissions): ?>
					<div class="alert alert-info"><?= $lang_text_balance; ?> <b><?= $balance; ?></b></div>
					<table class="table table-striped">
						<thead>
							<tr>
								<th><?= $lang_column_date_added; ?></th>
								<th><?= $lang_column_description; ?></th>
								<th class="text-right"><?= $column_amount; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($commissions as $commission) { ?>
							<tr>
								<td><?= $commission['date_added']; ?></td>
								<td><?= $commission['description']; ?></td>
								<td class="text-right"><?= $commission['amount']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
					<?php else: ?>
						<div class="alert alert-warning"><?= $lang_text_empty; ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-actions">
				<div class="form-actions-inner text-right">
					<input type="submit" class="btn btn-warning" value="<?= $lang_button_save; ?>">
				</div>
			</div>
		</form>
		</div>
		<?php endif; ?>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>