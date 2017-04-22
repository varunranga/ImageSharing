<?php

	$email_id = $_POST['login_email_id'];
	$password = hash('ripemd128', $_POST['login_password']);

	$cmd = "mongo --eval \"var email_id='$email_id'; var password='$password'\" db_user_login.js";

	exec($cmd, $output, $status);

	$json = mongoOutputToJSON($output, $status);

	if(isset($json->problem))
	{
		echo ("<script type='text/javascript'>alert('Email ID or Password is incorrect.')</script>");
		header('Location: index.html');
	}
	else
	{
		echo ("<script type='text/javascript'>alert('Succesfully logged in.')</script>");

		setcookie('user_id',$json->user_id);

//		header("Location: newsfeed.php");
	}

	function mongoOutputToJSON($output, $status)
    {
    	$new_json = "";

		if ($status) 
		{
			echo "Exec command failed";
		}		
		else
		{
			$i = 0;
			$jsonReached = 0; 
			foreach($output as $line)
			{
				if ($line[0] == "{")
					$i = 1;

				if ($i == 1)
					$new_json .= $line;
			}
		}

		$new_json = json_decode($new_json);

		switch (json_last_error()) {
	        case JSON_ERROR_NONE:
	        break;
	        case JSON_ERROR_DEPTH:
	            echo ' - Maximum stack depth exceeded';
	        break;
	        case JSON_ERROR_STATE_MISMATCH:
	            echo ' - Underflow or the modes mismatch';
	        break;
	        case JSON_ERROR_CTRL_CHAR:
	            echo ' - Unexpected control character found';
	        break;
	        case JSON_ERROR_SYNTAX:
	            echo ' - Syntax error, malformed JSON';
	        break;
	        case JSON_ERROR_UTF8:
	            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
	        break;
	        default:
	            echo ' - Unknown error';
	        break;
	    }

		return $new_json;
    }

?>