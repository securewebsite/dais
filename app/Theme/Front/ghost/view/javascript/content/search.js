<script>
$(document).on('change', 'select[name=\'filter_category_id\']', function() {
	$checkbox = $('input[name=\'filter_sub_category\']');
	if (this.value == '0') {
		if ($checkbox.attr('checked'))
			$checkbox.trigger('click');
	} else {
		if (!$checkbox.attr('checked'))
			$checkbox.trigger('click');
	}
});
</script>