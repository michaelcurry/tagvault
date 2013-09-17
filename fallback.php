<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TagVault</title>
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
			<img class="logo img-responsive" src="./inc/img/logo.png" />
			<p class="intro" >Text <span><?php echo $config['number'] ?></span> a picture with the name of a tag.  Your image will be displayed on that tag.</p>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<form action="/" method="GET">
						<div class="input-group">
							<input type="text" class="form-control" name="tag" placeholder="Tag Name">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit">Go</button>
							</span>
						</div>
					</form>
					<?php $redis = new Predis\Client(); ?>
					<p class="stats">Number of Tags: <?php echo count(array_unique($redis->lrange('TAGLIST',0,-1))); ?></p>
					<p class="stats">Number of Images: <?php echo $redis->llen('TAGLIST'); ?></p>
				</div>
			</div>
			<img class="sponsor img-responsive" src="./inc/img/twilio.png" />
		</div>
	</body>
</html>