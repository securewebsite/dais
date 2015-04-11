<?= $header; ?>
<?php if ($success) { ?>
<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $success; ?></div>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
<?php } ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<h4><?= $lang_text_address_book; ?></h4>
		<table class="table table-striped">
			<tbody>
			<?php foreach ($addresses as $result) { ?>
				<tr>
					<td><?= $result['address']; ?></td>
					<td class="text-right"><a href="<?= $result['update']; ?>" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> <?= $lang_button_edit; ?></a>
					<a href="<?= $result['delete']; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<div class="form-actions">
			<div class="form-actions-inner text-right">
				<a href="<?= $back; ?>" class="btn btn-default pull-left"><?= $lang_button_back; ?></a>
				<a href="<?= $insert; ?>" class="btn btn-primary"><i class="hidden-xs icon-plus"></i> <?= $lang_button_new_address; ?></a>
			</div>
		</div>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>