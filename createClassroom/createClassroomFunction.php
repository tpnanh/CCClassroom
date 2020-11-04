<?php
	session_start();
	$user = $_SESSION['user'];
	$className = $_POST['CLASS_NAME'];
	$subject = $_POST['SUBJECT'];
	$room = $_POST['ROOM'];
	$email = $user['email'];
	$avatar = $_FILES['avatar'];

	date_default_timezone_set("UTC");
	$date = date("Y-m-d H:i:sa");

	#20MB
	if ($avatar['size']>=20*1024*1024) {
		die("File so big");
	}

	$target_dir = "upload/";
	$nameFile = $avatar['name'];
	$target_file = $target_dir . basename($nameFile);
	// Select file type
  	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Convert to base64 
	$image_base64 = base64_encode(file_get_contents($avatar['tmp_name']) );	
	$image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "insert into class(name_class, subject, room, email, avatar_class, date_created) values('$className','$subject','$room','$email','$image','$date')";

	if($conn->query($query)===false){

    	$error = $conn->error;
    	$conn->close();
    	die($error);
    }
	$idClass = $conn->insert_id;
	$query = "insert into class_of_user values($idClass, '$email')";

	if($conn->query($query)===false){

    	$error = $conn->error;
    	$conn->close();
    	die($error);
    }
	$conn->close();

	echo("Insert success");


?>