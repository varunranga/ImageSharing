<?php

	$cmd = "mongo --eval \"db = connect('127.0.0.1:27017/CCBD_GLOBAL'); var arr = db.CCBD_GLOBAL.find().toArray()[0]; printjson(arr)\"";

	exec($cmd, $output, $status);

	$json = mongoOutputToJSON($output, $status);

	$post_id = "PST".($json->post_count + 1);

	$user_id = $_COOKIE['user_id'];
	$description = $_POST['description'];

	$target_dir = "post_pictures/";
	$target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$target_file = "post_pictures/".$post_id.".".$imageFileType;
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}

	$post_picture = $target_file;

	$cmd = "mongo --eval \"var user_id='$user_id'; var post_id='$post_id'; var description='$description' ; var post_picture='$post_picture'\" db_insert_post.js";

	exec($cmd, $output, $status);

	echo ('<br><br><a href="my_profile.html">Click here to go back!</a>');

//	header('Location: newsfeed.php');

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