<?php
	$idClass = $_POST["ID_CLASS"];
	$email = $_POST["EMAIL"];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

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