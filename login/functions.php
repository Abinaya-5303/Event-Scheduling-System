<?php

function check_login($con)
{
	if(isset($_SESSION['user_id']))
	{
		return true; // Session is active
	}

	// Redirect to login
	header("Location: login.php");
	die;
}

function random_num($length)
{
	$text = "";
	if($length < 5)
	{
		$length = 5;
	}

	$len = rand(4,$length);

	for ($i = 0; $i < $len; $i++) { 
		$text .= rand(0, 9);
	}

	return $text;
}
?>
