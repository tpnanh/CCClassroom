<?php
	$idPost = $_GET['ID_POST'];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query = "select * from material where id = $idPost";

	$result = $conn->query($query);

	$conn->close();

	if($result->num_rows<=0){
    	die("Post/Assignment not found");
    } 
	$data = $result->fetch_assoc();
	

	echo(json_encode($data));
?>