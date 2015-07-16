<script>
new AjaxUpload('#button-upload', {
	action: 'index.php?route=catalog/download/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-upload').button('loading').append($('<i>',{class:'icon-loading'}));
	},
	onComplete: function (file, json) {
		$('#button-upload').button('reset');
		
		if (json['error']){
			alert(json['error']);
		}
		
		if (json['success']){
			alert(json['success']);
			$('input[name="filename"]').val(json['filename']);
			$('input[name="mask"]').val(json['mask']);
		}

		$('.icon-loading').remove();
	}
});
</script>