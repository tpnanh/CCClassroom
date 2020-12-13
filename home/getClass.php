<?php
	session_start();
	$user = $_SESSION['user'];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");
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
				ORDER BY date_created desc";
	}else {
		$query = "SELECT c.*, u.*
				FROM usercc u
				INNER JOIN class_of_user cof
				ON cof.email = u.email
				AND u.email = '$emailUser'
				INNER JOIN class c
				ON c.id_class = cof.id_class
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