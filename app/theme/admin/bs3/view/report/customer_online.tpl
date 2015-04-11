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
					<input type="text" name="filter_ip" value="<?= $filter_ip; ?>" placeholder="<?= $lang_column_ip; ?>" class="form-control">
				</div>
				<div class="col-sm-3">
					<input type="text" name="filter_customer" value="<?= $filter_customer; ?>" placeholder="<?= $lang_column_customer; ?>" class="form-control">
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
					<th><?= $lang_column_ip; ?></th>
					<th><?= $lang_column_customer; ?></th>
					<th class="hidden-xs"><?= $lang_column_url; ?></th>
					<th class="hidden-xs"><?= $lang_column_referer; ?></th>
					<th class="hidden-xs"><?= $lang_column_date_added; ?></th>
					<th class="text-right"><span class="hidden-xs"><?= $lang_column_action; ?></span></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($customers) { ?>
				<?php foreach ($customers as $customer) { ?>
				<tr>
					<td><a href="http://whatismyipaddress.com/ip/<?= $customer['ip']; ?>" target="_blank"><?= $customer['ip']; ?></a></td>
					<td><?= $customer['customer']; ?></td>
					<td class="hidden-xs"><a href="<?= $customer['url']; ?>" target="_blank"><?= implode('<br/>', str_split($customer['url'], 30)); ?></a></td>
					<td class="hidden-xs"><?php if ($customer['referer']) { ?>
						<a href="<?= $customer['referer']; ?>" target="_blank"><?= implode('<br/>', str_split($customer['referer'], 30)); ?></a>
					<?php } ?></td>
					<td class="hidden-xs"><?= $customer['date_added']; ?></td>
					<td class="text-right"><?php foreach ($customer['action'] as $action) { ?>
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
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?>