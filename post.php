<?php

	use Gregwar\Image\Image;

	/**
	 * this file handles Twilio MMS posts
	 */

	if ( isset($_POST['NumMedia']) && $_POST['NumMedia'] > 0 )
	{
		// Image logic
		for ($i = 0; $i < $_POST['NumMedia']; $i++)
		{
			// Set file name
			$file = sha1($_POST['MediaUrl'.$i]).'.jpg';

			// Save Original File
			file_put_contents('img_original/'.$file, file_get_contents($_POST['MediaUrl'.$i]));
			// file_put_contents('img_original/'.$file, file_get_contents('http://placehold.it/'.rand(1000,6000).'x'.rand(1000,6000)));
			chmod ('img_original/'.$file, $config['chmod']);

			// Edit image
			Image::open('img_original/'.$file)
				->cropResize($config['width'], $config['height'])
				->save('img_processed/'.$file);
			chmod ('img_processed/'.$file, $config['chmod']);

			// Remove Original Image
			if ($config['removeOriginal'] == True)
			{
				unlink('img_original/'.$file);
			}

			// Log in redis
			$redis = new Predis\Client();
			$redis->set($file,'{"file":"'.$file.'","from":"'.$_POST['From'].'","country":"'.$_POST['FromCountry'].'","datetime":"'.date('F jS Y h:i:s A').'"}');
			$redis->lpush(strtolower(trim($_POST['Body'])),$file);
		}

		// return
		return TRUE;
	}
	else
	{
		// Respond with 400
		header('HTTP/1.1 400 Bad Request', true, 400);

		// return
		return False;
	}

	/*
	// for each image sent
	foreach($_REQUEST['NumMedia'] as $image)
	{
		// save image locally on server
		$file = 'img/'.sha1(md5($image)).'.jpg';
		file_put_contents($file, file_get_contents($image));

		// save image information in csv database
		file_put_contents('bin/'.strtolower($_REQUEST['Body']).'.csv', '{"img":"'.$file.'","place":"'.$_REQUEST['FromCity'].', '.$_REQUEST['FromState'].'","time":"'.date('F jS Y h:i:s A').'"}|', FILE_APPEND);
	}
	*/