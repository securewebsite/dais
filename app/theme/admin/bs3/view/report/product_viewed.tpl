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
		<div class="pull-left h2"><i class="hidden-xs fa fa-bar-chart-o"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right"><a href="<?= $reset; ?>" class="btn btn-default"><?= $lang_button_reset; ?></a></div>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th><?= $lang_column_name; ?></th>
					<th class="hidden-xs"><?= $lang_column_model; ?></th>
					<th class="text-right"><?= $lang_column_viewed; ?></th>
					<th class="text-right"><?= $lang_column_percent; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($products) { ?>
				<?php foreach ($products as $product) { ?>
				<tr>
					<td><?= $product['name']; ?></td>
					<td class="hidden-xs"><?= $product['model']; ?></td>
					<td class="text-right"><?= $product['viewed']; ?></td>
					<td class="text-right"><?= $product['percent']; ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td class="text-center" colspan="4"><?= $lang_text_no_results; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		</div>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?>