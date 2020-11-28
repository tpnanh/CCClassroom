<?php
	$idClass = $_POST["ID_CLASS"];
	$idMaterial = $_POST["ID_MATERIAL"];

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "DELETE FROM material WHERE idClass=$idClass and id=$idMaterial";
	$result = $conn->query($query);

	if ($conn->query($query) === TRUE) {
		echo ("Delete material success");
		$conn->close();
		exit();
	}

?>