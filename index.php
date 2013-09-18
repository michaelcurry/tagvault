<?php
	/**
	 * Routing file
	 */

	// Include config
	include_once('config.php');

	// Check for composer installed
	if (file_exists('vendor/autoload.php'))
	{
		include_once('vendor/autoload.php');
	}
	else
	{
		// Display error
		echo '{"error":"Composer Install"}';

		// Respond with 500
		header('HTTP/1.1 500 Internal Server Error', true, 500);

		// return
		return False;
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST') // If request is a POST
	{
		include_once('post.php');
	}
	else // If request is a GET
	{
		if ( isset($_GET['tag']) ) // If tag is requested
		{
			if ( isset($_REQUEST['slide']) ) // If slide-show is requested
			{
				include_once('slide.php');
			}
			else // Gallery
			{
				include_once('gallery.php');
			}
		}
		elseif ( isset($_GET['del']) && isset($_GET['code']) )
		{
			include_once('delete.php');
		}
		else // Fallback
		{
			include_once('fallback.php');
		}
	}