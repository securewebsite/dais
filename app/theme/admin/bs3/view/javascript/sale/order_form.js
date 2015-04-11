<script>
$('#customer_group_id').change(function(){
	$('input[name="customer_group_id"]').val(this.value);
	
	var customer_group = [];
	
<?php foreach ($customer_groups as $customer_group) { ?>
	var i=<?= $customer_group['customer_group_id']; ?>;
	customer_group[i]=[];
	customer_group[i]['company_id_display']='<?= $customer_group['company_id_display']; ?>';
	customer_group[i]['company_id_required']='<?= $customer_group['company_id_required']; ?>';
	customer_group[i]['tax_id_display']='<?= $customer_group['tax_id_display']; ?>';
	customer_group[i]['tax_id_required']='<?= $customer_group['tax_id_required']; ?>';
<?php } ?>	

	if(customer_group[this.value]){
		if(customer_group[this.value]['company_id_display']==1){
			$('#company-id-display').show();
		}else{
			$('#company-id-display').hide();
		}
		if(customer_group[this.value]['company_id_required']==1){
			$('#company-id-required').show();
		}else{
			$('#company-id-required').hide();
		}
		if(customer_group[this.value]['tax_id_display']==1){
			$('#tax-id-display').show();
		}else{
			$('#tax-id-display').hide();
		}
		if(customer_group[this.value]['tax_id_required']==1){
			$('#tax-id-required').show();
		}else{
			$('#tax-id-required').hide();
		}	
	}
}).change();


</script>