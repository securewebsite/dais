<?= $header; ?>
<hr>
<h1 class="text-center">Configuration</h1>
<hr>
<div class="col-sm-4 hidden-xs pull-right">
	<ul class="list-group">
		<li class="list-group-item list-group-heading">Installation Progress</li>
		<li class="list-group-item"><i class="fa fa-check text-success"></i> License</li>
		<li class="list-group-item"><i class="fa fa-check text-success"></i> Pre-Installation</li>
		<li class="list-group-item"><i class="fa fa-chevron-circle-right text-info"></i> <b>Configuration</b></li>
		<li class="list-group-item"><i class="fa fa-times text-danger"></i> Finished</li>
	</ul>
</div>
<div id="content" class="col-sm-8">
	<?php if ($error_warning) { ?>
	<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
	<?php } ?>
	<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
		<fieldset>
			<p class="alert alert-info">1. Please enter your database connection details.</p>
			<div class="form-group">
				<label class="control-label col-sm-3" for="db-driver"><b class="required">*</b> Database Driver:</label>
				<div class="col-sm-6">
					<select name="db_driver" class="form-control col-sm-3" id="db-driver">
              			<option value="mpdo">MySQL</option>
					</select>
					<?php if ($error_db_driver): ?>
					<span class="help-block error"><?= $error_db_driver; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="db-host"><b class="required">*</b> Database Host:</label>
				<div class="col-sm-6">
					<input type="text" 
						name="db_host" value="<?= $db_host; ?>" class="form-control" 
						placeholder="Database Host"  id="db-host" required>
					<?php if ($error_db_host): ?>
					<span class="help-block error"><?= $error_db_host; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="db-user"><b class="required">*</b> Database User:</label>
				<div class="col-sm-6">
					<input type="text" 
						name="db_user" value="<?= $db_user; ?>" class="form-control" 
						placeholder="Database User"  id="db-user" required>
					<?php if ($error_db_user): ?>
					<span class="help-block error"><?= $error_db_user; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="db-password"><b class="required">*</b> Database Password:</label>
				<div class="col-sm-6">
					<input type="text" 
						name="db_password" value="<?= $db_password; ?>" class="form-control" 
						placeholder="Database Password"  id="db-password" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="db-name"><b class="required">*</b> Database Name:</label>
				<div class="col-sm-6">
					<input type="text" 
						name="db_name" value="<?= $db_name; ?>" class="form-control" 
						placeholder="Database Name"  id="db-name" required>
					<?php if ($error_db_name): ?>
					<span class="help-block error"><?= $error_db_name; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="db-prefix"><b class="required">*</b> Database Prefix:</label>
				<div class="col-sm-6">
					<input type="text" 
						name="db_prefix" value="<?= $db_prefix; ?>" class="form-control" 
						placeholder="Database Prefix"  id="db-prefix" required>
					<?php if ($error_db_prefix): ?>
					<span class="help-block error"><?= $error_db_prefix; ?></span>
					<?php endif; ?>
				</div>
			</div>
		</fieldset>
		<hr>
		<fieldset>
			<p class="alert alert-info">2. Please enter a username, password and email for the administration.</p>
			<div class="form-group">
				<label class="control-label col-sm-3" for="user_name"><b class="required">*</b> Username:</label>
				<div class="col-sm-6">
					<input type="text" 
						name="user_name" value="<?= $user_name; ?>" class="form-control" 
						placeholder="Username"  id="user_name" required>
					<?php if ($error_user_name): ?>
					<span class="help-block error"><?= $error_user_name; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="password"><b class="required">*</b> Password:</label>
				<div class="col-sm-6">
					<input type="text" 
						name="password" value="<?= $password; ?>" class="form-control" 
						placeholder="Password"  id="password" required>
					<?php if ($error_password): ?>
					<span class="help-block error"><?= $error_password; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="email"><b class="required">*</b> Email Address:</label>
				<div class="col-sm-6">
					<input type="email" 
						name="email" value="<?= $email; ?>" class="form-control" 
						placeholder="Email Address"  id="email" required>
					<?php if ($error_email): ?>
					<span class="help-block error"><?= $error_email; ?></span>
					<?php endif; ?>
				</div>
			</div>
		</fieldset>
		<div class="form-actions">
			<div class="row">
				<div class="col-xs-12 text-right">
					<a href="<?= $back; ?>" class="btn btn-default load-button">Back</a>
					<button type="submit" class="btn btn-primary">Continue <i class="fa fa-chevron-right"></i></button>
				</div>
			</div>
		</div>
	</form>
</div>
<?= $footer; ?>