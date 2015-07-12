<?= $header; ?>
<?= $post_header; ?>
<div class="row blog">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<?php if ($posts): ?>
		<?php foreach ($posts as $post): ?>
		<h2><a href="<?= $post['href']; ?>"><?= $post['name']; ?></a></h2>
		<div class="meta">
			<p>
				<span class="fa fa-user"></span> 
					<?= $lang_text_by; ?> <a href="<?= $post['author_href']; ?>" 
						data-toggle="tooltip" title="<?= $lang_text_all_by; ?> <?= $post['author_name']; ?>"><?= $post['author_name']; ?></a> | 
				<span class="fa fa-clock-o"></span> <?= $post['date_added']; ?> | 
				<?php if ($post['categories']): ?>
				<span class="fa fa-folder-open"></span> 
					<?= $lang_text_in; ?> <?= $post['categories']; ?> | 
				<?php endif; ?>
				<span class="fa fa-comments-o"></span> <?= $post['comments']; ?> | 
				<span class="fa fa-eye"></span> <?= $post['views']; ?>
			</p>
		</div>
		<hr>
		<a href="<?= $post['href']; ?>"><img class="img-responsive" src="<?= $post['thumb']; ?>" title="<?= $post['name']; ?>" alt="<?= $post['name']; ?>"></a>
		<hr>
		<p><?= $post['blurb']; ?></p>
		<a class="btn btn-primary" href="<?= $post['href']; ?>"><?= $lang_text_read_more; ?> <span class="fa fa-chevron-right"></span></a>
		<hr>
		<?php endforeach; ?>
		
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
		
		<?php else: ?>
		<p><?= $lang_text_empty; ?></p>
		<?php endif; ?>
		
	</div>
	
	<?= $column_right; ?>
	
	<?php if (trim($content_bottom)): ?>
	<div class="col-sm-12 clearfix">
		<hr>
		<?= $content_bottom; ?>
	</div>
	<?php endif; ?>		
</div>
<?= $pre_footer; ?>
<?= $footer; ?>