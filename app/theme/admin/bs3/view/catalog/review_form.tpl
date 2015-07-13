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
			<div class="pull-left h2"><i class="hidden-xs fa fa-comments"></i><?= $lang_heading_title; ?></div>
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
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_author; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="author" value="<?= $author; ?>" class="form-control">
					<?php if ($error_author) { ?>
					<div class="help-block error"><?= $error_author; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_product; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="product" value="<?= $product; ?>" id="review-product" autocomplete="off" class="form-control">
					<input type="hidden" name="product_id" value="<?= $product_id; ?>">
					<?php if ($error_product) { ?>
					<div class="help-block error"><?= $error_product; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_text; ?></label>
				<div class="control-field col-sm-8">
					<textarea name="text" class="form-control" rows="6"><?= $text; ?></textarea>
					<?php if ($error_text) { ?>
					<div class="help-block error"><?= $error_text; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_rating; ?></label>
				<div class="control-field col-sm-4">
					<div class="btn-group" data-toggle="buttons">
						<?php for ($i=1;$i<=5;$i++){ ?>
							<?php if ($i == $rating) { ?>
								<label class="btn btn-default active"><input type="radio" class="hide" name="rating" value="<?= $i; ?>" checked=""><?= $i; ?></label>
							<?php } else { ?>
								<label class="btn btn-default"><input type="radio" class="hide" name="rating" value="<?= $i; ?>"><?= $i; ?></label>
							<?php } ?>
						<?php } ?>
					</div>
					<?php if ($error_rating) { ?>
						<div class="help-block error"><?= $error_rating; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
				<div class="control-field col-sm-4">
					<div class="btn-group" data-toggle="buttons">
						<?php if ($status){ ?>
						<label class="btn btn-default active" title="<?= $lang_text_enabled; ?>"><input type="radio" name="status" value="1" checked=""><i class="fa fa-play"></i></label>
						<label class="btn btn-default" title="<?= $lang_text_disabled; ?>"><input type="radio" name="status" value="0"><i class="fa fa-pause"></i></label>
						<?php } else { ?>
						<label class="btn btn-default" title="<?= $lang_text_enabled; ?>"><input type="radio" name="status" value="1"><i class="fa fa-play"></i></label>
						<label class="btn btn-default active" title="<?= $lang_text_disabled; ?>"><input type="radio" name="status" value="0" checked=""><i class="fa fa-pause"></i></label>
						<?php } ?>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>