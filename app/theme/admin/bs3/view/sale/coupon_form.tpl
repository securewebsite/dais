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
		<ul class="nav nav-tabs"><li><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li>
			<?php if ($coupon_id) { ?>
			<li><a href="#tab-history" data-toggle="tab"><?= $lang_tab_history; ?></a></li>
			<?php } ?>
		</ul>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="tab-content">
				<div class="tab-pane" id="tab-general">
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_name; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="name" value="<?= $name; ?>" class="form-control">
							<?php if ($error_name) { ?>
								<div class="help-block error"><?= $error_name; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_code; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="code" value="<?= $code; ?>" class="form-control">
							<?php if ($error_code) { ?>
								<div class="help-block error"><?= $error_code; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_type; ?></label>
						<div class="control-field col-sm-4">
							<select name="type" class="form-control">
								<?php if ($type == 'P') { ?>
								<option value="P" selected><?= $lang_text_percent; ?></option>
							<?php } else { ?>
								<option value="P"><?= $lang_text_percent; ?></option>
							<?php } ?>
								<?php if ($type == 'F') { ?>
								<option value="F" selected><?= $lang_text_amount; ?></option>
							<?php } else { ?>
								<option value="F"><?= $lang_text_amount; ?></option>
							<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_discount; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="discount" value="<?= $discount; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_total; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="total" value="<?= $total; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_logged; ?></label>
						<div class="control-field col-sm-4">
							<?php if ($logged) { ?>
								<label class="radio-inline"><input type="radio" name="logged" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="logged" value="0"><?= $lang_text_no; ?></label>
							<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="logged" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="logged" value="0" checked=""><?= $lang_text_no; ?></label>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_shipping; ?></label>
						<div class="control-field col-sm-4">
							<?php if ($shipping) { ?>
								<label class="radio-inline"><input type="radio" name="shipping" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="shipping" value="0"><?= $lang_text_no; ?></label>
							<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="shipping" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="shipping" value="0" checked=""><?= $lang_text_no; ?></label>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_product; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="coupon_products" value="" class="form-control" autocomplete="off">
							<div id="coupon-product" class="panel panel-default panel-scrollable">
								<?php foreach ($coupon_product as $coupon_product) { ?>
									<div id="coupon-product<?= $coupon_product['product_id']; ?>">
										<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a>
										<?= $coupon_product['name']; ?>
										<input type="hidden" name="coupon_product[]" value="<?= $coupon_product['product_id']; ?>">
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_category; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="category" value="" class="form-control" data-target="coupon" autocomplete="off" class="form-control">
							<div id="coupon-category" class="panel panel-default panel-scrollable">
							<?php foreach ($coupon_category as $coupon_category) { ?>
							<div id="coupon-category<?= $coupon_category['category_id']; ?>">
								<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a>
								<?= $coupon_category['name']; ?>
								<input type="hidden" name="coupon_category[]" value="<?= $coupon_category['category_id']; ?>">
							</div>
							<?php } ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_date_start; ?></label>
						<div class="control-field col-sm-4">
							<label class="input-group">
								<input type="text" name="date_start" value="<?= $date_start; ?>" id="date-start" class="form-control date">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_date_end; ?></label>
						<div class="control-field col-sm-4">
							<label class="input-group">
								<input type="text" name="date_end" value="<?= $date_end; ?>" id="date-end" class="form-control date">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_uses_total; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="uses_total" value="<?= $uses_total; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_uses_customer; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="uses_customer" value="<?= $uses_customer; ?>" class="form-control">
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
				</div>
				<?php if ($coupon_id) { ?>
					<div class="tab-pane" id="tab-history">
						<div id="history" data-href="sale/coupon/history/coupon_id/<?= $coupon_id; ?>"></div>
					</div>
				<?php } ?>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>