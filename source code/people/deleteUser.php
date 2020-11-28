<?php
	$idClass = $_POST["ID_CLASS"];
	$email = $_POST["EMAIL"];

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "DELETE FROM class_of_user WHERE id_class=$idClass and email='$email'";
	$result = $conn->query($query);

	if ($conn->query($query) === TRUE) {
		echo ("Delete user success");
		$conn->close();
		exit();
	}else{
		echo ("Error delete 1");
	}

?>