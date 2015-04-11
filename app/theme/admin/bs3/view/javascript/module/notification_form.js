<script>
$(document).on('click', '#notification-submit', function(e) {
	<?php foreach($languages as $language): ?>
	$('textarea[name="email_content[<?= $language['language_id']; ?>][html]"]').val($('#html_<?= $language['language_id']; ?>').code());
	<?php endforeach; ?>
});
</script>