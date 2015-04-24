<script>
var token  = '<?= $token; ?>';
var method = '<?= $method; ?>';
if (method == 'insert') {
	var is_product = $('input[name="is_product"]:checked').val();
} else {
	var is_product = $('input[name="is_product"]').val();
}

var $url;

if (is_product == 1) {
	$('#page-panel').hide(function(){
		$url = 'index.php?route=catalog/product/slug&token='+token;
	});
} else {
	$('#product-panel').hide(function(){
		$url = 'index.php?route=content/page/slug&token='+token;
	});
}

$(document).on('change', 'input[name="is_product"]', function() {
	$('#page-panel').slideToggle(function(){
		if ($(this).is(':hidden')) {
			$url = 'index.php?route=catalog/product/slug&token='+token;
		}
	});
	$('#product-panel').slideToggle(function(){
		if ($(this).is(':hidden')) {
			$url = 'index.php?route=content/page/slug&token='+token;
		}
	});
});

$(document).on('click', '#event-slug-btn', function(){
	var page_id    = $('input[name="page_id"]').val();
	var product_id = $('input[name="product_id"]').val();
	var name       = $('input[name="name"]').val().toLowerCase();
	var slug       = $('#slug').val().toLowerCase();
	var send       = (name == slug || slug == '') ? name : slug;
	
	$url += '&name=' + encodeURIComponent(send);

	if (page_id > 0) {
		$url += '&page_id=' + page_id;
	}

	if (product_id > 0) {
		$url += '&product_id=' + product_id;
	}
	
	$.ajax({
		url: $url,
		type: 'get',
		dataType: 'json',
		success: function (json) {
			if (json['error']) {
				alertMessage('danger', json['error']);
			} else {
				$('#slug').val(json['slug']);
			}
		}
	});
});

$('input[name="event_class"]').on('change', function() {
    $('input[name="event_class"]').not(this).prop('checked', false);  
});

</script>