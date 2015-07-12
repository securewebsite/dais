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
			<div class="pull-left h2"><i class="hidden-xs fa fa-puzzle-piece"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-inline" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<table id="widget" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><?= $lang_entry_menu; ?></th>
						<th><?= $lang_entry_layout; ?></th>
						<th><?= $lang_entry_position; ?></th>
						<th><?= $lang_entry_status; ?></th>
						<th class="text-right"><?= $lang_entry_sort_order; ?></th>
						<th class="col-md-3"></th>
					</tr>
				</thead>
				<tbody>
				<?php $widget_row = 0; ?>
				<?php foreach ($widgets as $widget) { ?>
					<tr id="widget-row<?= $widget_row; ?>">
						<td><select name="side_bar_menu_widget[<?= $widget_row; ?>][menu_id]" class="form-control">
							<?php foreach ($menus as $menu): ?>
							<?php if ($menu['menu_id'] == $widget['menu_id']): ?>
							<option value="<?= $menu['menu_id']; ?>" selected><?= $menu['name']; ?></option>
							<?php else: ?>
							<option value="<?= $menu['menu_id']; ?>"><?= $menu['name']; ?></option>
							<?php endif; ?>
							<?php endforeach; ?>
						</select></td>
						<td><select name="side_bar_menu_widget[<?= $widget_row; ?>][layout_id]" class="form-control">
							<?php foreach ($layouts as $layout) { ?>
							<?php if ($layout['layout_id'] == $widget['layout_id']) { ?>
							<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
							<?php } else { ?>
							<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select></td>
						<td><select name="side_bar_menu_widget[<?= $widget_row; ?>][position]" class="form-control">
							<?php if ($widget['position'] == 'column_left'): ?>
							<option value="column_left" selected><?= $lang_text_column_left; ?></option>
							<?php else: ?>
							<option value="column_left"><?= $lang_text_column_left; ?></option>
							<?php endif; ?>
							<?php if ($widget['position'] == 'column_right'): ?>
							<option value="column_right" selected><?= $lang_text_column_right; ?></option>
							<?php else: ?>
							<option value="column_right"><?= $lang_text_column_right; ?></option>
							<?php endif; ?>
						</select></td>
						<td><div class="btn-group" data-toggle="buttons">
							<?php if ($widget['status']): ?>
							<label class="btn btn-default active" title="<?= $lang_text_enabled; ?>">
								<input type="radio" name="side_bar_menu_widget[<?= $widget_row; ?>][status]" value="1" checked=""><i class="fa fa-play"></i>
							</label>
							<label class="btn btn-default" title="<?= $lang_text_disabled; ?>">
								<input type="radio" name="side_bar_menu_widget[<?= $widget_row; ?>][status]" value="0"><i class="fa fa-pause"></i>
							</label>
							<?php else: ?>
							<label class="btn btn-default" title="<?= $lang_text_enabled; ?>">
								<input type="radio" name="side_bar_menu_widget[<?= $widget_row; ?>][status]" value="1"><i class="fa fa-play"></i>
							</label>
							<label class="btn btn-default active" title="<?= $lang_text_disabled; ?>">
								<input type="radio" name="side_bar_menu_widget[<?= $widget_row; ?>][status]" value="0" checked=""><i class="fa fa-pause"></i>
							</label>
							<?php endif; ?>
						</div></td>
						<td class="text-right">
							<input type="text" name="side_bar_menu_widget[<?= $widget_row; ?>][sort_order]" value="<?= $widget['sort_order']; ?>" class="form-control">
						</td>
						<td>
							<a onclick="$('#widget-row<?= $widget_row; ?>').remove();" class="btn btn-danger">
								<i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span>
							</a>
						</td>
					</tr>
				<?php $widget_row++; ?>
				<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5"></td>
						<td>
							<a onclick="addWidget();" class="btn btn-info">
								<i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_widget; ?></span>
							</a>
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</div>
<script>var widget_row=<?= $widget_row; ?>;</script>
<?= $footer; ?>