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
			<div class="pull-left h2"><i class="hidden-xs fa fa-user"></i><?= $lang_text_presenter_tab; ?></div>
			<div class="pull-right">
				<a href="<?= $insert; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_insert; ?></span></a>
				<button type="submit" form="form" formaction="<?= $delete; ?>" id="btn-delete" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></button>
				<a onclick="location = '<?= $cancel; ?>';" class="btn btn-warning"><?= $lang_button_cancel; ?></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-inline" action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
						<th><?= $lang_column_image; ?></th>
						<th><?= $lang_column_presenter; ?></th>
						<th><?= $lang_column_facebook; ?></th>
						<th><?= $lang_column_twitter; ?></th>
						<th><?= $lang_column_bio; ?></th>
						<th class="text-right"><?= $lang_column_action; ?></th>
					</tr>
				</thead>
				<tbody data-link="row" class="rowlink">
					<?php if ($presenters) { ?>
					<?php foreach ($presenters as $presenter) { ?>
					<tr>
						<td width="40" class="rowlink-skip text-center">
							<input type="checkbox" name="selected[]" value="<?= $presenter['presenter_id']; ?>" />
						</td>
						<td><img class="img-thumbnail" src="<?= $presenter['image']; ?>" alt="<?= $presenter['presenter_name']; ?>"></td>
						<td nowrap><?= $presenter['presenter_name']; ?></td>
						<td><?= $presenter['facebook']; ?></td>
						<td><?= $presenter['twitter']; ?></td>
						<td><?= $presenter['bio']; ?></td>
						<td class="text-right">
						<?php foreach ($presenter['action'] as $action) { ?>
							<a class="btn btn-default" href="<?= $action['href']; ?>">
								<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span></a>
						<?php } ?>
						</td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td class="text-center" colspan="7"><?= $lang_text_no_presenters; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
		<!-- pagination -->
	</div>
</div>
<?= $footer; ?>