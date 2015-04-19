<?php if ($comments): ?>
<?php foreach($comments as $comment): ?>
<div class="media">
	<?php if ($comment['href']): ?>
	<a class="pull-left" href="<?= $comment['href']; ?>" rel="nofollow" target="_blank">
		<img class="media-object img-responsive" src="<?= $comment['image']; ?>" alt="">
	</a>
	<?php else: ?>
	<img class="media-object img-responsive" src="<?= $comment['image']; ?>" alt="">
	<?php endif; ?>
	<div class="media-body">
		<div class="pull-right">
			<span class="reviews text-left">
			<?php for ($i = 1; $i < 6; $i++): ?>
			<?php if ($comment['rating'] < $i): ?>
				<i class="fa fa-star-o"></i>
			<?php else: ?>
				<i class="fa fa-star"></i>
			<?php endif; ?>
			<?php endfor; ?>
			</span>
		</div>
		<h4 class="media-heading">
			<?php if ($comment['href']): ?>
			<a href="<?= $comment['href']; ?>" rel="nofollow" target="_blank"><?= $comment['author']; ?></a>
			<?php else: ?>
			<?= $comment['author']; ?>
			<?php endif; ?>
			<small><span class="fa fa-clock-o"></span> <?= $comment['date_added']; ?></small>
		</h4>
		<?= $comment['text']; ?>
	</div>
</div>
<hr>
<?php endforeach; ?>

<div class="pagination"><?= str_replace('....','',$pagination); ?></div>

<?php else: ?>
<div class="media">
	<p class="text-center"><?= $text_no_comments; ?></p>
</div>
<?php endif; ?>
