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
			<div class="pull-left h2"><i class="hidden-xs fa fa-th"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<a href="<?= $edit; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_edit; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-inline" action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th><?= $lang_column_route; ?></th>
						<th><?= $lang_column_slug; ?></th>
					</tr>
				</thead>
				<tbody class="rowlink">
					<?php if ($routes): ?>
					<?php foreach ($routes as $route): ?>
					<tr>
						<td><?= $route['route']; ?></td>
						<td><?= $route['slug']; ?></td>
					</tr>
					<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td class="text-center" colspan="2"><?= $lang_text_no_results; ?></td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</form>
		<div class="pagination"><?= str_replace('....', '', $pagination); ?></div>
	</div>
</div>
<?= $footer; ?>