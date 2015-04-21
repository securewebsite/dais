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
			<div class="pull-left h2"><i class="hidden-xs fa fa-users"></i><?= $lang_column_waitlist; ?></div>
			<div class="pull-right">
				<a class="btn btn-danger" href="<?= $clear_list; ?>">
				<i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_clear_list; ?></span></a>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th><?= $lang_column_attendee; ?></th>
					<th class="text-right"><?= $lang_column_action; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($attendees): ?>
				<?php foreach ($attendees as $attendee): ?>
				<tr>
					<td><?= $attendee['attendee']; ?></td>
					<td class="text-right">
						<?php foreach ($attendee['action'] as $action): ?>
							<a class="btn btn-default" href="<?= $action['href']; ?>">
								<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span></a>
						<?php endforeach; ?>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td class="text-center" colspan="2"><?= $lang_text_no_results2; ?></td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
<?= $footer; ?>