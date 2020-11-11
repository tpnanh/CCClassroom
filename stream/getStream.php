<?php
	$id = $_GET['id'];

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "select * from material where idClass = $id ORDER BY date_create DESC";

	$result = $conn->query($query);

	if($result->num_rows<=0){
    	die("Classroom not found");
    } 
	$data = array();
	while($row = mysqli_fetch_array($result)){ 
    	$data[] = array('id' => $row[0], 'title' => $row[1], 'des' => $row[2],'due' => $row[3],'email' => $row[4],'type' => $row[5],'idClass' => $row[6],'nameFile' => $row[7], 'dateCreate' => $row[8] );
	}
	$conn->close();
	echo(json_encode($data));
?>