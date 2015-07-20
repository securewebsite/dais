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
		<div class="pull-left h2"><i class="hidden-xs fa fa-shopping-cart"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right">
			<button type="submit" form="form" formtarget="_blank" class="btn btn-success btn-spacer"><i class="fa fa-print"></i><span class="hidden-xs"> <?= $lang_button_invoice; ?></span></button>
			<a href="<?= $insert; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_insert; ?></span></a>
			<button type="submit" form="form" formaction="<?= $delete; ?>" id="btn-delete" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></button>
		</div>
	</div>
	<div class="panel-body">
		<form class="foe" action="<?= $invoice; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
						<th class="text-right"><a href="<?= $sort_order; ?>"><?= $lang_column_order_id; echo ($sort == 'o.order_id') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th><a href="<?= $sort_customer; ?>"><?= $lang_column_customer; echo ($sort == 'customer') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_status; ?>"><?= $lang_column_status; echo ($sort == 'status') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="text-right hidden-xs"><a href="<?= $sort_total; ?>"><?= $lang_column_total; echo ($sort == 'o.total') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_date_added; ?>"><?= $lang_column_date_added; echo ($sort == 'o.date_added') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs hidden-sm"><a href="<?= $sort_date_modified; ?>"><?= $lang_column_date_modified; echo ($sort == 'o.date_modified') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="text-right"><span class="hidden-xs"><?= $lang_column_action; ?></span></th>
					</tr>
				</thead>
				<tbody data-link="row" class="rowlink">
					<tr id="filter" class="info">
						<td class="text-center"><a class="btn btn-default btn-block" href="sale/order" rel="tooltip" title="Reset"><i class="fa fa-power-off fa-fw"></i></a></td>
						<td class="text-right"><input type="text" name="filter_order_id" value="<?= $filter_order_id; ?>" class="form-control text-right"></td>
						<td><input type="text" name="filter_customer" value="<?= $filter_customer; ?>" class="form-control" data-target="name" data-url="people/customer" class="form-control"></td>
						<td class="hidden-xs"><select name="filter_order_status_id" class="form-control">
							<option value="*">&ndash;</option>
							<?php if ($filter_order_status_id == '0') { ?>
							<option value="0" selected><?= $lang_text_missing; ?></option>
							<?php } else { ?>
							<option value="0"><?= $lang_text_missing; ?></option>
							<?php } ?>
							<?php foreach ($order_statuses as $order_status) { ?>
							<?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
							<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select></td>
						<td class="text-right hidden-xs"><input type="text" name="filter_total" value="<?= $filter_total; ?>" class="form-control text-right"></td>
						<td class="hidden-xs"><label class="input-group">
							<input type="text" name="filter_date_added" value="<?= $filter_date_added; ?>" class="form-control date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</label></td>
						<td class="hidden-xs hidden-sm"><label class="input-group">
							<input type="text" name="filter_date_modified" value="<?= $filter_date_modified; ?>" class="form-control date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</label></td>
						<td class="text-right"><button type="button" onclick="filter();" class="btn btn-info"><i class="fa fa-search"></i><span class="hidden-xs"> <?= $lang_button_filter; ?></span></button></td>
					</tr>
					<?php if ($orders) { ?>
					<?php foreach ($orders as $order) { ?>
					<tr>
						<td class="rowlink-skip text-center"><?php if ($order['selected']) { ?>
							<input type="checkbox" name="selected[]" value="<?= $order['order_id']; ?>" checked="">
							<?php } else { ?>
							<input type="checkbox" name="selected[]" value="<?= $order['order_id']; ?>">
							<?php } ?></td>
						<td class="text-right"><?= $order['order_id']; ?></td>
						<td><?= $order['customer']; ?></td>
						<td class="hidden-xs text-<?= strtolower($order['status']); ?>"><?= $order['status']; ?></td>
						<td class="text-right hidden-xs"><?= $order['total']; ?></td>
						<td class="hidden-xs"><?= $order['date_added']; ?></td>
						<td class="hidden-xs hidden-sm"><?= $order['date_modified']; ?></td>
						<td class="text-right"><?php foreach ($order['action'] as $action) { ?>
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
		</form>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?>