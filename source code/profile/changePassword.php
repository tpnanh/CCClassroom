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
		let errorAlter
		let oldPass
		let newPass
		let confirmPass

		window.onload = function(){
			errorAlter = document.getElementById('alter-error')
			oldPass = document.getElementById('old-password')
			newPass = document.getElementById('new-password')
			confirmPass = document.getElementById('confirm-password')
		}

		function updatePassword(){
			updatePasswordUser(newPass.value, confirmPass.value, oldPass.value).then(function(response){
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
	<form method="post" class="form-signin formSigninProfile" onsubmit='updatePassword();return false'>
		<img class="imgProfile" src="../img/icon.png" alt="icon" width="auto" height="60">
		<h3 class="userProfile"><b>Update Password</b></h3>

		<label class="labelSignUp" for="old-password">Old Password</label>     
		<input type="password" name="old-password" id="old-password" class="form-control formControlLogin inputPassLogin" placeholder="Old password" required >

		<label class="labelSignUp" for="new-password">New Password</label>     
		<input type="password" name="new-password" id="new-password" class="form-control formControlLogin inputPassLogin" placeholder="New password" required >

		<label class="labelSignUp" for="confirm-password">Confirm Password</label>     
		<input type="password" name="confirm-password" id="confirm-password" class="form-control formControlLogin inputPassLogin" placeholder="Confirm password" required >    


		<button class="btn btnSaveProfile btn-md btn-block" type="submit" name="submit">Save</button>
		<div class="alert alert-success"  style="display: none; margin-top: 15px;font-size: 15px;" id="alter-success">Information has been saved</div>
		<div class="alert alert-danger" style="display: none; margin-top: 15px;font-size: 15px;" id="alter-error"></div>
	</form>
	
</body>
</html>