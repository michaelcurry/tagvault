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
				<img src="/img_processed/<?php echo $entry->file ?>" />
			<?php endforeach; ?>
		</div>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
					$('#slideshow').cycle({
					fx: 'fade'
				});
			});

			// pusher
			var pusher = new Pusher('<?php echo $config['pusher.KEY'] ?>');
			var channel = pusher.subscribe('<?php echo $config['pusher.channel'] ?>');
			channel.bind('<?php echo strtolower(trim($_GET['tag'])) ?>', function(data) {
				var $element = $('<img class="img-responsive" src="/img_processed/'+data.file+'" />');
				$('#slideshow').prepend($element);
			});
		</script>
	</body>
</html>