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
			<div class="pull-left h2"><i class="hidden-xs fa fa-undo"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<a href="<?= $insert; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_insert; ?></span></a>
				<button type="submit" form="form" formaction="<?= $delete; ?>" id="btn-delete" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></button>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-inline" action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
						<th class="text-right hidden-xs"><a href="<?= $sort_return_id; ?>"><?= $lang_column_return_id; echo ($sort == 'r.return_id') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="text-right hidden-xs"><a href="<?= $sort_order_id; ?>"><?= $lang_column_order_id; echo ($sort == 'r.order_id') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th><a href="<?= $sort_customer; ?>"><?= $lang_column_customer; echo ($sort == 'customer') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="col-sm-2 hidden-xs"><a href="<?= $sort_product; ?>"><?= $lang_column_product; echo ($sort == 'r.product') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th><a href="<?= $sort_status; ?>"><?= $lang_column_status; echo ($sort == 'status') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_date_added; ?>"><?= $lang_column_date_added; echo ($sort == 'r.date_added') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_date_modified; ?>"><?= $lang_column_date_modified; echo ($sort == 'r.date_modified') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="col-sm-1 text-right"><span class="hidden-xs"><?= $lang_column_action; ?></span></th>
					</tr>
				</thead>
				<tbody data-link="row" class="rowlink">
					<tr id="filter" class="info">
						<td class="text-center"><a class="btn btn-default btn-block" href="index.php?route=sale/return" rel="tooltip" title="Reset"><i class="fa fa-power-off fa-fw"></i></a></td>
						<td class="text-right hidden-xs"><input type="text" name="filter_return_id" value="<?= $filter_return_id; ?>" class="form-control text-right"></td>
						<td class="text-right hidden-xs"><input type="text" name="filter_order_id" value="<?= $filter_order_id; ?>" class="form-control text-right"></td>
						<td><input type="text" name="filter_customer" value="<?= $filter_customer; ?>" class="form-control" data-target="name" data-url="people/customer" class="form-control"></td>
						<td class="hidden-xs"><input type="text" name="filter_product" value="<?= $filter_product; ?>" class="form-control" data-target="name" data-url="catalog/product" class="form-control"></td>
						<td><select name="filter_return_status_id" class="form-control">
							<option value="*">&ndash;</option>
							<?php foreach ($return_statuses as $return_status) { ?>
							<?php if ($return_status['return_status_id'] == $filter_return_status_id) { ?>
							<option value="<?= $return_status['return_status_id']; ?>" selected><?= $return_status['name']; ?></option>
							<?php } else { ?>
							<option value="<?= $return_status['return_status_id']; ?>"><?= $return_status['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select></td>
						<td class="hidden-xs"><label class="input-group">
							<input type="text" name="filter_date_added" value="<?= $filter_date_added; ?>" class="form-control date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</label></td>
						<td class="hidden-xs"><label class="input-group">
							<input type="text" name="filter_date_modified" value="<?= $filter_date_modified; ?>" class="form-control date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</label></td>
						<td class="text-right"><button type="button" onclick="filter();" class="btn btn-info"><i class="fa fa-search"></i><span class="hidden-xs"> <?= $lang_button_filter; ?></span></button></td>
					</tr>
					<?php if ($returns) { ?>
					<?php foreach ($returns as $return) { ?>
					<tr>
						<td class="rowlink-skip text-center"><?php if ($return['selected']) { ?>
							<input type="checkbox" name="selected[]" value="<?= $return['return_id']; ?>" checked="">
							<?php } else { ?>
							<input type="checkbox" name="selected[]" value="<?= $return['return_id']; ?>">
							<?php } ?></td>
						<td class="text-right hidden-xs"><?= $return['return_id']; ?></td>
						<td class="text-right hidden-xs"><?= $return['order_id']; ?></td>
						<td><?= $return['customer']; ?></td>
						<td class="hidden-xs"><?= $return['product']; ?></td>
						<td class="text-<?= strtolower($return['status']); ?>"><?= $return['status']; ?></td>
						<td class="hidden-xs"><?= $return['date_added']; ?></td>
						<td class="hidden-xs"><?= $return['date_modified']; ?></td>
						<td class="text-right"><?php foreach ($return['action'] as $action) { ?>
							<a class="btn btn-default" href="<?= $action['href']; ?>">
								<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span>
							</a>
							<?php } ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td class="text-center" colspan="9"><?= $lang_text_no_results; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?> 