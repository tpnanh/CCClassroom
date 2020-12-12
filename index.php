<!DOCTYPE html>
<?php
	session_start();
	if(isset($_SESSION['user'])){
		if($_SESSION['user']!==null){
    		header('Location: home/home.php');
			exit();
		}
	}
?>
<html lang="en">
<head>
    <title>Sign In - CC Classroom</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="img/thumbnail.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="main.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">

	<script>
		let email;
		let password;
		let alertError;
		window.onload = function(){
			email = document.getElementById('email');
			password = document.getElementById('password');
			alertError = document.getElementById('error');
		}

		function login(){
			loginUser(email.value, password.value).then(function(result){
				console.log(result)
				if (result==="User not found") {
					alertError.style.display = ""
					alertError.innerHTML = "User not found"
				}else if(result==="Password wrong"){
					alertError.style.display = ""
					alertError.innerHTML = "Password wrong"
				}else if (result === "Login success"){
					alertError.style.display = "none"
					window.location.href="home/home.php"
				}else{
					alertError.style.display = ""
					alertError.innerHTML = "Error"
				}
			})
		}

	</script>

</head>
<body class="text-center bodyLogin">
	<form method="post" class="form-signin formLogin" onsubmit='login();return false'>
      	<img class="imgLogin" src="img/icon.png" alt="icon" width="auto" height="100">
	  
      	<h3 class="signin"><b>Sign In</b></h3>
	  
      	<label class="labelLogin" for="email" >Email</label>      
	  	<input type="email" name="email" id="email" class="form-control formControlLogin inputEmailLogin" placeholder="Email" required autofocus>      
	  	<label for="password" class="labelLogin">Password</label>      
	  	<input type="password" name="password" id="password" class="form-control formControlLogin inputPassLogin" placeholder="Password" required>
	  
	  	<div class="alert alert-danger" id="error" style="display: none;"></div>
	  	<a class="forgotPasswordLinkLogin tagALogin" href="./resetPassword/reset_password.html">Forgot your password?</a>
      
      	<button class="btn btn-md btn-block btnLogin" type="submit" name="submit">Sign In</button>
	  
	   	<p class="dont-have-account">Don't have an account yet? <a class="tagALogin" href="./signUp/sign_up.html">Sign Up</a></p>
	</form>
</body>
</html>