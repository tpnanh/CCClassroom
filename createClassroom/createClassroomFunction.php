<?php
	session_start();
	$user = $_SESSION['user'];
	$className = $_POST['CLASS_NAME'];
	$subject = $_POST['SUBJECT'];
	$room = $_POST['SUBJECT'];
	$email = $user['email'];

	date_default_timezone_set("UTC");
	$date = date("Y-m-d H:i:sa");
	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "insert into class(name_class, subject, room, email, date_created) values('$className','$subject','$room','$email','$date')";

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