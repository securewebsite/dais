<script>
<?php foreach($languages as $language): ?>

$('#meta-description<?= $language["language_id"]; ?>').bind('click', function(e) {
	e.preventDefault();
	$data = $('textarea[name="page_description[<?= $language["language_id"]; ?>][description]"]').code();
	$.ajax({
		url: 'content/page/description',
		type: 'post',
		dataType: 'json',
		data: {
			description: $data
		},
		success: function (json) {
			if (json['success']) {
				$('textarea[name="page_description[<?= $language["language_id"]; ?>][meta_description]"]').html(json['success']);
			}
		} 
	});
});

$('#meta-keyword<?= $language["language_id"]; ?>').bind('click', function(e) {
	e.preventDefault();
	$data = $('textarea[name="page_description[<?= $language["language_id"]; ?>][description]"]').code();
	$.ajax({
		url: 'content/page/keyword',
		type: 'post',
		dataType: 'json',
		data: {
			keywords: $data
		},
		success: function (json) {
			if (json['success']) {
				$('textarea[name="page_description[<?= $language["language_id"]; ?>][meta_keywords]"]').html(json['success']);
			}
		} 
	});
});

<?php endforeach; ?>
</script>