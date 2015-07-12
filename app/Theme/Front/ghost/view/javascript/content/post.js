<script>
$('#post-comments').load('content/post/comment&post_id=<?= $post_id; ?>');

$(document).on('click', '#post-comments .pagination a', function(e) {
	e.preventDefault();
	$('#post-comments').fadeOut('slow', function() {
		$('#post-comments').load(this.href);
		$('#post-comments').fadeIn('slow');
	});
});

$(document).on('click', '#comment-send', function(e) {
	e.preventDefault();
	$.ajax({
		url:'content/post/write&post_id=<?= $post_id; ?>',
		type:'post',
		dataType:'json',
		data:$('#comment-form').serialize(),
		success:function(json){
			if(json['error']){
				alertMessage('danger',json['error']);
			}
			if(json['success']){
				alertMessage('success',json['success']);
				$('input[name="rating"]:checked').prop('checked',false);
				$('input[name="name"],input[name="email"],input[name="website"],textarea[name="text"],input[name="captcha"]').val('');
				
				$('#post-comments').fadeOut('slow', function() {
					$('#post-comments').load('content/post/comment&post_id=<?= $post_id; ?>');
					$('#post-comments').fadeIn('slow');
				});
			}
		}
	});
});	

</script>