<?php
	/**
	 * Routing file
	 */

	if (file_exists('vendor/autoload.php'))
	{
		include_once('vendor/autoload.php');
	}
	else
	{
		echo "Composer Install";
		die();
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
		else // Fallback
		{
			include_once('fallback.php');
		}
	}