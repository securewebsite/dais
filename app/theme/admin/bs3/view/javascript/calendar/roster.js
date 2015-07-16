<script>
$(document).on('click', '#add_waitlist', function() {
	if ($('input[name=\'customer\']').val() != "") {
		var dataString = 'event_id=<?= $event_id; ?>&attendee_id=' + $('input[name=\'attendee_id\']').val();
		$.ajax({
			url: 'index.php?route=calendar/event/add_to_wait_list',
			type: 'POST',
			dataType: 'json',
			data: dataString,
			success: function(json) {
				if (json.success == 1) {
					$('#response-success').html(json.message)
						.fadeIn(1000)
						.delay(5000)
						.fadeOut(1000, function(){
							$(this).html('');
						});
				} else {
					$('#response-warning').html(json.message)
						.fadeIn(1000)
						.delay(5000)
						.fadeOut(1000, function(){
							$(this).html('');
						});
				}
			},
			error: function(xhr,j,i) {
				alert(i);
			}
		});
	} else {
		alert('<?= $lang_error_attendee_required; ?>');
		return false;
	}
});

$(document).on('click', '#add_attendee', function() {
	if ($('input[name=\'customer\']').val() != "") {
		var dataString = 'event_id=<?= $event_id; ?>&attendee_id=' + $('input[name=\'attendee_id\']').val();
		$.ajax({
			url: 'index.php?route=calendar/event/insert_attendee',
			type: 'POST',
			dataType: 'json',
			data: dataString,
			success: function(json) {
				if (json.success == 1) {
					$('#roster').html(json.roster);
					$('#available').html(json.available);
					$('#response-success').html(json.message)
						.fadeIn(1000)
						.delay(5000)
						.fadeOut(1000, function(){
							$(this).html('');
						});
				} else {
					$('#response-warning').html(json.message)
						.fadeIn(1000)
						.delay(5000)
						.fadeOut(1000, function(){
							$(this).html('');
						});
				}
				$('input[name=\'customer\']').val('');
				$('input[name=\'attendee_id\']').val('');
				$('input[name=\'customer\']').focus();
			},
			error: function(xhr,j,i) {
				alert(i);
			}
		});
	} else {
		alert('<?= $lang_error_attendee_required; ?>');
		return false;
	}
});

var mapped={};
$('input[name="customer"]').typeahead({
	source:function(q,process){
		return $.getJSON('index.php?route=calendar/event/autocomplete&name='+encodeURIComponent(q),function(json){
			var data=[];
			$.each(json,function(i,item){
				mapped[item.name]=item;
				data.push(item.name);
			});
			process(data);
		});
	},
	updater:function(item){
		$('input[name="attendee_id"]').val(mapped[item].attendee_id);
		$('input[name="customer"]').val(mapped[item].name);
		return item;
	}
}).click(function(){
	this.select();
});


</script>