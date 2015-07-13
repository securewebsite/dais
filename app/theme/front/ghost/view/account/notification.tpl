<?= $header; ?>
<?php if ($error_warning) { ?>
<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $success; ?></div>
<?php } ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-notifications" data-toggle="tab"><?= $lang_tab_notifications; ?></a></li>
			<li><a href="#tab-settings" data-toggle="tab"><?= $lang_tab_settings; ?></a></li>
		</ul>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
			<div class="tab-content">
				<div class="tab-pane active" id="tab-notifications">
					<div class="row">
						<div class="col-sm-12" id="read-panel">
							<div class="pull-right">
								<button id="reader-close" class="btn btn-default"><?= $lang_button_close; ?></button>
							</div>
							<div id="reader"></div>
							<hr>
						</div>
						<div class="col-sm-12" id="inbox"></div>
					</div>
				</div>
				<div class="tab-pane" id="tab-settings">
					<div class="row">
						<div class="col-sm-12" id="notifications">
							<p><?= $lang_text_settings; ?></p>
							<hr>
							<?php foreach($notifications as $notify): ?>
							<div class="row">
								<div class="col-sm-6"><?= $notify['description']; ?>:</div>
								<div class="col-sm-6">
									<?php foreach($notify['content'] as $key => $value): ?>
									<div class="checkbox checkbox-inline">
										<label>
											<?php if ($value['value'] == 1): ?>
											<input type="checkbox" name="notification[<?= $notify['id']; ?>][<?= $key; ?>]" value="<?= $value['value']; ?>" checked><?= $value['title']; ?>
											<?php else: ?>
											<input type="checkbox" name="notification[<?= $notify['id']; ?>][<?= $key; ?>]" value="<?= $value['value']; ?>"><?= $value['title']; ?>
											<?php endif; ?>
										</label>
									</div>
									<?php endforeach; ?>	
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="form-actions">
						<div class="form-actions-inner text-right">
							<a href="<?= $back; ?>" class="btn btn-default pull-left"><?= $lang_button_back; ?></a>
							<button type="submit" class="btn btn-primary"><?= $lang_button_save; ?></button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>