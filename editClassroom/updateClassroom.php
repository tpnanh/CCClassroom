<?php
	$id = $_POST['id'];
	$className = $_POST['CLASS_NAME'];
	$subject = $_POST['SUBJECT'];
	$room = $_POST['ROOM'];
	$avatar = $_POST['avatar'];


	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "update class set name_class = '$className', subject = '$subject', room ='$room', avatar_class='$avatar' where id_class like $id";

	if($conn->query($query)===false){

    	$error = $conn->error;
    	$conn->close();
    	die($error);
    }
	$conn->close();

	echo("Update success");


?>