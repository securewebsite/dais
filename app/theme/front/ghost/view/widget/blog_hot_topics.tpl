<div class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title"><?= $lang_heading_title; ?></div>
	</div>
	<div class="row">
		<div class="col-sm-4 text-center">
			<a href="#tab-recent" data-toggle="tab" class="hot-topic active" title="<?= $lang_tab_recent; ?>"><i class="fa fa-fire"></i></a>
		</div>
		<div class="col-sm-4 text-center">
			<a href="#tab-viewed" data-toggle="tab" class="hot-topic" title="<?= $lang_tab_viewed; ?>"><i class="fa fa-eye"></i></a>
		</div>
		<div class="col-sm-4 text-center">
			<a href="#tab-discussed" data-toggle="tab" class="hot-topic" title="<?= $lang_tab_discussed; ?>"><i class="fa fa-comments"></i></a>
		</div>
	</div>
	<div class="panel-body widget">
		<div class="tab-content">
			<div id="tab-recent" class="tab-pane active">
				<ul class="list-unstyled">
					<?php foreach ($recent_posts as $post): ?>
					<li class="topic">
						<a class="clearfix" href="<?= $post['href']; ?>">
							<img class="img-responsive" src="<?= $post['pic']; ?>" style="float:left;margin-bottom:4px;" title="<?= $post['name']; ?>" alt="<?= $post['name']; ?>"> 
							<span><?= $post['name']; ?></span>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div id="tab-viewed" class="tab-pane">
				<ul class="list-unstyled">
					<?php foreach ($most_viewed as $post): ?>
					<li class="topic">
						<a class="clearfix" href="<?= $post['href']; ?>">
							<img class="img-responsive" src="<?= $post['pic']; ?>" style="float:left;margin-bottom:4px;" title="<?= $post['name']; ?>" alt="<?= $post['name']; ?>"> 
							<span><?= $post['name']; ?></span>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div id="tab-discussed" class="tab-pane">
				<ul class="list-unstyled">
					<?php foreach ($most_discussed as $post): ?>
					<li class="topic">
						<a class="clearfix" href="<?= $post['href']; ?>">
							<img class="img-responsive" src="<?= $post['pic']; ?>" style="float:left;margin-bottom:4px;" title="<?= $post['name']; ?>" alt="<?= $post['name']; ?>"> 
							<span><?= $post['name']; ?></span>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
