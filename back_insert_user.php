<?php
	
	$cmd = "mongo --eval \"db = connect('127.0.0.1:27017/CCBD_GLOBAL'); var arr = db.CCBD_GLOBAL.find({},{'_id':0}).toArray()[0]; printjson(arr)\"";

	exec($cmd, $output, $status);
	
	$json = mongoOutputToJSON($output, $status);

	$user_id = "USR".($json->user_count + 1);

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email_id = $_POST['email_id'];
	$phone_number = $_POST['phone_number'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$country = $_POST['country'];
	$password = hash('ripemd128', $_POST['password']);
	$profile_picture = "";

	if(isset($_FILES['profile_picture']))
	{
    	$errors = array();
      	$file_name = $_FILES['profile_picture']['name'];
      	$file_size = $_FILES['profile_picture']['size'];
      	$file_tmp = $_FILES['profile_picture']['tmp_name'];
      	$file_type = $_FILES['profile_picture']['type'];
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
      		$profile_picture = "/opt/lampp/htdocs/CCBD/Task 1/profile_pictures/".$user_id.".".$file_ext;

         	$status = move_uploaded_file($file_tmp,$profile_picture);
#         	echo "Success<br>";
      	}
      	else
      	{
#  			echo "Hello, world";
 #       	print_r($errors);
      	}

      	if ($status == false)
      	{
#      		echo "Did not work<br>";
      	}
   	}

	$cmd = "mongo --eval \"var user_id='$user_id'; var first_name='$first_name'; var last_name='$last_name'; var email_id='$email_id'; var phone_number='$phone_number'; var city='$city'; var state='$state'; var country='$country'; var password='$password'; var profile_picture='$profile_picture'\" db_insert_user.js";

	exec($cmd, $output, $status);

	header('Location: index.html');

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
				if ($i++ > 4) 
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