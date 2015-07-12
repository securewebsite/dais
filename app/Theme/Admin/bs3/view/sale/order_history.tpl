<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th><?= $lang_column_date_added; ?></th>
			<th class="col-sm-9"><?= $lang_column_comment; ?></th>
			<th><?= $lang_column_status; ?></th>
			<th><?= $lang_column_notify; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($histories) { ?>
		<?php foreach ($histories as $history) { ?>
		<tr>
			<td><?= $history['date_added']; ?></td>
			<td><?= $history['comment'] ? $history['comment'] : '&ndash;'; ?></td>
			<td class="text-<?= strtolower($history['status']); ?>"><?= $history['status']; ?></td>
			<td><?= $history['notify']; ?></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td class="text-center" colspan="4"><?= $lang_text_no_results; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
<?= $javascript; ?>