<?= $header; ?>
<?= $post_header; ?>
	<div class="row blog">
		<?= $column_left; ?>
		<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
			<?= $breadcrumb; ?>
			<?= $content_top; ?>
			
			<h2><?= $heading_title; ?></h2>
			<hr>
			
			<form class="form-inline" role="form">
				<div class="pull-right">
					<button type="submit" id="button-search" class="btn btn-primary"><?= $lang_button_search; ?></button>
				</div>
				<div class="form-group">
					<label class="sr-only" for="filter-name"><?= $lang_entry_search; ?></label>
					<input type="text" 
						name="filter_name" 
						class="form-control" 
						id="filter-name" 
						value="<?= $filter_name; ?>" 
						placeholder="<?= $lang_entry_search; ?>" required>
				</div>
				<div class="form-group">
					<select name="filter_category_id" class="form-control">
						<option value="0"><?= $lang_text_category; ?></option>
						<?php foreach ($categories as $category_1): ?>
						<?php if ($category_1['category_id'] == $filter_category_id): ?>
						<option value="<?= $category_1['category_id']; ?>" selected="selected"><?= $category_1['name']; ?></option>
						<?php else: ?>
						<option value="<?= $category_1['category_id']; ?>"><?= $category_1['name']; ?></option>
						<?php endif; ?>
						<?php foreach ($category_1['children'] as $category_2): ?>
						<?php if ($category_2['category_id'] == $filter_category_id): ?>
						<option value="<?= $category_2['category_id']; ?>" selected="selected"><?= $category_2['name']; ?></option>
						<?php else: ?>
						<option value="<?= $category_2['category_id']; ?>"><?= $category_2['name']; ?></option>
						<?php endif; ?>
						<?php foreach ($category_2['children'] as $category_3): ?>
						<?php if ($category_3['category_id'] == $filter_category_id): ?>
						<option value="<?= $category_3['category_id']; ?>" selected="selected"><?= $category_3['name']; ?></option>
						<?php else: ?>
						<option value="<?= $category_3['category_id']; ?>"><?= $category_3['name']; ?></option>
						<?php endif; ?>
						<?php endforeach; ?>
						<?php endforeach; ?>
						<?php endforeach; ?>&nbsp;
					</select>
				</div>
				<hr>
				<div class="form-group">
					<div class="checkbox checkbox-inline">
						<label><input type="checkbox" 
								name="filter_sub_category" 
								value="1"<?= $filter_sub_category ? ' checked=""' : ''; ?>> </label>
					</div>
					<label class="control-label"><?= $lang_text_sub_category; ?></label>
				</div>
				&nbsp;&nbsp;
				<div class="form-group">
					<div class="checkbox checkbox-inline">
						<label><input type="checkbox" 
								name="filter_description" 
								value="1"<?= $filter_description ? ' checked=""' : ''; ?>></label>
					</div>
					<label class="control-label"><?= $lang_entry_description; ?></label>
				</div>
			</form>
			
			<hr>
			
			<?php if ($posts): ?>
			<h2><?= $lang_text_search_results; ?></h2>
			<?php foreach ($posts as $post): ?>
			<h2><a href="<?= $post['href']; ?>"><?= $post['name']; ?></a></h2>
			<div class="meta">
				<p>
					<span class="fa fa-user"></span> 
						<?= $lang_text_by; ?> <a href="<?= $post['author_href']; ?>" 
							data-toggle="tooltip" title="<?= $lang_text_all_by; ?> <?= $post['author_name']; ?>"><?= $post['author_name']; ?></a> | 
					<span class="fa fa-clock-o"></span> <?= $post['date_added']; ?> | 
					<?php if ($post['categories']): ?>
					<span class="fa fa-folder-open"></span> 
						<?= $lang_text_in; ?> <?= $post['categories']; ?> | 
					<?php endif; ?>
					<span class="fa fa-comments-o"></span> <?= $post['comments']; ?> | 
					<span class="fa fa-eye"></span> <?= $post['views']; ?>
				</p>
			</div>
			<p><?= $post['blurb']; ?></p>
			<hr>
			<?php endforeach; ?>
			
			<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
			
			<?php else: ?>
			<p><?= $lang_text_empty; ?></p>
			<?php endif; ?>
					
		<?= $content_bottom; ?>
		</div>
		<?= $column_right; ?>
	</div>
<?= $pre_footer; ?>
<?= $footer; ?>