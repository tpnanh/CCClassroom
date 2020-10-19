<?php
	session_start();
	$mail = $_POST['email'];
	$pass = md5($_POST['password']);

	
	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "select * from usercc where email='$mail'";

	$result = $conn->query($query);

	$conn->close();
    if($result->num_rows<=0){
    	die("User not found");
    }
    $data = $result->fetch_assoc();

    if($pass!==$data['password']){
    	die("Password wrong");
    }
    $_SESSION['user'] = $data;
	echo("Login success");

?>