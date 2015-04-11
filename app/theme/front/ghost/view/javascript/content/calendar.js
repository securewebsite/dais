<script>

var calendar = $('#calendar').calendar({
	events_source: 'index.php?route=content/calendar/fetch',
	view: 'month',
	time_start: '06:00',
	time_end:   '22:00',
	time_split: '30',
	twelve_hour: true,
	tmpl_path: '<?= $template_path; ?>',
	day: '<?= $today; ?>',
	first_day: 2,
	onAfterViewLoad: function(view) {
		$('.tooltip').remove();
		$('#calendar-nav h3').text(this.getTitle());
		$('.btn-group:not(.navigator) button').removeClass('active');
		$('button[data-calendar-view="' + view + '"]').addClass('active');
	},
	classes: {
		months: {
			general: 'label'
		}
	},
	modal: '#events-modal',
	modal_type: 'template',
	modal_title: function (e) { 
		return e.title 
	}
});

$('.btn-group button[data-calendar-nav]').each(function() {
	var $this = $(this);
	$this.click(function() {
		calendar.navigate($this.data('calendar-nav'));
	});
});

$('.btn-group button[data-calendar-view]').each(function() {
	var $this = $(this);
	$this.click(function() {
		calendar.view($this.data('calendar-view'));
	});
});

$('#calendar-panel').hide();

$(document).on('click', '#calendar-legend', function(e){
	e.preventDefault();
	$('#calendar-panel').slideToggle(400, function(){
		var text = ($('#show-text').text() == 'show') ? 'hide' : 'show';
		$('#show-text').text(text);
	});
});

</script>