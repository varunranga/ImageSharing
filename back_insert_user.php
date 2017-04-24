<?php
	
	$cmd = "mongo --eval \"db = connect('127.0.0.1:27017/CCBD_GLOBAL'); var arr = db.CCBD_GLOBAL.find({},{'_id':0}).toArray()[0]; printjson(arr)\"";

	exec($cmd, $output, $status);
	
	$json = mongoOutputToJSON($output, $status);

	$user_id = "USR".($json->user_count + 1);

//	print_r($_POST);

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email_id = $_POST['email_id'];
	$phone_number = $_POST['phone_number'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$country = $_POST['country'];
	$password = hash('ripemd128', $_POST['password']);

	$target_dir = "profile_pictures/";
	$target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$target_file = "profile_pictures/".$user_id.".".$imageFileType;
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

	$profile_picture = $target_file;


	$cmd = "mongo --eval \"var user_id='$user_id'; var first_name='$first_name'; var last_name='$last_name'; var email_id='$email_id'; var phone_number='$phone_number'; var city='$city'; var state='$state'; var country='$country'; var password='$password'; var profile_picture='$profile_picture'\" db_insert_user.js";

	exec($cmd, $output, $status);

	echo ('<br><br><a href="index.html">Click here to go back!</a>');

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
				
				if ($line[0] == "[")
					$i = 1;
				
				if ($i == 1) 
				{	
					$new_json .= "$line\n"; 
				}
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
