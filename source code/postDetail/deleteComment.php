<?php
	$idComment = $_POST["ID_COMMENT"];

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

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