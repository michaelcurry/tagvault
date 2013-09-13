<?php
	/**
	 * this file handles Twilio MMS posts
	 */

	if ( isset($_POST['NumMedia']) )
	{

		return TRUE;
	}
	else
	{
		http_response_code('400');
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