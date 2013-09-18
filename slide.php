<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TagVault - <?php echo $_GET['tag'] ?></title>
		<link href="./inc/css/style2.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="./inc/js/cycle.js"></script>
	</head>
	<body>
		<div id="slideshow" >
			<?php $redis = new Predis\Client(); ?>
			<?php foreach(array_unique($redis->lrange(strtolower(trim($_GET['tag'])), 0, -1))  as $entry) : ?>
				<?php $entry = $redis->get($entry); ?>
				<?php $entry = json_decode($entry); ?>
				<?php if (file_exists('img_processed/'.$entry->file)) : ?>
					<img src="/img_processed/<?php echo $entry->file ?>" />
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
					$('#slideshow').cycle({
					fx: 'fade'
				});
			});
		</script>
		<?php echo $config['analytics'] ?>
	</body>
</html>