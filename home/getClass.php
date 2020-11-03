<?php
	session_start();
	$user = $_SESSION['user'];

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");
	$emailUser = $user["email"];

// 	SELECT p.*, f.*
// FROM person p
// INNER JOIN person_fruit pf
// ON pf.person_id = p.id
// INNER JOIN fruits f
// ON f.fruit_name = pf.fruit_name
	if ($user['role']==="Admin") {
		SELECT c.*, usercc.*
		FROM class usercc
		INNER JOIN class pf
		ON pf.person_id = p.id
		INNER JOIN fruits f
		ON f.fruit_name = pf.fruit_name
		$query = "select * from usercc where email!= '$emailUser' ORDER BY FIELD(role,'Admin', 'Teacher', 'Student'),ho_ten";
	}else if ($user['role'] === "Teacher"){

	}else{

	}
	
	$result = $conn->query($query);

	$data = array();
	while($row = mysqli_fetch_array($result)){ 

    	$data[] = array('email' => $row[0], 'user_name' => $row[1], 'password' => $row[2],'ho_ten' => $row[3],'birthday' => $row[4],'sdt' => $row[5],'role' => $row[6],'avatar' => $row[7]);
	}
	$conn->close();
	echo(json_encode($data));
?>