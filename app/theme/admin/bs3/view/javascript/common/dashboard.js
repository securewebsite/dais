<script>
$('#tabs-chart a[data-toggle="tab"]').on('shown.bs.tab',function(e){
	var $this=$(this);
	$.ajax({
		type:'get',
		url:'common/dashboard/sale/range/'+$this.attr('href'),
		dataType:'json',
		beforeSend:function(){
			$('#report').html('<i class="fa fa-cog fa-spin"></i>');
		},
		success:function(json){
			$.plot($('#report'),[json.order,json.customer],{
				colors:["#f89406","#3a87ad"],
				legend:{
					noColumns:2,
					labelFormatter:function(label,series){ 
						return '<b class="badge" style="background-color:'+series.color+'">'+label+'</b>';
					}
				},
				xaxis:{ticks:json.xaxis},
				yaxis:{position:'right'},
				shadowSize:0,
				lines:{fill:true,lineWidth:1},
				grid:{tickColor:'#eee',borderWidth:0}
			});
		}
	});
});
</script>