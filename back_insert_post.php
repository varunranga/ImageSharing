<?php

	$cmd = "mongo --eval \"db = connect('127.0.0.1:27017/CCBD_GLOBAL'); var arr = db.CCBD_GLOBAL.find().toArray()[0]; printjson(arr)\"";

	exec($cmd, $output, $status);

	$json = mongoOutputToJSON($output, $status);

	$post_id = "PST".($json->post_count + 1);

	$user_id = $_COOKIE['user_id'];
	$description = $_POST['description'];
	$post_picture = "";

	if(isset($_FILES['post_picture']))
	{
    	$errors = array();
      	$file_name = $_FILES['post_picture']['name'];
      	$file_size = $_FILES['post_picture']['size'];
      	$file_tmp = $_FILES['post_picture']['tmp_name'];
      	$file_type = $_FILES['post_picture']['type'];
		$tmp = explode('.', $file_name);
		$file_ext = end($tmp);      
      	$expensions = array("jpeg","jpg","png");
      
      	if(in_array($file_ext,$expensions) === false)
      	{
         	$errors[]="extension not allowed, please choose a JPEG or PNG file.";
      	}
      
      	if($file_size > 2097152)
      	{
        	$errors[]='File size must be lesser than 2 MB';
      	}
      
      	if(empty($errors) == true)
      	{
      		$post_picture = "/opt/lampp/htdocs/CCBD/Task 1/post_picture/".$user_id.".".$file_ext;

         	$status = move_uploaded_file($file_tmp,$post_picture);
#         	echo "Success<br>";
      	}
      	else
      	{
#  			echo "Hello, world";
        	print_r($errors);
      	}

      	if ($status == false)
      	{
#      		echo "Did not work<br>";
      	}
   	}

	$cmd = "mongo --eval \"var user_id='$user_id'; var post_id='$post_id'; var description='$description' ; var post_picture='$post_picture'\" db_insert_post.js";

	exec($cmd, $output, $status);

	header('Location: newsfeed.php');

	function mongoOutputToJSON($output, $status)
    {
    	$json = "{\n";

		if ($status) 
		{
			echo "Exec command failed";
		}		
		else
		{
			$i = 0; 
			foreach($output as $line) 
				if ($i++ > 6) 
				{	
					$json .= "$line\n"; 
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

?>