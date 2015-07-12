<?= $header; ?>
<?= $post_header; ?>
	<div class="row blog">
		<?= $column_left; ?>
		<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
			<?= $breadcrumb; ?>
			<?= $content_top; ?>
			
			<h1><?= $heading_title; ?></h1>
			
			<div class="meta">
				<p>
					<span class="fa fa-user"></span> 
						<?= $lang_text_by; ?> <a href="<?= $author_href; ?>" 
							data-toggle="tooltip" title="<?= $lang_text_all_by; ?> <?= $author_name; ?>"><?= $author_name; ?></a> | 
					<span class="fa fa-clock-o"></span> <?= $date_added; ?> | 
					<span class="fa fa-folder-open"></span> 
						<?= $lang_text_in; ?> <?= $posted_in_categories; ?> | 
					<span class="fa fa-comments-o"></span> <?= $text_comments; ?> | 
					<span class="fa fa-eye"></span> <?= $text_views; ?>
				</p>
			</div>
			
			<hr>
			
			<?php if ($thumb): ?>
			<img class="img-responsive" src="<?= $thumb; ?>" title="<?= $heading_title; ?>" alt="<?= $heading_title; ?>">
			<hr>
			<?php endif; ?>

            <?= $description; ?>
			
			<hr>
			
			<div class="row">
				<?php if ($tags): ?>
				<div class="col-sm-6">
					<span class="fa fa-tags"></span><?= $lang_text_tags; ?> 
				<?php foreach($tags as $tag): ?>
					<a href="<?= $tag['href']; ?>" class="label label-info"><?= $tag['name']; ?></a> 
				<?php endforeach; ?>
				</div>
				<div class="col-sm-6">
				<?= $share_bar; ?>
				</div>
				<?php else: ?>
				<div class="col-sm-12">
				<?= $share_bar; ?>
				</div>
				<?php endif; ?>
			</div>

			<hr>
			
			<!-- related posts -->
			
			<?php if ($comment_status): ?>
			
			<h4><?= $tab_comment; ?></h4>
			<!-- Blog Comments -->
			
			<div id="post-comments"></div>
			
			<?php if ($comment_allowed): ?>

			<hr>

			<!-- Comments Form -->
			<div class="well">
				<form role="form" id="comment-form" class="form-horizontal">
					<fieldset>
						<legend><?= $lang_text_write; ?></legend>
						<div class="form-group">
							<label class="control-label col-sm-2" for="name"><b class="required">*</b> <?= $lang_entry_name; ?></label>
							<div class="col-sm-6">
								<input type="text" name="name" class="form-control" placeholder="<?= $lang_entry_name; ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email"><b class="required">*</b> <?= $lang_entry_email; ?></label>
							<div class="col-sm-6">
								<input type="email" name="email" class="form-control" placeholder="<?= $lang_entry_email; ?>" required>
								<span class="help-block"><?= $lang_text_email_help; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="website"><?= $lang_entry_website; ?></label>
							<div class="col-sm-8">
								<input type="text" name="website" class="form-control" placeholder="<?= $lang_entry_website; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="rating"><b class="required">*</b> <?= $lang_entry_rating; ?></label>
							<div class="col-sm-6">
								<label style="margin-right:15px;" class="label label-danger"><?= $lang_entry_bad; ?></label>
								<?php for ($i = 1; $i < 6; $i++){ ?>
									<div class="radio radio-inline">
										<label><input type="radio" name="rating" value="<?= $i; ?>" <?= ($i == 3) ? 'checked' : ''; ?>></label>
									</div>
								<?php } ?>
								<label class="label label-success"><?= $lang_entry_good; ?></label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="text"><b class="required">*</b> <?= $lang_entry_leave; ?></label>
							<div class="col-sm-10">
								<textarea name="text" class="form-control" rows="3" placeholder="<?= $lang_entry_leave; ?>" required></textarea>
								<span class="help-block danger"><?= $lang_text_note; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="captcha"><b class="required">*</b> <?= $lang_entry_captcha; ?></label>
							<div class="col-sm-4">
								<input type="text" name="captcha" class="form-control">
								<p class="help-block"><img src="tool/captcha" alt="" id="captcha"></p>
							</div>
						</div>
						<div class="form-actions">
							<div class="form-actions-inner text-right">
								<button type="submit" id="comment-send" class="btn btn-primary"><?= $lang_button_send; ?></button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>

			<?php else: ?>

			<div class="alert alert-warning"><?= $lang_text_please_login; ?></div>

			<?php endif; ?>

            <hr>

			<?php endif; ?>
			
			
			<?= $content_bottom; ?>
		</div>
		<?= $column_right; ?>
	</div>
<?= $pre_footer; ?>
<?= $footer; ?>