<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 18:39
	 */
?>
</div>

<?php foreach (glob(ABSOLUTE_INCLUDES . "/js/*.js") as $file): ?>
	<script src="<?php echo URL_INCLUDES . "/js/" . basename($file); ?>"></script>
<?php endforeach; ?>
</body>
</html>
