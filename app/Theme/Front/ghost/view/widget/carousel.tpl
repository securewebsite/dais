<div class="well well-lg">
	<ul id="carousel<?= $widget; ?>" class="center-block jcarousel-skin-dais">
		<?php foreach ($banners as $banner): ?>
		<?php if ($banner['link']): ?>
		<li>
			<div>
				<a class="thumbnail" href="<?= $banner['link']; ?>">
					<img src="<?= $banner['image']; ?>" alt="<?= $banner['title']; ?>" title="<?= $banner['title']; ?>">
				</a>
			</div>
		</li>
		<?php else: ?>
		<li>
			<div>
				<span class="thumbnail">
					<img src="<?= $banner['image']; ?>" alt="<?= $banner['title']; ?>" title="<?= $banner['title']; ?>">
				</span>
			</div>
		</li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>