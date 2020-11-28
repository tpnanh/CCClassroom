<?php
	
	$id = $_POST["id"];

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "DELETE FROM class WHERE id_class = $id";
	$result = $conn->query($query);

	if ($conn->query($query) === TRUE) {
		echo ("Delete class success");
		$conn->close();
		exit();
	}

?>