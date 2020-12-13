<?php
	$idMaterial = $_GET['ID_MATERIAL'];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query = "SELECT u.*,uc.*
				FROM usercc u
				INNER JOIN user_comment uc
				ON u.email = uc.id_user
				AND uc.id_material = $idMaterial
				ORDER BY uc.time DESC";

	$result = $conn->query($query);

	$data = array();
	while($row = mysqli_fetch_array($result)){ 
    	$data[] = array('id_comment' => $row[8], 'time' => $row[10], 'content' => $row[11],'id_material' => $row[12],'email' => $row[0],'avatar' => $row[7] );
	}

	$conn->close();
	echo(json_encode($data));
?>