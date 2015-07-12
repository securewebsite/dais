<div class="form-group <?= ($error_items) ? 'has-error' : ''; ?>">
	<label class="control-label col-sm-2" for="menu_item"><b class="required">*</b> <?= $lang_entry_custom; ?></label>
	<div class="control-field col-sm-8">
		<table id="custom" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th><?= $lang_column_href; ?></th>
					<th><?= $lang_column_text; ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php $item_row = 0; ?>
			<?php foreach ($menu_items as $item): ?>
				<tr id="link-row<?= $item_row; ?>">
					<td><input type="text" name="menu_item[<?= $item_row; ?>][href]" value="<?= $item['href']; ?>" class="form-control"></td>
					<td><input type="text" name="menu_item[<?= $item_row; ?>][name]" value="<?= $item['name']; ?>" class="form-control"></td>
					<td><a onclick="$('#link-row<?= $item_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
				</tr>
			<?php $item_row++; ?>
			<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"></td>
					<td><a onclick="addLink();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_link; ?></span></a></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<script>var item_row = <?= $item_row; ?>;</script>
<?= $javascript; ?>