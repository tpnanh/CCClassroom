<?php
	$idComment = $_POST["ID_COMMENT"];

	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query = "DELETE FROM user_comment WHERE id_commnet=$idComment";
	$result = $conn->query($query);

	if ($conn->query($query) === TRUE) {
		echo ("Delete comment success");
		$conn->close();
		exit();
	}else{
		echo ("Error delete 1");
	}

?>