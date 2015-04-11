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
				<div class="col-sm-6 text-right">
					<button type="button" onclick="filter();" class="btn btn-info"><i class="fa fa-search"></i> <?= $lang_button_filter; ?></button>
				</div>
			</div>
		</div>
		<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th><?= $lang_column_affiliate; ?></th>
					<th class="hidden-xs"><?= $lang_column_email; ?></th>
					<th class="hidden-xs"><?= $lang_column_status; ?></th>
					<th class="text-right"><?= $lang_column_commission; ?></th>
					<th class="hidden-xs right"><?= $lang_column_orders; ?></th>
					<th class="text-right"><?= $lang_column_total; ?></th>
					<th class="text-right"><span class="hidden-xs"><?= $lang_column_action; ?></span></th>
				</tr>
			</thead>
			<tbody data-link="row" class="rowlink">
				<?php if ($affiliates) { ?>
				<?php foreach ($affiliates as $affiliate) { ?>
				<tr>
					<td><?= $affiliate['affiliate']; ?></td>
					<td class="hidden-xs"><?= $affiliate['email']; ?></td>
					<td class="hidden-xs text-<?= strtolower($affiliate['status']); ?>"><?= $affiliate['status']; ?></td>
					<td class="text-right"><?= $affiliate['commission']; ?></td>
					<td class="hidden-xs right"><?= $affiliate['orders']; ?></td>
					<td class="text-right"><?= $affiliate['total']; ?></td>
					<td class="text-right"><?php foreach ($affiliate['action'] as $action) { ?>
						<a class="btn btn-default" href="<?= $action['href']; ?>">
							<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span>
						</a>
						<?php } ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td class="text-center" colspan="7"><?= $lang_text_no_results; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		</div>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?>