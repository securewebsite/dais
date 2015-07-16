<script>
var mapped={};
<?php if ($posted_by == 'user_name'): ?>
	var filter_name = 'filter_user_name';
<?php else: ?>
	var filter_name = 'filter_name';
<?php endif; ?>
$('input[name="filter_author_id"]').typeahead({
	source:function(q,process){
		return $.getJSON('index.php?route=content/post/autoauthor&'+filter_name+'='+encodeURIComponent(q),function(json){
			var data=[];
			$.each(json,function(i,item){
				<?php if ($posted_by == 'user_name'): ?>
				mapped[item.user_name]=item;
				data.push(item.user_name);
				<?php else: ?>
				mapped[item.name]=item;
				data.push(item.name);
				<?php endif; ?>
			});
			process(data);
		});
	},
	updater:function(item){
		<?php if ($posted_by == 'user_name'): ?>
		$('input[name="filter_author_id"]').val(mapped[item].user_name);
		filter();
		<?php else: ?>
		$('input[name="filter_author_id"]').val(mapped[item].name);
		filter();
		<?php endif; ?>
		return item;
	}
}).click(function(){
	this.select();
});
</script>