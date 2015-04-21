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
		<div class="pull-left h2"><i class="hidden-xs fa fa-users"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right">
			<a href="<?= $presenters; ?>" class="btn btn-success">
				<i class="fa fa-user"></i> <?= $lang_button_presenters; ?></a>
			<a href="<?= $insert; ?>" class="btn btn-primary">
				<i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_insert; ?></span></a>
			<button type="submit" form="form" formaction="<?= $delete; ?>" id="btn-delete" class="btn btn-danger">
				<i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></button>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-inline" action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
						<th><?= $lang_column_event_name; ?></th>
						<th><?= $lang_column_presenter; ?></th>
						<th><?= $lang_column_date_time; ?></th>
						<th><?= $lang_column_location; ?></th>
						<th><?= $lang_column_visibility; ?></th>
						<th><?= $lang_column_cost; ?></th>
						<th><?= $lang_column_seats; ?></th>
						<th><?= $lang_column_filled; ?></th>
						<th><?= $lang_column_waitlist; ?></th>
						<th class="text-right"><?= $lang_column_action; ?></th>
					</tr>
				</thead>
				<tbody>
				<?php if ($events): ?>
				<?php foreach ($events as $event): ?>
					<tr>
						<td class="text-center">
							<?php if ($event['selected']): ?>
							<input type="checkbox" name="selected[]" value="<?= $event['event_id']; ?>" checked>
							<?php else: ?>
							<input type="checkbox" name="selected[]" value="<?= $event['event_id']; ?>">
							<?php endif; ?>
						</td>
						<td><?= $event['event_name']; ?></td>
						<td><?= $event['presenter']; ?></td>
						<td><?= $event['date_time']; ?></td>
						<td><?= $event['location']; ?></td>
						<td><?= $event['visibility']; ?></td>
						<td><?= $event['cost']; ?></td>
						<td><?= $event['seats']; ?></td>
						<td><?= $event['filled']; ?></td>
						<td><a href="<?= $event['waitlist_href']; ?>"><?= $event['waitlist']; ?></a></td>
						<td class="text-right">
							<?php foreach ($event['action'] as $action): ?>
							<a class="btn btn-default" href="<?= $action['href']; ?>">
								<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span></a>
							<?php endforeach; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td class="text-center" colspan="11"><?= $lang_text_no_results; ?></td>
					</tr>	
				<?php endif; ?>
				</tbody>
			</table>
		</form>
		<!-- // pagination -->
	</div>
</div>
<?= $footer; ?>