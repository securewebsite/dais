<?= $header; ?>
<hr>
<h1 class="text-center">404</h1>
<hr>
<div class="col-sm-4 hidden-xs pull-right">
	<ul class="list-group">
		<li class="list-group-item list-group-heading">Upgrade Progress</li>
		<li class="list-group-item"><i class="fa fa-times text-danger"></i> Upgrade</li>
		<li class="list-group-item"><i class="fa fa-times text-danger"></i> <b>Finished</b></li>
	</ul>
</div>
<div id="content" class="col-sm-8">
	
	<h1 style="font-size:85px;" class="text-danger">WHOOPS!</h1>
	<p>The file you're looking for doesn't exist. Sorry.</p>
	
	<div class="form-actions">
		<div class="row">
			<div class="col-xs-12 text-right">
				<a onclick="javascript:window.history.back();" class="btn btn-default load-button">Back</a>
			</div>
		</div>
	</div>
	
</div>
<?= $footer; ?>