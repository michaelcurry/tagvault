<?php
	/**
	 * this file handles Twilio MMS posts
	 */

	if ( isset($_POST['NumMedia']) && $_POST['NumMedia'] > 0 )
	{
		for ($i = 0; $i < $_POST['NumMedia']; $i++)
		{
			echo $i;
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