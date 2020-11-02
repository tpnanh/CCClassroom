<?php
	session_start();
	$user = $_SESSION['user'];

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");
	$emailUser = $user["email"];
	$query = "select * from usercc where email!= '$emailUser' ORDER BY FIELD(role,'Admin', 'Teacher', 'Student'),ho_ten";
	$result = $conn->query($query);

	$data = array();
	while($row = mysqli_fetch_array($result)){ 

    	$data[] = array('email' => $row[0], 'user_name' => $row[1], 'password' => $row[2],'ho_ten' => $row[3],'birthday' => $row[4],'sdt' => $row[5],'role' => $row[6],'avatar' => $row[7]);
	}
	$conn->close();
	echo(json_encode($data));
?>