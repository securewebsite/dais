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
		<div class="h2"><i class="fa fa-bar-chart-o"></i><?= $lang_heading_title; ?></div>
	</div>
	<div class="panel-body">
		<div id="filter" class="well">
			<div class="row">
				<div class="col-sm-3">
					<label class="input-group" title="<?= $lang_entry_date_start; ?>">
						<input type="text" name="filter_date_start" value="<?= $filter_date_start; ?>" id="date-start" placeholder="<?= $lang_entry_date_start; ?>" class="form-control date">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</label>
				</div>
				<div class="col-sm-3">
					<label class="input-group" title="<?= $lang_entry_date_end; ?>">
						<input type="text" name="filter_date_end" value="<?= $filter_date_end; ?>" id="date-end" placeholder="<?= $lang_entry_date_end; ?>" class="form-control date">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</label>
				</div>
				<div class="col-sm-2">
					<select name="filter_order_status_id" title="<?= $lang_entry_status; ?>" class="form-control">
						<option value="0"><?= $lang_text_all_status; ?></option>
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
				<div class="col-sm-4 text-right">
					<button type="button" onclick="filter();" class="btn btn-info"><i class="fa fa-search"></i> <?= $lang_button_filter; ?></button>
				</div>
			</div>
		</div>
		<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th><?= $lang_column_name; ?></th>
					<th class="hidden-xs"><?= $lang_column_model; ?></th>
					<th class="text-right"><?= $lang_column_quantity; ?></th>
					<th class="text-right"><?= $lang_column_total; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($products) { ?>
				<?php foreach ($products as $product) { ?>
				<tr>
					<td><?= $product['name']; ?></td>
					<td class="hidden-xs"><?= $product['model']; ?></td>
					<td class="text-right"><?= $product['quantity']; ?></td>
					<td class="text-right"><?= $product['total']; ?></td>
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