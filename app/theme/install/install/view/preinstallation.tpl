<?= $header; ?>
<hr>
<h1 class="text-center">Pre-Installation</h1>
<hr>
<div class="col-sm-4 hidden-xs pull-right">
  <ul class="list-group">
    <li class="list-group-item list-group-heading">Installation Progress</li>
	<li class="list-group-item"><i class="fa fa-check text-success"></i> License</li>
    <li class="list-group-item"><i class="fa fa-chevron-circle-right text-info"></i> <b>Pre-Installation</b></li>
    <li class="list-group-item"><i class="fa fa-times text-danger"></i> Configuration</li>
    <li class="list-group-item"><i class="fa fa-times text-danger"></i> Finished</li>
  </ul>
</div>
<div id="content" class="col-sm-8">
	<?php if ($error_warning) { ?>
	<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
	<?php } ?>
	<form action="<?= $action; ?>" method="post" id="pre-install-form" enctype="multipart/form-data">
		<p class="alert alert-info">1. Please configure your PHP settings to match requirements listed below.</p>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
				  <th class="text-left"><b>PHP Settings</b></th>
				  <th class="text-left"><b>Current Settings</b></th>
				  <th class="text-left"><b>Required Settings</b></th>
				  <th class="text-center"><b>Status</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
				  <td>PHP Version:</td>
				  <td><?= phpversion(); ?></td>
				  <td>5.4+</td>
				  <td class="text-center">
				  	<?= (phpversion() >= '5.4') ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				<tr>
				  <td>Register Globals:</td>
				  <td><?= (ini_get('register_globals')) ? 'On' : 'Off'; ?></td>
				  <td>Off</td>
				  <td class="text-center">
				  	<?= (!ini_get('register_globals')) ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				<tr>
				  <td>Magic Quotes GPC:</td>
				  <td><?= (ini_get('magic_quotes_gpc')) ? 'On' : 'Off'; ?></td>
				  <td>Off</td>
				  <td class="text-center">
				  	<?= (!ini_get('magic_quotes_gpc')) ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				<tr>
				  <td>File Uploads:</td>
				  <td><?= (ini_get('file_uploads')) ? 'On' : 'Off'; ?></td>
				  <td>On</td>
				  <td class="text-center">
				  	<?= (ini_get('file_uploads')) ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				<tr>
				  <td>Session Auto Start:</td>
				  <td><?= (ini_get('session_auto_start')) ? 'On' : 'Off'; ?></td>
				  <td>Off</td>
				  <td class="text-center">
				  	<?= (!ini_get('session_auto_start')) ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
			</tbody>
		</table>
		<hr>
		<p class="alert alert-info">2. Please make sure the PHP extensions listed below are installed.</p>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
				  <th class="text-left"><b>Extension</b></th>
				  <th class="text-left"><b>Current Settings</b></th>
				  <th class="text-left"><b>Required Settings</b></th>
				  <th class="text-center"><b>Status</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
				  <td>MySQLi:</td>
				  <td><?= extension_loaded('mysqli') ? 'On' : 'Off'; ?></td>
				  <td>On</td>
				  <td class="text-center">
				  	<?= extension_loaded('mysqli') ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				<tr>
				  <td>PDO MySQL:</td>
				  <td><?= extension_loaded('pdo_mysql') ? 'On' : 'Off'; ?></td>
				  <td>On</td>
				  <td class="text-center">
				  	<?= extension_loaded('pdo_mysql') ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				
				<tr>
				  <td>APC:</td>
				  <td><?= extension_loaded('apc') ? 'On' : 'Off'; ?></td>
				  <td>Optional</td>
				  <td class="text-center">
				  	<?= extension_loaded('apc') ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				
				<tr>
				  <td>Memcache:</td>
				  <td><?= extension_loaded('memcache') ? 'On' : 'Off'; ?></td>
				  <td>Optional</td>
				  <td class="text-center">
				  	<?= extension_loaded('memcache') ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				
				<tr>
				  <td>GD:</td>
				  <td><?= extension_loaded('gd') ? 'On' : 'Off'; ?></td>
				  <td>On</td>
				  <td class="text-center"><?= extension_loaded('gd') ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?></td>
				</tr>
				<tr>
				  <td>cURL:</td>
				  <td><?= extension_loaded('curl') ? 'On' : 'Off'; ?></td>
				  <td>On</td>
				  <td class="text-center">
				  	<?= extension_loaded('curl') ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				<tr>
				  <td>mCrypt:</td>
				  <td><?= function_exists('mcrypt_encrypt') ? 'On' : 'Off'; ?></td>
				  <td>On</td>
				  <td class="text-center">
				  	<?= function_exists('mcrypt_encrypt') ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				<tr>
				  <td>ZIP:</td>
				  <td><?= extension_loaded('zlib') ? 'On' : 'Off'; ?></td>
				  <td>On</td>
				  <td class="text-center">
				  	<?= extension_loaded('zlib') ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
				<tr>
				  <td>MB String:</td>
				  <td><?= extension_loaded('mbstring') ? 'On' : 'Off'; ?></td>
				  <td>On</td>
				  <td class="text-center">
				  	<?= extension_loaded('mbstring') ? '<i class="fa fa-check fa-lg text-success"></i>' : '<i class="fa fa-times fa-lg text-danger"></i>'; ?>
				  </td>
				</tr>
			</tbody>
		</table>
		<hr>
		<p class="alert alert-info">3. Please make sure you have set the correct permissions on the directories list below.</p>
		<table class="table table-striped table-hover table-responsive">
			<thead>
				<tr>
				  <th class="text-left"><b>Directories</b></th>
				  <th class="text-right"><b>Status</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
				  <td><?= reprint($config) . '/'; ?></td>
				  <td class="text-right">
				  	<?= is_writable($config) ? '<span class="label label-success">Writable</span>' : '<span class="label label-danger">Unwritable</span>'; ?>
				  </td>
				</tr>
				<tr>
				  <td><?= reprint($cache) . '/'; ?></td>
				  <td class="text-right">
				  	<?= is_writable($cache) ? '<span class="label label-success">Writable</span>' : '<span class="label label-danger">Unwritable</span>'; ?>
				  </td>
				</tr>
				<tr>
				  <td><?= reprint($logs) . '/'; ?></td>
				  <td class="text-right">
				  	<?= is_writable($logs) ? '<span class="label label-success">Writable</span>' : '<span class="label label-danger">Unwritable</span>'; ?>
				  </td>
				</tr>
				<tr>
				  <td><?= reprint($image) . '/'; ?></td>
				  <td class="text-right">
				  	<?= is_writable($image) ? '<span class="label label-success">Writable</span>' : '<span class="label label-danger">Unwritable</span>'; ?>
				  </td>
				</tr>
				<tr>
				  <td><?= reprint($image_cache) . '/'; ?></td>
				  <td class="text-right">
				  	<?= is_writable($image_cache) ? '<span class="label label-success">Writable</span>' : '<span class="label label-danger">Unwritable</span>';?>
				  </td>
				</tr>
				<tr>
				  <td><?= reprint($image_data) . '/'; ?></td>
				  <td class="text-right">
				  	<?= is_writable($image_data) ? '<span class="label label-success">Writable</span>' : '<span class="label label-danger">Unwritable</span>'; ?>
				  </td>
				</tr>
				<tr>
				  <td><?= reprint($download) . '/'; ?></td>
				  <td class="text-right">
				  	<?= is_writable($download) ? '<span class="label label-success">Writable</span>' : '<span class="label label-danger">Unwritable</span>'; ?>
				  </td>
				</tr>
			</tbody>
		</table>
		<div class="form-actions">
			<div class="row">
				<div class="col-xs-12 text-right">
					<a href="<?= $back; ?>" class="btn btn-default load-button">Back</a>
					<button type="submit" 
						id="pre-install" 
						class="btn btn-primary">
							Continue <i class="fa fa-chevron-right"></i>
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
<?php 
	function reprint($dir) {
		return ltrim(str_replace (dirname(APP_PATH), '', $dir), '/');
	}
?>
<?= $footer; ?>