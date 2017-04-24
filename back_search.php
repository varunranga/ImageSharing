<?php

	$search = $_GET['search'];

	$arr = explode(' ', $search);

	$first_name = '';
	$last_name = '';
	
	if (isset($arr[0])
		$first_name = $arr[0];	

	if (isset($arr[1]))
		$last_name = $arr[1];

	$cmd = "mongo --eval \"var first_name='$first_name'; var last_name='$last_name'\" db_search.js";

	echo "$cmd";

	exec($cmd, $output, $status);

	$json = mongoOutputToJSON($output, $status);

	function mongoOutputToJSON($output, $status)
    {
  		$json = "";

		if ($status) echo "Exec command failed";
		else
		{
			$i = 0; 
			foreach($output as $line) 
			{	
				if ($line[0] == "{")
					$i = 1;
				
				if ($line[0] == "[")
					$i = 1;
				
				if ($i == 1) 
				{	
					$json .= "$line"; 
				}
			}
		}

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

    echo json_encode($json);
?>
