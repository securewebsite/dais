<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<?php if ($credits) { ?>
		<div class="alert alert-info"><?= $lang_text_total; ?> <b><?= $total; ?></b></div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th><?= $lang_column_date_added; ?></th>
					<th><?= $lang_column_description; ?></th>
					<th class="text-right"><?= $column_amount; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($credits as $credit) { ?>
				<tr>
					<td><?= $credit['date_added']; ?></td>
					<td><?= $credit['description']; ?></td>
					<td class="text-right"><?= $credit['amount']; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
		<?php } else { ?>
			<div class="alert alert-warning"><?= $lang_text_empty; ?></div>
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