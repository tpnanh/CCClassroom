<!DOCTYPE html>
<html lang="en">
<head>
	<title>New Password - CC Classroom</title>
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
		
		let pass;
		let confirmPass;
		let token;
		let alertError;
		window.onload = function(){
			pass = document.getElementById('new_pass');
			confirmPass = document.getElementById('new_pass_c');
			token = document.getElementById('token');
			alertError = document.getElementById('alter-error');
		}
 
		function resetPassword(){
			resetPasswordUser(pass.value, confirmPass.value, token.innerHTML).then(function(response){
				if(response==="success "){
					window.location.href="../index.php"
				}else{
					alertError.style.display = ""
	 				alertError.innerHTML = response
				}
			})
		}
	</script>
</head>

<body class="text-center bodyLogin">
	<?php
		$token = "";
		if (isset($_GET['token'])) {
			$token = $_GET['token'];
		}else{
			header('Location: ../index.php');
			exit();
		}
	?>
	<p id="token" style="display: none;"><?= $token ?></p>
	<form  method="post" class="form-signin" onsubmit='resetPassword();return false'>
		<img src="../img/icon.png" alt="icon" width="auto" height="80" class="imgLogin">

   
		<br><br>
		<label for="password" class="labelSignUp" >Password</label>  
		<input type="password" name="password" id="new_pass" class="form-control inputPassLogin" placeholder="Password" required autofocus>
		<label for="confirm-password" class="labelSignUp">Confirm Password</label>
		<input type="password" name="confirm_password" id="new_pass_c" class="form-control inputPassLogin" placeholder="Confirm Password" required>     

		<button class="btn btn-md btn-block btnSignUp" type="submit" name="submit">Submit</button>
		<div class="alert alert-danger alertSignUp" style="display: none;" id="alter-error"></div>

	</form>
	
</body>
</html>