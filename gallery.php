<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TagVault - <?php echo $_GET['tag'] ?></title>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
		<link href="./inc/css/style.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script src="./inc/js/masonry.pkgd.min.js"></script>
	</head>
	<body>
		<div class="credits">
			<a href="https://twitter.com/intent/tweet?screen_name=KernelCurry" class="twitter-mention-button">Tweet author @KernelCurry</a>
			<br />
			<a href="https://twitter.com/share" class="twitter-share-button" data-text="Check out this cool MMS BBS @KernelCurry created!" data-hashtags="TagVault">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</div>
		<a href="https://github.com/michaelcurry/tagvault"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png" alt="Fork me on GitHub"></a>
		<div class="container text-center">
			<h1 class="tag">&lt;<?php echo $_GET['tag']; ?>&gt;</h1>
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<form action="/" method="GET">
						<div class="input-group">
							<input type="text" class="form-control" name="tag" placeholder="Tag Name">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit">Go</button>
							</span>
						</div>
					</form>
				</div>
			</div>
			<div class="row ">
				<div class="col-xs-12 text-center">
					<div id="mason" class="js-masonry">
					<?php $redis = new Predis\Client(); ?>
					<?php foreach(array_unique($redis->lrange(strtolower(trim($_GET['tag'])), 0, -1))  as $entry) : ?>
						<?php $entry = $redis->get($entry); ?>
						<?php $entry = json_decode($entry); ?>
						<div class="image one-edge-shadow">
							<a href="/img_processed/<?php echo $entry->file ?>" title="<?php echo $entry->datetime ?>" >
								<img class="img-responsive" src="/img_processed/<?php echo $entry->file ?>" />
							</a>
							<p class="place"><?php echo $entry->country?></p>
							<p class="time"><?php echo $entry->datetime?></p>
						</div>
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