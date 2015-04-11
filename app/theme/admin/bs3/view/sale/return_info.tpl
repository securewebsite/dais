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
		<div class="pull-left h2"><i class="hidden-xs fa fa-undo"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right"><a class="btn btn-warning" href="<?= $cancel; ?>"><i class="fa fa-ban"></i> <?= $lang_button_cancel; ?></a></div>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs"><li><a href="#tab-return" data-toggle="tab"><?= $lang_tab_return; ?></a></li><li><a href="#tab-product" data-toggle="tab"><?= $lang_tab_product; ?></a></li><li><a href="#tab-history" data-toggle="tab"><?= $lang_tab_history; ?></a></li></ul>
		<div class="form-horizontal tab-content">
			<div class="tab-pane" id="tab-return">
				<table class="table table-bordered table-striped table-hover">
					<tr>
						<td class="col-sm-3"><?= $lang_text_return_id; ?></td>
						<td><?= $return_id; ?></td>
					</tr>
					<tr>
						<td><?= $lang_text_order_id; ?></td>
						<?php if ($order) { ?>
							<td><a href="<?= $order; ?>"><?= $order_id; ?></a></td>
						<?php } else { ?>
							<td><?= $order_id; ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_date_ordered; ?></td>
						<td><?= $date_ordered; ?></td>
					</tr>
					<tr>
						<td><?= $lang_text_customer; ?></td>
						<?php if ($customer) { ?>
							<td><a href="<?= $customer; ?>"><?= $firstname; ?> <?= $lastname; ?></a></td>
						<?php } else { ?>
							<td><?= $firstname; ?> <?= $lastname; ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_email; ?></td>
						<td><?= $email; ?></td>
					</tr>
					<tr>
						<td><?= $lang_text_telephone; ?></td>
						<td><?= $telephone; ?></td>
					</tr>
					<?php if ($return_status) { ?>
						<tr>
							<td><?= $lang_text_return_status; ?></td>
							<td id="return-status"><?= $return_status; ?></td>
						</tr>
					<?php } ?>
					<tr>
						<td><?= $lang_text_date_added; ?></td>
						<td><?= $date_added; ?></td>
					</tr>
					<tr>
						<td><?= $lang_text_date_modified; ?></td>
						<td><?= $date_modified; ?></td>
					</tr>
				</table>
			</div>
			<div class="tab-pane" id="tab-product">
				<table class="table table-bordered table-striped table-hover">
					<tr>
						<td class="col-sm-3"><?= $lang_text_product; ?></td>
						<td><?= $product; ?></td>
					</tr>
					<tr>
						<td><?= $lang_text_model; ?></td>
						<td><?= $model; ?></td>
					</tr>
					<tr>
						<td><?= $lang_text_quantity; ?></td>
						<td><?= $quantity; ?></td>
					</tr>
					<tr>
						<td><?= $lang_text_return_reason; ?></td>
						<td><?= $return_reason; ?></td>
					</tr>
					<tr>
						<td><?= $lang_text_opened; ?></td>
						<td><?= $opened; ?></td>
					</tr>
					<tr>
						<td><?= $lang_text_return_action; ?></td>
						<td>
							<div class="col-sm-5" style="padding-left:0;">
								<select name="return_action_id" class="form-control">
									<option value="0"><?= $lang_text_select; ?></option>
									<?php foreach ($return_actions as $return_action): ?>
									<?php if ($return_action['return_action_id'] == $return_action_id): ?>
									<option value="<?= $return_action['return_action_id']; ?>" selected><?= $return_action['name']; ?></option>
									<?php else: ?>
									<option value="<?= $return_action['return_action_id']; ?>"><?= $return_action['name']; ?></option>
									<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</td>
					</tr>
					<?php if ($comment) { ?>
					<tr>
						<td><?= $lang_text_comment; ?></td>
						<td><?= $comment; ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<div class="tab-pane" id="tab-history">
				<div id="history" data-href="index.php?route=sale/returns/history&token=<?= $token; ?>&return_id=<?= $return_id; ?>"></div>
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
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_notify; ?></label>
					<div class="control-field col-sm-4">
						<label class="checkbox-inline"><input type="checkbox" name="notify" value="1" id="notify"></label>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_comment; ?></label>
					<div class="control-field col-sm-4">
						<textarea name="comment" class="form-control" rows="3" id="comment"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="control-field col-sm-4 col-sm-offset-2">
						<button type="button" id="button-history-returns" data-action="returns" data-id="<?= $return_id; ?>" class="btn btn-info"><i class="fa fa-plus-circle"></i> <?= $lang_button_add_history; ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $footer; ?>