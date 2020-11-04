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

	$data = array();
	while($row = mysqli_fetch_array($result)){ 

    	// $data[] = array('email' => $row[0], 'user_name' => $row[1], 'password' => $row[2],'ho_ten' => $row[3],'birthday' => $row[4],'sdt' => $row[5],'role' => $row[6],'avatar' => $row[7]);
    	$data[]= array('id_class' => $row["id_class"], 'name_class' => $row["name_class"], 'subject' => $row["subject"], 'room' => $row["room"], 'name_class' => $row["name_class"], 'email' => $row["4"], 'date_created' => $row["date_created"], 'avatar' => $row["avatar_class"]);	
    	// $data[] = $row;
	}
	$conn->close();
	echo(json_encode($data));
?>