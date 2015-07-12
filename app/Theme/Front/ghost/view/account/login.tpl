<?= $header; ?>
<?php if ($success) { ?>
<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $success; ?></div>
<?php } ?>
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
		<ul class="nav nav-tabs">
			<li class="active"><a href="#"><?= $lang_text_returning_customer; ?></a></li>
			<li><a href="<?= $register; ?>"><?= $lang_text_new_customer; ?></a></li>
		</ul>
		<div class="tab-content">
			<p class="alert alert-warning"><?= $lang_text_i_am_returning_customer; ?></p>
			<div class="row">
				<div class="col-sm-6">
					<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label class="control-label col-sm-4" for="email"><?= $lang_entry_email; ?></label>
							<div class="col-sm-8">
								<input type="text" name="email" value="<?= $email; ?>" class="form-control" placeholder="<?= $lang_entry_email; ?>"  id="email" autofocus>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="password"><?= $lang_entry_password; ?></label>
							<div class="col-sm-8">
								<input type="password" name="password" value="<?= $password; ?>" class="form-control" placeholder="<?= $lang_entry_password; ?>"  id="password">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-4">
								<a href="<?= $forgotten; ?>"><?= $lang_text_forgotten; ?></a>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-4">
								<button type="submit" class="btn btn-primary"><?= $lang_button_login; ?></button>
							</div>
						</div>
						<?php if ($redirect) { ?>
						<input type="hidden" name="redirect" value="<?= $redirect; ?>">
						<?php } ?>
					</form>
				</div>
				<div class="col-sm-6">
					<p class="h3" style="margin-top:0;"><?= $lang_text_register; ?></p>
					<p><?= $lang_text_register_account; ?></p>
					<p><a href="<?= $register; ?>" class="btn btn-warning"><?= $lang_button_continue; ?></a></p>
				</div>
			</div>
		</div>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>