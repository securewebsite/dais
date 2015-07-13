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
			<div class="pull-left h2"><i class="hidden-xs fa fa-filter"></i><?= $lang_heading_title; ?></div>
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
					<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
					<th><a href="<?= $sort_name; ?>"><?= $lang_column_group; echo ($sort == 'fgd.name') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
					<th class="text-right"><a href="<?= $sort_sort_order; ?>"><?= $lang_column_sort_order; echo ($sort == 'fg.sort_order') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
					<th class="text-right"><?= $lang_column_action; ?></th>
					</tr>
				</thead>
				<tbody data-link="row" class="rowlink">
					<?php if ($filters) { ?>
					<?php foreach ($filters as $filter) { ?>
					<tr>
					<td class="text-center"><?php if ($filter['selected']) { ?>
						<input type="checkbox" name="selected[]" value="<?= $filter['filter_group_id']; ?>" checked="">
						<?php } else { ?>
						<input type="checkbox" name="selected[]" value="<?= $filter['filter_group_id']; ?>">
						<?php } ?></td>
					<td><?= $filter['name']; ?></td>
					<td class="text-right"><?= $filter['sort_order']; ?></td>
					<td class="text-right"><?php foreach ($filter['action'] as $action) { ?>
						<a class="btn btn-default" href="<?= $action['href']; ?>">
								<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span>
							</a>
						<?php } ?></td>
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