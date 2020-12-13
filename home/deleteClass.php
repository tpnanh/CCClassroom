<?php
	
	$id = $_POST["id"];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query = "DELETE FROM class WHERE id_class = $id";
	$result = $conn->query($query);

	if ($conn->query($query) === TRUE) {
		echo ("Delete class success");
		$conn->close();
		exit();
	}

?>