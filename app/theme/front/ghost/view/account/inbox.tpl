<?php if ($inbox): ?>
<table class="table table-bordered">
	<thead>
		<tr>
			<th><?= $lang_column_message; ?></th>
			<th class="text-center"><?= $lang_column_read; ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($inbox as $email): ?>
		<tr>
			<td>
				<?php if (!$email['read']): ?>
				<a class="read-notify-link" href="<?= $email['href']; ?>"><b><?= $email['subject']; ?></b></a>
				<?php else: ?>
				<a class="read-notify-link" href="<?= $email['href']; ?>"><?= $email['subject']; ?></a>
				<?php endif; ?>
			</td>
			<td width="80" class="text-center">
				<?php if ($email['read']): ?>
				<?= $lang_text_yes; ?>
				<?php else: ?>
				<?= $lang_text_no; ?>
				<?php endif; ?>
			</td>
			<td width="80" class="text-center">
				<a href="<?= $email['delete']; ?>" class="delete-button btn btn-danger btn-sm"><?= $lang_button_delete; ?> <i class="fa fa-times"></i></a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<div class="pagination"><?= str_replace('....', '', $pagination); ?></div>
<?php else: ?>
<div class="alert alert-warning"><?= $lang_text_empty; ?></div>
<div class="form-actions">
	<div class="form-actions-inner text-right">
		<a href="<?= $back; ?>" class="btn btn-primary"><?= $lang_button_continue; ?></a>
		<br>
	</div>
</div>
<?php endif; ?>
	