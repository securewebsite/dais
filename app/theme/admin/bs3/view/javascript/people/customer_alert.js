<script>
<?php if ($error_warning) { ?>
alertMessage('danger','<?= $error_warning; ?>');
<?php } ?>
<?php if ($success) { ?>
alertMessage('success','<?= $success; ?>');
<?php } ?>
</script>