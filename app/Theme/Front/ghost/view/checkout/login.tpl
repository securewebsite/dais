<div class="panel-body">
	<div class="row">
		<div class="col-sm-6">
			<fieldset>
				<legend><?= $lang_text_new_customer; ?></legend>
				<p><?= $lang_text_checkout; ?></p>
				<div class="radio radio-inline">
				<?php if ($account == 'register') { ?>
				<label><input type="radio" name="account" value="register" checked> <?= $lang_text_register; ?></label>
				<?php } else { ?>
				<label><input type="radio" name="account" value="register"> <?= $lang_text_register; ?></label>
				<?php } ?>
				</div>
				<?php if ($guest_checkout) { ?>
					<div class="radio radio-inline">
					<?php if ($account == 'guest') { ?>
					<label><input type="radio" name="account" value="guest" checked> <?= $lang_text_guest; ?></label>
					<?php } else { ?>
					<label><input type="radio" name="account" value="guest"> <?= $lang_text_guest; ?></label>
					<?php } ?>
					</div>
				<?php } ?>
				<hr>
				<p><?= $lang_text_register_account; ?></p>
				<button type="button" id="button-account" class="btn btn-primary"><?= $lang_button_continue; ?></button>
			</fieldset>
		</div>
		<div class="col-sm-6">
			<form id="form-login">
				<fieldset>
					<legend><?= $lang_text_returning_customer; ?></legend>
					<p><?= $lang_text_i_am_returning_customer; ?></p>
					<label><?= $lang_entry_user_email; ?></label>
					<div class="form-group">
						<input type="text" name="email" value="" class="form-control" placeholder="<?= $lang_entry_email; ?>" >
					</div>
					<label><?= $lang_entry_password; ?></label>
					<div class="form-group">
						<input type="password" name="password" value="" class="form-control" placeholder="<?= $lang_entry_password; ?>" >
						<div class="help-block"><a href="<?= $forgotten; ?>"><?= $lang_text_forgotten; ?></a></div>
					</div>
					<button type="button" id="button-login" class="btn btn-primary"><?= $lang_button_login; ?></button>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<?= $javascript; ?>