<?= $header; ?>
<hr>
<h1 class="text-center">Welcome to Dais</h1>
<hr>
<div class="col-sm-4 hidden-xs pull-right">
	<ul class="list-group">
		<li class="list-group-item list-group-heading">Installation Progress</li>
		<li class="list-group-item"><i class="fa fa-times text-danger"></i> License</li>
		<li class="list-group-item"><i class="fa fa-times text-danger"></i> Pre-Installation</li>
		<li class="list-group-item"><i class="fa fa-times text-danger"></i> Configuration</li>
		<li class="list-group-item"><i class="fa fa-times text-danger"></i> Finished</li>
	</ul>
</div>
<div id="content" class="col-sm-8">
	<?php if ($error_warning): ?>
	<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
	<?php else: ?>
	<div class="row">
		<div class="col-sm-12">
			<p>In the next few minutes you're going to be installing the Dais system on your server.</p>
			<p>Before you begin you'll need the following items/information:</p>
			<div class="col-sm-offset-1">
				<ul class="list-unstyled fa-ul">
					<li>
						<i class="fa-li fa fa-arrow-right text-info"></i> 
						An Apache web server</li>
					<li>
						<i class="fa-li fa fa-arrow-right text-info"></i> 
						An empty MySQL database</li>
					<li>
						<i class="fa-li fa fa-arrow-right text-info"></i> 
						Username, password and database name for your database</li>
					<li>
						<i class="fa-li fa fa-arrow-right text-info"></i> 
						A username for administration</li>
					<li>
						<i class="fa-li fa fa-arrow-right text-info"></i> 
						A password for administration</li>
					<li>
						<i class="fa-li fa fa-arrow-right text-info"></i> 
						An email for administration</li>
				</ul>
			</div>
			<p>Once you have all these things written down or ready to go, press the Get Started button below.</p>
			<div class="form-actions">
				<div class="row">
					<div class="col-xs-12 text-right">
						<a href="<?= $action; ?>" class="btn btn-success load-button">
							Get Started <i class="fa fa-chevron-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
<?= $footer; ?>