<?php

	$cmd = "mongo --eval \"db = connect('127.0.0.1:27017/CCBD_USER'); var arr = db.CCBD_USER.find().toArray()[0]; printjson(arr)\"";

	exec($cmd, $output, $status);

	$json = mongoOutputToJSON($output, $status);

    function mongoOutputToJSON($output, $status)
    {
    	$json = "{\n";

		if ($status) echo "Exec command failed";
		else
		{
			$i = 0; 
			foreach($output as $line) 
				if ($i++ > 6) 
				{	
					$json .= "$line\n"; 
				}
		}

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

		return json_decode($json);
    }

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<script type="text/javascript">
		var json = <?php echo json_encode($json); ?>;
		document.write(JSON.stringify(json))
	</script>
</body>
</html>
