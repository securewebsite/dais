<script>
$(document).on('click', '#search-button', function(e){
	$search = $('input[name="search-field"]').val();
	$('#search-form').submit();
});
</script>