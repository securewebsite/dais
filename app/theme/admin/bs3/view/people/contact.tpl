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
		<div class="pull-left h2"><i class="hidden-xs fa fa-envelope"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right">
			<button type="button" id="button-send" data-url="index.php?route=people/contact/send" class="btn btn-primary load-left"><i class="fa fa-envelope"></i> <?= $lang_button_send; ?></button>
			<a class="btn btn-warning" href="<?= $cancel; ?>"><i class="fa fa-ban"></i> <?= $lang_button_cancel; ?></a>
		</div>
	</div>
	<div class="panel-body">
		<form id="contact-form">
		<div id="mail" class="form-horizontal">
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_store; ?></label>
				<div class="control-field col-sm-4">
					<select name="store_id" class="form-control">
						<option value="0"><?= $lang_text_default; ?></option>
						<?php foreach ($stores as $store) { ?>
						<option value="<?= $store['store_id']; ?>"><?= $store['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_to; ?></label>
				<div class="control-field col-sm-4">
					<select name="to" class="form-control">
						<option value="newsletter"><?= $lang_text_newsletter; ?></option>
						<option value="customer_all"><?= $lang_text_customer_all; ?></option>
						<option value="customer_group"><?= $lang_text_customer_group; ?></option>
						<option value="customer"><?= $lang_text_customer; ?></option>
						<option value="affiliate_all"><?= $lang_text_affiliate_all; ?></option>
						<option value="affiliate"><?= $lang_text_affiliate; ?></option>
						<option value="product"><?= $lang_text_product; ?></option>
					</select>
				</div>
			</div>
			<div class="form-group to" id="to-customer-group">
				<label class="control-label col-sm-2"><?= $lang_entry_customer_group; ?></label>
				<div class="control-field col-sm-4">
					<select name="customer_group_id" class="form-control">
						<?php foreach ($customer_groups as $customer_group) { ?>
						<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group to" id="to-customer">
				<label class="control-label col-sm-2" for="customers"><?= $lang_entry_customer; ?></label>
				<div class="control-field col-sm-4">
					<p><input type="text" name="customers" value="" class="form-control" id="customers" class="form-control"></p>
					<div id="customer" class="panel panel-default panel-scrollable">
						<div class="list-group"></div>
					</div>
				</div>
			</div>
			<div class="form-group to" id="to-affiliate">
				<label class="control-label col-sm-2" for="affiliates"><?= $lang_entry_affiliate; ?></label>
				<div class="control-field col-sm-4">
					<p><input type="text" name="affiliates" value="" class="form-control" id="affiliates" class="form-control"></p>
					<div id="affiliate" class="panel panel-default panel-scrollable">
						<div class="list-group"></div>
					</div>
				</div>
			</div>
			<div class="form-group to" id="to-product">
				<label class="control-label col-sm-2" for="products"><?= $lang_entry_product; ?></label>
				<div class="control-field col-sm-4">
					<p><input type="text" name="products" value="" class="form-control" id="products" class="form-control"></p>
					<div id="product" class="panel panel-default panel-scrollable">
						<div class="list-group"></div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="subject"><b class="required">*</b> <?= $lang_entry_subject; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="subject" value="" class="form-control" id="subject" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="contact_html"><b class="required">*</b> <?= $lang_entry_html; ?></label>
				<div class="control-field col-sm-8">
					<textarea name="contact_html" class="summernote form-control" rows="10" spellcheck="false" id="contact-html"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="contact_text"><b class="required">*</b> <?= $lang_entry_text; ?></label>
				<div class="col-sm-8">
					<textarea name="contact_text" class="form-control" rows="6" id="contact-text"></textarea>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<?= $footer; ?>