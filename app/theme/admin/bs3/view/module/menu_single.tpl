<div class="form-group">
	<label class="control-label col-sm-2" for="menu_item"><b class="required">*</b> <?= $lang_entry_single; ?></label>
	<div class="control-field col-sm-6">
		<div class="panel panel-default panel-scrollable">
			<div class="list-group list-group-hover">
				<?php foreach ($singles as $single): ?>
				<label class="list-group-item">
				<?php if (in_array($single['item_id'], $menu_items)): ?>
					<input type="checkbox" name="menu_item[]" value="<?= $single['item_id']; ?>" checked="checked"> <?= $single['name']; ?>
				<?php else: ?>
					<input type="checkbox" name="menu_item[]" value="<?= $single['item_id']; ?>"> <?= $single['name']; ?>
				<?php endif; ?>
				</label>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>