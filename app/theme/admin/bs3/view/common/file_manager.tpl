<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $title; ?></title>
<base href="<?= $base; ?>">
<link rel="stylesheet" href="<?= $css_link; ?>">
</head>
<body>
<div class="container-fluid" id="container">
	<div class="btn-toolbar" id="menu">
		<div class="btn-group">
			<a id="create" class="btn btn-primary" title="<?= $lang_button_folder; ?>"><i class="fa fa-folder-open"></i><span class="hidden-xs"> <?= $lang_button_folder; ?></span></a>
			<a id="upload" class="btn btn-primary" title="<?= $lang_button_upload; ?>"><i class="fa fa-upload"></i><span class="hidden-xs"> <?= $lang_button_upload; ?></span></a>
		</div>
		<div class="btn-group">
			<a id="move" class="btn btn-info" title="<?= $lang_button_move; ?>"><i class="fa fa-arrows"></i><span class="hidden-xs"> <?= $lang_button_move; ?></span></a>
			<a id="copy" class="btn btn-info" title="<?= $lang_button_copy; ?>"><i class="fa fa-files-o"></i><span class="hidden-xs"> <?= $lang_button_copy; ?></span></a>
			<a id="rename" class="btn btn-info" title="<?= $lang_button_rename; ?>"><i class="fa fa-pencil-square-o"></i><span class="hidden-xs"> <?= $lang_button_rename; ?></span></a>
		</div>
		<a id="refresh" class="btn btn-warning" title="<?= $lang_button_refresh; ?>"><i class="fa fa-refresh"></i><span class="hidden-xs"> <?= $lang_button_refresh; ?></span></a>
		<a id="delete" class="pull-right btn btn-danger load-left" title="<?= $lang_button_delete; ?>"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_delete; ?></span></a>
	</div>
	<div id="notification"><div class="alert alert-warning"><b class="label label-warning"><i class="fa fa-inbox fa-lg"></i></b></div></div>
	<div class="row">
		<div class="col-sm-4"><div id="column-left" class="well well-sm pre-scrollable"></div></div>
		<div class="col-sm-8"><div id="column-right" class="well pre-scrollable"></div></div>
	</div>
</div>

<script src="<?= $js_link; ?>"></script>
<?= $javascript; ?>

</body>
</html>