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
			<div class="pull-left h2"><i class="hidden-xs fa fa-users"></i><?= $lang_text_roster; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" formaction="<?= $delete; ?>" id="btn-delete" class="btn btn-danger">
				<i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="row clearfix">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="alert alert-info text-center">
					<strong><?= $lang_text_event_name; ?></strong> <?= $event_name; ?> 
					<strong><?= $lang_text_seats; ?></strong> <?= $seats; ?> 
					<strong><?= $lang_text_available; ?></strong> <span id="available"><?= $available; ?></span>
				</div>
				<div id="response-warning" class="alert alert-danger" style="display:none;"></div>
				<div id="response-success" class="alert alert-success" style="display:none;"></div>
				<div class="form-group">
					<label class="control-label col-sm-3"><b class="required">*</b> <?= $lang_entry_customers; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="customer" value="" class="form-control">
						<input type="hidden" name="attendee_id" value="">
					</div>
					<div class="col-sm-5">
						<a id="add_attendee" class="btn btn-primary"><?= $lang_button_add_attendee; ?></a>
						<a id="add_waitlist" class="btn btn-info"><?= $lang_button_add_waitlist; ?></a>
					</div>
				</div>
			</div>
		</div>
		<br>
		<form class="form-inline" action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
						<th><?= $lang_column_attendee; ?></th>
						<th class="text-right"><?= $lang_column_date_added; ?></th>
					</tr>
				</thead>
				<tbody id="roster">
					<?php if ($attendees): ?>
					<?php foreach ($attendees as $attendee): ?>
					<tr>	
						<td class="text-center">
							<input type="checkbox" name="selected[]" value="<?= $attendee['attendee_id']; ?>">
						</td>
						<td><?= $attendee['name']; ?></td>
						<td class="text-right"><?= $attendee['date_added']; ?></td>
					</tr>
					<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td class="text-center" colspan="3"><?= $lang_text_no_attendees; ?></td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</form>
	</div>
</div>
<?= $footer; ?>