<?php
	$id = $_GET['id'];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query = "select * from material where idClass = $id ORDER BY date_create DESC";

	$result = $conn->query($query);

	$data = array();
	while($row = mysqli_fetch_array($result)){ 
    	$data[] = array('id' => $row[0], 'title' => $row[1], 'des' => $row[2],'due' => $row[3],'email' => $row[4],'type' => $row[5],'idClass' => $row[6],'nameFile' => $row[7], 'dateCreate' => $row[8] );
	}
	$conn->close();
	echo(json_encode($data));
?>