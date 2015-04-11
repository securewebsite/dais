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
			<div class="pull-left h2"><i class="hidden-xs fa fa-info-circle"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs"><li><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li><li><a href="#tab-data" data-toggle="tab"><?= $lang_tab_data; ?></a></li><li><a href="#tab-design" data-toggle="tab"><?= $lang_tab_design; ?></a></li></ul>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="tab-content">
				<div class="tab-pane" id="tab-general">
					<div id="language-tabs">
						<ul class="nav nav-tabs">
							<?php foreach ($languages as $language) { ?>
								<li><a href="#language<?= $language['language_id']; ?>" data-toggle="tab"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i> <?= $language['name']; ?></a></li>
							<?php } ?>
						</ul>
						<div class="tab-content">
							<?php foreach ($languages as $language) { ?>
							<div class="tab-pane" id="language<?= $language['language_id']; ?>">
								<div class="form-group">
									<label class="control-label col-sm-2" for="name<?= $language['language_id']; ?>"><b class="required">*</b> <?= $lang_entry_title; ?></label>
									<div class="col-sm-6">
										<input type="text" name="page_description[<?= $language['language_id']; ?>][title]" class="form-control" id="name<?= $language['language_id']; ?>" value="<?= isset($page_description[$language['language_id']]) ? $page_description[$language['language_id']]['title'] : ''; ?>" class="form-control">
										<?php if (isset($error_title[$language['language_id']])) { ?>
										<span class="help-block error"><?= $error_title[$language['language_id']]; ?></span>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_description; ?></label>
									<div class="control-field col-sm-8">
										<textarea name="page_description[<?= $language['language_id']; ?>][description]" class="summernote form-control" rows="10" spellcheck="false"><?= isset($page_description[$language['language_id']]) ? $page_description[$language['language_id']]['description'] :''; ?></textarea>
										<?php if (isset($error_description[$language['language_id']])) { ?>
										<span class="help-block error"><?= $error_description[$language['language_id']]; ?></span>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_meta_description; ?></label>
									<div class="col-sm-6">
										<textarea name="page_description[<?= $language['language_id']; ?>][meta_description]" class="form-control" rows="6"><?= isset($page_description[$language['language_id']]) ? $page_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
										<?php if (isset($error_meta_description[$language['language_id']])) { ?>
										<span class="help-block error"><?= $error_meta_description[$language['language_id']]; ?></span>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_meta_keyword; ?></label>
									<div class="col-sm-6">
										<textarea name="page_description[<?= $language['language_id']; ?>][meta_keywords]" class="form-control" rows="5"><?= isset($page_description[$language['language_id']]) ? $page_description[$language['language_id']]['meta_keywords'] : ''; ?></textarea>
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-data">
					<div class="form-group">
						<label class="control-label col-sm-2" for="store"><?= $lang_entry_store; ?></label>
						<div class="control-field col-sm-4">
							<div class="panel panel-default panel-scrollable">
								<div class="list-group list-group-hover">
									<label class="list-group-item">
										<?php if (in_array(0, $page_store)) { ?>
										<input type="checkbox" name="page_store[]" value="0" checked=""><?= $lang_text_default; ?>
										<?php } else { ?>
										<input type="checkbox" name="page_store[]" value="0"><?= $lang_text_default; ?>
										<?php } ?>
									</label>
									<?php foreach ($stores as $store) { ?>
									<label class="list-group-item">
										<?php if (in_array($store['store_id'], $page_store)) { ?>
										<input type="checkbox" name="page_store[]" value="<?= $store['store_id']; ?>" checked=""><?= $store['name']; ?>
										<?php } else { ?>
										<input type="checkbox" name="page_store[]" value="<?= $store['store_id']; ?>"><?= $store['name']; ?>
										<?php } ?>
									</label>
									<?php } ?>
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
									<button class="btn btn-default" id="info-slug-btn" type="button"><?= $lang_text_build; ?></button>
								</span>
							</div>
							<?php if ($error_slug): ?>
							<span class="help-block error"><?= $error_slug; ?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="bottom"><?= $lang_entry_bottom; ?></label>
						<div class="control-field col-sm-4">
							<?php if ($bottom) { ?>
								<p class="form-control-static"><input type="checkbox" name="bottom" value="1" checked="" id="bottom"></p>
							<?php } else { ?>
								<p class="form-control-static"><input type="checkbox" name="bottom" value="1" id="bottom"></p>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_visibility; ?></label>
						<div class="control-field col-sm-4">
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
						<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
						<div class="control-field col-sm-4">
							<select name="status" class="form-control">
								<?php if ($status === 1): ?>
								<option value="1" selected><?= $lang_text_posted; ?></option>
								<option value="2"><?= $lang_text_draft; ?></option>
								<option value="0"><?= $lang_text_disabled; ?></option>
								<?php elseif($status === 2): ?>
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
						<div class="control-field col-sm-4">
							<input type="text" name="sort_order" value="<?= $sort_order; ?>" id="sort_order" class="form-control">
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
								<td>
									<div class="col-sm-4">
										<select name="page_layout[0][layout_id]" class="form-control">
											<option value="">&ndash;</option>
											<?php foreach ($layouts as $layout) { ?>
											<?php if (isset($page_layout[0]) && $page_layout[0] == $layout['layout_id']) { ?>
											<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
											<?php } else { ?>
											<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
									</div>
								</td>
							</tr>
							<?php foreach ($stores as $store) { ?>
								<tr>
									<td><?= $store['name']; ?></td>
									<td>
										<div class="col-sm-4">
											<select name="page_layout[<?= $store['store_id']; ?>][layout_id]" class="form-control">
												<option value="">&ndash;</option>
												<?php foreach ($layouts as $layout) { ?>
												<?php if (isset($page_layout[$store['store_id']]) && $page_layout[$store['store_id']] == $layout['layout_id']) { ?>
												<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
												<?php } else { ?>
												<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>