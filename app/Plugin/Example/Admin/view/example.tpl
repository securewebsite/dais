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
		<div class="pull-left h2"><i class="hidden-xs fa fa-book"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right"></div>
	</div>
	<div class="panel-body">
		<div class="col-sm-8">
			<p>This example plugin has no settings, but if there were any, they would be below.</p>
			<p>This plugin implements both Events and Hooks to alter the core behavior of other areas of the application.</p>
			<h3>Events</h3>
			<p>Events are implemented when actual events occur inside the app, mostly in Models, but occasionally on other user action events such as login and logout.</p>
			<p>For a full list of default Events, click the Events List tab.</p>
			<h3>Hooks</h3>
			<p>Hooks are callback methods that can target specific controllers and methods in order to modify the default data stream from the given method, 
			or if you wish to trigger a process to run prior to a specific method.</p>
			<p>There are two types of hooks, <code>pre</code> and <code>post.</code> <code>Pre hooks</code> are passed as an argument to your called method, 
			thusly they fire before your method actually fires allowing you to run a given action just prior to your method. <code>Pre hooks</code> cannot access data within your method.</p>
			<p><code>Post hooks</code> are called within your method via the <code>$plugin->listen()</code> method.  
			This allows you to modify existing data within a given method prior to passing it to the view.</p>
		</div>
	</div>
</div>
<?= $footer; ?>