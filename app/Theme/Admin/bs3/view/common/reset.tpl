<?= $header; ?>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
			<?php if ($success): ?>
			<div class="alert alert-success"><?= $success; ?>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
			<?php endif; ?>
			<?php if ($error_warning): ?>
			<div class="alert alert-danger"><?= $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
			<?php endif; ?>
			<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="well well-lg">
				<p class="lead"><?= $lang_text_password; ?></p>
				<div class="form-group">
					<label><?= $lang_entry_password; ?></label>
					<input type="password" name="password" class="form-control" value="<?= $password; ?>">
					<?php if ($error_password): ?>
						<div class="help-block error"><?= $error_password; ?></div>
					<?php endif; ?>
				</div>
				<div class="form-group">
					<label><?= $lang_entry_confirm; ?></label>
					<input type="password" name="confirm" class="form-control" value="<?= $confirm; ?>">
					<?php if ($error_confirm): ?>
						<div class="help-block error"><?= $error_confirm; ?></div>
					<?php endif; ?>
				</div>
				<hr>
				<button type="submit" class="btn btn-primary"><?= $lang_button_save; ?></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>"><i class="fa fa-ban"></i> <?= $lang_button_cancel; ?></a>
			</div>
			</form>
		</div>
	</div>
</div>
<?= $footer; ?>