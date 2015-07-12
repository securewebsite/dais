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
		<div class="h2"><i class="fa fa-shopping-cart"></i><?= $lang_heading_title; ?></div>
	</div>
	<div class="panel-body">
		<form class="form-inline" action="" method="post" enctype="multipart/form-data" id="form">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>
						<a href="<?= $sort_order_recurring; ?>">
							<?= $lang_entry_order_recurring; ?><?= ($sort == 'or.order_recurring_id') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?>
						</a>
					</th>
					<th>
						<a href="<?= $sort_order; ?>">
							<?= $lang_entry_order_id; ?><?= ($sort == 'or.order_id') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?>
						</a>
					</th>
					<th>
						<a href="<?= $sort_reference; ?>">
							<?= $lang_entry_reference; ?><?= ($sort == 'or.reference') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?>
						</a>
					</th>
					<th>
						<a href="<?= $sort_customer; ?>">
							<?= $lang_entry_customer; ?><?= ($sort == 'customer') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?>
						</a>
					</th>
					<th class="hidden-xs">
						<a href="<?= $sort_date_added; ?>">
							<?= $lang_entry_date_added; ?><?= ($sort == 'or.added') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?>
						</a>
					</th>
					<th class="hidden-xs">
						<a href="<?= $sort_status; ?>">
							<?= $lang_entry_status; ?><?= ($sort == 'or.status') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?>
						</a>
					</th>
					<th class="text-right"><?= $lang_entry_action; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr id="filter" class="info">
					<td><input type="text" name="filter_order_recurring_id" value="<?= $filter_order_recurring_id ?>" class="form-control"></td>
					<td><input type="text" name="filter_order_id" value="<?= $filter_order_id ?>" class="form-control"></td>
					<td><input type="text" name="filter_payment_reference" value="<?= $filter_reference ?>" class="form-control"></td>
					<td><input type="text" name="filter_customer" value="<?= $filter_customer ?>" class="form-control"></td>
					<td class="hidden-xs"><label class="input-group">
						<input type="text" name="filter_date_added" value="<?= $filter_date_added; ?>" class="form-control date">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</label></td>
					<td class="hidden-xs"><select name="filter_status" class="form-control">
					<?php foreach ($statuses as $status => $text) { ?>
						<?php if ($filter_status == $status) { ?>
							<option value="<?= $status ?>" selected><?= $text ?></option>
						<?php } else { ?>
							<option value="<?= $status ?>"><?= $text ?></option>
						<?php } ?>
					<?php } ?>
					</select></td>
					<td class="text-right"><a onclick="filter();" class="btn btn-info"><i class="fa fa-search"></i><span class="hidden-xs"> <?= $lang_text_filter; ?></span></a></td>
				</tr>
			<?php if ($recurrings) { ?>
			<?php foreach ($recurrings as $recurring) { ?>
			<tr>
				<td><?= $recurring['order_recurring_id'] ?></td>
				<td><a href="<?= $recurring['order_link'] ?>"><?= $recurring['order_id'] ?></a></td>
				<td><?= $recurring['reference'] ?></td>
				<td><?= $recurring['customer'] ?></td>
				<td class="hidden-xs"><?= $recurring['date_added'] ?></td>
				<td class="hidden-xs"><?= $recurring['status'] ?></td>
				<td class="text-right">
					<a class="btn btn-default" href="<?= $recurring['view']; ?>"><i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $lang_text_view; ?></span></a>
				</td>
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