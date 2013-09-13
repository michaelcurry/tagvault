<html>
	<head>
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
		<link href="./inc/style.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
		<script src="./inc/masonry.pkgd.min.js"></script>
		<script type="text/javascript" src="lightbox.js"></script>
	</head>
	<body>
		<div class="container" >
			<div class="row-fluid">
				<div class="span12">
				<h1>Tag: <i><?php echo $_REQUEST['tag']; ?></i></h1>
				<div id="container" class="js-masonry">
					<?php $mms = str_getcsv(file_get_contents('bin/'.strtolower($_REQUEST['tag']).'.csv'),'|');?>
					<?php foreach (array_reverse($mms) as $message) : ?>
						<?php if ($message) : ?>
							<?php $m = json_decode($message); ?>
							<div class="image">
								<a href="<?php echo $m->img ?>" rel="lightbox" title="<?php echo $m->time?>" >
									<img src="<?php echo $m->img ?>" />
								</a>
								<p class="place"><?php echo $m->place?></p>
								<p class="time"><?php echo $m->time?></p>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				var $container = $('#container');
				setTimeout(function() {
					$container.masonry({
						itemSelector: '.image'
					});
				}, 500)
			});
		</script>
	</body>
</html>