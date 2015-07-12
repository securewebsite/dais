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
			<div class="pull-left h2"><i class="hidden-xs fa fa-undo"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs"><li><a href="#tab-return" data-toggle="tab"><?= $lang_tab_return; ?></a></li><li><a href="#tab-product" data-toggle="tab"><?= $lang_tab_product; ?></a></li></ul>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="tab-content">
				<div class="tab-pane" id="tab-return">
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_order_id; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="order_id" value="<?= $order_id; ?>" class="form-control">
							<?php if ($error_order_id) { ?>
								<span class="text-danger"><?= $error_order_id; ?></span>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_date_ordered; ?></label>
						<div class="control-field col-sm-4">
							<label class="input-group">
								<input type="text" name="date_ordered" value="<?= $date_ordered; ?>" class="form-control date">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_customer; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="customer" value="<?= $customer; ?>" id="return-customer" autocomplete="off" class="form-control">
							<input type="hidden" name="customer_id" value="<?= $customer_id; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="firstname" value="<?= $firstname; ?>" class="form-control">
							<?php if ($error_firstname) { ?>
								<div class="help-block error"><?= $error_firstname; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="lastname" value="<?= $lastname; ?>" class="form-control">
							<?php if ($error_lastname) { ?>
								<div class="help-block error"><?= $error_lastname; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_email; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="email" value="<?= $email; ?>" class="form-control">
							<?php if ($error_email) { ?>
								<div class="help-block error"><?= $error_email; ?></div>
							<?php	} ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_telephone; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="telephone" value="<?= $telephone; ?>" class="form-control">
							<?php if ($error_telephone) { ?>
								<div class="help-block error"><?= $error_telephone; ?></div>
							<?php	} ?>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-product">
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_product; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="product" value="<?= $product; ?>" id="return-product" autocomplete="off" class="form-control">
							<input type="hidden" name="product_id" value="<?= $product_id; ?>">
							<?php if ($error_product) { ?>
								<div class="help-block error"><?= $error_product; ?></div>
							<?php	} ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_model; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="model" value="<?= $model; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_quantity; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="quantity" value="<?= $quantity; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_reason; ?></label>
						<div class="control-field col-sm-4">
							<select name="return_reason_id" class="form-control">
								<?php foreach ($return_reasons as $return_reason) { ?>
									<?php if ($return_reason['return_reason_id'] == $return_reason_id) { ?>
									<option value="<?= $return_reason['return_reason_id']; ?>" selected><?= $return_reason['name']; ?></option>
								<?php } else { ?>
									<option value="<?= $return_reason['return_reason_id']; ?>"><?= $return_reason['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_opened; ?></label>
						<div class="control-field col-sm-4">
							<select name="opened" class="form-control">
								<?php if ($opened) { ?>
									<option value="1" selected><?= $lang_text_opened; ?></option>
									<option value="0"><?= $lang_text_unopened; ?></option>
								<?php } else { ?>
									<option value="1"><?= $lang_text_opened; ?></option>
									<option value="0" selected><?= $lang_text_unopened; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_comment; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="comment" class="form-control" rows="3"><?= $comment; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_action; ?></label>
						<div class="control-field col-sm-4">
							<select name="return_action_id" class="form-control">
								<option value="0">&ndash;</option>
								<?php foreach ($return_actions as $return_action) { ?>
								<?php if ($return_action['return_action_id'] == $return_action_id) { ?>
									<option value="<?= $return_action['return_action_id']; ?>" selected> <?= $return_action['name']; ?></option>
								<?php } else { ?>
									<option value="<?= $return_action['return_action_id']; ?>"><?= $return_action['name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_return_status; ?></label>
						<div class="control-field col-sm-4">
							<select name="return_status_id" class="form-control">
								<?php foreach ($return_statuses as $return_status) { ?>
								<?php if ($return_status['return_status_id'] == $return_status_id) { ?>
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
		</form>
	</div>
</div>
<?= $footer; ?>