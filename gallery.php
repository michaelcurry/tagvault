<!doctype html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
		<link href="./inc/style.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script src="./inc/masonry.pkgd.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h1>Tag: <i><?php echo $_GET['tag']; ?></i></h1>
					<div id="mason" class="js-masonry">
					<?php $redis = new Predis\Client(); ?>
					<?php foreach($redis->lrange(strtolower(trim($_GET['tag'])), 0, -1)  as $entry) : ?>
						<?php var_dump($entry); ?>
					<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				var $container = $('#mason');
				setTimeout(function() {
					$container.masonry({
						itemSelector: '.image'
					});
				}, 500)
			});
		</script>
	</body>
</html>

<?php /*
<?php $mms = str_getcsv(file_get_contents('bin/'.strtolower($_REQUEST['tag']).'.csv'),'|');?>
					<?php foreach (array_reverse($mms) as $message) : ?>
						<?php if ($message) : ?>
							<?php $m = json_decode($message); ?>
							<div class="image">
								<a href="<?php echo $m->img ?>" title="<?php echo $m->time?>" >
									<img src="<?php echo $m->img ?>" />
								</a>
								<p class="place"><?php echo $m->place?></p>
								<p class="time"><?php echo $m->time?></p>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
*/