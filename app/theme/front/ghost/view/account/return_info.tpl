<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<fieldset>
			<legend><?= $lang_text_return_detail; ?></legend>
			<div class="row">
				<div class="col-sm-6">
					<b><?= $lang_text_return_id; ?></b> #<?= $return_id; ?><br>
					<b><?= $lang_text_date_added; ?></b> <?= $date_added; ?>
				</div>
				<div class="col-sm-6">
					<b><?= $lang_text_order_id; ?></b> #<?= $order_id; ?><br>
					<b><?= $lang_text_date_ordered; ?></b> <?= $date_ordered; ?>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend><?= $lang_text_product; ?></legend>
			<div class="row">
				<div class="col-sm-6">
					<b><?= $lang_column_product; ?>:</b> <?= $product; ?><br>
					<b><?= $lang_column_model; ?>:</b> <?= $model; ?><br>
					<b><?= $lang_column_quantity; ?>:</b> <?= $quantity; ?>
				</div>
				<div class="col-sm-6">
					<b><?= $lang_column_reason; ?>:</b> <?= $reason; ?><br>
					<b><?= $lang_column_opened; ?>:</b> <?= $opened; ?><br>
					<b><?= $lang_column_action; ?>:</b> <?= $action; ?>
				</div>
			</div>
		</fieldset>
		<?php if ($comment) { ?>
			<fieldset>
				<legend><?= $lang_text_comment; ?></legend>
				<?= $comment; ?>
			</fieldset>
		<?php } ?>
		<?php if ($histories) { ?>
			<fieldset>
				<legend><?= $lang_text_history; ?></legend>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?= $lang_column_date_added; ?></th>
							<th class="col-sm-3"><?= $lang_column_status; ?></th>
							<th class="col-sm-3"><?= $lang_column_comment; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($histories as $history) { ?>
						<tr>
							<td><?= $history['date_added']; ?></td>
							<td><?= $history['status']; ?></td>
							<td><?= $history['comment']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</fieldset>
		<?php } ?>
		<div class="form-actions">
			<div class="form-actions-inner text-right">
				<a href="<?= $continue; ?>" class="btn btn-primary"><?= $lang_button_continue; ?></a>
			</div>
		</div>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>