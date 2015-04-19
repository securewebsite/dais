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
			<li><a href="#tab-links" data-toggle="tab"><?= $lang_tab_links; ?></a></li>
			<li><a href="#tab-image" data-toggle="tab"><?= $lang_tab_image; ?></a></li>
			<li><a href="#tab-design" data-toggle="tab"><?= $lang_tab_design; ?></a></li>
		</ul>
		<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
			<div class="tab-content">
				<div class="tab-pane" id="tab-general">
					<div class="row" id="language-tabs">
						<div class="col-sm-2 tabs-left">
							<ul class="nav nav-tabs">
								<?php foreach ($languages as $language): ?>
									<li><a href="#language<?= $language['language_id']; ?>" data-toggle="tab">
										<i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i> <?= $language['name']; ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="col-sm-10">
							<div class="tab-content">
								<?php foreach ($languages as $language): ?>
									<div class="tab-pane" id="language<?= $language['language_id']; ?>">
										<div class="form-group">
											<label class="control-label col-sm-2" for="name<?= $language['language_id']; ?>"><b class="required">*</b> <?= $lang_entry_name; ?></label>
											<div class="col-sm-6">
												<input type="text" name="post_description[<?= $language['language_id']; ?>][name]" value="<?= isset($post_description[$language['language_id']]) ? $post_description[$language['language_id']]['name'] : ''; ?>" class="form-control">
												<?php if (isset($error_name[$language['language_id']])): ?>
												<span class="help-block error"><?= $error_name[$language['language_id']]; ?></span>
												<?php endif; ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="description<?= $language['language_id']; ?>"><b class="required">*</b> <?= $lang_entry_description; ?></label>
											<div class="col-sm-8">
												<textarea name="post_description[<?= $language['language_id']; ?>][description]" id="description<?= $language['language_id']; ?>" class="form-control summernote" rows="6"><?= isset($post_description[$language['language_id']]) ? $post_description[$language['language_id']]['description'] : ''; ?></textarea>
												<?php if (isset($error_description[$language['language_id']])): ?>
												<span class="help-block error"><?= $error_description[$language['language_id']]; ?></span>
												<?php endif; ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="meta_description<?= $language['language_id']; ?>"><?= $lang_entry_meta_description; ?></label>
											<div class="col-sm-6">
												<textarea name="post_description[<?= $language['language_id']; ?>][meta_description]" class="form-control" rows="6"><?= isset($post_description[$language['language_id']]) ? $post_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
											</div>
											<div class="col-sm-2">
												<button id="meta-description<?= $language['language_id']; ?>" class="btn btn-primary">
													<?= $lang_button_generate; ?>
												</button>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="meta_keyword<?= $language['language_id']; ?>"><?= $lang_entry_meta_keyword; ?></label>
											<div class="col-sm-6">
												<textarea name="post_description[<?= $language['language_id']; ?>][meta_keyword]" class="form-control" rows="5"><?= isset($post_description[$language['language_id']]) ? $post_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
											</div>
											<div class="col-sm-2">
												<button id="meta-keyword<?= $language['language_id']; ?>" class="btn btn-primary">
													<?= $lang_button_generate; ?>
												</button>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="tag<?= $language['language_id']; ?>"><?= $lang_entry_tag; ?></label>
											<div class="col-sm-6">
												<input type="text" name="post_description[<?= $language['language_id']; ?>][tag]" value="<?= isset($post_description[$language['language_id']]) ? $post_description[$language['language_id']]['tag'] : ''; ?>" class="form-control">
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-data">
					<div class="form-group">
						<label class="control-label col-sm-2" for="author"><b class="required">*</b> <?= $lang_entry_author; ?></label>
						<div class="col-sm-4">
							<input type="text" name="author" value="<?= $author; ?>" autocomplete="off" class="form-control">
							<input type="hidden" name="author_id" value="<?= $author_id; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="slug"><b class="required">*</b> <?= $lang_entry_slug; ?></label>
						<div class="col-sm-4">
							<div class="input-group">	
								<input type="text" name="slug" value="<?= $slug; ?>" id="slug" class="form-control">
								<span class="input-group-btn">
									<button class="btn btn-default" id="post-slug-btn" type="button"><?= $lang_text_build; ?></button>
								</span>
							</div>
							<?php if ($error_slug): ?>
							<span class="help-block error"><?= $error_slug; ?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="date_available"><?= $lang_entry_date_available; ?></label>
						<div class="col-sm-2">
							<label class="input-group">
								<input type="text" name="date_available" value="<?= $date_available; ?>" class="form-control date" autocomplete="off">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_visibility; ?></label>
						<div class="control-field col-sm-2">
							<select name="visibility" class="form-control">
								<option value="0"><?= $lang_text_select; ?></option>
								<?php foreach ($customer_groups as $customer_group): ?>
								<?php if ($customer_group['customer_group_id'] == $visibility): ?>
								<option value="<?= $customer_group['customer_group_id']; ?>" selected><?= $customer_group['name']; ?></option>
								<?php else: ?>
								<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="status"><?= $lang_entry_status; ?></label>
						<div class="col-sm-2">
							<select name="status" class="form-control">
								<?php if ($status === '1'): ?>
								<option value="1" selected><?= $lang_text_posted; ?></option>
								<option value="2"><?= $lang_text_draft; ?></option>
								<option value="0"><?= $lang_text_disabled; ?></option>
								<?php elseif($status === '2'): ?>
								<option value="1"><?= $lang_text_posted; ?></option>
								<option value="2" selected><?= $lang_text_draft; ?></option>
								<option value="0"><?= $lang_text_disabled; ?></option>
								<?php else: ?>
								<option value="1"><?= $lang_text_posted; ?></option>
								<option value="2"><?= $lang_text_draft; ?></option>
								<option value="0" selected><?= $lang_text_disabled; ?></option>
								<?php endif; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="sort_order"><?= $lang_entry_sort_order; ?></label>
						<div class="col-sm-2">
							<input type="text" name="sort_order" value="<?= $sort_order; ?>" class="form-control">
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-links">
					<div class="form-group">
						<label class="control-label col-sm-2" for="post_category"><?= $lang_entry_category; ?></label>
						<div class="control-field col-sm-6">
							<div class="panel panel-default panel-scrollable">
								<div class="list-group list-group-hover">
									<?php foreach ($categories as $category): ?>
									<label class="list-group-item">
									<?php if (in_array($category['category_id'], $post_category)): ?>
										<input type="checkbox" name="post_category[]" value="<?= $category['category_id']; ?>" checked="checked"> <?= $category['name']; ?>
									<?php else: ?>
										<input type="checkbox" name="post_category[]" value="<?= $category['category_id']; ?>"> <?= $category['name']; ?>
									<?php endif; ?>
									</label>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="post_store"><?= $lang_entry_store; ?></label>
						<div class="control-field col-sm-4">
							<div class="panel panel-default panel-scrollable">
								<div class="list-group list-group-hover">
									<label class="list-group-item">
										<?php if (in_array(0, $post_store)): ?>
										<input type="checkbox" name="post_store[]" value="0" checked=""><?= $lang_text_default; ?>
										<?php else: ?>
										<input type="checkbox" name="post_store[]" value="0"><?= $lang_text_default; ?>
										<?php endif; ?>
									</label>
									<?php foreach ($stores as $store): ?>
									<label class="list-group-item">
										<?php if (in_array($store['store_id'], $post_store)): ?>
										<input type="checkbox" name="post_store[]" value="<?= $store['store_id']; ?>" checked=""><?= $store['name']; ?>
										<?php else: ?>
										<input type="checkbox" name="post_store[]" value="<?= $store['store_id']; ?>"><?= $store['name']; ?>
										<?php endif; ?>
									</label>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_related; ?></label>
						<div class="control-field col-sm-4">
							<p><input type="text" name="postrelated" value="" class="form-control" autocomplete="off"></p>
							<div class="panel panel-default panel-scrollable">
								<div id="post-related" class="list-group">
								<?php foreach ($posts_related as $post_related): ?>
									<div class="list-group-item" id="post-related<?= $post_related['post_id']; ?>">
									<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><?= $post_related['name']; ?>
									<input type="hidden" name="post_related[]" value="<?= $post_related['post_id']; ?>">
									</div>
								<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-image">
					<table id="images" class="table table-bordered">
						<thead>
							<tr>
								<th><?= $lang_entry_image; ?></th>
								<th class="text-right"><?= $lang_entry_sort_order; ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<tr>
							<td><div class="media">
								<a class="pull-left" onclick="image_upload('image','thumb');"><img class="img-thumbnail" src="<?= $thumb; ?>" width="100" height="100" alt="" id="thumb"></a>
								<input type="hidden" name="image" value="<?= $image; ?>" id="image">
								<div class="media-body hidden-xs">
									<a class="btn btn-default" onclick="image_upload('image','thumb');"><?= $lang_text_browse; ?></a>
									<a class="btn btn-default" onclick="$('#thumb').attr('src','<?= $no_image; ?>'); $('#image').val('');"><?= $lang_text_clear; ?></a>
								</div>
							</div></td>
							<td class="text-right"><i class="muted"><?= $lang_text_default; ?></i></td>
							<td></td>
						</tr>
						<?php $image_row = 0; ?>
						<?php 
							$sort_order = array(); 
							foreach ($post_images as $key => $post_image): 
								$sort_order[$key] = $post_image['sort_order']; 
							endforeach;
							
							array_multisort($sort_order, SORT_ASC, $post_images); 
						?>
						<?php foreach ($post_images as $post_image): ?>
							<tr id="image-row<?= $image_row; ?>">
								<td>
									<div class="media">
										<a class="pull-left" onclick="image_upload('image<?= $image_row; ?>','thumb<?= $image_row; ?>');">
											<img class="img-thumbnail" src="<?= $post_image['thumb']; ?>" width="100" height="100" alt="" id="thumb<?= $image_row; ?>">
										</a>
										<input type="hidden" name="post_image[<?= $image_row; ?>][image]" value="<?= $post_image['image']; ?>" id="image<?= $image_row; ?>">
										<div class="media-body hidden-xs">
											<a class="btn btn-default" onclick="image_upload('image<?= $image_row; ?>','thumb<?= $image_row; ?>');">
												<?= $lang_text_browse; ?></a>&nbsp;
											<a class="btn btn-default" onclick="$('#thumb<?= $image_row; ?>').attr('src', '<?= $no_image; ?>'); $('#image<?= $image_row; ?>').val('');">
												<?= $lang_text_clear; ?></a>
										</div>
									</div>
								</td>
								<td class="text-right">
									<input type="text" name="post_image[<?= $image_row; ?>][sort_order]" value="<?= $post_image['sort_order']; ?>" class="form-control">
								</td>
								<td>
									<a onclick="$('#image-row<?= $image_row; ?>').remove();" class="btn btn-danger">
										<i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a>
								</td>
							</tr>
						<?php $image_row++; ?>
						<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"></td>
								<td><a onclick="addImage();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_image; ?></span></a></td>
							</tr>
						</tfoot>
					</table>
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
								<td>
									<select name="post_layout[0][layout_id]" class="form-control">
										<option value="">&ndash;</option>
										<?php foreach ($layouts as $layout): ?>
										<?php if (isset($post_layout[0]) && $post_layout[0] == $layout['layout_id']): ?>
										<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
										<?php else: ?>
										<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
										<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
							<?php foreach ($stores as $store): ?>
								<tr>
									<td><?= $store['name']; ?></td>
									<td>
										<select name="post_layout[<?= $store['store_id']; ?>][layout_id]" class="form-control">
											<option value="">&ndash;</option>
											<?php foreach ($layouts as $layout): ?>
											<?php if (isset($post_layout[$store['store_id']]) && $post_layout[$store['store_id']] == $layout['layout_id']): ?>
											<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
											<?php else: ?>
											<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
											<?php endif; ?>
											<?php endforeach; ?>
										</select>
									</td>
								</tr>
							<?php endforeach; ?>
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
<script>var image_row = <?= $image_row; ?>;</script>
<?= $footer; ?>