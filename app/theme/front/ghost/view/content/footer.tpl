	</div>	
	<div id="push"></div>
</div>
<footer>
	<div class="container">
		<div class="row">
			<?= $footer_blocks; ?>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<p class="text-center"><?= $powered; ?></p>
			</div>
		</div>
	</div>
</footer>
<div id="notification"></div>
<script> var route = '<?= $route; ?>'; </script>
<script src="<?= $js_link; ?>"></script>
<?= $javascript; ?>

<?= $google_analytics; ?>

</body></html>