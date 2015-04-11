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
			<div class="pull-left h2"><i class="hidden-xs fa fa-leaf"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li>
			<li><a href="#tab-data" data-toggle="tab"><?= $lang_tab_data; ?></a></li>
			<li><a href="#tab-design" data-toggle="tab"><?= $lang_tab_design; ?></a></li>
		</ul>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="tab-content">
				<div class="tab-pane" id="tab-general">
					<div id="language-tabs">
						<ul class="nav nav-tabs">
							<?php foreach ($languages as $language): ?>
								<li><a href="#language<?= $language['language_id']; ?>" data-toggle="tab"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i> <?= $language['name']; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<div class="tab-content">
							<?php foreach ($languages as $language): ?>
							<div class="tab-pane" id="language<?= $language['language_id']; ?>">
								<div class="form-group">
									<label class="control-label col-sm-2" for="name<?= $language['language_id']; ?>"><b class="required">*</b> <?= $lang_entry_name; ?></label>
									<div class="col-sm-6">
										<input type="text" name="category_description[<?= $language['language_id']; ?>][name]" class="form-control" id="name<?= $language['language_id']; ?>" value="<?= isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" class="form-control">
										<?php if (isset($error_name[$language['language_id']])): ?>
										<span class="help-block error"><?= $error_name[$language['language_id']]; ?></span>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_meta_description; ?></label>
									<div class="control-field col-sm-6">
										<textarea name="category_description[<?= $language['language_id']; ?>][meta_description]" class="form-control" rows="6"><?= isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_meta_keyword; ?></label>
									<div class="control-field col-sm-6">
										<textarea name="category_description[<?= $language['language_id']; ?>][meta_keyword]" class="form-control" rows="6"><?= isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_description; ?></label>
									<div class="control-field col-sm-8">
										<textarea name="category_description[<?= $language['language_id']; ?>][description]" class="summernote form-control" rows="10" spellcheck="false"><?= isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] :''; ?></textarea>
										<?php if (isset($error_description[$language['language_id']])): ?>
										<span class="help-block error"><?= $error_description[$language['language_id']]; ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-data">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_parent; ?></label>
						<div class="control-field col-sm-4">
							<select name="parent_id" class="form-control">
								<option value="0"><?= $lang_text_none; ?></option>
								<?php foreach ($categories as $category): ?>
								<?php if ($category['category_id'] == $parent_id): ?>
								<option value="<?= $category['category_id']; ?>" selected="selected"><?= $category['name']; ?></option>
								<?php else: ?>
								<option value="<?= $category['category_id']; ?>"><?= $category['name']; ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="store"><?= $lang_entry_store; ?></label>
						<div class="control-field col-sm-4">
							<div class="panel panel-default panel-scrollable">
								<div class="list-group list-group-hover">
									<label class="list-group-item">
										<?php if (in_array(0, $category_store)): ?>
										<input type="checkbox" name="category_store[]" value="0" checked=""><?= $lang_text_default; ?>
										<?php else: ?>
										<input type="checkbox" name="category_store[]" value="0"><?= $lang_text_default; ?>
										<?php endif; ?>
									</label>
									<?php foreach ($stores as $store): ?>
									<label class="list-group-item">
										<?php if (in_array($store['store_id'], $category_store)): ?>
										<input type="checkbox" name="category_store[]" value="<?= $store['store_id']; ?>" checked=""><?= $store['name']; ?>
										<?php else: ?>
										<input type="checkbox" name="category_store[]" value="<?= $store['store_id']; ?>"><?= $store['name']; ?>
										<?php endif; ?>
									</label>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="slug"><b class="required">*</b> <?= $lang_entry_slug; ?></label>
						<div class="control-field col-sm-4">
							<div class="input-group">
								<input type="text" name="slug" value="<?= $slug; ?>" id="slug" class="form-control">
								<span class="input-group-btn">
									<button class="btn btn-default" id="blog-cat-slug-btn" type="button"><?= $lang_text_build; ?></button>
								</span>
							</div>
							<?php if ($error_slug): ?>
							<span class="help-block error"><?= $error_slug; ?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="image"><b class="required">*</b> <?= $lang_entry_image; ?></label>
						<div class="control-field col-sm-4">
							<div class="media">
								<a class="pull-left" onclick="image_upload('image','thumb');"><img class="img-thumbnail" src="<?= $thumb; ?>" width="100" height="100" alt="" id="thumb"></a>
								<input type="hidden" name="image" value="<?= $image; ?>" id="image">
								<div class="media-body hidden-xs">
									<a class="btn btn-default" onclick="image_upload('image','thumb');"><?= $lang_text_browse; ?></a>
									<a class="btn btn-default" onclick="$('#thumb').attr('src','<?= $no_image; ?>'); $('#image').val('');"><?= $lang_text_clear; ?></a>
								</div>
							</div>
						</div>	
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="sort_order"><?= $lang_entry_sort_order; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="sort_order" value="<?= $sort_order; ?>" id="sort_order" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
						<div class="control-field col-sm-4">
							<select name="status" class="form-control">
								<?php if ($status): ?>
								<option value="1" selected><?= $lang_text_enabled; ?></option>
								<option value="0"><?= $lang_text_disabled; ?></option>
								<?php else: ?>
								<option value="1"><?= $lang_text_enabled; ?></option>
								<option value="0" selected><?= $lang_text_disabled; ?></option>
								<?php endif; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-design">
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th><?= $lang_entry_store; ?></th>
								<th><?= $lang_entry_layout; ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?= $lang_text_default; ?></td>
								<td><select name="category_layout[0][layout_id]" class="form-control">
									<option value="">&ndash;</option>
									<?php foreach ($layouts as $layout): ?>
									<?php if (isset($category_layout[0]) && $category_layout[0] == $layout['layout_id']): ?>
									<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
									<?php else: ?>
									<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
									<?php endif; ?>
									<?php endforeach; ?>
								</select></td>
							</tr>
							<?php foreach ($stores as $store) { ?>
								<tr>
									<td><?= $store['name']; ?></td>
									<td><select name="category_layout[<?= $store['store_id']; ?>][layout_id]" class="form-control">
										<option value="">&ndash;</option>
										<?php foreach ($layouts as $layout): ?>
										<?php if (isset($category_layout[$store['store_id']]) && $category_layout[$store['store_id']] == $layout['layout_id']): ?>
										<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
										<?php else: ?>
										<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
										<?php endif; ?>
										<?php endforeach; ?>
									</select></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?= $lang_text_image_manager; ?></h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning btn-block" data-dismiss="modal"><?= $lang_button_cancel; ?></button>
			</div>
		</div>
	</div>
</div>
<?= $footer; ?>