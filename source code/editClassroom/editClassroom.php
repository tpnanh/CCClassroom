<!DOCTYPE html>
<?php
	session_start();

	if(!isset($_SESSION['user']) || $_SESSION['user']==null){
		header('Location: ../index.php');
		exit();
	}
	$user = $_SESSION['user'];
	if ($user['role']==='Student') {
		header('Location: ../index.php');
		exit();
	}
?>
<html lang="en">
<head>
    <title>Edit Classroom - CC Classroom</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="img/thumbnail.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="../main.js"></script> 
	<link rel="stylesheet" type="text/css" href="../style.css">

	<script>
		let avatarFile
		let errorAlter
		let imageAvatar
		let className
		let subject
		let room
		let idClass
		window.onload = function(){
			makeTextInputFile()
			idClass = document.getElementById('idClass');
			avatarFile = document.getElementById('custom-file');
			errorAlter = document.getElementById('alter-error');
			imageAvatar = document.getElementById('imageAvatar');
			className = document.getElementById('class-name');
			subject = document.getElementById('subject');
			room = document.getElementById('class-room');
		}

		//Make text input file has name
		function makeTextInputFile(){
			$(".custom-file-input").on("change", function() {
			  	let fileName = $(this).val().split("\\").pop();
			  	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);

				let file = avatarFile.files[0]
				compressFile(file)
			});
		}

		function compressFile(file){
			let fd = new FormData();
			fd.append('avatar', file)

			$.ajax({
				type:"POST",
				url:"../img/base64ImageEncode.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					if (response === 'File so big') {
						error(response)
					}else{
						imageAvatar.src = response
					}

					
				},
				fail: function(xhr, textStatus, errorThrown){
					error("Request failed")
				}
			});
		}

		function updateClass(){
			let fd = new FormData();
			fd.append('id',idClass.innerHTML)
			fd.append('avatar', imageAvatar.src)
			fd.append('CLASS_NAME', className.value)
			fd.append('SUBJECT', subject.value)
			fd.append('ROOM', room.value)

			$.ajax({
				type:"POST",
				url:"updateClassroom.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					console.log(response)
					if (response === 'Update success') {
						history.go(-1)
					}else{
						error(response)
					}

					
				},
				fail: function(xhr, textStatus, errorThrown){
					error("Request failed")
				}
			});
		}

		function error(errorStr){
			errorAlter.innerHTML = errorStr
			errorAlter.style.display = ""
		}

	</script>
</head>
<body class="text-center bodyLogin">
	<?php

		if(isset($_GET['id'])){
			$id = $_GET['id'];

			$conn = new mysqli('127.0.0.1','root','',"ccclassroom");
			$sql = "select * from class where id_class='$id'";
			$result = $conn->query($sql);
			
        	if($result->num_rows<=0){
          		header('Location: ../index.php');
				exit();
        	}
        	$data = $result->fetch_assoc();
        	if ($user["role"]!='Admin' && $data['email'] != $user['email']){
        		header('Location: ../index.php');
				exit();
        	}
         	$name = $data['name_class'];
			$subject = $data['subject'];
			$room = $data['room'];
			$avatar = $data['avatar_class'];

		}else{
			header('Location: ../home/home.php');
			exit();
		}
	?>
	<p id="idClass" style="display: none;"><?= $id ?></p>
	<form method="post" class="form-signin formSigninProfile" onsubmit='updateClass();return false'>
		<img class="imgProfile" src="../img/icon.png" alt="icon" width="auto" height="60">
		<h3 class="createClass"><b>Edit Classroom</b></h3>

		<label class="labelSignUp" for="class-name">Class name</label>     
		<input type="text" name="class-name" id="class-name" class="form-control formControlLogin inputPassLogin" placeholder="Class name" value="<?= $name ?>"required autofocus>    

		<label class="labelSignUp" for="subject"> Subject</label>     
		<input type="text" name="subject" id="subject" class="form-control formControlLogin inputPassLogin" placeholder="Subject" value="<?= $subject ?>" required >   
		
		<label class="labelSignUp" for="class-room">Room</label>     
		<input type="text" name="class-room" id="class-room" class="form-control formControlLogin inputPassLogin" placeholder="Room" value="<?= $room ?>"required> 

		<?php
			echo ('<img class="imgProfile" id="imageAvatar" src="'.$avatar.'" style="float: left; width: 30%; padding-right: 15px">');
		?>
		<label class="labelSignUp" for="custom-file" style="margin-top: 30px">Choose your classroom picture</label>
		<div class="custom-file" style="width: 70%;">
			<label class="custom-file-label labelSignUp" style="margin:0px;" for="custom-file">Choose file</label>
			<input  type='file' name="custom-file" class="custom-file-input inputPassLogin" id="custom-file" accept="image/*">		
		</div>		

		<button class="btn btnSaveProfile btn-md btn-block" type="submit" name="submit">Save</button>

		<div class="alert alertSignUp alert-success" style="display: none;" id="alter-success">Class has been updated</div>
		<div class="alert alertSignUp alert-danger" style="display: none;" id="alter-error"></div>
	</form>
	
</body>
</html>