<?php

	// If request is a POST form Twilio (MMS)
	if ($_REQUEST && isset($_REQUEST['Body']) && isset($_REQUEST['MediaContentTypes']) && strpos($_REQUEST['MediaContentTypes'], 'image') !== false ){

		// For each image sent
		foreach($_REQUEST['MediaUrls'] as $image) {

			// Save image locally on server
			$file = 'img/'.sha1(md5($image)).'.jpg';
			file_put_contents($file, file_get_contents($image));

			// Save image information in csv database
			file_put_contents('bin/'.strtolower($_REQUEST['Body']).'.csv', '{"img":"'.$file.'","place":"'.$_REQUEST['FromCity'].', '.$_REQUEST['FromState'].'","time":"'.date('F jS Y h:i:s A').'"}|', FILE_APPEND);

		}

	// If request is for a tag && requests a slide-show
	}elseif ($_REQUEST && isset($_REQUEST['tag']) && isset($_REQUEST['slide']) && file_exists('bin/'.$_REQUEST['tag'].'.csv')) {

?>

<html>
	<head>
		<link href="./inc/style2.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="cycle.js"></script>
	</head>
	<body>
		<div id="slideshow" >
			<?php $mms = str_getcsv(file_get_contents('bin/'.strtolower($_REQUEST['tag']).'.csv'),'|');?>
			<?php foreach (array_reverse($mms) as $message) : ?>
				<?php if ($message) : ?>
					<?php $m = json_decode($message); ?>
					<img src="<?php echo $m->img ?>" />
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
	</body>
</html>

<?php

	// If request is for a tag
	}elseif ($_REQUEST && isset($_REQUEST['tag']) && file_exists('bin/'.$_REQUEST['tag'].'.csv')) {

?>

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

<?php
	// Reques Fall back ( We don't want random people to get in! )
	}else {
		echo 'NOPE';
	}