<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $heading_title; ?></h1></div>
		<div class="row">
			<div class="col-sm-12">
				<h4><?= $lang_text_event_about; ?></h4>
				<?= $description; ?>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12"><h4><?= $lang_text_event_detail; ?></h4><br></div>
			<div class="col-sm-6">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td><?= $lang_text_event_date; ?></td>
							<td><?= $event_date; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_event_time; ?></td>
							<td><?= $event_time; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_event_days; ?></td>
							<td>
								<?php foreach ($event_days as $event_day): ?>
									<?= $event_day; ?><br />
								<?php endforeach; ?>
							</td>
						</tr>
						<tr>
							<td><?= $lang_text_event_length; ?></td>
							<td><?= $event_length; ?> <?= $event_length_text; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-sm-6">
				<table class="table table-striped">
					<tbody>
						<?php if ($telephone): ?>
						<tr>
							<td><?= $lang_text_telephone; ?></td>
							<td><?= $telephone; ?></td>
						</tr>
						<?php endif; ?>
						<?php if ($location): ?>
						<tr>
							<td><?= $lang_text_location; ?></td>
							<td>
								<?php if ($online): ?>
								<a href="<?= $location; ?>" target="_blank"><?= $location; ?></a>
								<?php else: ?>
								<?= $location; ?>
								<?php endif; ?>
							</td>
						</tr>
						<?php endif; ?>
						<tr>
							<td><?= $lang_text_seats; ?></td>
							<td><?= $seats; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_available; ?></td>
							<td><?= $available; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<h4><?= $text_presenter_info; ?></h4>
				<?php if ($presenter_image): ?>
				<div class="col-sm-3">
					<div class="thumbnail">
						<img src="<?= $presenter_image; ?>" class="img-responsive" title="<?= $presenter; ?>" alt="<?= $presenter; ?>">
					</div>
				</div>
				<div class="col-sm-9">
					<h4><?= $presenter; ?></h4>
					<?php if ($presenter_facebook): ?>
					<span><i class="fa fa-facebook-square" style="color:#3b5998;"></i> <a href="http://www.facebook.com/<?= $presenter_facebook; ?>" target="_blank"><?= $presenter; ?></a></span>
					<?php if ($presenter_twitter): ?>
					<br>
					<?php else: ?>
					<br><br>
					<?php endif; ?>
					<?php endif; ?>
					<?php if ($presenter_twitter): ?>
					<span><i class="fa fa-twitter" style="color:#4099FF;"></i> <a href="https://twitter.com/<?= $presenter_twitter; ?>" target="_blank">@<?= $presenter_twitter; ?></a></span><br><br>
					<?php endif; ?>
					<p><b><?= $text_presenter_bio; ?></b></p>
					<p><?= $presenter_bio; ?></p>
				</div>
				<?php else: ?>
				<h4><?= $presenter; ?></h4>
				<p><b><?= $text_presenter_bio; ?></b></p>
				<p><?= $presenter_bio; ?></p>
				<?php endif; ?>
			</div>
		</div>
		<hr>
		<div class="row">
			<?php if ($tags): ?>
			<div class="col-sm-6">
				<span class="fa fa-tags"></span> <?= $lang_text_tags; ?> 
			<?php foreach($tags as $tag): ?>
				<a href="<?= $tag['href']; ?>" class="label label-info"><?= $tag['name']; ?></a> 
			<?php endforeach; ?>
			</div>
			<div class="col-sm-6">
			<?= $sharebar; ?>
			</div>
			<?php else: ?>
			<div class="col-sm-12">
			<?= $sharebar; ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="form-actions">
			<div class="form-actions-inner text-right">
				<a href="<?= $continue; ?>" class="btn btn-primary"><?= $lang_button_continue; ?></a>
			</div>
		</div>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>