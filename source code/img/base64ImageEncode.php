<?php
	$avatar = $_FILES['avatar']; 
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
	echo ($image);
?>