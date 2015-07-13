<?= $header; ?>
<?= $breadcrumb; ?>
<?php if (!empty($error_warning)): ?>
<div class="alert alert-danger"><?= $error_warning; ?><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
<div class="alert alert-success"><?= $success; ?><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
<?php endif; ?>
<div class="panel panel-default">
	<div class="panel-heading">
      <div class="clearfix">
			<div class="pull-left h2"><i class="hidden-xs fa fa-retweet"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_facebook; ?></label>
				<div class="col-sm-6">
					<?php if ($facebook_enabled): ?>
						<label class="radio-inline">
							<input type="radio" name="facebook_enabled" value="1" checked=""><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="facebook_enabled" value="0"><?= $lang_text_disabled; ?></label>
						<?php else: ?>
						<label class="radio-inline">
							<input type="radio" name="facebook_enabled" value="1"><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="facebook_enabled" value="0" checked=""><?= $lang_text_disabled; ?></label>
						<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_twitter; ?></label>
				<div class="col-sm-6">
					<?php if ($twitter_enabled): ?>
						<label class="radio-inline">
							<input type="radio" name="twitter_enabled" value="1" checked=""><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="twitter_enabled" value="0"><?= $lang_text_disabled; ?></label>
						<?php else: ?>
						<label class="radio-inline">
							<input type="radio" name="twitter_enabled" value="1"><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="twitter_enabled" value="0" checked=""><?= $lang_text_disabled; ?></label>
						<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_google; ?></label>
				<div class="col-sm-6">
					<?php if ($google_enabled): ?>
						<label class="radio-inline">
							<input type="radio" name="google_enabled" value="1" checked=""><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="google_enabled" value="0"><?= $lang_text_disabled; ?></label>
						<?php else: ?>
						<label class="radio-inline">
							<input type="radio" name="google_enabled" value="1"><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="google_enabled" value="0" checked=""><?= $lang_text_disabled; ?></label>
						<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_linkedin; ?></label>
				<div class="col-sm-6">
					<?php if ($linkedin_enabled): ?>
						<label class="radio-inline">
							<input type="radio" name="linkedin_enabled" value="1" checked=""><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="linkedin_enabled" value="0"><?= $lang_text_disabled; ?></label>
						<?php else: ?>
						<label class="radio-inline">
							<input type="radio" name="linkedin_enabled" value="1"><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="linkedin_enabled" value="0" checked=""><?= $lang_text_disabled; ?></label>
						<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_pinterest; ?></label>
				<div class="col-sm-6">
					<?php if ($pinterest_enabled): ?>
						<label class="radio-inline">
							<input type="radio" name="pinterest_enabled" value="1" checked=""><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="pinterest_enabled" value="0"><?= $lang_text_disabled; ?></label>
						<?php else: ?>
						<label class="radio-inline">
							<input type="radio" name="pinterest_enabled" value="1"><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="pinterest_enabled" value="0" checked=""><?= $lang_text_disabled; ?></label>
						<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_tumblr; ?></label>
				<div class="col-sm-6">
					<?php if ($tumblr_enabled): ?>
						<label class="radio-inline">
							<input type="radio" name="tumblr_enabled" value="1" checked=""><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="tumblr_enabled" value="0"><?= $lang_text_disabled; ?></label>
						<?php else: ?>
						<label class="radio-inline">
							<input type="radio" name="tumblr_enabled" value="1"><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="tumblr_enabled" value="0" checked=""><?= $lang_text_disabled; ?></label>
						<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_digg; ?></label>
				<div class="col-sm-6">
					<?php if ($digg_enabled): ?>
						<label class="radio-inline">
							<input type="radio" name="digg_enabled" value="1" checked=""><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="digg_enabled" value="0"><?= $lang_text_disabled; ?></label>
						<?php else: ?>
						<label class="radio-inline">
							<input type="radio" name="digg_enabled" value="1"><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="digg_enabled" value="0" checked=""><?= $lang_text_disabled; ?></label>
						<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_stumbleupon; ?></label>
				<div class="col-sm-6">
					<?php if ($stumbleupon_enabled): ?>
						<label class="radio-inline">
							<input type="radio" name="stumbleupon_enabled" value="1" checked=""><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="stumbleupon_enabled" value="0"><?= $lang_text_disabled; ?></label>
						<?php else: ?>
						<label class="radio-inline">
							<input type="radio" name="stumbleupon_enabled" value="1"><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="stumbleupon_enabled" value="0" checked=""><?= $lang_text_disabled; ?></label>
						<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_delicious; ?></label>
				<div class="col-sm-6">
					<?php if ($delicious_enabled): ?>
						<label class="radio-inline">
							<input type="radio" name="delicious_enabled" value="1" checked=""><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="delicious_enabled" value="0"><?= $lang_text_disabled; ?></label>
						<?php else: ?>
						<label class="radio-inline">
							<input type="radio" name="delicious_enabled" value="1"><?= $lang_text_enabled; ?></label>
						<label class="radio-inline">
							<input type="radio" name="delicious_enabled" value="0" checked=""><?= $lang_text_disabled; ?></label>
						<?php endif; ?>
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>