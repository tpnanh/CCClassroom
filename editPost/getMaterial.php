<?php
	$idMaterial = $_GET['id'];
	$idClass = $_GET['idClass'];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query = "select * from material where id = $idMaterial and idClass = $idClass";

	$result = $conn->query($query);

	$conn->close();

	if($result->num_rows<=0){
    	die("Post/Assignment not found");
    } 
	$data = $result->fetch_assoc();
	

	echo(json_encode($data));


?>