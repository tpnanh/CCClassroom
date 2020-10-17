<?php
	$mail = $_POST['mail'];
	$pass = md5($_POST['pass']);
	$username = $_POST['username'];
	$hoTen = $_POST['hoTen'];
	$birth = $_POST['birth'];
	$sdt = $_POST['sdt'];
	$avatar = $_FILES['avatar'];

	#20MB
	if ($avatar['size']>=20*1024*1024) {
		die("File so big");
	}

	$target_dir = "upload/";
	$nameFile = $avatar['name'];
	$target_file = $target_dir . basename($nameFile);
	// Select file type
  	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Convert to base64 
	$image_base64 = base64_encode(file_get_contents($avatar['tmp_name']) );	
	$image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "insert into usercc values('$mail','$username','$pass','$hoTen','$birth','$sdt','Học viên','$image')";

    if($conn->query($query)===false){
    	die($conn->error);
    }
	$conn->close();

	echo("Insert success");

?>