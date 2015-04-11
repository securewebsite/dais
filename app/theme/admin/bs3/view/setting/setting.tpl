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
			<div class="pull-left h2"><i class="hidden-xs fa fa-cog"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<a class="btn btn-danger" href="<?= $flush; ?>">
					<i class="fa fa-refresh"></i><span class="hidden-xs"> <?= $lang_button_flush; ?></span>
				</a>
				<button type="submit" form="form" class="btn btn-primary">
					<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span>
				</button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
					<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span>
				</a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li>
			<li><a href="#tab-store" data-toggle="tab"><?= $lang_tab_store; ?></a></li>
			<li><a href="#tab-local" data-toggle="tab"><?= $lang_tab_local; ?></a></li>
			<li><a href="#tab-option" data-toggle="tab"><?= $lang_tab_option; ?></a></li>
			<li><a href="#tab-image" data-toggle="tab"><?= $lang_tab_image; ?></a></li>
			<li><a href="#tab-ftp" data-toggle="tab"><?= $lang_tab_ftp; ?></a></li>
			<li><a href="#tab-mail" data-toggle="tab"><?= $lang_tab_mail; ?></a></li>
			<li><a href="#tab-fraud" data-toggle="tab"><?= $lang_tab_fraud; ?></a></li>
			<li><a href="#tab-server" data-toggle="tab"><?= $lang_tab_server; ?></a></li>
			<li><a href="#tab-cache" data-toggle="tab"><?= $lang_tab_cache; ?></a></li>
		</ul>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="tab-content">
				<div id="tab-general" class="tab-pane">
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_name; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_name" value="<?= $config_name; ?>" class="form-control">
							<?php if ($error_name) { ?>
								<div class="help-block error"><?= $error_name; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_owner; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_owner" value="<?= $config_owner; ?>" class="form-control">
							<?php if ($error_owner) { ?>
								<div class="help-block error"><?= $error_owner; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_address; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="config_address" class="form-control" rows="3"><?= $config_address; ?></textarea>
							<?php if ($error_address) { ?>
								<div class="help-block error"><?= $error_address; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_email; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_email" value="<?= $config_email; ?>" class="form-control">
							<?php if ($error_email) { ?>
								<div class="help-block error"><?= $error_email; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_telephone; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_telephone" value="<?= $config_telephone; ?>" class="form-control">
							<?php if ($error_telephone) { ?>
								<div class="help-block error"><?= $error_telephone; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_default_visibility; ?></label>
						<div class="control-field col-sm-3">
							<select name="config_default_visibility" class="form-control">
								<option value="0"><?= $lang_text_select; ?></option>
								<?php foreach ($customer_groups as $customer_group): ?>
								<?php if ($customer_group['customer_group_id'] == $config_default_visibility): ?>
								<option value="<?= $customer_group['customer_group_id']; ?>" selected><?= $customer_group['name']; ?></option>
								<?php else: ?>
								<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
							</select>
							<?php if ($error_default_visibility): ?>
								<div class="help-block error"><?= $error_default_visibility; ?></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_free_customer; ?></label>
						<div class="control-field col-sm-3">
							<select name="config_free_customer" class="form-control">
								<option value="0"><?= $lang_text_select; ?></option>
								<?php foreach ($customer_groups as $customer_group): ?>
								<?php if ($customer_group['customer_group_id'] == $config_free_customer): ?>
								<option value="<?= $customer_group['customer_group_id']; ?>" selected><?= $customer_group['name']; ?></option>
								<?php else: ?>
								<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
							</select>
							<?php if ($error_free_customer): ?>
								<div class="help-block error"><?= $error_free_customer; ?></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_top_customer; ?></label>
						<div class="control-field col-sm-3">
							<select name="config_top_customer" class="form-control">
								<option value="0"><?= $lang_text_select; ?></option>
								<?php foreach ($customer_groups as $customer_group): ?>
								<?php if ($customer_group['customer_group_id'] == $config_top_customer): ?>
								<option value="<?= $customer_group['customer_group_id']; ?>" selected><?= $customer_group['name']; ?></option>
								<?php else: ?>
								<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
							</select>
							<?php if ($error_top_customer): ?>
								<div class="help-block error"><?= $error_top_customer; ?></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_site_style; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_site_style" class="form-control">
								<?php foreach ($site_styles as $style): ?>
									<?php if ($style['type'] == $config_site_style): ?>
									<option value="<?= $style['type']; ?>" selected><?= $style['name']; ?></option>
									<?php else: ?>
									<option value="<?= $style['type']; ?>"><?= $style['name']; ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_home_page; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_home_page" class="form-control">
								<option value="0"><?= $lang_text_select; ?></option>
								<?php foreach ($pages as $page): ?>
									<?php if ($page['page_id'] == $config_home_page): ?>
									<option value="<?= $page['page_id']; ?>" selected><?= $page['title']; ?></option>
									<?php else: ?>
									<option value="<?= $page['page_id']; ?>"><?= $page['title']; ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div id="tab-store" class="tab-pane">
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_title; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_title" value="<?= $config_title; ?>" class="form-control">
							<?php if ($error_title) { ?>
								<div class="help-block error"><?= $error_title; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_meta_description; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="config_meta_description" class="form-control" rows="3"><?= $config_meta_description; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_theme; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_theme" onchange="$('#theme').load('index.php?route=setting/setting/theme&token=<?= $token; ?>&theme='+encodeURIComponent(this.value));" class="form-control">
								<?php foreach ($themes as $theme) { ?>
									<?php if ($theme == $config_theme) { ?>
									<option value="<?= $theme; ?>" selected><?= $theme; ?></option>
									<?php } else { ?>
									<option value="<?= $theme; ?>"><?= $theme; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<div class="help-block" id="theme"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_admin_theme; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_admin_theme" onchange="$('#admin_theme').load('index.php?route=setting/setting/admin_theme&amp;token=<?= $token; ?>&amp;theme='+encodeURIComponent(this.value));" class="form-control">
								<?php foreach ($admin_themes as $theme) { ?>
									<?php if ($theme == $config_admin_theme) { ?>
									<option value="<?= $theme; ?>" selected><?= $theme; ?></option>
									<?php } else { ?>
									<option value="<?= $theme; ?>"><?= $theme; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<div class="help-block" id="admin_theme"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_layout; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_layout_id" class="form-control">
								<?php foreach ($layouts as $layout) { ?>
									<?php if ($layout['layout_id'] == $config_layout_id) { ?>
									<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div id="tab-local" class="tab-pane">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_country; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_country_id" data-id="<?= $config_zone_id; ?>" data-none="<?= $lang_text_none; ?>" class="form-control">
								<?php foreach ($countries as $country) { ?>
									<?php if ($country['country_id'] == $config_country_id) { ?>
									<option value="<?= $country['country_id']; ?>" selected><?= $country['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $country['country_id']; ?>"><?= $country['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_zone; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_zone_id" class="form-control"></select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_language; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_language" class="form-control">
								<?php foreach ($languages as $language) { ?>
									<?php if ($language['code'] == $config_language) { ?>
									<option value="<?= $language['code']; ?>" selected><?= $language['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $language['code']; ?>"><?= $language['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_admin_language; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_admin_language" class="form-control">
								<?php foreach ($languages as $language) { ?>
									<?php if ($language['code'] == $config_admin_language) { ?>
									<option value="<?= $language['code']; ?>" selected><?= $language['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $language['code']; ?>"><?= $language['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_currency; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_currency" class="form-control">
								<?php foreach ($currencies as $currency) { ?>
									<?php if ($currency['code'] == $config_currency) { ?>
									<option value="<?= $currency['code']; ?>" selected><?= $currency['title']; ?></option>
									<?php } else { ?>
									<option value="<?= $currency['code']; ?>"><?= $currency['title']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_currency_auto; ?></label>
						<div class="col-sm-6">
							<?php if ($config_currency_auto) { ?>
								<label class="radio-inline"><input type="radio" name="config_currency_auto" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_currency_auto" value="0"><?= $lang_text_no; ?></label>
								<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="config_currency_auto" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_currency_auto" value="0" checked=""><?= $lang_text_no; ?></label>
								<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_length_class; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_length_class_id" class="form-control">
								<?php foreach ($length_classes as $length_class) { ?>
									<?php if ($length_class['length_class_id'] == $config_length_class_id) { ?>
									<option value="<?= $length_class['length_class_id']; ?>" selected><?= $length_class['title']; ?></option>
									<?php } else { ?>
									<option value="<?= $length_class['length_class_id']; ?>"><?= $length_class['title']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_weight_class; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_weight_class_id" class="form-control">
								<?php foreach ($weight_classes as $weight_class) { ?>
									<?php if ($weight_class['weight_class_id'] == $config_weight_class_id) { ?>
									<option value="<?= $weight_class['weight_class_id']; ?>" selected><?= $weight_class['title']; ?></option>
									<?php } else { ?>
									<option value="<?= $weight_class['weight_class_id']; ?>"><?= $weight_class['title']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div id="tab-option" class="tab-pane">
					<div>
						<ul class="nav nav-tabs">
							<li><a href="#tab-items" data-toggle="tab"><?= $lang_text_items; ?></a></li>
							<li><a href="#tab-product" data-toggle="tab"><?= $lang_text_product; ?></a></li>
							<li><a href="#tab-blog" data-toggle="tab"><?= $lang_tab_blog; ?></a></li>
							<li><a href="#tab-giftcard" data-toggle="tab"><?= $lang_text_giftcard; ?></a></li>
							<li><a href="#tab-tax" data-toggle="tab"><?= $lang_text_tax; ?></a></li>
							<li><a href="#tab-account" data-toggle="tab"><?= $lang_text_account; ?></a></li>
							<li><a href="#tab-checkout" data-toggle="tab"><?= $lang_text_checkout; ?></a></li>
							<li><a href="#tab-stock" data-toggle="tab"><?= $lang_text_stock; ?></a></li>
							<li><a href="#tab-affiliate" data-toggle="tab"><?= $lang_text_affiliate; ?></a></li>
							<li><a href="#tab-return" data-toggle="tab"><?= $lang_text_return; ?></a></li>
						</ul>
						<div class="tab-content">
							<div id="tab-items" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_catalog_limit; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="config_catalog_limit" value="<?= $config_catalog_limit; ?>" class="form-control">
										<?php if ($error_catalog_limit) { ?>
											<div class="help-block error"><?= $error_catalog_limit; ?></div>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_admin_limit; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="config_admin_limit" value="<?= $config_admin_limit; ?>" class="form-control">
										<?php if ($error_admin_limit) { ?>
											<div class="help-block error"><?= $error_admin_limit; ?></div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div id="tab-product" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_product_count; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_product_count) { ?>
										<label class="radio-inline"><input type="radio" name="config_product_count" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_product_count" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_product_count" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_product_count" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_review; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_review_status) { ?>
										<label class="radio-inline"><input type="radio" name="config_review_status" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_review_status" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_review_status" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_review_status" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_review_anonymous; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_review_logged) { ?>
										<label class="radio-inline"><input type="radio" name="config_review_logged" value="1" checked><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_review_logged" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_review_logged" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_review_logged" value="0" checked><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_download; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_download) { ?>
										<label class="radio-inline"><input type="radio" name="config_download" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_download" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_download" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_download" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
							</div>
							<div id="tab-blog" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2" for="blog_posted_by"><b class="required">*</b> <?= $lang_entry_blog_posted_by; ?></label>
									<div class="control-field col-sm-4">
										<select name="blog_posted_by" class="form-control">
											<option value="0"><?= $lang_text_select; ?></option>
										<?php if ($blog_posted_by == 'firstname lastname'): ?>
											<option value="firstname lastname" selected="selected"><?= $lang_text_blog_pb_firstname_lastname; ?></option>
											<option value="lastname firstname"><?= $lang_text_blog_pb_lastname_firstname; ?></option>
											<option value="user_name"><?= $lang_text_blog_pb_username; ?></option>
										<?php elseif ($blog_posted_by == 'lastname firstname'): ?>
											<option value="firstname lastname"><?= $lang_text_blog_pb_firstname_lastname; ?></option>
											<option value="lastname firstname" selected="selected"><?= $lang_text_blog_pb_lastname_firstname; ?></option>
											<option value="user_name"><?= $lang_text_blog_pb_username; ?></option>
										<?php elseif($blog_posted_by == 'user_name'): ?>
											<option value="firstname lastname"><?= $lang_text_blog_pb_firstname_lastname; ?></option>
											<option value="lastname firstname"><?= $lang_text_blog_pb_lastname_firstname; ?></option>
											<option value="user_name" selected="selected"><?= $lang_text_blog_pb_username; ?></option>
										<?php else: ?>
											<option value="firstname lastname"><?= $lang_text_blog_pb_firstname_lastname; ?></option>
											<option value="lastname firstname"><?= $lang_text_blog_pb_lastname_firstname; ?></option>
											<option value="user_name"><?= $lang_text_blog_pb_username; ?></option>
										<?php endif; ?>
										</select>
										<?php if ($error_blog_posted_by): ?>
										<span class="help-block error"><?= $error_blog_posted_by; ?></span>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="blog_comment_status"><?= $lang_entry_blog_comment; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($blog_comment_status): ?>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_status" value="1" checked="checked"> <?= $lang_text_yes; ?>
										</label>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_status" value="0"> <?= $lang_text_no; ?>
										</label>
										<?php else: ?>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_status" value="1"> <?= $lang_text_yes; ?>
										</label>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_status" value="0" checked="checked"> <?= $lang_text_no; ?>
										</label>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="blog_comment_logged"><?= $lang_entry_blog_comment_anonymous; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($blog_comment_logged): ?>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_logged" value="1" checked> <?= $lang_text_yes; ?>
										</label>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_logged" value="0"> <?= $lang_text_no; ?>
										</label>
										<?php else: ?>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_logged" value="1"> <?= $lang_text_yes; ?>
										</label>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_logged" value="0" checked> <?= $lang_text_no; ?>
										</label>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="blog_comment_require_approve"><?= $lang_entry_blog_comment_require_approve; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($blog_comment_require_approve): ?>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_require_approve" value="1" checked="checked"> <?= $lang_text_yes; ?>
										</label>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_require_approve" value="0"> <?= $lang_text_no; ?>
										</label>
										<?php else: ?>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_require_approve" value="1"> <?= $lang_text_yes; ?>
										</label>
										<label class="radio-inline">
											<input type="radio" name="blog_comment_require_approve" value="0" checked="checked"> <?= $lang_text_no; ?>
										</label>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="blog_admin_group_id"><b class="required">*</b> <?= $lang_entry_blog_admin_group; ?></label>
									<div class="control-field col-sm-4">
										<select name="blog_admin_group_id" class="form-control">
											<option value="0"><?= $lang_text_select; ?></option>
											<?php foreach($user_groups as $user_group): ?>
											<?php if ($user_group['user_group_id'] == $blog_admin_group_id): ?>
											<option value="<?= $user_group['user_group_id']; ?>" selected="selected"><?= $user_group['name']; ?></option>
											<?php else: ?>
											<option value="<?= $user_group['user_group_id']; ?>"><?= $user_group['name']; ?></option>
											<?php endif; ?>
											<?php endforeach; ?>
										</select>
										<?php if ($error_blog_admin_group_id): ?>
										<span class="help-block error"><?= $error_blog_admin_group_id; ?></span>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_blog_image_thumb; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="blog_image_thumb_width" value="<?= $blog_image_thumb_width; ?>" class="form-control" placeholder="<?= $lang_text_blog_width; ?>"> 
										<input type="text" name="blog_image_thumb_height" value="<?= $blog_image_thumb_height; ?>" class="form-control" placeholder="<?= $lang_text_blog_height; ?>">
										<?php if ($error_blog_image_thumb): ?>
										<span class="help-block error"><?= $error_blog_image_thumb; ?></span>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_blog_image_popup; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="blog_image_popup_width" value="<?= $blog_image_popup_width; ?>" class="form-control" placeholder="<?= $lang_text_blog_width; ?>">
										<input type="text" name="blog_image_popup_height" value="<?= $blog_image_popup_height; ?>" class="form-control" placeholder="<?= $lang_text_blog_height; ?>">
										<?php if ($error_blog_image_popup): ?>
										<span class="help-block error"><?= $error_blog_image_popup; ?></span>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_blog_image_post; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="blog_image_post_width" value="<?= $blog_image_post_width; ?>" class="form-control" placeholder="<?= $lang_text_blog_width; ?>">
										<input type="text" name="blog_image_post_height" value="<?= $blog_image_post_height; ?>" class="form-control" placeholder="<?= $lang_text_blog_height; ?>">
										<?php if ($error_blog_image_post): ?>
										<span class="help-block error"><?= $error_blog_image_post; ?></span>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_blog_image_additional; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="blog_image_additional_width" value="<?= $blog_image_additional_width; ?>" class="form-control" placeholder="<?= $lang_text_blog_width; ?>">
										<input type="text" name="blog_image_additional_height" value="<?= $blog_image_additional_height; ?>" class="form-control" placeholder="<?= $lang_text_blog_height; ?>">
										<?php if ($error_blog_image_additional): ?>
										<span class="help-block error"><?= $error_blog_image_additional; ?></span>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_blog_image_related; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="blog_image_related_width" value="<?= $blog_image_related_width; ?>" class="form-control" placeholder="<?= $lang_text_blog_width; ?>">
										<input type="text" name="blog_image_related_height" value="<?= $blog_image_related_height; ?>" class="form-control" placeholder="<?= $lang_text_blog_height; ?>">
										<?php if ($error_blog_image_related): ?>
										<span class="help-block error"><?= $error_blog_image_related; ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div id="tab-giftcard" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_giftcard_min; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="config_giftcard_min" value="<?= $config_giftcard_min; ?>" class="form-control">
										<?php if ($error_giftcard_min) { ?>
											<div class="help-block error"><?= $error_giftcard_min; ?></div>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_giftcard_max; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="config_giftcard_max" value="<?= $config_giftcard_max; ?>" class="form-control">
										<?php if ($error_giftcard_max) { ?>
											<div class="help-block error"><?= $error_giftcard_max; ?></div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div id="tab-tax" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_tax; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_tax) { ?>
										<label class="radio-inline"><input type="radio" name="config_tax" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_tax" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_tax" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_tax" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_vat; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_vat) { ?>
										<label class="radio-inline"><input type="radio" name="config_vat" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_vat" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_vat" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_vat" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_tax_default; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_tax_default" class="form-control">
											<option value=""><?= $lang_text_none; ?></option>
											<?php	if ($config_tax_default == 'shipping') { ?>
											<option value="shipping" selected><?= $lang_text_shipping; ?></option>
											<?php } else { ?>
											<option value="shipping"><?= $lang_text_shipping; ?></option>
											<?php } ?>
											<?php	if ($config_tax_default == 'payment') { ?>
											<option value="payment" selected><?= $lang_text_payment; ?></option>
											<?php } else { ?>
											<option value="payment"><?= $lang_text_payment; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_tax_customer; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_tax_customer" class="form-control">
											<option value=""><?= $lang_text_none; ?></option>
											<?php	if ($config_tax_customer == 'shipping') { ?>
											<option value="shipping" selected><?= $lang_text_shipping; ?></option>
											<?php } else { ?>
											<option value="shipping"><?= $lang_text_shipping; ?></option>
											<?php } ?>
											<?php	if ($config_tax_customer == 'payment') { ?>
											<option value="payment" selected><?= $lang_text_payment; ?></option>
											<?php } else { ?>
											<option value="payment"><?= $lang_text_payment; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div id="tab-account" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_customer_online; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_customer_online) { ?>
										<label class="radio-inline"><input type="radio" name="config_customer_online" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_customer_online" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_customer_online" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_customer_online" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>	
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_customer_group; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_customer_group_id" class="form-control">
											<?php foreach ($customer_groups as $customer_group) { ?>
												<?php if ($customer_group['customer_group_id'] == $config_customer_group_id) { ?>
												<option value="<?= $customer_group['customer_group_id']; ?>" selected><?= $customer_group['name']; ?></option>
												<?php } else { ?>
												<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_customer_group_display; ?></label>
									<div class="control-field col-sm-4">
										<div class="panel panel-default panel-scrollable">
											<div class="list-group">
											<?php foreach ($customer_groups as $customer_group) { ?>
												<label class="list-group-item">
													<?php if (in_array($customer_group['customer_group_id'], $config_customer_group_display)) { ?>
													<input type="checkbox" name="config_customer_group_display[]" value="<?= $customer_group['customer_group_id']; ?>" checked="">
													<?= $customer_group['name']; ?>
													<?php } else { ?>
													<input type="checkbox" name="config_customer_group_display[]" value="<?= $customer_group['customer_group_id']; ?>">
													<?= $customer_group['name']; ?>
													<?php } ?>
												</label>
											<?php } ?>
											</div>
										</div>
										<?php if ($error_customer_group_display) { ?>
											<div class="help-block error"><?= $error_customer_group_display; ?></div>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_customer_price; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_customer_price) { ?>
										<label class="radio-inline"><input type="radio" name="config_customer_price" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_customer_price" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_customer_price" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_customer_price" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_account; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_account_id" class="form-control">
											<option value="0"><?= $lang_text_none; ?></option>
											<?php foreach ($pages as $page) { ?>
												<?php if ($page['page_id'] == $config_account_id) { ?>
												<option value="<?= $page['page_id']; ?>" selected><?= $page['title']; ?></option>
												<?php } else { ?>
												<option value="<?= $page['page_id']; ?>"><?= $page['title']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div id="tab-checkout" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_cart_weight; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_cart_weight) { ?>
										<label class="radio-inline"><input type="radio" name="config_cart_weight" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_cart_weight" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_cart_weight" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_cart_weight" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_guest_checkout; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_guest_checkout) { ?>
										<label class="radio-inline"><input type="radio" name="config_guest_checkout" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_guest_checkout" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_guest_checkout" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_guest_checkout" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_checkout; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_checkout_id" class="form-control">
											<option value="0"><?= $lang_text_none; ?></option>
											<?php foreach ($pages as $page) { ?>
												<?php if ($page['page_id'] == $config_checkout_id) { ?>
												<option value="<?= $page['page_id']; ?>" selected><?= $page['title']; ?></option>
												<?php } else { ?>
												<option value="<?= $page['page_id']; ?>"><?= $page['title']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_order_edit; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="config_order_edit" value="<?= $config_order_edit; ?>" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_invoice_prefix; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="config_invoice_prefix" value="<?= $config_invoice_prefix; ?>" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_order_status; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_order_status_id" class="form-control">
											<?php foreach ($order_statuses as $order_status) { ?>
												<?php if ($order_status['order_status_id'] == $config_order_status_id) { ?>
												<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
												<?php } else { ?>
												<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_complete_status; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_complete_status_id" class="form-control">
											<?php foreach ($order_statuses as $order_status) { ?>
												<?php if ($order_status['order_status_id'] == $config_complete_status_id) { ?>
												<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
												<?php } else { ?>
												<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div id="tab-stock" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_stock_display; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_stock_display) { ?>
										<label class="radio-inline"><input type="radio" name="config_stock_display" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_stock_display" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_stock_display" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_stock_display" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_stock_warning; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_stock_warning) { ?>
										<label class="radio-inline"><input type="radio" name="config_stock_warning" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_stock_warning" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_stock_warning" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_stock_warning" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_stock_checkout; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_stock_checkout) { ?>
										<label class="radio-inline"><input type="radio" name="config_stock_checkout" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_stock_checkout" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_stock_checkout" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_stock_checkout" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_stock_status; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_stock_status_id" class="form-control">
											<?php foreach ($stock_statuses as $stock_status) { ?>
												<?php if ($stock_status['stock_status_id'] == $config_stock_status_id) { ?>
												<option value="<?= $stock_status['stock_status_id']; ?>" selected><?= $stock_status['name']; ?></option>
												<?php } else { ?>
												<option value="<?= $stock_status['stock_status_id']; ?>"><?= $stock_status['name']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div id="tab-affiliate" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_affiliate_allowed; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_affiliate_allowed) { ?>
										<label class="radio-inline"><input type="radio" name="config_affiliate_allowed" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_affiliate_allowed" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_affiliate_allowed" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_affiliate_allowed" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_affiliate_terms; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_affiliate_terms" class="form-control">
											<option value="0"><?= $lang_text_none; ?></option>
											<?php foreach ($pages as $page) { ?>
												<?php if ($page['page_id'] == $config_affiliate_terms) { ?>
												<option value="<?= $page['page_id']; ?>" selected><?= $page['title']; ?></option>
												<?php } else { ?>
												<option value="<?= $page['page_id']; ?>"><?= $page['title']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
										<?php if ($error_affiliate_terms) { ?>
											<div class="help-block error"><?= $error_affiliate_terms; ?></div>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_commission; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="config_commission" value="<?= $config_commission; ?>" class="form-control">
										<?php if ($error_commission) { ?>
											<div class="help-block error"><?= $error_commission; ?></div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div id="tab-return" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_return; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_return_id" class="form-control">
											<option value="0"><?= $lang_text_none; ?></option>
											<?php foreach ($pages as $page) { ?>
											<?php if ($page['page_id'] == $config_return_id) { ?>
											<option value="<?= $page['page_id']; ?>" selected><?= $page['title']; ?></option>
											<?php } else { ?>
											<option value="<?= $page['page_id']; ?>"><?= $page['title']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_return_status; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_return_status_id" class="form-control">
											<?php foreach ($return_statuses as $return_status) { ?>
												<?php if ($return_status['return_status_id'] == $config_return_status_id) { ?>
												<option value="<?= $return_status['return_status_id']; ?>" selected><?= $return_status['name']; ?></option>
												<?php } else { ?>
												<option value="<?= $return_status['return_status_id']; ?>"><?= $return_status['name']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="tab-image" class="tab-pane">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_logo; ?></label>
						<div class="col-sm-1">
							<a onclick="image_upload('logo','thumb-logo');"><img class="img-thumbnail" src="<?= $logo; ?>" width="100" height="100" alt="" id="thumb-logo"></a>
						</div>
						<div class="control-field col-sm-4">
							<input type="hidden" name="config_logo" value="<?= $config_logo; ?>" id="logo">
							<a class="btn btn-default" onclick="image_upload('logo','thumb-logo');"><?= $lang_text_browse; ?></a>&nbsp;
							<a class="btn btn-default" onclick="$('#thumb-logo').attr('src', '<?= $no_image; ?>'); $('#logo').val('');"><?= $lang_text_clear; ?></a>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_icon; ?></label>
						<div class="col-sm-1">
							<a onclick="image_upload('icon','thumb-icon');"><img class="img-thumbnail" src="<?= $icon; ?>" width="100" height="100" alt="" id="thumb-icon"></a>
						</div>
						<div class="control-field col-sm-4">
							<input type="hidden" name="config_icon" value="<?= $config_icon; ?>" id="icon">
							<a class="btn btn-default" onclick="image_upload('icon','thumb-icon');"><?= $lang_text_browse; ?></a>&nbsp;
							<a class="btn btn-default" onclick="$('#thumb-icon').attr('src', '<?= $no_image; ?>'); $('#icon').val('');"><?= $lang_text_clear; ?></a>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_category; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_category_width" value="<?= $config_image_category_width; ?>" class="form-control"> <input type="text" name="config_image_category_height" value="<?= $config_image_category_height; ?>" class="form-control">
							<?php if ($error_image_category) { ?>
								<div class="help-block error"><?= $error_image_category; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_thumb; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_thumb_width" value="<?= $config_image_thumb_width; ?>" class="form-control"> <input type="text" name="config_image_thumb_height" value="<?= $config_image_thumb_height; ?>" class="form-control">
							<?php if ($error_image_thumb) { ?>
								<div class="help-block error"><?= $error_image_thumb; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_popup; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_popup_width" value="<?= $config_image_popup_width; ?>" class="form-control"> <input type="text" name="config_image_popup_height" value="<?= $config_image_popup_height; ?>" class="form-control">
							<?php if ($error_image_popup) { ?>
								<div class="help-block error"><?= $error_image_popup; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_product; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_product_width" value="<?= $config_image_product_width; ?>" class="form-control"> <input type="text" name="config_image_product_height" value="<?= $config_image_product_height; ?>" class="form-control">
							<?php if ($error_image_product) { ?>
								<div class="help-block error"><?= $error_image_product; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_additional; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_additional_width" value="<?= $config_image_additional_width; ?>" class="form-control"> <input type="text" name="config_image_additional_height" value="<?= $config_image_additional_height; ?>" class="form-control">
							<?php if ($error_image_additional) { ?>
								<div class="help-block error"><?= $error_image_additional; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_related; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_related_width" value="<?= $config_image_related_width; ?>" class="form-control"> <input type="text" name="config_image_related_height" value="<?= $config_image_related_height; ?>" class="form-control">
							<?php if ($error_image_related) { ?>
								<div class="help-block error"><?= $error_image_related; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_compare; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_compare_width" value="<?= $config_image_compare_width; ?>" class="form-control"> <input type="text" name="config_image_compare_height" value="<?= $config_image_compare_height; ?>" class="form-control">
							<?php if ($error_image_compare) { ?>
								<div class="help-block error"><?= $error_image_compare; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_wishlist; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_wishlist_width" value="<?= $config_image_wishlist_width; ?>" class="form-control"> <input type="text" name="config_image_wishlist_height" value="<?= $config_image_wishlist_height; ?>" class="form-control">
							<?php if ($error_image_wishlist) { ?>
								<div class="help-block error"><?= $error_image_wishlist; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_cart; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_cart_width" value="<?= $config_image_cart_width; ?>" class="form-control"> <input type="text" name="config_image_cart_height" value="<?= $config_image_cart_height; ?>" class="form-control">
							<?php if ($error_image_cart) { ?>
								<div class="help-block error"><?= $error_image_cart; ?></div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div id="tab-ftp" class="tab-pane">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_ftp_host; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_ftp_host" value="<?= $config_ftp_host; ?>" class="form-control">
							<?php if ($error_ftp_host) { ?>
							<div class="help-block error"><?= $error_ftp_host; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_ftp_port; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_ftp_port" value="<?= $config_ftp_port; ?>" class="form-control">
							<?php if ($error_ftp_port) { ?>
							<div class="help-block error"><?= $error_ftp_port; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_ftp_username; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_ftp_username" value="<?= $config_ftp_username; ?>" class="form-control">
							<?php if ($error_ftp_username) { ?>
							<div class="help-block error"><?= $error_ftp_username; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_ftp_password; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_ftp_password" value="<?= $config_ftp_password; ?>" class="form-control">
							<?php if ($error_ftp_password) { ?>
							<div class="help-block error"><?= $error_ftp_password; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_ftp_root; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_ftp_root" value="<?= $config_ftp_root; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_ftp_status; ?></label>
						<div class="col-sm-6">
							<?php if ($config_ftp_status) { ?>
							<label class="radio-inline"><input type="radio" name="config_ftp_status" value="1" checked=""><?= $lang_text_yes; ?></label>
							<label class="radio-inline"><input type="radio" name="config_ftp_status" value="0"><?= $lang_text_no; ?></label>
							<?php } else { ?>
							<label class="radio-inline"><input type="radio" name="config_ftp_status" value="1"><?= $lang_text_yes; ?></label>
							<label class="radio-inline"><input type="radio" name="config_ftp_status" value="0" checked=""><?= $lang_text_no; ?></label>
							<?php } ?>
						</div>
					</div>
				</div>
				<div id="tab-mail" class="tab-pane">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_mail_protocol; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_mail_protocol" class="form-control">
								<?php if ($config_mail_protocol == 'mail') { ?>
								<option value="mail" selected><?= $lang_text_mail; ?></option>
								<?php } else { ?>
								<option value="mail"><?= $lang_text_mail; ?></option>
								<?php } ?>
								<?php if ($config_mail_protocol == 'smtp') { ?>
								<option value="smtp" selected><?= $lang_text_smtp; ?></option>
								<?php } else { ?>
								<option value="smtp"><?= $lang_text_smtp; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_mail_parameter; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_mail_parameter" value="<?= $config_mail_parameter; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_smtp_host; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_smtp_host" value="<?= $config_smtp_host; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_smtp_username; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_smtp_username" value="<?= $config_smtp_username; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_smtp_password; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_smtp_password" value="<?= $config_smtp_password; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_smtp_port; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_smtp_port" value="<?= $config_smtp_port; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_smtp_timeout; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_smtp_timeout" value="<?= $config_smtp_timeout; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_admin_email_user; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_admin_email_user" class="form-control">
								<option value="0"><?= $lang_text_select; ?></option>
								<?php foreach ($users as $user): ?>
								<?php if ($user['user_id'] == $config_admin_email_user): ?>
								<option value="<?= $user['user_id']; ?>" selected><?= $user['name']; ?></option>
								<?php else: ?>
								<option value="<?= $user['user_id']; ?>"><?= $user['name']; ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
							</select>
							<?php if ($error_admin_email_user) { ?>
								<div class="help-block error"><?= $error_admin_email_user; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="config_html_signature"><b class="required">*</b> <?= $lang_entry_signature_html; ?></label>
						<div class="control-field col-sm-8">
							<textarea name="config_html_signature" class="summernote form-control" rows="10" spellcheck="false"><?= $config_html_signature; ?></textarea>
							<?php if ($error_html_signature) { ?>
								<div class="help-block error"><?= $error_html_signature; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="config_text_signature"><b class="required">*</b> <?= $lang_entry_signature_text; ?></label>
						<div class="col-sm-8">
							<textarea name="config_text_signature" class="form-control" rows="6"><?= $config_text_signature; ?></textarea>
							<?php if ($error_text_signature) { ?>
								<div class="help-block error"><?= $error_text_signature; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_mail_twitter; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_mail_twitter" value="<?= $config_mail_twitter; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_mail_facebook; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_mail_facebook" value="<?= $config_mail_facebook; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_alert_mail; ?></label>
						<div class="col-sm-6">
							<?php if ($config_alert_mail) { ?>
								<label class="radio-inline"><input type="radio" name="config_alert_mail" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_alert_mail" value="0"><?= $lang_text_no; ?></label>
								<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="config_alert_mail" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_alert_mail" value="0" checked=""><?= $lang_text_no; ?></label>
								<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_account_mail; ?></label>
						<div class="col-sm-6">
							<?php if ($config_account_mail) { ?>
								<label class="radio-inline"><input type="radio" name="config_account_mail" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_account_mail" value="0"><?= $lang_text_no; ?></label>
								<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="config_account_mail" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_account_mail" value="0" checked=""><?= $lang_text_no; ?></label>
								<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_alert_emails; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="config_alert_emails" class="form-control" rows="3"><?= $config_alert_emails; ?></textarea>
						</div>
					</div>
				</div>
				<div id="tab-fraud" class="tab-pane">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_fraud_detection; ?></label>
						<div class="col-sm-6">
							<?php if ($config_fraud_detection) { ?>
								<label class="radio-inline"><input type="radio" name="config_fraud_detection" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_fraud_detection" value="0"><?= $lang_text_no; ?></label>
								<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="config_fraud_detection" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_fraud_detection" value="0" checked=""><?= $lang_text_no; ?></label>
								<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_fraud_key; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_fraud_key" value="<?= $config_fraud_key; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_fraud_score; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_fraud_score" value="<?= $config_fraud_score; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_fraud_status; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_fraud_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $config_fraud_status_id) { ?>
									<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div id="tab-server" class="tab-pane">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_secure; ?></label>
						<div class="col-sm-6">
							<?php if ($config_secure) { ?>
								<label class="radio-inline"><input type="radio" name="config_secure" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_secure" value="0"><?= $lang_text_no; ?></label>
							<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="config_secure" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_secure" value="0" checked=""><?= $lang_text_no; ?></label>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_shared; ?></label>
						<div class="col-sm-6">
							<?php if ($config_shared) { ?>
								<label class="radio-inline"><input type="radio" name="config_shared" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_shared" value="0"><?= $lang_text_no; ?></label>
							<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="config_shared" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_shared" value="0" checked=""><?= $lang_text_no; ?></label>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_top_level; ?></label>
						<div class="col-sm-4">
							<?php if ($config_top_level): ?>
								<label class="radio-inline"><input type="radio" name="config_top_level" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_top_level" value="0"><?= $lang_text_no; ?></label>
							<?php else: ?>
								<label class="radio-inline"><input type="radio" name="config_top_level" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_top_level" value="0" checked=""><?= $lang_text_no; ?></label>
							<?php endif; ?>
							<div class="alert alert-info help-block"><?= $lang_text_top_level; ?></div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_ucfirst; ?></label>
						<div class="col-sm-4">
							<?php if ($config_ucfirst): ?>
								<label class="radio-inline"><input type="radio" name="config_ucfirst" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_ucfirst" value="0"><?= $lang_text_no; ?></label>
							<?php else: ?>
								<label class="radio-inline"><input type="radio" name="config_ucfirst" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_ucfirst" value="0" checked=""><?= $lang_text_no; ?></label>
							<?php endif; ?>
							<div class="alert alert-info help-block"><?= $lang_text_ucfirst; ?></div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_robots; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="config_robots" class="form-control" rows="3"><?= $config_robots; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_file_extension_allowed; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="config_file_extension_allowed" class="form-control" rows="3"><?= $config_file_extension_allowed; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_file_mime_allowed; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="config_file_mime_allowed" class="form-control" rows="3"><?= $config_file_mime_allowed; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_maintenance; ?></label>
						<div class="col-sm-6">
							<?php if ($config_maintenance) { ?>
								<label class="radio-inline"><input type="radio" name="config_maintenance" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_maintenance" value="0"><?= $lang_text_no; ?></label>
								<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="config_maintenance" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_maintenance" value="0" checked=""><?= $lang_text_no; ?></label>
								<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_password; ?></label>
						<div class="col-sm-6">
							<?php if ($config_password) { ?>
								<label class="radio-inline"><input type="radio" name="config_password" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_password" value="0"><?= $lang_text_no; ?></label>
								<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="config_password" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_password" value="0" checked=""><?= $lang_text_no; ?></label>
								<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_encryption; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_encryption" value="<?= $config_encryption; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_compression; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_compression" value="<?= $config_compression; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_error_display; ?></label>
						<div class="col-sm-6">
							<?php if ($config_error_display) { ?>
								<label class="radio-inline"><input type="radio" name="config_error_display" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_error_display" value="0"><?= $lang_text_no; ?></label>
								<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="config_error_display" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_error_display" value="0" checked=""><?= $lang_text_no; ?></label>
								<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_error_log; ?></label>
						<div class="col-sm-6">
							<?php if ($config_error_log) { ?>
								<label class="radio-inline"><input type="radio" name="config_error_log" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_error_log" value="0"><?= $lang_text_no; ?></label>
								<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="config_error_log" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="config_error_log" value="0" checked=""><?= $lang_text_no; ?></label>
								<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_error_filename; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_error_filename" value="<?= $config_error_filename; ?>" class="form-control">
							<?php if ($error_error_filename) { ?>
								<div class="help-block error"><?= $error_error_filename; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_google_analytics; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="config_google_analytics" class="form-control" rows="3"><?= $config_google_analytics; ?></textarea>
						</div>
					</div>
				</div>
				<div id="tab-cache" class="tab-pane">
					<div class="form-group">
						<div class="control-field col-sm-8">
							<div class="alert alert-info help-block"><?= $lang_text_description; ?></div>
							<div class="alert alert-warning help-block"><?= $lang_text_available; ?></div>
							<label class="control-label col-sm-3"><?= $lang_entry_caches; ?></label>
							<div class="col-sm-5">
							<select name="config_cache_type_id" class="form-control">
								<?php foreach ($cache_types as $cache_type) { ?>
									<?php if ($cache_type['cache_type_id'] == $config_cache_type_id) { ?>
									<option value="<?= $cache_type['cache_type_id']; ?>" selected><?= $cache_type['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $cache_type['cache_type_id']; ?>"><?= $cache_type['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_cache_status; ?></label>
						<div class="control-field col-sm-2">
							<select name="config_cache_status" class="form-control">
								<?php if ($config_cache_status): ?>
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