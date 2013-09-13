<?php

	// If request is a POST form Twilio (MMS)
	if ($_REQUEST && isset($_REQUEST['Body']) && isset($_REQUEST['MediaContentTypes']) && strpos($_REQUEST['MediaContentTypes'], 'image') !== false )
	{
		include_once('post.php');
	} // If request is for a tag && requests a slide-show
	elseif ($_REQUEST && isset($_REQUEST['tag']) && isset($_REQUEST['slide']) && file_exists('bin/'.$_REQUEST['tag'].'.csv'))
	{
		include_once('slide.php');
	} // If request is for a tag
	elseif ($_REQUEST && isset($_REQUEST['tag']) && file_exists('bin/'.$_REQUEST['tag'].'.csv'))
	{
		include_once('gallery.php');
	}// Reques Fall back ( We don't want random people to get in! )
	else
	{
		include_once('fallback.php');
	}