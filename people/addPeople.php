<?php
	$emailUser = $_POST['EMAIL'];
	$idClass = $_POST['ID'];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query =  "select * from usercc where email = '$emailUser'";

	$result = $conn->query($query);

	if ($result->num_rows <= 0) {
		die("User not exist");
	}

	$query = "select * from class_of_user where id_class = $idClass and email = '$emailUser'";

	$result = $conn->query($query);

	if ($result->num_rows > 0) {
		die("User has join this class");
	}

	$query = "insert into class_of_user values($idClass, '$emailUser')";

	if($conn->query($query)===false){

    	$error = $conn->error;
    	$conn->close();
    	die($error);
    }
	$conn->close();

	echo("Add success");

	
?>