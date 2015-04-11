<?= $header; ?>
<hr>
<h1 class="text-center">Congratulations!</h1>
<hr>
<div class="col-sm-4 hidden-xs pull-right">
	<ul class="list-group">
		<li class="list-group-item list-group-heading">Installation Progress</li>
		<li class="list-group-item"><i class="fa fa-check text-success"></i> License</li>
		<li class="list-group-item"><i class="fa fa-check text-success"></i> Pre-Installation</li>
		<li class="list-group-item"><i class="fa fa-check text-success"></i> Configuration</li>
		<li class="list-group-item"><i class="fa fa-check text-success"></i> <b>Finished</b></li>
	</ul>
</div>
<div id="content" class="col-sm-8">
	<div class="alert alert-success">
		<a class="close" data-dismiss="alert" href="#">&times;</a>
		You have successfully installed Dais.
	</div>
	<?php if (!$removed): ?>
	<div class="alert alert-danger">
		<a class="close" data-dismiss="alert" href="#">&times;</a>
		Don't forget to rename or delete your dais.sql file in app/install/. Leaving it in place is a security risk that would allow others to run the upgrade script against your database.
	</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-sm-6 text-center">
			<a href="<?= $home; ?>">
				<img src="../asset/install/img/home.png" alt="" class="thumbnail img-responsive">
			</a>
			<hr>
			<div class="text-center spacer">
				<a class="btn btn-lg btn-info" href="<?= $home; ?>">
					<i class="fa fa-shopping-cart"></i> Go to Site
				</a>
			</div>
		</div>
		<div class="col-sm-6 text-center">
			<a href="<?= $manager; ?>">
				<img src="../asset/install/img/manager.png" alt="" class="thumbnail img-responsive">
			</a>
			<hr>
			<div class="text-center spacer">
				<a class="btn btn-lg btn-primary" href="<?= $manager; ?>">
					<i class="fa fa-gear"></i> Login to Manager
				</a>
			</div>
		</div>
	</div>
</div>
<?= $footer; ?>