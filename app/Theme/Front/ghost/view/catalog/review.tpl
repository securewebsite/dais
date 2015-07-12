<?php if ($reviews) { ?>
	<?php foreach ($reviews as $review) { ?>
	<div class="media">
		<h1 class="pull-left rating-quote"><i class="fa fa-quote-left"></i></h1>
		<div class="media-body">
			<div class="row">
				<div class="col-sm-9">
					<div class="reviews"><?php for ($i = 1; $i <= 5; $i++) {
						if ($review['rating'] < $i) {
							echo '<i class="fa fa-star-o"></i>';
						} else {
							echo '<i class="fa fa-star"></i>';
						}
					} ?></div>
					<p><?= $review['text']; ?></p>
					<small class="text-muted">&mdash; <?= $review['author']; ?> <?= $lang_text_on; ?> <?= $review['date_added']; ?></small>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
<?php } else { ?>
	<div class="alert alert-warning"><?= $lang_text_no_reviews; ?></div>
<?php } ?>
