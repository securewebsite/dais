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
			<div class="pull-left h2"><i class="hidden-xs fa fa-tablet"></i><?= $lang_heading_title; ?></div>
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
			<li><a href="#tab-attribute" data-toggle="tab"><?= $lang_tab_attribute; ?></a></li>
			<li><a href="#tab-option" data-toggle="tab"><?= $lang_tab_option; ?></a></li>
			<li><a href="#tab-recurring" data-toggle="tab"><?= $lang_tab_recurring; ?></a></li>
			<li><a href="#tab-discount" data-toggle="tab"><?= $lang_tab_discount; ?></a></li>
			<li><a href="#tab-special" data-toggle="tab"><?= $lang_tab_special; ?></a></li>
			<li><a href="#tab-image" data-toggle="tab"><?= $lang_tab_image; ?></a></li>
			<li><a href="#tab-reward" data-toggle="tab"><?= $lang_tab_reward; ?></a></li>
			<li><a href="#tab-design" data-toggle="tab"><?= $lang_tab_design; ?></a></li>
		</ul>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="tab-content">
				<div class="tab-pane" id="tab-general">
					<div class="row" id="language-tabs">
						<div class="col-sm-2 tabs-left">
							<ul class="nav nav-tabs">
								<?php foreach ($languages as $language) { ?>
									<li><a href="#language<?= $language['language_id']; ?>" data-toggle="tab"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i> <?= $language['name']; ?></a></li>
								<?php } ?>
							</ul>
						</div>
						<div class="col-sm-10">
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
									<div class="tab-pane" id="language<?= $language['language_id']; ?>">
										<div class="form-group">
											<label class="control-label col-sm-2" for="name<?= $language['language_id']; ?>"><b class="required">*</b> <?= $lang_entry_name; ?></label>
											<div class="col-sm-6">
												<input type="text" name="product_description[<?= $language['language_id']; ?>][name]" value="<?= isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>" class="form-control" id="name<?= $language['language_id']; ?>" class="form-control">
												<?php if (isset($error_name[$language['language_id']])) { ?>
												<div class="help-block error"><?= $error_name[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="meta_description<?= $language['language_id']; ?>"><?= $lang_entry_meta_description; ?></label>
											<div class="col-sm-6">
												<textarea name="product_description[<?= $language['language_id']; ?>][meta_description]" class="form-control" rows="3" spellcheck="false" id="meta_description<?= $language['language_id']; ?>"><?= isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="meta_keyword<?= $language['language_id']; ?>"><?= $lang_entry_meta_keyword; ?></label>
											<div class="col-sm-6">
												<textarea name="product_description[<?= $language['language_id']; ?>][meta_keyword]" class="form-control" rows="3" spellcheck="false" id="meta_keyword<?= $language['language_id']; ?>"><?= isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="description<?= $language['language_id']; ?>"><?= $lang_entry_description; ?></label>
											<div class="col-sm-10">
												<textarea name="product_description[<?= $language['language_id']; ?>][description]" class="summernote form-control" rows="10" spellcheck="false"><?= isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['description'] :''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="description<?= $language['language_id']; ?>"><?= $lang_entry_tag; ?></label>
											<div class="col-sm-6">
												<?php if (isset($product_tag)) { ?>
													<input type="text" name="product_tag[<?= $language['language_id']; ?>]" value="<?= isset($product_tag[$language['language_id']]) ? $product_tag[$language['language_id']] : ''; ?>" class="form-control">
												<?php } else { ?>
													<input type="text" name="product_description[<?= $language['language_id']; ?>][tag]" value="<?= isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['tag'] : ''; ?>" class="form-control">
												<?php } ?>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-data">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label col-sm-4"><b class="required">*</b> <?= $lang_entry_model; ?></label>
								<div class="col-sm-6">
									<input type="text" name="model" value="<?= $model; ?>" class="form-control">
									<?php if ($error_model) { ?>
									<div class="help-block error"><?= $error_model; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_sku; ?></label>
								<div class="col-sm-6">
									<input type="text" name="sku" value="<?= $sku; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_upc; ?></label>
								<div class="col-sm-6">
									<input type="text" name="upc" value="<?= $upc; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_ean; ?></label>
								<div class="col-sm-6">
									<input type="text" name="ean" value="<?= $ean; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_jan; ?></label>
								<div class="col-sm-6">
									<input type="text" name="jan" value="<?= $jan; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_isbn; ?></label>
								<div class="col-sm-6">
									<input type="text" name="isbn" value="<?= $isbn; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_mpn; ?></label>
								<div class="col-sm-6">
									<input type="text" name="mpn" value="<?= $mpn; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_location; ?></label>
								<div class="col-sm-6">
									<input type="text" name="location" value="<?= $location; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_price; ?></label>
								<div class="col-sm-6">
									<input type="text" name="price" value="<?= $price; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_tax_class; ?></label>
								<div class="col-sm-6">
									<select name="tax_class_id" class="form-control">
										<option value="0"><?= $lang_text_none; ?></option>
										<?php foreach ($tax_classes as $tax_class) { ?>
										<?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>
										<option value="<?= $tax_class['tax_class_id']; ?>" selected><?= $tax_class['title']; ?></option>
										<?php } else { ?>
										<option value="<?= $tax_class['tax_class_id']; ?>"><?= $tax_class['title']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_quantity; ?></label>
								<div class="col-sm-6">
									<input type="text" name="quantity" value="<?= $quantity; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_minimum; ?></label>
								<div class="col-sm-6">
									<input type="text" name="minimum" value="<?= $minimum; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_subtract; ?></label>
								<div class="col-sm-6">
									<select name="subtract" class="form-control">
										<?php if ($subtract) { ?>
										<option value="1" selected><?= $lang_text_yes; ?></option>
										<option value="0"><?= $lang_text_no; ?></option>
										<?php } else { ?>
										<option value="1"><?= $lang_text_yes; ?></option>
										<option value="0" selected><?= $lang_text_no; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_stock_status; ?></label>
								<div class="col-sm-6">
									<select name="stock_status_id" class="form-control">
										<?php foreach ($stock_statuses as $stock_status) { ?>
										<?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>
										<option value="<?= $stock_status['stock_status_id']; ?>" selected><?= $stock_status['name']; ?></option>
										<?php } else { ?>
										<option value="<?= $stock_status['stock_status_id']; ?>"><?= $stock_status['name']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_shipping; ?></label>
								<div class="col-sm-6">
									<div class="btn-group" data-toggle="buttons">
										<?php if ($shipping) { ?>
										<label class="btn btn-default active"><input type="radio" name="shipping" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="btn btn-default"><input type="radio" name="shipping" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="btn btn-default"><input type="radio" name="shipping" value="1"><?= $lang_text_yes; ?></label>
										<label class="btn btn-default active"><input type="radio" name="shipping" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_slug; ?></label>
								<div class="col-sm-6">
									<div class="input-group">	
										<input type="text" name="slug" value="<?= $slug; ?>" id="slug" class="form-control">
										<span class="input-group-btn">
											<button class="btn btn-default" id="product-slug-btn" type="button"><?= $lang_text_build; ?></button>
										</span>
									</div>
									<?php if ($error_slug): ?>
									<span class="help-block error"><?= $error_slug; ?></span>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_date_available; ?></label>
								<div class="col-sm-6">
									<label class="input-group">
										<input type="text" name="date_available" value="<?= $date_available; ?>" autocomplete="off" class="form-control date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_dimension; ?></label>
								<div class="col-sm-6">
									<div class="slim-row">
										<div class="slim-col-sm-4">
											<input type="text" name="length" value="<?= $length; ?>" class="form-control">
										</div>
										<div class="slim-col-sm-4">
											<input type="text" name="width" value="<?= $width; ?>" class="form-control">
										</div>
										<div class="slim-col-sm-4">
											<input type="text" name="height" value="<?= $height; ?>" class="form-control">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_length; ?></label>
								<div class="col-sm-6">
									<select name="length_class_id" class="form-control">
										<?php foreach ($length_classes as $length_class) { ?>
										<?php if ($length_class['length_class_id'] == $length_class_id) { ?>
										<option value="<?= $length_class['length_class_id']; ?>" selected><?= $length_class['title']; ?></option>
										<?php } else { ?>
										<option value="<?= $length_class['length_class_id']; ?>"><?= $length_class['title']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_weight; ?></label>
								<div class="col-sm-6">
									<input type="text" name="weight" value="<?= $weight; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_weight_class; ?></label>
								<div class="col-sm-6">
									<select name="weight_class_id" class="form-control">
										<?php foreach ($weight_classes as $weight_class) { ?>
										<?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>
										<option value="<?= $weight_class['weight_class_id']; ?>" selected><?= $weight_class['title']; ?></option>
										<?php } else { ?>
										<option value="<?= $weight_class['weight_class_id']; ?>"><?= $weight_class['title']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_status; ?></label>
								<div class="col-sm-6">
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
							<div class="form-group">
								<label class="control-label col-sm-4"><b class="required">*</b> <?= $lang_entry_visibility; ?></label>
								<div class="control-field col-sm-6">
									<select name="visibility" class="form-control">
										<option value="*"><?= $lang_text_select; ?></option>
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
								<label class="control-label col-sm-4"><?= $lang_entry_one_customer; ?></label>
								<div class="control-field col-sm-6">
									<div class="input-group">	
										<input type="text" name="customer" value="<?= $customer; ?>" class="form-control">
										<input type="hidden" name="customer_id" value="<?= $customer_id; ?>">
										<span class="input-group-btn">
											<button class="btn btn-default" id="clear-customer-btn" type="button"><?= $lang_text_clear; ?></button>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4"><?= $lang_entry_sort_order; ?></label>
								<div class="col-sm-6">
									<input type="text" name="sort_order" value="<?= $sort_order; ?>" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-links">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_manufacturer; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="manufacturer" value="<?= $manufacturer ?>" class="form-control" autocomplete="off"><input type="hidden" name="manufacturer_id" value="<?= $manufacturer_id; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_category; ?></label>
						<div class="control-field col-sm-4">
							<p><input type="text" name="category" value="" class="form-control" data-target="product" autocomplete="off"></p>
							<div class="panel panel-default panel-scrollable">
								<div id="product-category" class="list-group">
								<?php foreach ($product_categories as $product_category) { ?>
									<div class="list-group-item" id="product-category<?= $product_category['category_id']; ?>">
									<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><?= $product_category['name']; ?>
									<input type="hidden" name="product_category[]" value="<?= $product_category['category_id']; ?>">
									</div>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_filter; ?></label>
						<div class="control-field col-sm-4">
							<p><input type="text" name="filter" value="" class="form-control" data-target="product" autocomplete="off"></p>
							<div class="panel panel-default panel-scrollable">
								<div id="product-filter" class="list-group">
								<?php foreach ($product_filters as $product_filter) { ?>
									<div class="list-group-item" id="product-filter<?= $product_filter['filter_id']; ?>">
									<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><?= $product_filter['name']; ?>
									<input type="hidden" name="product_filter[]" value="<?= $product_filter['filter_id']; ?>">
									</div>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_store; ?></label>
						<div class="control-field col-sm-4">
							<div class="panel panel-default panel-scrollable">
								<div class="list-group list-group-hover">
									<label class="list-group-item">
										<?php if (in_array(0, $product_store)) { ?>
										<input type="checkbox" name="product_store[]" value="0" checked=""><?= $lang_text_default; ?>
										<?php } else { ?>
										<input type="checkbox" name="product_store[]" value="0"><?= $lang_text_default; ?>
										<?php } ?>
									</label>
									<?php foreach ($stores as $store) { ?>
									<label class="list-group-item">
										<?php if (in_array($store['store_id'], $product_store)) { ?>
										<input type="checkbox" name="product_store[]" value="<?= $store['store_id']; ?>" checked=""><?= $store['name']; ?>
										<?php } else { ?>
										<input type="checkbox" name="product_store[]" value="<?= $store['store_id']; ?>"><?= $store['name']; ?>
										<?php } ?>
									</label>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_download; ?></label>
						<div class="control-field col-sm-4">
							<p><input type="text" name="download" value="" class="form-control" autocomplete="off"></p>
							<div class="panel panel-default panel-scrollable">
								<div id="product-download" class="list-group">
								<?php foreach ($product_downloads as $product_download) { ?>
									<div class="list-group-item" id="product-download<?= $product_download['download_id']; ?>">
									<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><?= $product_download['name']; ?>
									<input type="hidden" name="product_download[]" value="<?= $product_download['download_id']; ?>">
									</div>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_related; ?></label>
						<div class="control-field col-sm-4">
							<p><input type="text" name="related" value="" class="form-control" autocomplete="off"></p>
							<div class="panel panel-default panel-scrollable">
								<div id="product-related" class="list-group">
								<?php foreach ($product_related as $product_related) { ?>
									<div class="list-group-item" id="product-related<?= $product_related['product_id']; ?>">
									<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><?= $product_related['name']; ?>
									<input type="hidden" name="product_related[]" value="<?= $product_related['product_id']; ?>">
									</div>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-attribute">
					<table id="attribute" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="col-sm-4"><?= $lang_entry_attribute; ?></th>
								<th><?= $lang_entry_text; ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php $attribute_row = 0; ?>
							<?php foreach ($product_attributes as $product_attribute) { ?>
								<tr id="attribute-row<?= $attribute_row; ?>">
									<td><input type="text" name="product_attribute[<?= $attribute_row; ?>][name]" value="<?= $product_attribute['name']; ?>" class="form-control">
										<input type="hidden" name="product_attribute[<?= $attribute_row; ?>][attribute_id]" value="<?= $product_attribute['attribute_id']; ?>"></td>
									<td><?php foreach ($languages as $language) { ?>
										<div class="input-group">
											<textarea name="product_attribute[<?= $attribute_row; ?>][product_attribute_description][<?= $language['language_id']; ?>][text]" class="form-control" rows="3"><?= isset($product_attribute['product_attribute_description'][$language['language_id']]) ? $product_attribute['product_attribute_description'][$language['language_id']]['text'] :''; ?></textarea>
											<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span>
										</div>
										<?php } ?></td>
									<td><a onclick="$('#attribute-row<?= $attribute_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
								</tr>
							<?php $attribute_row++; ?>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"></td>
								<td><a onclick="addAttribute();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_attribute; ?></span></a></td>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="tab-pane" id="tab-option">
					<div class="row">
						<div class="col-sm-2">
							<div class="tabs-left">
								<ul id="vtab-option" class="nav nav-tabs">
									<?php $option_row = 0; ?>
									<?php foreach ($product_options as $product_option) { ?>
									<li><a href="#tab-option-<?= $option_row; ?>" id="option-<?= $option_row; ?>" data-toggle="tab">
										<span class="label label-danger" onclick="$('#vtab-option a:first').trigger('click');$('#option-<?= $option_row; ?>').remove();$('#tab-option-<?= $option_row; ?>').remove();return false;"><i class="fa fa-trash-o"></i></span>
										<?= $product_option['name']; ?>
									</a></li>
									<?php $option_row++; ?>
									<?php } ?>
									<li class="action" id="option-add"><label class="input-group">
										<input type="text" name="option" value="" class="form-control">
										<span class="input-group-addon"><i class="fa fa-plus-circle fa-lg" title="<?= $lang_button_add_option; ?>"></i></span>
									</label></li>
								</ul>
							</div>
						</div>
						<div class="col-sm-10">
							<div class="tab-content" id="option-container">
								<?php $option_row = 0; ?>
								<?php $option_value_row = 0; ?>
								<?php foreach ($product_options as $product_option) { ?>
								<div id="tab-option-<?= $option_row; ?>" class="tab-pane">
									<input type="hidden" name="product_option[<?= $option_row; ?>][product_option_id]" value="<?= $product_option['product_option_id']; ?>">
									<input type="hidden" name="product_option[<?= $option_row; ?>][name]" value="<?= $product_option['name']; ?>">
									<input type="hidden" name="product_option[<?= $option_row; ?>][option_id]" value="<?= $product_option['option_id']; ?>">
									<input type="hidden" name="product_option[<?= $option_row; ?>][type]" value="<?= $product_option['type']; ?>">
									<div class="form-group">
										<label class="control-label col-sm-2"><?= $lang_entry_required; ?></label>
										<div class="control-field col-sm-4">
											<select name="product_option[<?= $option_row; ?>][required]" class="form-control">
												<?php if ($product_option['required']) { ?>
												<option value="1" selected><?= $lang_text_yes; ?></option>
												<option value="0"><?= $lang_text_no; ?></option>
												<?php } else { ?>
												<option value="1"><?= $lang_text_yes; ?></option>
												<option value="0" selected><?= $lang_text_no; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<?php if ($product_option['type'] == 'text') { ?>
										<div class="form-group">
											<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="product_option[<?= $option_row; ?>][option_value]" value="<?= $product_option['option_value']; ?>" class="form-control">
											</div>
										</div>
									<?php } elseif ($product_option['type'] == 'textarea') { ?>
										<div class="form-group">
											<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>
											<div class="col-sm-8">
												<textarea name="product_option[<?= $option_row; ?>][option_value]" class="form-control" rows="3"><?= $product_option['option_value']; ?></textarea>
											</div>
										</div>
									<?php } elseif ($product_option['type'] == 'file') { ?>
										<div class="form-group" style="display:none;">
											<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="product_option[<?= $option_row; ?>][option_value]" value="<?= $product_option['option_value']; ?>" class="form-control">
											</div>
										</div>
									<?php } elseif ($product_option['type'] == 'date') { ?>
										<div class="form-group">
											<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>
											<div class="control-field col-sm-4">
												<label class="input-group">
													<input type="text" class="form-control date" name="product_option[<?= $option_row; ?>][option_value]" value="<?= $product_option['option_value']; ?>">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</label>
											</div>
										</div>
									<?php } elseif ($product_option['type'] == 'datetime') { ?>
										<div class="form-group">
											<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>
											<div class="control-field col-sm-4">
												<label class="input-group">
													<input type="text" class="form-control datetime" name="product_option[<?= $option_row; ?>][option_value]" value="<?= $product_option['option_value']; ?>" autocomplete="off">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</label>
											</div>
										</div>
									<?php } elseif ($product_option['type'] == 'time') { ?>
										<div class="form-group">
											<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>
											<div class="control-field col-sm-4">
												<label class="input-group">
													<input type="text" class="form-control time" name="product_option[<?= $option_row; ?>][option_value]" value="<?= $product_option['option_value']; ?>" autocomplete="off">
													<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
												</label>
											</div>
										</div>
									<?php } elseif ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
									<div class="table-responsive">
									<table id="option-value<?= $option_row; ?>" class="table table-bordered table-striped form-inline">
										<thead>
											<tr>
												<th><?= $lang_entry_option_value; ?></th>
												<th class="text-right"><?= $lang_entry_quantity; ?></th>
												<th><?= $lang_entry_subtract; ?></th>
												<th class="text-right"><?= $lang_entry_price; ?></th>
												<th class="text-right"><?= $lang_entry_option_points; ?></th>
												<th class="text-right"><?= $lang_entry_weight; ?></th>
												<th></th>
											</tr>
										</thead>
										<tbody>
										<?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
											<tr id="option-value-row<?= $option_value_row; ?>">
												<td><select name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][option_value_id]" class="form-control">
													<?php if (isset($option_values[$product_option['option_id']])) { ?>
													<?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
													<?php if ($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
													<option value="<?= $option_value['option_value_id']; ?>" selected><?= $option_value['name']; ?></option>
													<?php } else { ?>
													<option value="<?= $option_value['option_value_id']; ?>"><?= $option_value['name']; ?></option>
													<?php } ?>
													<?php } ?>
													<?php } ?>
												</select>
												<input type="hidden" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][product_option_value_id]" value="<?= $product_option_value['product_option_value_id']; ?>"></td>
												<td class="text-right"><input type="text" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][quantity]" value="<?= $product_option_value['quantity']; ?>" class="form-control"></td>
												<td><select name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][subtract]" class="form-control">
													<?php if ($product_option_value['subtract']) { ?>
													<option value="1" selected><?= $lang_text_yes; ?></option>
													<option value="0"><?= $lang_text_no; ?></option>
													<?php } else { ?>
													<option value="1"><?= $lang_text_yes; ?></option>
													<option value="0" selected><?= $lang_text_no; ?></option>
													<?php } ?>
												</select></td>
												<td class="text-right"><div class="input-group">
													<span class="input-group-btn" data-toggle="buttons">
														<?php if ($product_option_value['price_prefix'] == '+') { ?>
															<label class="btn btn-default active"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][price_prefix]" value="+" checked=""><i class="glyphicon glyphicon-plus"></i></label>
														<?php } else { ?>
															<label class="btn btn-default"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][price_prefix]" value="+"><i class="glyphicon glyphicon-plus"></i></label>
														<?php } ?>
														<?php if ($product_option_value['price_prefix'] == '-') { ?>
															<label class="btn btn-default active"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][price_prefix]" value="-" checked=""><i class="glyphicon glyphicon-minus"></i></label>
														<?php } else { ?>
															<label class="btn btn-default"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][price_prefix]" value="-"><i class="glyphicon glyphicon-minus"></i></label>
														<?php } ?>
													</span>
													<input type="text" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][price]" value="<?= $product_option_value['price']; ?>" class="form-control">
												</div></td>
												<td class="text-right"><div class="input-group">
													<span class="input-group-btn" data-toggle="buttons">
														<?php if ($product_option_value['points_prefix'] == '+') { ?>
															<label class="btn btn-default active"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][points_prefix]" value="+" checked=""><i class="glyphicon glyphicon-plus"></i></label>
														<?php } else { ?>
															<label class="btn btn-default"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][points_prefix]" value="+"><i class="glyphicon glyphicon-plus"></i></label>
														<?php } ?>
														<?php if ($product_option_value['points_prefix'] == '-') { ?>
															<label class="btn btn-default active"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][points_prefix]" value="-" checked=""><i class="glyphicon glyphicon-minus"></i></label>
														<?php } else { ?>
															<label class="btn btn-default"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][points_prefix]" value="-"><i class="glyphicon glyphicon-minus"></i></label>
														<?php } ?>
													</span>
													<input type="text" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][points]" value="<?= $product_option_value['points']; ?>" class="form-control">
												</div></td>
												<td class="text-right"><div class="input-group">
													<span class="input-group-btn" data-toggle="buttons">
														<?php if ($product_option_value['weight_prefix'] == '+') { ?>
															<label class="btn btn-default active"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][weight_prefix]" value="+" checked=""><i class="glyphicon glyphicon-plus"></i></label>
														<?php } else { ?>
															<label class="btn btn-default"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][weight_prefix]" value="+"><i class="glyphicon glyphicon-plus"></i></label>
														<?php } ?>
														<?php if ($product_option_value['weight_prefix'] == '-') { ?>
															<label class="btn btn-default active"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][weight_prefix]" value="-" checked=""><i class="glyphicon glyphicon-minus"></i></label>
														<?php } else { ?>
															<label class="btn btn-default"><input type="radio" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][weight_prefix]" value="-"><i class="glyphicon glyphicon-minus"></i></label>
														<?php } ?>
													</span>
													<input type="text" name="product_option[<?= $option_row; ?>][product_option_value][<?= $option_value_row; ?>][weight]" value="<?= $product_option_value['weight']; ?>" class="form-control">
												</div></td>
												<td><a onclick="$('#option-value-row<?= $option_value_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
											</tr>
										<?php $option_value_row++; ?>
										<?php } ?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="7" class="text-right"><a onclick="addOptionValue('<?= $option_row; ?>');" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_option_value; ?></span></a></td>
											</tr>
										</tfoot>
									</table>
									</div>
									<select id="option-values<?= $option_row; ?>" style="display:none;">
										<?php if (isset($option_values[$product_option['option_id']])) { ?>
										<?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
										<option value="<?= $option_value['option_value_id']; ?>"><?= $option_value['name']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
									<?php } ?>
								</div>
								<?php $option_row++; ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-recurring">
					<div class="table-responsive">
						<table id="recurring" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<td class="text-left"><strong><?= $lang_entry_recurring; ?></strong></td>
									<td class="text-left"><strong><?= $lang_entry_customer_group; ?></strong></td>
									<td class="text-left"></td>
								</tr>
							</thead>
						<tbody>
							<?php $recurring_row = 0; ?>
							<?php foreach ($product_recurrings as $product_recurring) { ?>
							<tr id="recurring-row<?= $recurring_row; ?>">
								<td class="text-left">
									<select name="product_recurrings[<?= $recurring_row; ?>][recurring_id]" class="form-control">
									<?php foreach ($recurrings as $recurring) { ?>
									<?php if ($recurring['recurring_id'] == $product_recurring['recurring_id']) { ?>
										<option value="<?= $recurring['recurring_id']; ?>" selected="selected"><?= $recurring['name']; ?></option>
									<?php } else { ?>
										<option value="<?= $recurring['recurring_id']; ?>"><?= $recurring['name']; ?></option>
									<?php } ?>
									<?php } ?>
									</select>
								</td>
								<td class="text-left">
									<select name="product_recurrings[<?= $recurring_row; ?>][customer_group_id]" class="form-control">
									<?php foreach ($customer_groups as $customer_group) { ?>
									<?php if ($customer_group['customer_group_id'] == $product_recurring['customer_group_id']) { ?>
										<option value="<?= $customer_group['customer_group_id']; ?>" selected="selected"><?= $customer_group['name']; ?></option>
									<?php } else { ?>
										<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
									<?php } ?>
									<?php } ?>
									</select>
								</td>
								<td class="text-left">
									<button type="button" onclick="$('#recurring-row<?= $recurring_row; ?>').remove()" class="btn btn-danger">
										<i class="fa fa-trash-o fa-lg"><span class="hidden-xs"> <?= $lang_button_remove; ?></span></i>
									</button>
								</td>
							</tr>
							<?php $recurring_row++; ?>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"></td>
								<td class="text-left">
									<button type="button" onclick="addRecurring()" data-toggle="tooltip" title="<?= $lang_button_add_recurring; ?>" class="btn btn-info">
										<i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_recurring; ?></span></button>
								</td>
							</tr>
						</tfoot>
						</table>
					</div>
				</div>
				<div class="tab-pane" id="tab-discount">
					<div class="table-responsive">
					<table id="discount" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?= $lang_entry_customer_group; ?></th>
								<th class="text-right"><?= $lang_entry_quantity; ?></th>
								<th class="text-right"><?= $lang_entry_priority; ?></th>
								<th class="text-right"><?= $lang_entry_price; ?></th>
								<th class="col-sm-2"><?= $lang_entry_date_start; ?></th>
								<th class="col-sm-2"><?= $lang_entry_date_end; ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $discount_row = 0; ?>
						<?php foreach ($product_discounts as $product_discount) { ?>
							<tr id="discount-row<?= $discount_row; ?>">
								<td><select name="product_discount[<?= $discount_row; ?>][customer_group_id]" class="form-control">
									<?php foreach ($customer_groups as $customer_group) { ?>
									<?php if ($customer_group['customer_group_id'] == $product_discount['customer_group_id']) { ?>
									<option value="<?= $customer_group['customer_group_id']; ?>" selected><?= $customer_group['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select></td>
								<td class="text-right"><input type="text" name="product_discount[<?= $discount_row; ?>][quantity]" value="<?= $product_discount['quantity']; ?>" class="form-control"></td>
								<td class="text-right"><input type="text" name="product_discount[<?= $discount_row; ?>][priority]" value="<?= $product_discount['priority']; ?>" class="form-control"></td>
								<td class="text-right"><input type="text" name="product_discount[<?= $discount_row; ?>][price]" value="<?= $product_discount['price']; ?>" class="form-control"></td>
								<td><label class="input-group"><input type="text" name="product_discount[<?= $discount_row; ?>][date_start]" value="<?= strtotime($product_discount['date_start']) ? $product_discount['date_start'] : ''; ?>" class="form-control date" autocomplete="off"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></label></td>
								<td><label class="input-group"><input type="text" name="product_discount[<?= $discount_row; ?>][date_end]" value="<?= strtotime($product_discount['date_end']) ? $product_discount['date_end'] : ''; ?>" class="form-control date" autocomplete="off"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></label></td>
								<td><a onclick="$('#discount-row<?= $discount_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
							</tr>
						<?php $discount_row++; ?>
						<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="6"></td>
								<td><a onclick="addDiscount();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_discount; ?></span></a></td>
							</tr>
						</tfoot>
					</table>
					</div>
				</div>
				<div class="tab-pane" id="tab-special">
					<div class="table-responsive">
					<table id="special" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?= $lang_entry_customer_group; ?></th>
								<th class="text-right"><?= $lang_entry_priority; ?></th>
								<th class="text-right"><?= $lang_entry_price; ?></th>
								<th class="col-sm-3"><?= $lang_entry_date_start; ?></th>
								<th class="col-sm-3"><?= $lang_entry_date_end; ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $special_row = 0; ?>
						<?php foreach ($product_specials as $product_special) { ?>
							<tr id="special-row<?= $special_row; ?>">
								<td><select name="product_special[<?= $special_row; ?>][customer_group_id]" class="form-control">
									<?php foreach ($customer_groups as $customer_group) { ?>
									<?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
									<option value="<?= $customer_group['customer_group_id']; ?>" selected><?= $customer_group['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select></td>
								<td class="text-right"><input type="text" name="product_special[<?= $special_row; ?>][priority]" value="<?= $product_special['priority']; ?>" class="form-control"></td>
								<td class="text-right"><input type="text" name="product_special[<?= $special_row; ?>][price]" value="<?= $product_special['price']; ?>" class="form-control"></td>
								<td><label class="input-group"><input type="text" name="product_special[<?= $special_row; ?>][date_start]" value="<?= strtotime($product_special['date_start']) ? $product_special['date_start'] : ''; ?>" class="form-control date" autocomplete="off"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></label></td>
								<td><label class="input-group"><input type="text" name="product_special[<?= $special_row; ?>][date_end]" value="<?= strtotime($product_special['date_end']) ? $product_special['date_end'] : ''; ?>" class="form-control date" autocomplete="off"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></label></td>
								<td><a onclick="$('#special-row<?= $special_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
							</tr>
						<?php $special_row++; ?>
						<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5"></td>
								<td><a onclick="addSpecial();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="visible-desktop"> <?= $lang_button_add_special; ?></span></a></td>
							</tr>
						</tfoot>
					</table>
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
						<?php $sort_order = array(); foreach ($product_images as $key => $product_image) { $sort_order[$key] = $product_image['sort_order']; } array_multisort($sort_order, SORT_ASC, $product_images); ?>
						<?php foreach ($product_images as $product_image) { ?>
							<tr id="image-row<?= $image_row; ?>">
								<td><div class="media">
									<a class="pull-left" onclick="image_upload('image<?= $image_row; ?>','thumb<?= $image_row; ?>');"><img class="img-thumbnail" src="<?= $product_image['thumb']; ?>" width="100" height="100" alt="" id="thumb<?= $image_row; ?>"></a>
									<input type="hidden" name="product_image[<?= $image_row; ?>][image]" value="<?= $product_image['image']; ?>" id="image<?= $image_row; ?>">
									<div class="media-body hidden-xs">
										<a class="btn btn-default" onclick="image_upload('image<?= $image_row; ?>','thumb<?= $image_row; ?>');"><?= $lang_text_browse; ?></a>&nbsp;
										<a class="btn btn-default" onclick="$('#thumb<?= $image_row; ?>').attr('src', '<?= $no_image; ?>'); $('#image<?= $image_row; ?>').val('');"><?= $lang_text_clear; ?></a>
									</div>
								</div></td>
								<td class="text-right"><input type="text" name="product_image[<?= $image_row; ?>][sort_order]" value="<?= $product_image['sort_order']; ?>" class="form-control"></td>
								<td><a onclick="$('#image-row<?= $image_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
							</tr>
						<?php $image_row++; ?>
						<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"></td>
								<td><a onclick="addImage();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_image; ?></span></a></td>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="tab-pane" id="tab-reward">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_points; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="points" value="<?= $points; ?>" class="form-control">
						</div>
					</div>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?= $lang_entry_customer_group; ?></th>
								<th><?= $lang_entry_reward; ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($customer_groups as $customer_group) { ?>
							<tr>
								<td><?= $customer_group['name']; ?></td>
								<td><input type="text" name="product_reward[<?= $customer_group['customer_group_id']; ?>][points]" value="<?= isset($product_reward[$customer_group['customer_group_id']]) ? $product_reward[$customer_group['customer_group_id']]['points'] :''; ?>" class="form-control"></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="tab-design">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th><?= $lang_entry_store; ?></th>
								<th><?= $lang_entry_layout; ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?= $lang_text_default; ?></td>
								<td><select name="product_layout[0][layout_id]" class="form-control">
									<option value="">&ndash;</option>
									<?php foreach ($layouts as $layout) { ?>
									<?php if (isset($product_layout[0]) && $product_layout[0] == $layout['layout_id']) { ?>
									<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select></td>
							</tr>
							<?php foreach ($stores as $store) { ?>
								<tr>
									<td><?= $store['name']; ?></td>
									<td><select name="product_layout[<?= $store['store_id']; ?>][layout_id]" class="form-control">
										<option value="">&ndash;</option>
										<?php foreach ($layouts as $layout) { ?>
										<?php if (isset($product_layout[$store['store_id']]) && $product_layout[$store['store_id']] == $layout['layout_id']) { ?>
										<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
										<?php } else { ?>
										<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
										<?php } ?>
										<?php } ?>
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
<script>
var attribute_row=<?= $attribute_row; ?>;
var option_row=<?= $option_row; ?>;
var option_value_row=<?= $option_value_row; ?>;
var discount_row=<?= $discount_row; ?>;
var special_row=<?= $special_row; ?>;
var image_row=<?= $image_row; ?>;
var recurring_row=<?= $recurring_row; ?>;
</script>
<?= $footer; ?>