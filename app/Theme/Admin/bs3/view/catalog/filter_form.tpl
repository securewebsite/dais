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
			<div class="pull-left h2"><i class="hidden-xs fa fa-filter"></i><?= $lang_heading_title; ?></div>
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
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_group; ?></label>
				<div class="control-field col-sm-4">
					<?php foreach ($languages as $language) { ?>
						<div class="input-group"><input type="text" name="filter_group_description[<?= $language['language_id']; ?>][name]" value="<?= isset($filter_group_description[$language['language_id']]) ? $filter_group_description[$language['language_id']]['name'] :''; ?>" class="form-control">
						<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span>
						<?php if (isset($error_group[$language['language_id']])) { ?>
						<div class="help-block error"><?= $error_group[$language['language_id']]; ?></div>
						<?php } ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_sort_order; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="sort_order" value="<?= $sort_order; ?>" class="form-control">
				</div>
			</div>
			<table id="filter" class="table table-bordered table-striped">
				<thead>
					<tr>
					<th class="col-sm-4"><b class="required">*</b> <?= $lang_entry_name ?></th>
					<th class="text-right"><?= $lang_entry_sort_order; ?></th>
					<th></th>
					</tr>
				</thead>
				<tbody>
				<?php $filter_row = 0; ?>
				<?php foreach ($filters as $filter) { ?>
					<tr id="filter-row<?= $filter_row; ?>">
						<td><input type="hidden" name="filter[<?= $filter_row; ?>][filter_id]" value="<?= $filter['filter_id']; ?>">
							<?php foreach ($languages as $language) { ?>
							<div class="input-group"><input type="text" name="filter[<?= $filter_row; ?>][filter_description][<?= $language['language_id']; ?>][name]" value="<?= isset($filter['filter_description'][$language['language_id']]) ? $filter['filter_description'][$language['language_id']]['name'] : ''; ?>" class="form-control">
							<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span>
							<?php if (isset($error_filter[$filter_row][$language['language_id']])) { ?>
							<span class="text-danger"><?= $error_filter[$filter_row][$language['language_id']]; ?></span>
							<?php } ?></div>
							<?php } ?></td>
						<td class="text-right"><input type="text" name="filter[<?= $filter_row; ?>][sort_order]" value="<?= $filter['sort_order']; ?>" class="form-control"></td>
						<td><a onclick="$('#filter-row<?= $filter_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
					</tr>
				<?php $filter_row++; ?>
				<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"></td>
						<td><a onclick="addFilter();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_filter; ?></span></a></td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</div>
<script> var filter_row=<?= $filter_row; ?>; </script>
<?= $footer; ?>