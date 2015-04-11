<div class="col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?= $lang_heading_title; ?></h3>
		</div>
		<div class="panel-body">
			
			<?php if ($events): ?>
			<?php foreach ($events as $event): ?>
			<div class="col-sm-4">
				<strong><?= $event['name']; ?></strong><br>
				<?= $lang_text_date; ?> <?= $event['start_date']; ?><br>
				<?= $lang_text_starts; ?> <?= $event['start_time']; ?><br>
				<?= $lang_text_days; ?> <?= $event['event_days']; ?><br>
				<?php if ($event['online']): ?>
				<?= $lang_text_location; ?> <a href="<?= $event['hangout']; ?>">Google Hangout</a>
				<?php else: ?>
				<?= $lang_text_location; ?> <?= $event['location']; ?><br>
				<?php endif; ?>
				<?= $lang_text_telephone; ?> <?= $event['telephone']; ?><br>
			</div>
			<?php endforeach; ?>
			<?php else: ?>
			<div class="text-center">
				<?= $lang_text_no_upcoming; ?>
			</div>
			<?php endif; ?>
			
		</div>
	</div>
</div>