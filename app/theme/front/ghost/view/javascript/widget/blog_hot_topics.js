<script>
$('.hot-topic').tooltip();
	
$(document).on('click', '.hot-topic', function(e) {
	$('.hot-topic').removeClass('active');
	$(this).addClass('active');
});
</script>