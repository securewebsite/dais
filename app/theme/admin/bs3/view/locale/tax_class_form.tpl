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
			<div class="pull-left h2"><i class="hidden-xs fa fa-money"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_title; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="title" value="<?= $title; ?>" class="form-control" autofocus>
					<?php if ($error_title) { ?>
						<div class="help-block error"><?= $error_title; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_description; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="description" value="<?= $description; ?>" class="form-control">
					<?php if ($error_description) { ?>
						<div class="help-block error"><?= $error_description; ?></div>
					<?php } ?>
				</div>
			</div>
			<table id="tax-rule" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><?= $lang_entry_rate; ?></th>
						<th><?= $lang_entry_based; ?></th>
						<th><?= $lang_entry_priority; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php $tax_rule_row = 0; ?>
				<?php foreach ($tax_rules as $tax_rule) { ?>
					<tr id="tax-rule-row<?= $tax_rule_row; ?>">
						<td><select name="tax_rule[<?= $tax_rule_row; ?>][tax_rate_id]" class="form-control">
							<?php foreach ($tax_rates as $tax_rate) { ?>
							<?php	if ($tax_rate['tax_rate_id'] == $tax_rule['tax_rate_id']) { ?>
							<option value="<?= $tax_rate['tax_rate_id']; ?>" selected><?= $tax_rate['name']; ?></option>
							<?php } else { ?>
							<option value="<?= $tax_rate['tax_rate_id']; ?>"><?= $tax_rate['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select></td>
						<td><select name="tax_rule[<?= $tax_rule_row; ?>][based]" class="form-control">
							<?php	if ($tax_rule['based'] == 'shipping') { ?>
							<option value="shipping" selected><?= $lang_text_shipping; ?></option>
							<?php } else { ?>
							<option value="shipping"><?= $lang_text_shipping; ?></option>
							<?php } ?>
							<?php	if ($tax_rule['based'] == 'payment') { ?>
							<option value="payment" selected><?= $lang_text_payment; ?></option>
							<?php } else { ?>
							<option value="payment"><?= $lang_text_payment; ?></option>
							<?php } ?>	
							<?php	if ($tax_rule['based'] == 'store'){ ?>
							<option value="store" selected><?= $lang_text_store; ?></option>
							<?php } else { ?>
							<option value="store"><?= $lang_text_store; ?></option>
							<?php } ?>												
						</select></td>
						<td><input type="text" name="tax_rule[<?= $tax_rule_row; ?>][priority]" value="<?= $tax_rule['priority']; ?>" class="form-control"></td>
						<td><a onclick="$('#tax-rule-row<?= $tax_rule_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
					</tr>
				<?php $tax_rule_row++; ?>
				<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"></td>
						<td><a onclick="addRule();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs">	<?= $lang_button_add_rule; ?></span></a></td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</div>
<script>var tax_rule_row=<?= $tax_rule_row; ?>;</script>
<?= $footer; ?>