<?php
	session_start();
	$user = $_SESSION['user'];
	$title = nl2br($_POST['TITLE']);
	$des = nl2br($_POST['DES']);
	$type = $_POST['TYPE'];
	$due = $_POST['DUE'];
	$urlForm = $_POST['URL_FORM'];

	$emailUser = $user["email"];
	$file = "";
	$nameFile="";

	$idClass = $_POST['ID_CLASS'];

	if (isset($_FILES['FILE'])) {
		$file = $_FILES['FILE'];

		$nameFile= $file['name'];

		$tmp_name= $file['tmp_name'];

		$position= strpos($nameFile, "."); 

		$fileextension= substr($nameFile, $position + 1);

		$fileextension= strtolower($fileextension);

		if (isset($nameFile)) {

			$path= "../Uploads/files/".$idClass."/";
			if (!file_exists($path)) {
   				 mkdir($path, 0777, true);
			}

			if (!empty($nameFile)){
				if (move_uploaded_file($tmp_name, $path.$nameFile)) {
					//echo ('Uploaded!');
				}
			}
		}
	}
	$timeNow = gmdate("Y-m-d\TH:i:s\Z"); 
	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");

	$query = "insert into material(title, des, due, email, type, idClass, nameFile,date_create, url_form) values('$title','$des','$due','$emailUser','$type', $idClass,'$nameFile','$timeNow', '$urlForm')";

    if($conn->query($query)===false){

    	$error = $conn->error;
    	$conn->close();
    	die($error);
    }
	$conn->close();
	echo ("Insert success");
?>