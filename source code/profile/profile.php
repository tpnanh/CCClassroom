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
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../main.js"></script>  

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
			avatarFile = document.getElementById('custom-file');
			imageAvatar = document.getElementById('imageAvatar');
			errorAlter = document.getElementById('alter-error');
			userName = document.getElementById('username');
			email = document.getElementById('user-email');
			birth = document.getElementById('user-date-of-birth');
			phone = document.getElementById('user-phone-number');
			fullname = document.getElementById('fullname');
		}

		$(document).ready(function () {
        	makeTextInputFileCompress()
    	});

		//Make text input file has name
		function makeTextInputFileCompress(){
			$(".custom-file-input").on("change", function() {
			  	let fileName = $(this).val().split("\\").pop();
			  	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);

				let file = avatarFile.files[0]
				compressFile(file)
			});
		}

		function compressFile(file){
			compressFileImage(file).then(function(response){
				if (response === 'File so big') {
					error(response)
				}else{
					imageAvatar.src = response
				}
			})
		}

		function updateProfile(){
			updateProfileUser(email.value, userName.value, fullname.value, birth.value, phone.value, imageAvatar.src).then(function(response){
				if (response === 'Update success') {
					history.go(-1)
				}else{
					error(response)
				}
			})
		}

		function error(errorStr){
			errorAlter.innerHTML = errorStr
			errorAlter.style.display = ""
		}
	</script>
</head>
<body class="text-center bodyLogin">
	<form method="post" class="form-signin formSigninProfile" onsubmit='updateProfile();return false'>
		<img class="imgProfile" src="../img/icon.png" alt="icon" width="auto" height="60">
		<h3 class="userProfile"><b>Profile</b></h3>

		<label class="labelProfile" for="user-name">Username</label> 
		<input type="text" name="user-name" id="username" class="form-control formControlLogin inputPassLogin" placeholder="Username" required autofocus value="<?= $user['user_name'] ?>"> 

		<label class="labelProfile" for="full-name">Full name</label> 
		<input type="text" name="full-name" id="fullname" class="form-control formControlLogin inputPassLogin" placeholder="Full name" required autofocus value="<?= $user['ho_ten'] ?>">   

		<!-- <label for="user-password">Password</label>     
		<input type="text" name="user-password" id="user-password" class="form-control" placeholder="Password" required > -->    

		
		<label class="labelProfile" for="user-email">Email</label>     
		<input type="email" name="user-email" id="user-email" class="form-control inputPassLogin" placeholder="Email" style="pointer-events: none;" required value="<?= $user['email'] ?>" disabled> 

		<label class="labelProfile" for="user-date-of-birth" >Date of birth</label>     
		<input type="date" name="user-date-of-birth" id="user-date-of-birth" class="form-control inputPassLogin" placeholder="Date of birth" required value="<?= $user['birthday'] ?>"> 	

		<label class="labelProfile" for="user-phone-number">Phone number</label>     
		<input type="tel" name="user-phone-number" id="user-phone-number" class="form-control inputPassLogin" placeholder="Phone number" 
		pattern="[0-9]{10}" required value="<?= $user['sdt'] ?>"> 

		<?php
			echo ('<img class="imgProfile" id="imageAvatar" src="'.$user['avatar'].'" style="float: left; width: 30%; padding-right: 15px">');
		?>
		<label class="labelProfile" for="custom-file" style="margin-top: 30px">Choose your profile picture</label>
		<div class="custom-file" style="width: 70%;">
			<label class="custom-file-label labelProfile"  style="margin: 0;" for="custom-file">Choose file</label>
			<input type='file' name="custom-file" class="custom-file-input" id="custom-file" accept="image/*">		
		</div>	

		<button class="btn btnSaveProfile btn-md btn-block" type="submit" name="submit">Save</button>

		<div class="alert alertProfile alert-success" style="display: none;" id="alter-success">Information has been saved</div>
		<div class="alert alertProfile alert-danger" style="display: none;" id="alter-error"></div>
	</form>
	
</body>
</html>