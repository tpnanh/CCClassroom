<?php
	session_start();
	
	$email = $_POST["Email"];

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "DELETE FROM usercc WHERE email like '$email'";
	$result = $conn->query($query);

	if ($conn->query($query) === TRUE) {
		echo ("Delete user success");
		$conn->close();
		exit();
	}

?>