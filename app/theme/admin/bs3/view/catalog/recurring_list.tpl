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
			<div class="pull-left h2"><i class="hidden-xs fa fa-tablet"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<a href="<?= $insert; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_insert; ?></span></a>
				<button type="submit" form="form" formaction="<?= $delete; ?>" id="btn-delete" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></button>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="text-center" width="1"><input type="checkbox" onclick="$('input[name*=\'recurring_ids\']').attr('checked', this.checked)"></th>
					<th><?php if ($sort == 'rd.name') { ?>
					<a href="<?= $sort_name; ?>" class="<?= strtolower($order); ?>"><?= $lang_column_name; ?></a>
					<?php } else { ?>
					<a href="<?= $sort_name; ?>"><?= $lang_column_name; ?></a>
					<?php } ?></th>
					<th><?php if ($sort == 'r.sort_order') { ?>
					<a href="<?= $sort_sort_order; ?>" class="<?= strtolower($order); ?>"><?= $lang_column_sort_order; ?></a>
					<?php } else { ?>
					<a href="<?= $sort_sort_order; ?>"><?= $lang_column_sort_order; ?></a>
					<?php } ?></th>
					<th class="text-right"><?= $lang_column_action ?></th>
				</tr>
			</thead>
			<tbody>
			<?php if ($recurrings) { ?>
				<?php foreach ($recurrings as $recurring) { ?>
				<tr>
					<td class="text-center"><input type="checkbox" name="recurring_ids[]" value="<?= $recurring['recurring_id'] ?>"></td>
					<td><?= $recurring['name'] ?></td>
					<td><?= $recurring['sort_order'] ?></td>
					<td class="text-right">
						<a class="btn btn-default" href="<?= $recurring['edit']; ?>">
							<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $lang_button_edit; ?></span>
						</a>
					</td>
				</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td class="text-center" colspan="4"><?= $lang_text_no_results; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		</form>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?>