<script>
$('select[name="ups_origin"]').change(function(){
	$('#service>div').hide();
	$('#'+this.value).show();
}).change();
</script>