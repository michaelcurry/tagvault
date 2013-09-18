<?php
	// Code Check
	if ( $_GET['code'] != $config['code'] )
	{
		return False;
	}

	// Rename File
	if ( file_exists('img_processed/'.$_GET['del']) )
	{
		move_uploaded_file('img_processed/.'.$_GET['del'], 'img_deleted/.'.$_GET['del']);
	}

	return True;