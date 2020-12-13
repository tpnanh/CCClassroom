<?php
	session_start();
	$user = $_SESSION['user'];
	$oldPass = md5($_POST['OLD_PASS']);
	$pass = md5($_POST['PASS']);
	$email = $user['email'];

	if ($oldPass != $user['password']) {
		die('Old pass is wrong');
	}

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query = "update usercc set password = '$pass' where email like '$email'";

	if($conn->query($query)===false){

    	$error = $conn->error;
    	$conn->close();
    	die($error);
    }
	$conn->close();

	$user['password'] = $pass;
	$_SESSION['user'] = $user;
	echo("Update success");


?>