<?= $header; ?>
<hr>
<h1 class="text-center">Upgrade</h1>
<hr>
<div class="col-sm-4 hidden-xs pull-right">
	<ul class="list-group">
		<li class="list-group-item list-group-heading">Upgrade Progress</li>
		<li class="list-group-item"><i class="fa fa-chevron-circle-right text-info"></i> <b>Upgrade</b></li>
		<li class="list-group-item"><i class="fa fa-times text-danger"></i> Finished</li>
	</ul>
</div>
<div class="col-sm-8">
	<?php if ($error_warning): ?>
	<div class="alert alert-danger">
		<a class="close" data-dismiss="alert" href="#">&times;</a>
		<?= $error_warning; ?>
	</div>
	<?php else: ?>
	<form action="<?= $action; ?>" method="post" enctype="multipart/form-data">
		<p class="alert alert-info">After upgrade follow these steps carefully ... </p>
		<div class="list-group">
			<span class="list-group-item">
				<i class="fa fa-check-square-o fa-fw fa-lg text-success"></i> 
					Post any upgrade script errors problems in the forums</span>
			<span class="list-group-item">
				<i class="fa fa-check-square-o fa-fw fa-lg text-success"></i> 
					Clear any cookies in your browser to avoid getting token errors.</span>
			<span class="list-group-item">
				<i class="fa fa-check-square-o fa-fw fa-lg text-success"></i> 
					Load the admin page & press Ctrl+F5 twice to force the browser to update the css changes.</span>
			<span class="list-group-item">
				<i class="fa fa-check-square-o fa-fw fa-lg text-success"></i> 
					Goto Manage -> Users -> User Groups and Edit the Top Adminstrator group. Check All boxes.</span>
			<span class="list-group-item">
				<i class="fa fa-check-square-o fa-fw fa-lg text-success"></i> 
					Goto Manage and Edit the main System Settings. Update all fields and click save, even if nothing changed.</span>
			<span class="list-group-item">
				<i class="fa fa-check-square-o fa-fw fa-lg text-success"></i> 
					Load the store front & press Ctrl+F5 twice to force the browser to update the css changes.</span>
		</div>
		<div class="form-actions">
			<div class="row">
				<div class="col-xs-12 text-right">
					<button type="submit" class="btn btn-primary">Continue <i class="fa fa-chevron-right"></i></button>
				</div>
			</div>
		</div>
	</form>
	<?php endif; ?>
</div>
<?= $footer; ?> 