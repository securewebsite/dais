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
		<div class="pull-left h2"><i class="fa fa-th-list"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right">
			<a href="<?= $insert; ?>" class="btn btn-primary">
				<i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_insert; ?></span>
			</a>
			<button type="submit" form="form" id="btn-delete" class="btn btn-danger">
				<i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span>
			</button>
		</div>
	</div>
	<div class="panel-body">
		<form action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
						<th><?= $lang_column_name; ?></th>
						<th><?= $lang_column_type; ?></th>
						<th class="hidden-xs"><?= $lang_column_status; ?></th>
						<th class="text-right"><span class="hidden-xs"><?= $lang_column_action; ?></span></th>
					</tr>
				</thead>
				<tbody data-link="row" class="rowlink">
					<?php if ($menus) { ?>
					<?php foreach ($menus as $menu) { ?>
					<tr>
						<td class="rowlink-skip text-center">
							<?php if ($menu['selected']): ?>
							<input type="checkbox" name="selected[]" value="<?= $menu['menu_id']; ?>" checked>
							<?php else: ?>
							<input type="checkbox" name="selected[]" value="<?= $menu['menu_id']; ?>">
							<?php endif; ?>
						</td>
						<td><?= $menu['name']; ?></td>
						<td><?= $menu['type']; ?></td>
						<td class="hidden-xs text-<?= strtolower($menu['status']); ?>"><?= $menu['status'] ?></td>
						<td class="text-right"><?php foreach ($menu['action'] as $action) { ?>
							<a class="btn btn-default" href="<?= $action['href']; ?>">
								<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span>
							</a>
							<?php } ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td class="text-center" colspan="5"><?= $lang_text_no_results; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?>