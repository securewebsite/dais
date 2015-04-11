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
			<div class="pull-left h2"><i class="hidden-xs fa fa-credit-card"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<a href="<?= $insert; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_insert; ?></span></a>
				<button type="submit" form="form" formaction="<?= $delete; ?>" id="btn-delete" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></button>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-inline" action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
						<th class="hidden-xs"><a href="<?= $sort_code; ?>"><?= $lang_column_code; echo ($sort == 'v.code') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th><a href="<?= $sort_from; ?>"><?= $lang_column_from; echo ($sort == 'v.from_name') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th><a href="<?= $sort_to; ?>"><?= $lang_column_to; echo ($sort == 'v.to_name') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="text-right hidden-xs"><a href="<?= $sort_amount; ?>"><?= $lang_column_amount; echo ($sort == 'v.amount') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_theme; ?>"><?= $lang_column_theme; echo ($sort == 'theme') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_status; ?>"><?= $lang_column_status; echo ($sort == 'v.status') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="hidden-xs"><a href="<?= $sort_date_added; ?>"><?= $lang_column_date_added; echo ($sort == 'v.date_added') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="text-right"><span class="hidden-xs"><?= $lang_column_action; ?></span></th>
					</tr>
				</thead>
				<tbody data-link="row" class="rowlink">
					<?php if ($giftcards) { ?>
					<?php foreach ($giftcards as $giftcard) { ?>
					<tr>
						<td class="rowlink-skip text-center"><?php if ($giftcard['selected']) { ?>
							<input type="checkbox" name="selected[]" value="<?= $giftcard['giftcard_id']; ?>" checked="">
							<?php } else { ?>
							<input type="checkbox" name="selected[]" value="<?= $giftcard['giftcard_id']; ?>">
							<?php } ?></td>
						<td class="hidden-xs"><?= $giftcard['code']; ?></td>
						<td><?= $giftcard['from']; ?></td>
						<td><?= $giftcard['to']; ?></td>
						<td class="text-right hidden-xs"><?= $giftcard['amount']; ?></td>
						<td class="hidden-xs"><?= $giftcard['theme']; ?></td>
						<td class="hidden-xs text-<?= strtolower($giftcard['status']); ?>"><?= $giftcard['status']; ?></td>
						<td class="hidden-xs"><?= $giftcard['date_added']; ?></td>
						<td class="text-right"><?php foreach ($giftcard['action'] as $action) { ?>
							<a class="btn btn-default" href="<?= $action['href']; ?>">
								<i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span>
							</a>
							<?php } ?>
							<a class="rowlink-skip btn btn-default" onclick="sendGiftcard('<?= $giftcard['giftcard_id']; ?>','<?= $lang_text_wait; ?>');">
								<i class="fa fa-envelope-o"></i> <?= $lang_text_send; ?>
							</a>
						</td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td class="text-center" colspan="9"><?= $lang_text_no_results; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?>