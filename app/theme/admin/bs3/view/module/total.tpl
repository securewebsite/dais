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
		<div class="h2"><i class="fa fa-btc"></i><?= $lang_heading_total; ?></div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th><?= $lang_column_name; ?></th>
					<th class="hidden-xs"><?= $lang_column_status; ?></th>
					<th class="text-right hidden-xs"><?= $lang_column_sort_order; ?></th>
					<th class="text-right"><span class="hidden-xs"><?= $lang_column_action; ?></span></th>
				</tr>
			</thead>
			<tbody data-link="row" class="rowlink">
				<?php if ($modules) { ?>
				<?php foreach ($modules as $module) { ?>
				<tr>
					<td><?= $module['name']; ?></td>
					<td class="hidden-xs text-<?= strtolower($module['status']); ?>"><?= $module['status'] ?></td>
					<td class="text-right hidden-xs"><?= $module['sort_order']; ?></td>
					<td class="text-right"><?php foreach ($module['action'] as $action) { ?>
						<a class="btn btn-default" href="<?= $action['href']; ?>">
							<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span>
						</a>
						<?php } ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td class="text-center" colspan="8"><?= $lang_text_no_results; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?= $footer; ?>