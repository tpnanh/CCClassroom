<!DOCTYPE html>
<?php
	session_start();

	if(!isset($_SESSION['user']) || $_SESSION['user']==null){
		header('Location: ../index.php');
		exit();
	}

	$user = $_SESSION['user'];
	if ($user["role"]!="Admin" && $user["role"]!="Teacher") {
		header('Location: ../home.php');
		exit();
	}
?>
<html lang="en">
<head>
    <title>Create Classroom - CC Classroom</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="img/thumbnail.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../main.js"></script>  

	<script>
		let className;
		let subject;
		let room;
		let avatar;
		let errorAlter;

		window.onload = function(){
			makeTextInputFile()
			className = document.getElementById('class-name')
			subject = document.getElementById('subject')
			room = document.getElementById('class-room')
			avatar = document.getElementById('custom-file');
			errorAlter = document.getElementById('alter-error')
		}

		//Make text input file has name
		function makeTextInputFile(){
			$(".custom-file-input").on("change", function() {
			  let fileName = $(this).val().split("\\").pop();
			  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
			});
		}

		function createClass(){
			let file = avatar.files[0]
			let fd = new FormData();
			fd.append('avatar', file)
			fd.append('CLASS_NAME', className.value)
			fd.append('SUBJECT', subject.value)
			fd.append('ROOM', room.value)

			$.ajax({
				type:"POST",
				url:"createClassroomFunction.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					console.log(response)
					if (response === 'Insert success') {
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
	<form method="post" class="form-signin formSigninProfile" onsubmit='createClass();return false' enctype="multipart/form-data">
		<img class="imgProfile" src="../img/icon.png" alt="icon" width="auto" height="60">
		<h3 class="createClass"><b>Create Class</b></h3>

		<label class="labelSignUp" for="class-name">Class name</label>     
		<input type="text" name="class-name" id="class-name" class="form-control formControlLogin inputPassLogin" placeholder="Class name" required autofocus>    

		<label class="labelSignUp" for="subject"> Subject</label>     
		<input type="text" name="subject" id="subject" class="form-control formControlLogin inputPassLogin" placeholder="Subject" required >   
		
		<label class="labelSignUp" for="class-room">Room</label>     
		<input type="text" name="class-room" id="class-room" class="form-control formControlLogin inputPassLogin" placeholder="Room" required> 

		<label class="labelSignUp" for="custom-file" >Choose your classroom picture</label> 
		<div class="custom-file">
			<label class="custom-file-label labelSignUp" style="margin: 0;" for="custom-file">Choose file</label>
			<input type='file' name="custom-file" class="custom-file-input inputPassLogin" id="custom-file" accept="image/*" required>			
		</div>

		<button class="btn btnSaveProfile btn-md btn-block" type="submit" name="submit">Create</button>

		<div class="alert alertProfile alert-success" style="display: none;" id="alter-success">Class has been created</div>
		<div class="alert alertProfile alert-danger" style="display: none;" id="alter-error"></div>
	</form>
	
</body>
</html>