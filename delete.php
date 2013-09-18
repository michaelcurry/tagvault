<?php
	// Code Check
	if ( $_GET['code'] != $config['code'] )
	{
		echo 'False';
		return False;
	}

	// Rename File
	if ( file_exists('img_processed/'.$_GET['del']) )
	{
		rename('img_processed/'.$_GET['del'], 'img_deleted/'.$_GET['del']);
	}

	echo 'True';
	return True;