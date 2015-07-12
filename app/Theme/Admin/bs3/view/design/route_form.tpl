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
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<table id="route" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><?= $lang_entry_route; ?></th>
						<th><?= $lang_entry_slug; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php $route_row = 0; ?>
				<?php foreach ($custom_routes as $custom_route) { ?>
					<tr id="route-row<?= $route_row; ?>">
						<td><input type="text" name="custom_route[<?= $route_row; ?>][route]" value="<?= $custom_route['route']; ?>" class="form-control"></td>
						<td><input type="text" name="custom_route[<?= $route_row; ?>][slug]" value="<?= $custom_route['slug']; ?>" class="form-control"></td>
						<td><a onclick="$('#route-row<?= $route_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
					</tr>
				<?php $route_row++; ?>
				<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"></td>
						<td><a onclick="addRoute();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_route; ?></span></a></td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</div>
<script>var route_row=<?= $route_row; ?>;</script>
<?= $footer; ?>