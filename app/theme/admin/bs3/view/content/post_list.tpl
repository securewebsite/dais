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
		<div class="pull-left h2"><i class="hidden-xs fa fa-leaf"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right">
			<a href="<?= $insert; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_insert; ?></span></a>
			<button type="submit" form="form" formaction="<?= $delete; ?>" id="btn-delete" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></button>
		</div>
	</div>
	<div class="panel-body">
		<form action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="40" class="text-center"><input type="checkbox" data-toggle="selected"></th>
						<th><a href="<?= $sort_name; ?>"><?= $lang_column_name; echo ($sort == 'pd.name') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th><?= $lang_column_author; ?></th>
						<th><?= $lang_column_category; ?></th>
						<th><a href="<?= $sort_status; ?>"><?= $lang_column_status; echo ($sort == 'p.status') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th><a href="<?= $sort_viewed; ?>"><?= $lang_column_viewed; echo ($sort == 'p.viewed') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="text-right"><a href="<?= $sort_date_added; ?>"><?= $lang_column_date_added; echo ($sort == 'p.date_added') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="text-right"><a href="<?= $sort_date_modified; ?>"><?= $lang_column_date_modified; echo ($sort == 'p.date_modified') ? '<i class="caret caret-' . strtolower($order) . '"></i>' : ''; ?></a></th>
						<th class="text-right"><?= $lang_column_action; ?></th>
					</tr>
				</thead>
				<tbody data-link="row" class="rowlink">
					<tr id="filter" class="info">
						<td class="text-center">
							<a class="btn btn-default btn-block" href="content/post" rel="tooltip" title="Reset">
								<i class="fa fa-power-off fa-fw"></i></a>
						</td>
						<td><input type="text" name="filter_name" value="<?= $filter_name; ?>" class="form-control" data-target="name" data-url="content/post"></td>
						<td><input type="text" name="filter_author_id" value="<?= $filter_author_id; ?>" class="form-control" data-target="author_id" data-url="content/post"></td>
						<td>
							<select name="filter_category_id" class="form-control">
								<option value="*"></option>
								<?php foreach($categories as $category): ?>
								<?php if ($category['category_id'] == $filter_category_id): ?>
								<option value="<?= $category['category_id']; ?>" selected="selected"><?= $category['name'];?></option>
								<?php else: ?>
								<option value="<?= $category['category_id']; ?>"><?= $category['name'];?></option>
								<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</td>
						<td>
							<select name="filter_status" class="form-control">
								<option value="*"></option>
								<?php if ($filter_status === '1'): ?>
								<option value="1" selected="selected"><?= $lang_text_posted; ?></option>
								<?php else: ?>
								<option value="1"><?= $lang_text_posted; ?></option>
								<?php endif; ?>
								<?php if ($filter_status === '2'): ?>
								<option value="2" selected="selected"><?= $lang_text_draft; ?></option>
								<?php else: ?>
								<option value="2"><?= $lang_text_draft; ?></option>
								<?php endif; ?>
								<?php if (!is_null($filter_status) && !$filter_status): ?>
								<option value="0" selected="selected"><?= $lang_text_disabled; ?></option>
								<?php else: ?>
								<option value="0"><?= $lang_text_disabled; ?></option>
								<?php endif; ?>
							</select>
						</td>
						<td class="text-center"> --- </td>
						<td align="right">
							<label class="input-group">
								<input type="text" name="filter_date_added" value="<?= $filter_date_added; ?>" class="form-control date" autocomplete="off">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</label>
						</td>
						<td align="right">
							<label class="input-group">
								<input type="text" name="filter_date_modified" value="<?= $filter_date_modified; ?>" class="form-control date" autocomplete="off">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</label>	
						</td>
						<td class="text-right">
							<button type="button" onclick="filter();" class="btn btn-info">
								<i class="fa fa-search"></i><span class="hidden-xs"> <?= $lang_button_filter; ?></span></button>
						</td>
					</tr>
					
					<?php if ($posts): ?>
					<?php foreach ($posts as $post): ?>
					<tr>
						<td class="rowlink-skip text-center"><?php if ($post['selected']): ?>
						<input type="checkbox" name="selected[]" value="<?= $post['post_id']; ?>" checked="checked">
						<?php else: ?>
						<input type="checkbox" name="selected[]" value="<?= $post['post_id']; ?>">
						<?php endif; ?></td>
						<td><?= $post['name']; ?></td>
						<td><?= $post['author_name']; ?></td>
						<td><?= $post['category']; ?></td>
						<td><?= $post['status']; ?></td>
						<td class="text-center"><?= $post['viewed']; ?></td>
						<td class="text-right"><?= $post['date_added']; ?></td>
						<td class="text-right"><?= $post['date_modified']; ?></td>
						<td class="text-right">
						<?php foreach ($post['action'] as $action): ?>
							<a class="btn btn-default" href="<?= $action['href']; ?>"><i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $action['text']; ?></span></a>
						<?php endforeach; ?>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td class="text-center" colspan="9"><?= $lang_text_no_results; ?></td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</form>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
	</div>
</div>
<?= $footer; ?>