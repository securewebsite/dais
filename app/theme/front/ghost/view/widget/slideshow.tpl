<div id="slideshow<?= $widget; ?>" class="carousel slide" data-ride="carousel" data-interval="10000">
	<ol class="carousel-indicators hidden-xs">
		<?php foreach ($banners as $i => $banner) { ?>
			<li data-target="#slideshow<?= $widget; ?>" data-slide-to="<?= $i; ?>"<?= !$i ? ' class="active"' : ''; ?>></li>
		<?php } ?>
	</ol>
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
	<?php if (count($banners) > 1) { ?>
		<a class="carousel-control left" href="#slideshow<?= $widget; ?>" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
		<a class="carousel-control right" href="#slideshow<?= $widget; ?>" data-slide="next"><i class="fa fa-chevron-right"></i></a>
	<?php } ?>
</div>