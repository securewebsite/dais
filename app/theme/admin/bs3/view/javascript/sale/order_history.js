<script>
<?php if ($error) { ?>
alertMessage('danger','<?= $error; ?>');
<?php } ?>
<?php if ($success) { ?>
alertMessage('success','<?= $success; ?>');
<?php } ?>
</script>