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
<?php if ($error_install) { ?>
<div class="alert alert-danger"><?= $error_install; ?></div>
<?php } ?>
<?php if ($error_image) { ?>
<div class="alert alert-danger"><?= $error_image; ?></div>
<?php } ?>
<?php if ($error_image_cache) { ?>
<div class="alert alert-danger"><?= $error_image_cache; ?></div>
<?php } ?>
<?php if ($error_cache) { ?>
<div class="alert alert-danger"><?= $error_cache; ?></div>
<?php } ?>
<?php if ($error_download) { ?>
<div class="alert alert-danger"><?= $error_download; ?></div>
<?php } ?>
<?php if ($error_logs) { ?>
<div class="alert alert-danger"><?= $error_logs; ?></div>
<?php } ?>
<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="h2"><i class="fa fa-home"></i><?= $lang_text_overview; ?></div>
			</div>
			<div class="panel-body">
				<table class="form">
					<tr>
						<td><?= $lang_text_total_sale; ?></td>
						<td class="text-right"><span class="h4"><?= $total_sale; ?></span></td>
					</tr>
					<tr>
						<td><?= $lang_text_total_sale_year; ?></td>
						<td class="text-right"><span class="h4"><?= $total_sale_year; ?></span></td>
					</tr>
					<tr>
						<td><?= $lang_text_total_order; ?></td>
						<td class="text-right"><span class="h4"><?= $total_order; ?></span></td>
					</tr>
					<tr>
						<td><?= $lang_text_total_customer; ?></td>
						<td class="text-right"><span class="h4"><?= $total_customer; ?></span></td>
					</tr>
					<tr>
						<td><?= $lang_text_total_customer_approval; ?></td>
						<td class="text-right"><span class="h4"><?= $total_customer_approval; ?></span></td>
					</tr>
					<tr>
						<td><?= $lang_text_total_review_approval; ?></td>
						<td class="text-right"><span class="h4"><?= $total_review_approval; ?></span></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="h2"><i class="fa fa-bar-chart-o"></i><?= $lang_text_statistics; ?></div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" id="tabs-chart" title="<?= $lang_entry_range; ?>">
					<li><a href="day" data-toggle="tab"><?= $lang_text_day; ?></a></li>
					<li><a href="week" data-toggle="tab"><?= $lang_text_week; ?></a></li>
					<li><a href="month" data-toggle="tab"><?= $lang_text_month; ?></a></li>
					<li><a href="year" data-toggle="tab"><?= $lang_text_year; ?></a></li>
				</ul>
				<div class="tab-content">
					<div id="report"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="h2"><i class="fa fa-shopping-cart"></i><?= $lang_text_latest_10_orders; ?></div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="text-right hidden-xs"><?= $lang_column_order; ?></th>
					<th><?= $lang_column_customer; ?></th>
					<th class="hidden-xs"><?= $lang_column_status; ?></th>
					<th class="hidden-xs"><?= $lang_column_date_added; ?></th>
					<th class="text-right hidden-xs"><?= $lang_column_total; ?></th>
					<th class="text-right"><span class="hidden-xs"><?= $lang_column_action; ?></span></th>
				</tr>
			</thead>
			<tbody data-link="row" class="rowlink">
				<?php if ($orders) { ?>
				<?php foreach ($orders as $order) { ?>
				<tr>
					<td class="text-right hidden-xs"><?= $order['order_id']; ?></td>
					<td><?= $order['customer']; ?></td>
					<td class="hidden-xs text-<?= strtolower($order['status']); ?>"><?= $order['status']; ?></td>
					<td class="hidden-xs muted"><?= $order['date_added']; ?></td>
					<td class="text-right hidden-xs"><span class="h4"><?= $order['total']; ?></span></td>
					<td class="text-right"><?php foreach ($order['action'] as $action) { ?>
						<a class="btn btn-default" href="<?= $action['href']; ?>">
							<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span>
						</a>
					<?php } ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td class="text-center" colspan="6"><?= $lang_text_no_results; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?= $footer; ?>