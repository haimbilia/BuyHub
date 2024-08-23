<?php if (!empty($errors)) { ?>
	<script type="text/javascript">
		close();
		window.opener.twitter_error('<?php echo $errors; ?>');
	</script>
<?php } else { ?>
	<script type="text/javascript">
		close();
		window.opener.twitter_shared();
		opener.location.reload();
	</script>
<?php
}
