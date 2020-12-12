<?php
	session_start();
	$user = $_SESSION['user'];
	$email = $_POST['EMAIL'];
	$userName = $_POST['USER_NAME'];
	$fullName = $_POST['FULL_NAME'];
	$birth = $_POST['BIRTH'];
	$phone = $_POST['PHONE'];
	$avatar = $_POST['AVATAR'];


	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "update usercc set user_name = '$userName', ho_ten = '$fullName', birthday ='$birth', sdt='$phone', avatar='$avatar' where email like '$email'";

	if($conn->query($query)===false){

    	$error = $conn->error;
    	$conn->close();
    	die($error);
    }
	$conn->close();

	$user['user_name'] = $userName;
	$user['ho_ten'] = $fullName;
	$user['avatar'] = $avatar;
	$user['birthday'] = $birth;
	$user['sdt'] = $phone;
	$_SESSION['user'] = $user;
	echo("Update success");


?>