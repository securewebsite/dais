<script>

/**
 * Hide the read-panel so we can slide it down
 */

$('#read-panel').hide();

/**
 * Make sure we set the values of our checkboxes
 */

var checkbox = $('#notifications').find('input:checkbox');

checkbox.each(function(){
	$(this).on('click', function(){
		$(this).val() == 0 || $(this).val() == null ? $(this).val(1) : $(this).val(0);
	});
});

/**
 * Load the inbox
 */

$('#inbox').load('account/notification/inbox');

/**
 * Execute our Pagination
 */

$(document).on('click', '#inbox .pagination a', function(e) {
	e.preventDefault();
	
	$href = this.href;

	$('#inbox').fadeOut('slow', function() {
		$('#inbox').load($href);
		$('#inbox').fadeIn('slow');
	});
});

/**
 * Execute our notification links to the read panel
 * Update the badge
 * Remove the <b></b> tags from our links
 */

$(document).on('click', '#inbox .read-notify-link', function(e) {
	e.preventDefault();

	$url  = $(this).attr('href');
	$self = $(this);

	$.ajax({
		url: $url,
		type:'get',
		dataType:'json',
		success:function(json) {
			if (json['message']) {
				$('#reader').html(json['message']);
				$('#read-panel').slideToggle();
				resetBadge();
				unWrapLink($self); 
			}
		}
	});
});

/**
 * Execute our delete buttons
 * Update the badge
 * Reload the inbox
 */

$(document).on('click', '#inbox .delete-button', function(e) {
	e.preventDefault();

	$url  = $(this).attr('href');
	
	$.ajax({
		url: $url,
		type:'get',
		dataType:'json',
		success:function(json) {
			if (json['success']) {
				resetBadge();
				$('#inbox').load('account/notification/inbox');
			}
		}
	});
});

/**
 * Close the read panel
 */

$(document).on('click', '#reader-close', function(e){
	e.preventDefault();
	$('#read-panel').slideToggle();
});

/**
 * Reset the counter if we have a badge,
 * or remove it if it's zero
 */

function resetBadge() {
	var badge = $('#notify-badge').text();

	// badge is a string so we need to cast it to int
	badge = parseInt(badge, 10);

	// subtract 1 since the item was read
	badge--;

	if (badge == 0) {
		$('#notify-badge').remove();
	} else {
		$('#notify-badge').text(badge);
	}
}

/**
 * Unwrap the bold tags on links
 */

function unWrapLink(url) {
	$(url).html(function (i, h) { 
		return h.replace(/<b>/g,'').replace(/<\/b>/g,''); 
	});
}

</script>