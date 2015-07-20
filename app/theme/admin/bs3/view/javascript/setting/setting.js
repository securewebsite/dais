<script>
	$(document).on('click', '.default-cat', function () {
		$('.default-cat').prop('checked', false);
		$(this).prop('checked', true);
	});
	var mapped={};
	$('input[name="assign_to"]').typeahead({
		source:function(q,process){
			return $.getJSON('setting/setting/autocomplete/filter_username/'+encodeURIComponent(q),function(json){
				var data=[];
				$.each(json,function(i,item){
					mapped[item.username]=item;
					data.push(item.username);
				});
				process(data);
			});
		},
		updater:function(item){
			$('input[name="config_assign_to"]').val(mapped[item].customer_id);
			$('input[name="assign_to"]').val(mapped[item].username);
			return item;
		}
	}).click(function(){
		this.select();
	});

	$(document).on('submit', '#form', function(){
		if ($('input[name="assign_to"]').val() == '') {
			$('input[name="config_assign_to"]').val('');
		}
	});
</script>