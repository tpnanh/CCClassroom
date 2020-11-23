<?php
	$idMaterial = $_POST['ID_MATERIAL'];
	$idClass = $_POST['ID_CLASS'];
	$title = $_POST['TITLE'];
	$des = $_POST['DES'];
	$due = $_POST['DUE'];
	$oldFile = $_POST['OLD_FILE'];
	$urlForm = $_POST['URL_FORM'];

	$file = "";
	$nameFile="";

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

	$postFile = "";
	if ($oldFile!="" && $nameFile!="") {
		$postFile = $nameFile;
	}else if ($oldFile!="" && $nameFile==""){
		$postFile = $oldFile;
	}else if ($oldFile=="" && $nameFile==""){
		$postFile = "";
	}else if ($oldFile=="" && $nameFile!=""){
		$postFile = $nameFile;
	}

	$conn = new mysqli('127.0.0.1','root','',"ccclassroom");


	$query = "UPDATE material SET title='$title',des='$des',due='$due',nameFile='$postFile',url_form = '$urlForm' WHERE idClass=$idClass and id=$idMaterial";
	if($conn->query($query)===false){

    	$error = $conn->error;
    	$conn->close();
    	die($error);
    }
	$conn->close();
	

	echo("Update success");


?>