<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th><?= $lang_column_date_added; ?></th>
			<th class="col-sm-10"><?= $lang_column_description; ?></th>
			<th class="text-right"><?= $lang_column_points; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($rewards) { ?>
		<?php foreach ($rewards as $reward) { ?>
		<tr>
			<td><?= $reward['date_added']; ?></td>
			<td><?= $reward['description']; ?></td>
			<td class="text-right"><?= $reward['points']; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="2" class="text-right"><?= $lang_text_balance; ?></td>
			<td class="text-right"><?= $balance; ?></td>
		</tr>
		<?php } else { ?>
		<tr>
			<td class="text-center" colspan="3"><?= $lang_text_no_results; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
<?= $javascript; ?>