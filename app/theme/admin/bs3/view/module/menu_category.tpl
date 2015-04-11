<div class="form-group <?= ($error_items) ? 'has-error' : ''; ?>">
	<label class="control-label col-sm-2" for="menu_item"><b class="required">*</b> <?= $lang_entry_category; ?></label>
	<div class="control-field col-sm-6">
		<div class="panel panel-default panel-scrollable">
			<div class="list-group list-group-hover">
				<?php foreach ($categories as $category): ?>
				<label class="list-group-item">
				<?php if (in_array($category['category_id'], $menu_items)): ?>
					<input type="checkbox" name="menu_item[]" value="<?= $category['category_id']; ?>" checked="checked"> <?= $category['name']; ?>
				<?php else: ?>
					<input type="checkbox" name="menu_item[]" value="<?= $category['category_id']; ?>"> <?= $category['name']; ?>
				<?php endif; ?>
				</label>
				<?php endforeach; ?>
			</div>
		</div>
		<?php if ($error_items): ?>
		<div class="help-block error"><?= $error_items; ?></div>
		<?php endif; ?>
	</div>
</div>