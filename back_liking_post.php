<?php

	$post_id = $_GET['post_id'];
	$user_id = $_GET['user_id'];

	$cmd = "mongo --eval \"var post_id='$post_id'; var user_id='$user_id'\" db_liking_post.js";

#	echo "$cmd";

	exec($cmd, $output, $status);

	header('Location: newsfeed.php');

	function mongoOutputToJSON($output, $status)
    {
    	$json = "";

		if ($status) 
		{
			echo "Exec command failed";
		}		
		else
		{
			$i = 0; 
			foreach($output as $line) 
			{	
				if ($i++ > 4) 
				{	
					$json .= "$line\n"; 
				}
			}
		}

		echo "$json";

		$json = json_decode($json);

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

		return $json;
    }

?>