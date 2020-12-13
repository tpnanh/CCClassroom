<?php
	$idClass = $_POST["ID_CLASS"];
	$idMaterial = $_POST["ID_MATERIAL"];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query = "DELETE FROM material WHERE idClass=$idClass and id=$idMaterial";
	$result = $conn->query($query);

	if ($conn->query($query) === TRUE) {
		echo ("Delete material success");
		$conn->close();
		exit();
	}

?>