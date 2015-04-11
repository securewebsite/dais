<script>
var customer_group=[];
<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?= $customer_group['customer_group_id']; ?>]=[];
	customer_group[<?= $customer_group['customer_group_id']; ?>]['company_id_display']=<?= $customer_group['company_id_display']; ?>;
	customer_group[<?= $customer_group['customer_group_id']; ?>]['company_id_required']=<?= $customer_group['company_id_required']; ?>;
	customer_group[<?= $customer_group['customer_group_id']; ?>]['tax_id_display']=<?= $customer_group['tax_id_display']; ?>;
	customer_group[<?= $customer_group['customer_group_id']; ?>]['tax_id_required']=<?= $customer_group['tax_id_required']; ?>;
<?php } ?>

$('#payment-address select[name="customer_group_id"]').change();
</script>