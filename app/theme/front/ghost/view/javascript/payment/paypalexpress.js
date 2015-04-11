<script>
$(document).on('click', '#button-confirm', function(e) {
	e.preventDefault();
	location = '<?= $button_continue_action; ?>';
});
</script>