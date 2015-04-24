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
			<div class="pull-left h2"><i class="hidden-xs fa fa-users"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="alert alert-info"><?= $lang_text_instructions; ?></div>	
		<ul class="nav nav-tabs"><li><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li></ul>
		<div class="tab-content">
			<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_name; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="name" value="<?= $name; ?>" class="form-control" id="name" class="form-control" autofocus>
						<?php if ($error_name) { ?>
						<div class="help-block error"><?= $error_name; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_description; ?></label>
					<div class="control-field col-sm-6">
						<textarea name="description" class="form-control summernote"><?= $description; ?></textarea>
						<?php if ($error_description) { ?>
						<span class="help-block error"><?= $error_description; ?></span>
						<?php } ?>
					</div>
				</div>
				<?php if ($method == 'insert'): ?>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_is_product; ?></label>
					<div class="control-field col-sm-4">
						<?php if ($is_product): ?>
							<label class="checkbox-inline"><input type="radio" name="is_product" value="1" checked> <?= $lang_text_yes; ?></label>
							<label class="checkbox-inline"><input type="radio" name="is_product" value="0"> <?= $lang_text_no; ?></label>
						<?php else: ?>
							<label class="checkbox-inline"><input type="radio" name="is_product" value="1"> <?= $lang_text_yes; ?></label>
							<label class="checkbox-inline"><input type="radio" name="is_product" value="0" checked> <?= $lang_text_no; ?></label>
						<?php endif; ?>
					</div>
				</div>
				<?php else: ?>
					<input type="hidden" name="is_product" value="<?= $is_product; ?>">
				<?php endif; ?>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_slug; ?></label>
					<div class="control-field col-sm-4">
						<div class="input-group">
							<input type="text" name="slug" value="<?= $slug; ?>" class="form-control" id="slug" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-default" id="event-slug-btn" type="button"><?= $lang_text_build; ?></button>
							</span>
						</div>
						<?php if ($error_slug): ?>
						<span class="help-block error"><?= $error_slug; ?></span>
						<?php endif; ?>
					</div>
				</div>
				<div id="product-panel">
					<input type="hidden" name="product_id" value="<?= $product_id; ?>">
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_model; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="model" value="<?= $model; ?>" class="form-control">
							<?php if ($error_model): ?>
							<span class="help-block error"><?= $error_model; ?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_sku; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="sku" value="<?= $sku; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_stock_status; ?></label>
						<div class="control-field col-sm-4">
							<select name="stock_status_id" class="form-control">
							<?php foreach ($stock_statuses as $stock_status) { ?>
								<?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>
								<option value="<?= $stock_status['stock_status_id']; ?>" selected="selected"><?= $stock_status['name']; ?></option>
								<?php } else { ?>
								<option value="<?= $stock_status['stock_status_id']; ?>"><?= $stock_status['name']; ?></option>
								<?php } ?>
							<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_category; ?></label>
						<div class="control-field col-sm-4">
							<div class="panel panel-default panel-scrollable">
								<div class="list-group list-group-hover">
									<?php foreach ($categories as $category): ?>
									<label class="list-group-item">
									<?php if (in_array($category['category_id'], $product_category)): ?>
										<input type="checkbox" name="product_category[]" value="<?= $category['category_id']; ?>" checked="checked"> <?= $category['name']; ?>
									<?php else: ?>
										<input type="checkbox" name="product_category[]" value="<?= $category['category_id']; ?>"> <?= $category['name']; ?>
									<?php endif; ?>
									</label>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_cost; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="cost" value="<?= $cost; ?>" class="form-control">
							<?php if ($error_cost) { ?>
							<span class="help-block error"><?= $error_cost; ?></span>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_refundable; ?></label>
						<div class="control-field col-sm-4">
							<?php if ($refundable) { ?>
								<label class="checkbox-inline"><input type="radio" name="refundable" value="1" checked> <?= $lang_text_yes; ?></label>
								<label class="checkbox-inline"><input type="radio" name="refundable" value="0"> <?= $lang_text_no; ?></label>
							<?php } else { ?>
								<label class="checkbox-inline"><input type="radio" name="refundable" value="1"> <?= $lang_text_yes; ?></label>
								<label class="checkbox-inline"><input type="radio" name="refundable" value="0" checked> <?= $lang_text_no; ?></label>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_store; ?></label>
						<div class="control-field col-sm-4">
							<div class="panel panel-default panel-scrollable">
								<div class="list-group list-group-hover">
									<label class="list-group-item">
									<?php if (in_array(0, $product_store)) { ?>
										<input type="checkbox" name="product_store[]" value="0" checked="checked" />
										<?= $lang_text_default; ?>
									<?php } else { ?>
										<input type="checkbox" name="product_store[]" value="0" />
										<?= $lang_text_default; ?>
									<?php } ?>
									</label>
									<?php foreach ($stores as $store) { ?>
									<label class="list-group-item">	
									<?php if (in_array($store['store_id'], $product_store)) { ?>
										<input type="checkbox" name="product_store[]" value="<?= $store['store_id']; ?>" checked="checked" />
										<?= $store['name']; ?>
									<?php } else { ?>
										<input type="checkbox" name="product_store[]" value="<?= $store['store_id']; ?>">
										<?= $store['name']; ?>
									<?php } ?>
									</label>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="page-panel">
					<input type="hidden" name="page_id" value="<?= $page_id; ?>">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_page_status; ?></label>
						<div class="control-field col-sm-4">
							<select name="page_status" class="form-control">
								<?php if ($page_status === 1): ?>
								<option value="1" selected><?= $lang_text_posted; ?></option>
								<option value="2"><?= $lang_text_draft; ?></option>
								<option value="0"><?= $lang_text_disabled; ?></option>
								<?php elseif($page_status === 2): ?>
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
						<label class="control-label col-sm-2"><?= $lang_entry_store; ?></label>
						<div class="control-field col-sm-4">
							<div class="panel panel-default panel-scrollable">
								<div class="list-group list-group-hover">
									<label class="list-group-item">
									<?php if (in_array(0, $page_store)) { ?>
										<input type="checkbox" name="page_store[]" value="0" checked="checked" />
										<?= $lang_text_default; ?>
									<?php } else { ?>
										<input type="checkbox" name="page_store[]" value="0" />
										<?= $lang_text_default; ?>
									<?php } ?>
									</label>
									<?php foreach ($stores as $store) { ?>
									<label class="list-group-item">	
									<?php if (in_array($store['store_id'], $page_store)) { ?>
										<input type="checkbox" name="page_store[]" value="<?= $store['store_id']; ?>" checked="checked" />
										<?= $store['name']; ?>
									<?php } else { ?>
										<input type="checkbox" name="page_store[]" value="<?= $store['store_id']; ?>">
										<?= $store['name']; ?>
									<?php } ?>
									</label>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="visibility"><b class="required">*</b> <?= $lang_entry_visibility; ?></label>
					<div class="control-field col-sm-4">
						<select name="visibility" class="form-control">
							<option value="*"><?= $lang_text_select; ?></option>
							<?php foreach($customer_groups as $customer_group): ?>
							<?php if ($customer_group['customer_group_id'] == $visibility): ?> 
							<option value="<?= $customer_group['customer_group_id']; ?>" selected="selected"><?= $customer_group['name']; ?></option>
							<?php else: ?>
							<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
							<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="event_class"><b class="required">*</b> <?= $lang_entry_event_class; ?></label>
					<div class="control-field col-sm-4">
						<div class="panel panel-default panel-scrollable">
							<div class="list-group list-group-hover">
								<?php foreach($event_classes as $class): ?>
								<label class="list-group-item <?= $class['event']; ?>">
									<?php if ($class['event'] == $event_class): ?>
									<input type="checkbox" name="event_class" value="<?= $class['event']; ?>" checked>
									<?= $class['name']; ?>
									<?php else: ?>
									<input type="checkbox" name="event_class" value="<?= $class['event']; ?>">
									<?= $class['name']; ?>
									<?php endif; ?>
								</label>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_event_date; ?></label>
					<div class="col-sm-2">
						<label class="input-group">
							<input type="text" name="event_date" value="<?= $event_date; ?>" class="form-control date" data-date-format="yyyy-mm-dd" autocomplete="off">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</label>
						<?php if ($error_event_date) { ?>
						<span class="help-block error"><?= $error_event_date; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_event_time; ?></label>
					<div class="col-sm-2">
						<label class="input-group">
							<input type="text" name="event_time" value="<?= $event_time; ?>" class="form-control time" data-date-format="H:ii P" autocomplete="off">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</label>
						<?php if ($error_event_time) { ?>
						<span class="help-block error"><?= $error_event_time; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_event_days; ?></label>
					<div class="control-field col-sm-6">
						<?php foreach ($days as $day) { ?>
						<?php if (!empty($event_days)) { ?>
						<?php if (in_array($day, $event_days)) { ?>
						<label class="checkbox-inline">
							<input type="checkbox" name="event_days[]" value="<?= $day; ?>" checked> <?= $day; ?>
						</label>
						<?php } else { ?>
						<label class="checkbox-inline">
							<input type="checkbox" name="event_days[]" value="<?= $day; ?>"> <?= $day; ?>
						</label>
						<?php } ?>
						<?php } else { ?>
						<label class="checkbox-inline">
							<input type="checkbox" name="event_days[]" value="<?= $day; ?>"> <?= $day; ?>
						</label>
						<?php } ?>
						<?php } ?>
						<?php if ($error_event_days) { ?>
						<span class="help-block error"><?= $error_event_days; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_event_length; ?></label>
					<div class="control-field col-sm-1">
						<input type="number" name="event_length" min="1" max="24" value="<?= $event_length; ?>" class="form-control">
						<?php if ($error_event_length) { ?>
							<span class="help-block error"><?= $error_event_length; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_online; ?></label>
					<div class="control-field col-sm-4">
						<?php if ($online) { ?>
							<label class="checkbox-inline"><input type="radio" name="online" value="1" checked> <?= $lang_text_yes; ?></label>
							<label class="checkbox-inline"><input type="radio" name="online" value="0"> <?= $lang_text_no; ?></label>
						<?php } else { ?>
							<label class="checkbox-inline"><input type="radio" name="online" value="1"> <?= $lang_text_yes; ?></label>
							<label class="checkbox-inline"><input type="radio" name="online" value="0" checked> <?= $lang_text_no; ?></label>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_link; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="link" value="<?= $link; ?>" class="form-control">
						<?php if ($error_link) { ?>
						<span class="help-block error"><?= $error_link; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_location; ?></label>
					<div class="control-field col-sm-4">
						<textarea name="location" class="form-control"><?= $location; ?></textarea>
						<?php if ($error_location) { ?>
						<span class="help-block error"><?= $error_location; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_telephone; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="telephone" value="<?= $telephone; ?>" class="form-control">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_seats; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="seats" value="<?= $seats; ?>" class="form-control">
						<?php if ($error_seats) { ?>
						<span class="help-block error"><?= $error_seats; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_presenter_tab; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="presenter_tab" value="<?= $presenter_tab; ?>" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_presenter; ?></label>
					<div class="control-field col-sm-4">
						<select name="presenter" class="form-control">
							<option value="*"><?= $lang_text_select; ?></option>
						<?php foreach ($presenters as $person) { ?>
						<?php if ($presenter == $person['presenter_id']) { ?>
							<option value="<?= $person['presenter_id']; ?>" selected><?= $person['presenter_name']; ?></option>
						<?php } else { ?>
							<option value="<?= $person['presenter_id']; ?>"><?= $person['presenter_name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
					<div class="control-field col-sm-4">
						<select name="status" class="form-control">
							<?php if ($status) { ?>
								<option value="1" selected><?= $lang_text_enabled; ?></option>
								<option value="0"><?= $lang_text_disabled; ?></option>
							<?php } else { ?>
								<option value="1"><?= $lang_text_enabled; ?></option>
								<option value="0" selected><?= $lang_text_disabled; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<input type="hidden" name="product_id" value="<?= $product_id; ?>">
			</form>
		</div>
	</div>
</div>
<?= $footer; ?>