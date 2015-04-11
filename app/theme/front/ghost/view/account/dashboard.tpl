<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<?php if ($warning) { ?>
		<div class="alert alert-info"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $warning; ?></div>
		<?php } ?>
		<?php if ($success) { ?>
		<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $success; ?></div>
		<?php } ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<div class="col-sm-6">
			<fieldset>
				<legend><?= $lang_text_my_account; ?></legend>
					<a href="<?= $edit; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-edit fa-3x"></i><br>
						<span><?= $lang_icon_edit; ?></span>
					</a>
					<a href="<?= $password; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-ellipsis-h fa-3x"></i><br>
						<span><?= $lang_icon_password; ?></span>
					</a>
					<a href="<?= $address; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-book fa-3x"></i><br>
						<span><?= $lang_icon_address; ?></span>
					</a>
					<a href="<?= $wishlist; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-heart fa-3x"></i><br>
						<span><?= $lang_icon_wishlist; ?></span>
					</a>
					<a href="<?= $newsletter; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-envelope fa-3x"></i><br>
						<span><?= $lang_icon_subscribe; ?></span>
					</a>
				<?php if ($affiliate): ?>
					<a href="<?= $affiliate; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-bar-chart-o fa-3x"></i><br>
						<span><?= $lang_icon_affiliate; ?></span>
					</a>
				<?php endif; ?>
			</fieldset>
		</div>
		<div class="col-sm-6">
			<fieldset>
				<legend><?= $lang_text_my_orders; ?></legend>
					<a href="<?= $order; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-3x fa-archive"></i><br>
						<?= $lang_icon_history; ?>
					</a>
					<?php if ($download): ?>
					<a href="<?= $download; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-3x fa-download"></i><br>
						<?= $lang_icon_download; ?>
					</a>
					<?php endif; ?>
					<?php if ($reward) { ?>
					<a href="<?= $reward; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-3x fa-trophy"></i><br>
						<?= $lang_icon_reward; ?>
					</a>
					<?php } ?>
					<a href="<?= $return; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-3x fa-exchange"></i><br>
						<?= $lang_icon_return; ?>
					</a>
					<a href="<?= $credit; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-3x fa-money"></i><br>
						<?= $lang_icon_credit; ?>
					</a>
					<a href="<?= $waitlist; ?>" class="btn btn-transparent btn-primary btn-app">
						<i class="fa fa-3x fa-clock-o"></i><br>
						<?= $lang_icon_waitlist; ?>
					</a>
			</fieldset>
		</div>
		<div class="col-sm-12">
			<hr>
			<fieldset>
				<legend><?= $lang_text_updates; ?></legend>
				
			</fieldset>
		</div>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?> 