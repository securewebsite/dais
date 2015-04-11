<h2><?= $lang_text_payment_info; ?></h2>
<table class="form">
	<tr>
		<td><?= $lang_entry_capture_status; ?>: </td>
		<td id="capture-status">
			<?php if ($complete) { ?>
				<?= $lang_text_complete ?>
			<?php } else { ?>
				<?= $lang_text_incomplete ?>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td><?= $lang_entry_capture ?></td>
		<td id="complete-entry">
			<?php if ($complete) { ?>
				-
			<?php } else { ?>
				<?= $lang_entry_complete_capture ?> <input type="checkbox" name="capture-complete" value="1"><br>
				<input type="text" name="capture-amount" value="0.00" class="form-control">
				<a class="btn btn-default" id="button-capture" onclick="capture()"><?= $lang_button_capture ?></a>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td><?= $lang_entry_void ?></td>
		<td id="reauthorise-entry">
			<?php if ($complete) { ?>
				-
			<?php } else { ?>
				<a class="btn btn-default" id="button-void" onclick="doVoid()"><?= $lang_button_void ?></a>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td><?= $lang_entry_transactions ?></td>
		<td>
			<table class="table table-bordered" id="transaction-table">
				<thead>
					<tr>
						<td><?= $lang_column_transaction_id ?></td>
						<td><?= $lang_column_transaction_type ?></td>
						<td><?= $lang_column_amount ?></td>
						<td><?= $lang_column_time ?></td>
						<td><?= $lang_column_actions ?></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($transactions as $transaction) { ?>
						<tr>
							<td><?= $transaction['transaction_reference'] ?></td>
							<td><?= $transaction['transaction_type'] ?></td>
							<td><?= number_format($transaction['amount'], 2) ?></td>
							<td><?= $transaction['time'] ?></td>
							<td>
								<?php foreach ($transaction['actions'] as $action) { ?>
								[<a href="<?= $action['href'] ?>"><?= $action['title'] ?></a>]
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</td>
	</tr>
</table>
<?= $javascript; ?>