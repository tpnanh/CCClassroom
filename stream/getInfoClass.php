<?php
	$id = $_GET['id'];

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "select * from class where id_class = $id";

	$result = $conn->query($query);

	$conn->close();

	if($result->num_rows<=0){
    	die("Classroom not found");
    } 
	$data = $result->fetch_assoc();
	

	echo(json_encode($data));


?>