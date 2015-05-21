<h3 class="text-muted"><?= $heading_title; ?></h3>
<?php if ($posts): ?>
<div class="<?= $class_row; ?> post-<?= $class_1; ?>">
<?php foreach ($posts as $post): ?>
	<div class="brick <?= $class_col; ?>">
		<div class="<?= $class_2; ?>">
			<?php if ($post['thumb']): ?>
				<a class="<?= $class_3; ?>" href="<?= $post['href']; ?>">
					<img class="img-responsive" src="<?= $post['thumb']; ?>" alt="<?= $post['name']; ?>">
				</a>
			<?php endif; ?>
			<div class="caption">
				<div class="name"><a href="<?= $post['href']; ?>"><?= $post['name']; ?></a></div>
				<?php if ($post['description']): ?>
					<div class="description"><?= $post['description']; ?></div>
				<?php endif; ?>
				<?php if ($post['rating']): ?>
					<div class="reviews" title="<?= $post['reviews']; ?>">
					<?php for ($i = 1; $i <= 5; $i++):
						  if ($post['rating'] < $i): ?>
						<i class="fa fa-star-o"></i>
					<?php else: ?>
						<i class="fa fa-star"></i>
					<?php endif;
						  endfor; ?>
					</div>
				<?php endif; ?>
				<?php if ($button): ?>
					<div class="cart">
						<button type="button" 
							data-toggle="tooltip" 
							title="<?= $lang_text_read_more; ?>" 
							class="btn btn-warning"><?= $lang_button_view_post; ?>
						</button>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
<?php else: ?>
	<div class="alert alert-warning"><?= $text_empty; ?></div>
<?php endif; ?>
