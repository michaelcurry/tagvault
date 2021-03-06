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
			// If media is not image
			if (strripos($_POST['MediaContentType'.$i], 'image') === False)
			{
				continue;
			}

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
			$redis->set($file,'{"file":"'.$file.'","from":"'.$_POST['From'].'","country":"'.$_POST['FromCountry'].'","datetime":"'.date('F jS Y H:i:s e').'"}');
			$redis->lpush(strtolower(trim($_POST['Body'])),$file);
			$redis->lpush('TAGLIST',strtolower(trim($_POST['Body'])));

			// Pusher
			$pusher = new Pusher($config['pusher.KEY'], $config['pusher.SECRET'], $config['pusher.AppID']);
			$pusher->trigger($config['pusher.channel'], strtolower(trim($_POST['Body'])), array('file' => $file, 'country' => $_POST['FromCountry'], 'datetime' => date('F jS Y H:i:s e')) );

		}

		// Twilio
		$client = new Services_Twilio($config['twilio.sid'], $config['twilio.token']);
		$message = $client->account->sms_messages->create(
			$config['number'], // From a valid Twilio number
			$_POST['From'], // Text this number
			"Image(s) Added to <".strtolower(trim($_POST['Body']))."> TagVault Link: ".$config['url']."?tag=".strtolower(trim($_POST['Body']))
		);

		// return
		return TRUE;
	}
	else
	{
		if ( isset($_POST['From']) )
		{
			// Twilio
			$client = new Services_Twilio($config['twilio.sid'], $config['twilio.token']);
			$message = $client->account->sms_messages->create(
				$config['number'], // From a valid Twilio number
				$_POST['From'], // Text this number
				"MMS error. Please try sending your image again."
			);
		}

		// Respond with 400
		header('HTTP/1.1 400 Bad Request', true, 400);

		// return
		return False;
	}