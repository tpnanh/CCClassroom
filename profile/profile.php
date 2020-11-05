<!DOCTYPE html>
<?php
	session_start();

	if(!isset($_SESSION['user']) || $_SESSION['user']==null){
		header('Location: ../index.php');
		exit();
	}
	$user = $_SESSION['user'];
?>
<html lang="en">
<head>
    <title>Profile - CC Classroom</title>
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

		img{
			margin-top: 20px;
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
			/*blue*/
			background-color: #7492c4;
			margin-top: 20px;
		}
		
		.alert{
			margin-top: 15px;
			font-size: 15px;
		}

		.dropdown{
			display: flex;
			justify-content: flex-start;
		}
		.dropdown-menu{
			font-size: 14px;
		}
	</style>

	<script>
		let avatarFile
		let imageAvatar
		let errorAlter
		let userName
		let fullName
		let email
		let birth
		let phone

		window.onload = function(){
			makeTextInputFile()
			avatarFile = document.getElementById('custom-file');
			imageAvatar = document.getElementById('imageAvatar');
			errorAlter = document.getElementById('alter-error');
			userName = document.getElementById('username');
			email = document.getElementById('user-email');
			birth = document.getElementById('user-date-of-birth');
			phone = document.getElementById('user-phone-number');
			fullname = document.getElementById('fullname');
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

		function updateProfile(){
			let fd = new FormData();
			fd.append('EMAIL',email.value)
			fd.append('USER_NAME',userName.value)
			fd.append('FULL_NAME',fullname.value)
			fd.append('BIRTH',birth.value)
			fd.append('PHONE',phone.value)
			fd.append('AVATAR', imageAvatar.src)

			$.ajax({
				type:"POST",
				url:"updateProfile.php",
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
	<form method="post" class="form-signin" onsubmit='updateProfile();return false'>
		<img src="../img/icon.png" alt="icon" width="auto" height="60">
		<h3 class="userProfile"><b>Profile</b></h3>

		<label for="user-name">Username</label> 
		<input type="text" name="user-name" id="username" class="form-control" placeholder="Username" required autofocus value="<?= $user['user_name'] ?>"> 

		<label for="full-name">Full name</label> 
		<input type="text" name="full-name" id="fullname" class="form-control" placeholder="Full name" required autofocus value="<?= $user['ho_ten'] ?>">   

		<!-- <label for="user-password">Password</label>     
		<input type="text" name="user-password" id="user-password" class="form-control" placeholder="Password" required > -->    

		
		<label for="user-email">Email</label>     
		<input type="email" name="user-email" id="user-email" class="form-control" placeholder="Email" style="pointer-events: none;" required value="<?= $user['email'] ?>" disabled> 

		<label for="user-date-of-birth" >Date of birth</label>     
		<input type="date" name="user-date-of-birth" id="user-date-of-birth" class="form-control" placeholder="Date of birth" required value="<?= $user['birthday'] ?>"> 	

		<label for="user-phone-number">Phone number</label>     
		<input type="tel" name="user-phone-number" id="user-phone-number" class="form-control" placeholder="Phone number" 
		pattern="[0-9]{10}" required value="<?= $user['sdt'] ?>"> 

		<?php
			echo ('<img id="imageAvatar" src="'.$user['avatar'].'" style="float: left; width: 30%; padding-right: 15px">');
		?>
		<label for="custom-file" style="margin-top: 30px">Choose your profile picture</label>
		<div class="custom-file" style="width: 70%;">
			<label class="custom-file-label"   for="custom-file">Choose file</label>
			<input type='file' name="custom-file" class="custom-file-input" id="custom-file" accept="image/*">		
		</div>	

		<button class="btn btn-md btn-block" type="submit" name="submit">Save</button>

		<div class="alert alert-success" style="display: none;" id="alter-success">Information has been saved</div>
		<div class="alert alert-danger" style="display: none;" id="alter-error"></div>
	</form>
	
</body>
</html>