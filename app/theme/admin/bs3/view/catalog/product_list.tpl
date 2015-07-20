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
		<div class="pull-left h2"><i class="hidden-xs fa fa-tablet"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right">
			<button type="submit" form="form" class="btn btn-success btn-spacer"><i class="fa fa-files-o"></i><span class="hidden-xs"> <?= $lang_button_copy; ?></span></button>
			<a href="<?= $insert; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_insert; ?></span></a>
			<button type="submit" form="form" formaction="<?= $delete; ?>" id="btn-delete" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></button>
		</div>
	</div>
	<div class="panel-body">
		<form action="<?= $copy; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
						<th class="text-center"><?= $lang_column_image; ?></th>
						<th><a href="<?= $sort_name; ?>"><?= $lang_column_name; echo ($sort == 'pd.name') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_model; ?>"><?= $lang_column_model; echo ($sort == 'p.model') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="text-right hidden-xs"><a href="<?= $sort_price; ?>"><?= $lang_column_price; echo ($sort == 'p.price') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="text-right hidden-xs"><a href="<?= $sort_quantity; ?>"><?= $lang_column_quantity; echo ($sort == 'p.quantity') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_status; ?>"><?= $lang_column_status; echo ($sort == 'p.status') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th><span class="hidden-xs"><?= $lang_column_action; ?></span></th>
					</tr>
				</thead>
				<tbody data-link="row" class="rowlink">
					<tr id="filter" class="info">
						<td class="text-center"><a class="btn btn-default btn-block" href="catalog/product" rel="tooltip" title="Reset"><i class="fa fa-power-off fa-fw"></i></a></td>
						<td></td>
						<td><input type="text" name="filter_name" value="<?= $filter_name; ?>" class="form-control" data-target="name" data-url="catalog/product" class="form-control"></td>
						<td class="hidden-xs"><input type="text" name="filter_model" value="<?= $filter_model; ?>" class="form-control" data-target="model" data-url="catalog/product" class="form-control"></td>
						<td class="text-right hidden-xs"><input type="text" name="filter_price" value="<?= $filter_price; ?>" class="form-control"></td>
						<td class="text-right hidden-xs"><input type="text" name="filter_quantity" value="<?= $filter_quantity; ?>" class="form-control text-right"></td>
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
						<td><button type="button" onclick="filter();" class="btn btn-info"><i class="fa fa-search"></i><span class="hidden-xs"> <?= $lang_button_filter; ?></span></button></td>
					</tr>
					<?php if ($products) { ?>
					<?php foreach ($products as $product) { ?>
					<tr>
						<td class="rowlink-skip text-center"><?php if ($product['selected']) { ?>
							<input type="checkbox" name="selected[]" value="<?= $product['product_id']; ?>" checked="">
							<?php } else { ?>
							<input type="checkbox" name="selected[]" value="<?= $product['product_id']; ?>">
							<?php } ?></td>
						<td class="text-center"><img class="img-thumbnail" src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>"></td>
						<td><?= $product['name']; ?></td>
						<td class="hidden-xs"><?= $product['model']; ?></td>
						<td class="text-right hidden-xs"><?php if ($product['special']) { ?>
								<s class="text-danger"><?= $product['price']; ?></s> <?= $product['special']; ?>
							<?php } else { ?>
								<?= $product['price']; ?>
							<?php } ?></td>
						<td class="text-right hidden-xs"><?php if ($product['quantity'] <= 0) { ?>
							<b class="text-danger"><?= $product['quantity']; ?></b>
							<?php } elseif ($product['quantity'] <= 5) { ?>
							<b class="text-warning"><?= $product['quantity']; ?></b>
							<?php } else { ?>
							<span class="text-success"><?= $product['quantity']; ?></span>
							<?php } ?></td>
						<td class="hidden-xs text-<?= strtolower($product['status']); ?>"><?= $product['status']; ?></td>
						<td><?php foreach ($product['action'] as $action) { ?>
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
		</form>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?>