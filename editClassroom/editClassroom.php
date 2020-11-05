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

	<style>	
		body {
			color: #43437B;
			display: flex;
			justify-content: center;
			padding-bottom: 80px;
			height: 100%;
			width: 100%;
			font-family:verdana;
		}
		
		img{
			margin-bottom: 20px;
		}

		.form-signin {
			width: 35%;
			margin: 30px;
		}	
		
		.form-control{
			position: relative;
			box-sizing: border-box;
			height: auto;
			margin-top: 5px;
			font-size: 14px;
		}
		
		.form-control:focus {
			z-index: 2;
		}
		
		label{
			display: block;
			text-align: left;
			margin-top: 20px;
			color: #43437B;
			font-size: 13px;
			font-weight: bold;
		}
		
		.custom-file-label{
			margin: 0;
		}

		input{		
			margin-bottom: 10px;
			border-bottom-right-radius: 0;
			border-bottom-left-radius: 0;
		}
		
		.btn:hover{
			background-color: #43437B;
			color: white;
			margin-top: 20px;
		}
		
		.btn{
			color: white;
			background-color: #7492c4;
			margin-top: 20px;
		}
		
		.alert{
			margin-top: 15px;
			font-size: 15px;
		}
	</style>

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
<body class="text-center">
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
	<form method="post" class="form-signin" onsubmit='updateClass();return false'>
		<img src="../img/icon.png" alt="icon" width="auto" height="60">
		<h3 class="createClass"><b>Edit Classroom</b></h3>

		<label for="class-name">Class name</label>     
		<input type="text" name="class-name" id="class-name" class="form-control" placeholder="Class name" value="<?= $name ?>"required autofocus>    

		<label for="subject"> Subject</label>     
		<input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" value="<?= $subject ?>" required >   
		
		<label for="class-room">Room</label>     
		<input type="text" name="class-room" id="class-room" class="form-control" placeholder="Room" value="<?= $room ?>"required> 

		<?php
			echo ('<img id="imageAvatar" src="'.$avatar.'" style="float: left; width: 30%; padding-right: 15px">');
		?>
		<label for="custom-file" style="margin-top: 30px">Choose your classroom picture</label>
		<div class="custom-file" style="width: 70%;">
			<label class="custom-file-label"   for="custom-file">Choose file</label>
			<input type='file' name="custom-file" class="custom-file-input" id="custom-file" accept="image/*" required>		
		</div>		

		<button class="btn btn-md btn-block" type="submit" name="submit">Save</button>

		<div class="alert alert-success" style="display: none;" id="alter-success">Class has been updated</div>
		<div class="alert alert-danger" style="display: none;" id="alter-error"></div>
	</form>
	
</body>
</html>