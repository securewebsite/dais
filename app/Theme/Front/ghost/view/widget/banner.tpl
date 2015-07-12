<div id="banner<?= $widget; ?>" class="carousel carousel-fade slide" data-ride="carousel" data-pause="false">
	<div class="carousel-inner">
		<?php foreach ($banners as $i => $banner) { ?>
			<div class="item<?= !$i ? ' active' : ''; ?>">
				<?php if ($banner['link']) { ?>
				<a href="<?= $banner['link']; ?>"><img class="img-rounded" src="<?= $banner['image']; ?>" alt="<?= $banner['title']; ?>"></a>
				<?php } else { ?>
				<img class="img-rounded" src="<?= $banner['image']; ?>" alt="<?= $banner['title']; ?>">
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>