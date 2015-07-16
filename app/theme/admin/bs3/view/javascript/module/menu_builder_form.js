<script>
$(document).on('change', 'select[name="type"]', function(){
	var method = $(this).val(), 
		menu = '';
	
	<?php if ($menu_id): ?>
		var menu = '&menu_id=' + <?= $menu_id; ?>;
	<?php endif; ?>
	
	switch(method) {
		case 'product_category':
			$('#result-panel').load('index.php?route=module/menu/product_category' + menu);
			break;
		case 'content_category':
			$('#result-panel').load('index.php?route=module/menu/content_category' + menu);
			break;
		case 'page':
			$('#result-panel').load('index.php?route=module/menu/page' + menu);
			break;
		case 'post':
			$('#result-panel').load('index.php?route=module/menu/post' + menu);
			break;
		case 'custom':
			$('#result-panel').load('index.php?route=module/menu/custom' + menu);
			break;
	}
});

$('select[name="type"]').trigger('change');

</script>