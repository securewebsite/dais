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
						<th><?= $lang_entry_limit; ?></th>
						<th><?= $lang_entry_span; ?></th>
						<th><?= $lang_entry_height; ?></th>
						<th><?= $lang_entry_product; ?></th>
						<th><?= $lang_entry_description; ?></th>
						<th><?= $lang_entry_button; ?></th>
						<th><?= $lang_entry_layout; ?></th>
						<th><?= $lang_entry_position; ?></th>
						<th><?= $lang_entry_status; ?></th>
						<th><?= $lang_entry_sort_order; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $widget_row = 0; ?>
					<?php foreach ($widgets as $widget): ?>
					<tr id="widget-row<?= $widget_row; ?>">
						<td><input type="text" class="form-control" name="masonry_widget[<?= $widget_row; ?>][limit]" 
								value="<?= $widget['limit']; ?>" size="1"></td>
						<td><select name="masonry_widget[<?= $widget_row; ?>][span]" class="form-control">
								<?php foreach (array(1,2,3,4,6) as $span): ?>
								<?php if ($span == $widget['span']): ?>
								<option value="<?= $span; ?>" selected><?= $span; ?></option>
								<?php else: ?>
								<option value="<?= $span; ?>"><?= $span; ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
							</select></td>
						<td><?php if (!$widget['height']): ?>
							<input type="text" class="form-control" name="masonry_widget[<?= $widget_row; ?>][height]" value="<?= $widget['height']; ?>" disabled="" size="1">
							&nbsp; <label class="checkbox">
								<input type="checkbox" name="masonry_widget[<?= $widget_row; ?>][height]" value="" class="toggle" checked="">
								<?= $lang_text_auto; ?>
							</label>
							<?php else: ?>
								<input type="text" class="form-control" name="masonry_widget[<?= $widget_row; ?>][height]" value="<?= $widget['height']; ?>" size="1">
								&nbsp; <label class="checkbox">
								<input type="checkbox" name="masonry_widget[<?= $widget_row; ?>][height]" value="" class="toggle"> 
									<?= $lang_text_auto; ?>
								</label>
							<?php endif; ?></td>
						<td><select name="masonry_widget[<?= $widget_row; ?>][product_type]" class="form-control">
								<?php foreach ($product_types as $key => $product_type): ?>
								<?php if ($key == $widget['product_type']): ?>
								<option value="<?= $key; ?>" selected><?= $product_type; ?></option>
								<?php else: ?>
								<option value="<?= $key; ?>"><?= $product_type; ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
							</select></td>
						<td><select name="masonry_widget[<?= $widget_row; ?>][description]" class="form-control">
								<?php if ($widget['description']): ?>
								<option value="1" selected><?= $lang_text_enabled; ?></option>
								<option value="0"><?= $lang_text_disabled; ?></option>
								<?php else: ?>
								<option value="1"><?= $lang_text_enabled; ?></option>
								<option value="0" selected><?= $lang_text_disabled; ?></option>
								<?php endif; ?>
							</select>
							<?php if (isset($error_asterisk[$widget_row]['description'])): ?>
								<div class="text-danger"><?= $error_asterisk[$widget_row]['description']; ?></div>
							<?php endif; ?></td>
						<td><select name="masonry_widget[<?= $widget_row; ?>][button]" class="form-control">
								<?php if ($widget['button']): ?>
								<option value="1" selected><?= $lang_text_enabled; ?></option>
								<option value="0"><?= $lang_text_disabled; ?></option>
								<?php else: ?>
								<option value="1"><?= $lang_text_enabled; ?></option>
								<option value="0" selected><?= $lang_text_disabled; ?></option>
								<?php endif; ?>
							</select>
							<?php if (isset($error_asterisk[$widget_row]['button'])): ?>
								<div class="error"><?= $error_asterisk[$widget_row]['button']; ?></div>
							<?php endif; ?></td>
						<td><select name="masonry_widget[<?= $widget_row; ?>][layout_id]" class="form-control">
								<?php foreach ($layouts as $layout): ?>
								<?php if ($layout['layout_id'] == $widget['layout_id']): ?>
								<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
								<?php else: ?>
								<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
								<?php endif; ?>
								<?php endforeach; ?>
							</select></td>
						<td><select name="masonry_widget[<?= $widget_row; ?>][position]" class="form-control">
								<?php if ($widget['position'] == 'content_top'): ?>
								<option value="content_top" selected><?= $lang_text_content_top; ?></option>
								<?php else: ?>
								<option value="content_top"><?= $lang_text_content_top; ?></option>
								<?php endif; ?>
								<?php if ($widget['position'] == 'content_bottom'): ?>
								<option value="content_bottom" selected><?= $lang_text_content_bottom; ?></option>
								<?php else: ?>
								<option value="content_bottom"><?= $lang_text_content_bottom; ?></option>
								<?php endif; ?>
								<?php if ($widget['position'] == 'post_header'): ?>
								<option value="post_header" selected><?= $lang_text_post_header; ?></option>
								<?php else: ?>
								<option value="post_header"><?= $lang_text_post_header; ?></option>
								<?php endif; ?>
								<?php if ($widget['position'] == 'pre_footer'): ?>
								<option value="pre_footer" selected><?= $lang_text_pre_footer; ?></option>
								<?php else: ?>
								<option value="pre_footer"><?= $lang_text_pre_footer; ?></option>
								<?php endif; ?>
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
							<?php if ($widget['status']){ ?>
							<label class="btn btn-default active" title="<?= $lang_text_enabled; ?>">
								<input type="radio" name="masonry_widget[<?= $widget_row; ?>][status]" value="1" checked=""><i class="fa fa-play"></i></label>
							<label class="btn btn-default" title="<?= $lang_text_disabled; ?>">
								<input type="radio" name="masonry_widget[<?= $widget_row; ?>][status]" value="0"><i class="fa fa-pause"></i></label>
							<?php } else { ?>
							<label class="btn btn-default" title="<?= $lang_text_enabled; ?>">
								<input type="radio" name="masonry_widget[<?= $widget_row; ?>][status]" value="1"><i class="fa fa-play"></i></label>
							<label class="btn btn-default active" title="<?= $lang_text_disabled; ?>">
								<input type="radio" name="masonry_widget[<?= $widget_row; ?>][status]" value="0" checked=""><i class="fa fa-pause"></i></label>
							<?php } ?>
							</div></td>
						<td><input type="text" class="form-control" name="masonry_widget[<?= $widget_row; ?>][sort_order]" value="<?= $widget['sort_order']; ?>" size="3"></td>
						<td><a onclick="$('#widget-row<?= $widget_row; ?>').remove();" class="btn btn-danger">
								<i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
					</tr>
					<?php $widget_row++; ?>
					<?php endforeach; ?>
					<tfoot>
						<tr>
							<td colspan="10"></td>
							<td>
								<a onclick="addWidget();" class="btn btn-info">
									<i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_widget; ?></span></a>
							</td>
						</tr>
					</tfoot>
				</tbody>
			</table>
		</form>
	</div>
</div>
<script>var widget_row=<?= $widget_row; ?>;</script>
<?= $footer; ?>