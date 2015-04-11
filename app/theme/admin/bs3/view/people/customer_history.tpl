<?php if ($error_warning) { ?>
<div class="alert alert-danger"><?= $error_warning; ?><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
<?php } ?>
<table class="table table-bordered table-striped table-hover">
	<thead>
	<tr>
		<td><?= $lang_column_date_added; ?></td>
		<td><?= $lang_column_comment; ?></td>
	</tr>
	</thead>
	<tbody>
	<?php if ($histories) { ?>
	<?php foreach ($histories as $history) { ?>
	<tr>
		<td><?= $history['date_added']; ?></td>
		<td><?= $history['comment']; ?></td>
	</tr>
	<?php } ?>
	<?php } else { ?>
	<tr>
		<td class="text-center" colspan="2"><?= $lang_text_no_results; ?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
