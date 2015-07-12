<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<?php if ($waitlists): ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th><?= $lang_column_event; ?></th>
					<th><?= $lang_column_start_date; ?></th>
					<th><?= $lang_column_location; ?></th>
					<th><?= $lang_column_telephone; ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($waitlists as $waitlist) { ?>
				<tr>
					<td><?= $waitlist['name']; ?></td>
					<td><?= $waitlist['start_date']; ?></td>
					<td><?= $waitlist['location']; ?></td>
					<td><?= $waitlist['telephone']; ?></td>
					<td class="text-right">
						<a class="btn btn-danger" href="<?= $waitlist['remove']; ?>">
							<i class="fa fa-minus-square"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php else: ?>
		<div class="alert alert-warning"><?= $lang_text_no_waitlists; ?></div>
		<?php endif; ?>
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