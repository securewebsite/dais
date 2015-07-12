<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th><?= $lang_column_date_added; ?></th>
			<th><?= $lang_column_description; ?></th>
			<th class="text-right"><?= $lang_column_amount; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($commissions) { ?>
		<?php foreach ($commissions as $commission) { ?>
		<tr>
			<td><?= $commission['date_added']; ?></td>
			<td><?= $commission['description']; ?></td>
			<td class="text-right"><?= $commission['amount']; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td>&nbsp;</td>
			<td class="text-right"><b><?= $lang_text_balance; ?></b></td>
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