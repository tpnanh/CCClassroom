<?php
	session_start();
	$user = $_SESSION['user'];
	$keyword = $_GET['KEY_WORD'];
	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");
	$emailUser = $user["email"];

	if ($user['role']==="Admin") {
		
		$query = "SELECT c.*, u.*
				FROM usercc u
				INNER JOIN class_of_user cof
				ON cof.email = u.email		
				AND (u.role = 'Teacher'
				OR u.role = 'Admin')
				INNER JOIN class c
				ON c.id_class = cof.id_class
				AND c.name_class LIKE '%$keyword%'
				OR c.subject LIKE '%$keyword%'
				OR c.room LIKE '%$keyword%'
				ORDER BY date_created desc";
	}else {
		$query = "SELECT c.*, u.*
				FROM usercc u
				INNER JOIN class_of_user cof
				ON cof.email = u.email
				AND u.email = '$emailUser'
				INNER JOIN class c
				ON c.id_class = cof.id_class
				AND c.name_class LIKE '%$keyword%'
				OR c.subject LIKE '%$keyword%'
				OR c.room LIKE '%$keyword%'
				ORDER BY date_created desc";
	}
	
	$result = $conn->query($query);
	$key_class = array();
	$data = array();
	while($row = mysqli_fetch_array($result)){ 
    
		if(in_array($row["id_class"], $key_class)){
			continue;
		}
    	$data[]= array('id_class' => $row["id_class"], 'name_class' => $row["name_class"], 'subject' => $row["subject"], 'room' => $row["room"], 'email' => $row["4"], 'date_created' => $row["date_created"], 'avatar' => $row["avatar_class"]);
    	$key_class[] = 	$row["id_class"];
    	//$data[] = $row;
	}
	//echo ($result);
	$conn->close();
	echo(json_encode($data));
?>