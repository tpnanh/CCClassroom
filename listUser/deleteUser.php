<?php
	session_start();
	
	$email = $_POST["Email"];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query = "DELETE FROM usercc WHERE email like '$email'";
	$result = $conn->query($query);

	if ($conn->query($query) === TRUE) {
		echo ("Delete user success");
		$conn->close();
		exit();
	}

?>