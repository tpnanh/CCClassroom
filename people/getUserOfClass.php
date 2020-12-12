<?php
	session_start();
	$id = $_GET['id'];
	$user = $_SESSION['user'];
	$emailUser = $user['email'];

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "SELECT c.*, u.*
				FROM usercc u
				INNER JOIN class_of_user cof
				ON cof.email = u.email
				AND u.email != '$emailUser'
				INNER JOIN class c
				ON c.id_class = cof.id_class
				AND c.id_class = '$id'
				ORDER BY FIELD(u.role,'Admin', 'Teacher', 'Student'),cof.email";

	//$query = "select * from class_of_user where id_class = $id and email != '$emailUser'";

	$result = $conn->query($query);

	$data = array();
	while($row = mysqli_fetch_array($result)){
    	$data[] = array('id_class' => $row[0], 'emailPeople'=> $row[7], 'emailUserOfClass'=>$row[4],'img' => $row[14] );
	}
	$conn->close();
	

	echo(json_encode($data));
?>