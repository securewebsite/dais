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
			<div class="pull-left h2"><i class="hidden-xs fa fa-user"></i><?= $lang_heading_title; ?></div>
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
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_name; ?></label>
				<div class="control-field col-sm-4">
					<?php foreach ($languages as $language) { ?>
						<div class="input-group"><input type="text" name="customer_group_description[<?= $language['language_id']; ?>][name]" value="<?= isset($customer_group_description[$language['language_id']]) ? $customer_group_description[$language['language_id']]['name'] :''; ?>" class="form-control">
						<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span>
						<?php if (isset($error_name[$language['language_id']])) { ?>
						<div class="help-block error"><?= $error_name[$language['language_id']]; ?></div>
						<?php } ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_description; ?></label>
				<div class="control-field col-sm-4">
				<?php foreach ($languages as $language) { ?>
					<div class="input-group"><textarea name="customer_group_description[<?= $language['language_id']; ?>][description]" class="form-control" rows="3"><?= isset($customer_group_description[$language['language_id']]) ? $customer_group_description[$language['language_id']]['description'] :''; ?></textarea>
					<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span></div>
				<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_approval; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($approval) { ?>
					<label class="radio-inline"><input type="radio" name="approval" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="approval" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="approval" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="approval" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_company_id_display; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($company_id_display) { ?>
					<label class="radio-inline"><input type="radio" name="company_id_display" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="company_id_display" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="company_id_display" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="company_id_display" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_company_id_required; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($company_id_required) { ?>
					<label class="radio-inline"><input type="radio" name="company_id_required" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="company_id_required" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="company_id_required" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="company_id_required" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_tax_id_display; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($tax_id_display) { ?>
					<label class="radio-inline"><input type="radio" name="tax_id_display" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="tax_id_display" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="tax_id_display" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="tax_id_display" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_tax_id_required; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($tax_id_required) { ?>
					<label class="radio-inline"><input type="radio" name="tax_id_required" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="tax_id_required" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="tax_id_required" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="tax_id_required" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_sort_order; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="sort_order" value="<?= $sort_order; ?>" class="form-control">
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>