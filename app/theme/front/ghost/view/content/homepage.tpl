<?= $header; ?>
<?= $post_header; ?>
<div id="fb-root"></div>
<!-- <div id="tent-banner-home" class="container-fluid hidden-md hidden-sm hidden-xs"></div> -->
<div class="container">
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?> clearfix">
		<?= $content_top; ?>
		<div class="row">
			<div class="col-sm-12 text-center">
				<video 
					id="video-id" 
					class="video-js vjs-default-skin vjs-big-play-centered flex-video" 
					controls 
					preload 
					width="100%" height="56.25%" 
					poster="image/data/video/m93SHk4SANs.png"
					data-setup='{
						"techOrder": ["youtube"], 
						"quality": "720", 
						"plugins": { "watermark": {
							"file": "asset/redtent/img/watermark.png",
							"opacity": "0.3"
						}},
						"src": "//www.youtube.com/embed/m93SHk4SANs" 
					}'>
				</video>
			</div>
		</div>
		<div class="row">
			<div class="v-space5"></div>
		</div>
		<?= $description; ?>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>