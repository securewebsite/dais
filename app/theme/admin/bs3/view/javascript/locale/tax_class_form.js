<script>
function addRule(){
	html = '<tr id="tax-rule-row'+tax_rule_row+'">';
	html += '<td><select name="tax_rule['+tax_rule_row+'][tax_rate_id]" class="form-control">';
	<?php foreach ($tax_rates as $tax_rate) { ?>
	html += '<option value="<?= $tax_rate['tax_rate_id']; ?>"><?= addslashes($tax_rate['name']); ?></option>';
	<?php } ?>
	html += '</select></td>';
	html += '<td><select name="tax_rule['+tax_rule_row+'][based]" class="form-control">';
	html += '<option value="shipping"><?= $lang_text_shipping; ?></option>';
	html += '<option value="payment"><?= $lang_text_payment; ?></option>';
	html += '<option value="store"><?= $lang_text_store; ?></option>';
	html += '</select></td>';
	html += '<td><input type="text" name="tax_rule['+tax_rule_row+'][priority]" value="" class="form-control"></td>';
	html += '<td><a onclick="$(\'#tax-rule-row'+tax_rule_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#tax-rule > tbody').append(html);
	
	tax_rule_row++;
}
</script>