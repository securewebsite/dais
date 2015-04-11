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
		<div class="pull-left h2"><i class="hidden-xs fa fa-user"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right">
			<button type="submit" form="form" class="btn btn-success btn-spacer"><i class="fa fa-check"></i><span class="hidden-xs"> <?= $lang_button_approve; ?></span></button>
			<a href="<?= $insert; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_insert; ?></span></a>
			<button type="submit" form="form" formaction="<?= $delete; ?>" id="btn-delete" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></button>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-inline" action="<?= $approve; ?>" method="post" enctype="multipart/form-data" id="form">
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
						<th><a href="<?= $sort_username; ?>"><?= $lang_column_username; echo ($sort == 'username') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th><a href="<?= $sort_name; ?>"><?= $lang_column_name; echo ($sort == 'name') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th><a href="<?= $sort_email; ?>"><?= $lang_column_email; echo ($sort == 'c.email') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_customer_group; ?>"><?= $lang_column_customer_group; echo ($sort == 'customer_group') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_status; ?>"><?= $lang_column_status; echo ($sort == 'c.status') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="visible-lg"><?= $lang_column_login; ?></th>
						<th class="text-right"><span class="hidden-xs"><?= $lang_column_action; ?></span></th>
					</tr>
				</thead>
				<tbody data-link="row" class="rowlink">
					<tr id="filter" class="info">
						<td class="text-center"><a class="btn btn-default btn-block" href="index.php?route=people/customer&token=<?= $token; ?>" rel="tooltip" title="Reset"><i class="fa fa-power-off fa-fw"></i></a></td>
						<td>
							<input type="text" 
								name="filter_username" 
								value="<?= $filter_username; ?>" 
								class="form-control" 
								data-target="username" 
								data-url="people/customer">
						</td>
						<td>
							<input type="text" 
								name="filter_name" 
								value="<?= $filter_name; ?>" 
								class="form-control" 
								data-target="name" 
								data-url="people/customer">
						</td>
						<td>
							<input type="text" 
								name="filter_email" 
								value="<?= $filter_email; ?>" 
								class="form-control" 
								data-target="email" 
								data-url="people/customer">
						</td>
						<td class="hidden-xs"><select name="filter_customer_group_id" class="form-control">
							<option value="*">&ndash;</option>
							<?php foreach ($customer_groups as $customer_group) { ?>
							<?php if ($customer_group['customer_group_id'] == $filter_customer_group_id) { ?>
							<option value="<?= $customer_group['customer_group_id']; ?>" selected><?= $customer_group['name']; ?></option>
							<?php } else { ?>
							<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select></td>
						<td class="hidden-xs"><select name="filter_status" class="form-control">
							<option value="*">&ndash;</option>
							<?php if ($filter_status) { ?>
							<option value="1" selected><?= $lang_text_enabled; ?></option>
							<?php } else { ?>
							<option value="1"><?= $lang_text_enabled; ?></option>
							<?php } ?>
							<?php if (!is_null($filter_status) && !$filter_status) { ?>
							<option value="0" selected><?= $lang_text_disabled; ?></option>
							<?php } else { ?>
							<option value="0"><?= $lang_text_disabled; ?></option>
							<?php } ?>
						</select></td>
						<td class="visible-lg"></td>
						<td class="text-right"><button type="button" onclick="filter();" class="btn btn-info"><i class="fa fa-search"></i><span class="hidden-xs"> <?= $lang_button_filter; ?></span></button></td>
					</tr>
					<?php if ($customers) { ?>
					<?php foreach ($customers as $customer) { ?>
					<tr>
						<td class="rowlink-skip text-center"><?php if ($customer['selected']) { ?>
							<input type="checkbox" name="selected[]" value="<?= $customer['customer_id']; ?>" checked="">
							<?php } else { ?>
							<input type="checkbox" name="selected[]" value="<?= $customer['customer_id']; ?>">
							<?php } ?></td>
						<td><?= $customer['username']; ?></td>
						<td><?= $customer['name']; ?></td>
						<td><?= $customer['email']; ?></td>
						<td class="hidden-xs"><?= $customer['customer_group']; ?></td>
						<td class="hidden-xs text-<?= strtolower($customer['status']); ?>"><?= $customer['status']; ?></td>
						<td class="rowlink-skip text-center visible-lg">
							<select class="form-control login-selector" data-customer="<?= $customer['customer_id']; ?>">
							<option value=""><?= $lang_text_select; ?></option>
							<option value="0"><?= $lang_text_default; ?></option>
							<?php foreach ($stores as $store) { ?>
							<option value="<?= $store['store_id']; ?>"><?= $store['name']; ?></option>
							<?php } ?>
						</select></td>
						<td class="text-right"><?php foreach ($customer['action'] as $action) { ?>
							<a class="btn btn-default" href="<?= $action['href']; ?>"><i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span></a>
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
		</div>
		</form>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?> 