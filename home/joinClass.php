<?php
	session_start();
	$user = $_SESSION['user'];
	$idClass = $_POST['ID'];


	$emailUser = $user["email"];
	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");
	$query =  "select * from class where id_class = $idClass";

	$result = $conn->query($query);

	if ($result->num_rows <= 0) {
		die("ID Class is not available");
	}

	$query = "select * from class_of_user where id_class = $idClass and email = '$emailUser'";

	$result = $conn->query($query);

	if ($result->num_rows > 0) {
		die("You has join this class");
	}

	$query = "insert into class_of_user values($idClass, '$emailUser')";

	if($conn->query($query)===false){

    	$error = $conn->error;
    	$conn->close();
    	die($error);
    }
	$conn->close();

	echo("Join success");

	
?>