<?= $header; ?>
<?php if ($error_warning) { ?>
<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
<?php } ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend><?= $lang_text_your_details; ?></legend>
				<div class="form-group">
					<label class="control-label col-sm-3" for="username"><b class="required">*</b> <?= $lang_entry_username; ?></label>
					<div class="col-sm-6">
						<p class="form-control-static"><?= $username; ?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="firstname"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
					<div class="col-sm-6">
						<input type="text" name="firstname" value="<?= $firstname; ?>" class="form-control" placeholder="<?= $lang_entry_firstname; ?>"  autofocus id="firstname" required>
						<?php if ($error_firstname) { ?>
						<span class="help-block error"><?= $error_firstname; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="lastname"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
					<div class="col-sm-6">
						<input type="text" name="lastname" value="<?= $lastname; ?>" class="form-control" placeholder="<?= $lang_entry_lastname; ?>"  id="lastname" required>
						<?php if ($error_lastname) { ?>
						<span class="help-block error"><?= $error_lastname; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="email"><b class="required">*</b> <?= $lang_entry_email; ?></label>
					<div class="col-sm-6">
						<input type="text" name="email" value="<?= $email; ?>" class="form-control" placeholder="<?= $lang_entry_email; ?>"  id="email" required>
						<?php if ($error_email) { ?>
						<span class="help-block error"><?= $error_email; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="telephone"><b class="required">*</b> <?= $lang_entry_telephone; ?></label>
					<div class="col-sm-6">
						<input type="text" name="telephone" value="<?= $telephone; ?>" class="form-control" placeholder="<?= $lang_entry_telephone; ?>"  id="telephone" required>
						<?php if ($error_telephone) { ?>
						<span class="help-block error"><?= $error_telephone; ?></span>
						<?php } ?>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<div class="form-actions-inner text-right">
					<a href="<?= $back; ?>" class="btn btn-default pull-left"><?= $lang_button_back; ?></a>
					<button type="submit" class="btn btn-primary"><?= $lang_button_continue; ?></button>
				</div>
			</div>
		</form>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>