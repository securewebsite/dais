<ul class="list-inline clearfix">
	<li class="share-bar<?= ($type == 'product') ? ' product' : ''; ?>" data-toggle="tooltip" title="<?= $lang_text_share_on; ?>">
		<?php if ($facebook_enabled): ?>
		<a href="http://www.facebook.com/sharer.php?u=<?= $social_href; ?>" 
			class="social-share facebook" 
			data-width="550" 
			data-height="275"><?= $lang_text_facebook; ?></a>
		<?php endif; ?>
		<?php if ($twitter_enabled): ?>
		<a href="http://twitter.com/share?url=<?= $social_href; ?>&text=<?= $social_desc; ?>" 
			class="social-share twitter" 
			data-width="550" 
			data-height="275"><?= $lang_text_twitter; ?></a>
		<?php endif; ?>
		<?php if ($google_enabled): ?>
		<a href="https://plus.google.com/share?url=<?= $social_href; ?>" 
			class="social-share google" 
			data-width="550" 
			data-height="275"><?= $lang_text_google; ?></a>
		<?php endif; ?>
		<?php if ($linkedin_enabled): ?>
		<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?= $social_href; ?>" 
			class="social-share linkedin" 
			data-width="550" 
			data-height="502"><?= $lang_text_linkedin; ?></a>
		<?php endif; ?>
		<?php if ($pinterest_enabled): ?>
		<a href="http://pinterest.com/pin/create/button/?url=<?= $social_href; ?>&media=<?= urlencode($popup); ?>&description=<?= $social_desc; ?>" 
				class="social-share pinterest" 
				data-width="725" 
				data-height="300"><?= $lang_text_pinterest; ?></a>
		<?php endif; ?>
		<?php if ($tumblr_enabled): ?>
		<a href="http://www.tumblr.com/share/link?url=<?= $social_href; ?>&name=<?= $heading_title; ?>" 
			class="social-share tumblr" 
			data-width="550" 
			data-height="275"><?= $lang_text_tumblr; ?></a>
		<?php endif; ?>
		<?php if ($digg_enabled): ?>
		<a href="http://www.digg.com/submit?url=<?= $social_href; ?>" 
			class="social-share digg" 
			data-width="760" 
			data-height="315"><?= $lang_text_digg; ?></a>
		<?php endif; ?>
		<?php if ($stumbleupon_enabled): ?>
		<a href="http://www.stumbleupon.com/submit?url=<?= $social_href; ?>&title=<?= $heading_title; ?>" 
			class="social-share stumble" 
			data-width="845" 
			data-height="550"><?= $lang_text_stumble; ?></a>
		<?php endif; ?>
		<?php if ($delicious_enabled): ?>
		<a href="https://delicious.com/save?v=5&provider=<?= $social_site; ?>&noui&jump=close&url=<?= $social_href; ?>&title=<?= $heading_title; ?>" 
			class="social-share delicious" 
			data-width="550" 
			data-height="550"><?= $lang_text_delicious; ?></a>
		<?php endif; ?>
	</li>
</ul>
