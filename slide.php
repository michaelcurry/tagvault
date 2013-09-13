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