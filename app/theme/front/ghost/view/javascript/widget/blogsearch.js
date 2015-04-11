<script>
$('#blog-search-form').keydown(function(e) {
    if (e.keyCode == 13) {
        var url = $(this).data('url') + '?filter_name=' + encodeURIComponent($(this).val());
		location = url;
    }
});
</script>