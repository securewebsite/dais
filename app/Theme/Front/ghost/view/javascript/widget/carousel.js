<script>
$(function(){
	$('#carousel<?= $widget; ?>').jcarousel({
		wrap:'circular',
		buttonNextHTML:'<div>&rsaquo;</div>',
		buttonPrevHTML:'<div>&lsaquo;</div>',
		setupCallback:function(a){
			a.reload();
		},
		reloadCallback:function(a){
			if(a.clipping() < 480 && <?= $limit; ?> > 2){
				a.options.scroll = 1;
				a.options.visible = 2;
			}else if(a.clipping() < 768 && <?= $limit; ?> > 6){
				a.options.scroll = <?= $scroll > 2 ? 2 : $scroll; ?>;
				a.options.visible = 6;
			}else{
				a.options.scroll = <?= $scroll; ?>;
				a.options.visible = <?= $limit; ?>;
			}
		}
	});
});
</script>