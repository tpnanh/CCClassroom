<?php
	session_start();
	$user = $_SESSION['user'];
	$content = $_POST['CONTENT'];
	$idMaterial = $_POST['MATERIAL'];
	$emailUser = $user['email'];
	$timeNow = gmdate("Y-m-d\TH:i:s\Z");

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query =  "insert into user_comment(id_user, time, content, id_material) values('$emailUser', '$timeNow', '$content', $idMaterial)";

	 if($conn->query($query)===false){

    	$error = $conn->error;
    	$conn->close();
    	die($error);
    }
	
	$conn->close();

	echo("Add comment success");

	
?>