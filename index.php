<!DOCTYPE html>
<?php
	session_start();
	// if(isset($_SESSION['user'])){
	// 	if($_SESSION['user']!==null){
 //    		header('Location: home.php');
	// 		exit();
	// 	}
	// }
?>
<html lang="en">
<head>
    <title>Signin - CC Classroom</title>
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
			align-items: center;
			justify-content: center;
			padding-top: 20px;
			padding-bottom: 80px;
			height: 100%;
			font-family:verdana;
		}

		.form-signin {
			width: 100%;
			max-width: 330px;
			margin: 10px;
		}
		
		img{
			margin-bottom: 10px;
		}
		
		.form-control{
			position: relative;
			box-sizing: border-box;
			height: auto;
			margin-top: 5px;
			font-size: 16px;
		}
		
		.form-control:focus {
			z-index: 2;
		}
		
		label{
			display: block;
			text-align: left;
			margin-top: 10px;
		}
		
		input[type="email"] {
			border-bottom-right-radius: 0;
			border-bottom-left-radius: 0;
		}
		
		input[type="password"] {
			margin-bottom: 10px;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
		}
		
		a{
			color: #43437B;
		}
		
		.forgot-password-link{
			display: block;
			text-align: left;
			margin-bottom: 30px;		
		}
		
		.btn:hover{
			background-color: #43437B;
			color: white;
		}
		
		.btn{
			color: white;
			background-color: #7492c4;
		}
		
		.dont-have-account{
			text-align: left;
			margin-top: 10px;	
			color: dimgrey;		
		}

	</style>

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
			let fd = new FormData();
			fd.append('email', email.value)
			fd.append('password', password.value)
			$.ajax({
					type:"POST",
					url:"./login/login.php",
					cache: false,
                    contentType: false,
                    processData: false,
					data:fd,
					success: function (response) {
						console.log(response)
						if (response==="User not found") {
							alertError.style.display = ""
							alertError.innerHTML = "User not found"
						}else if(response==="Password wrong"){
							alertError.style.display = ""
							alertError.innerHTML = "Password wrong"
						}else if (response === "Login success"){
							alertError.style.display = "none"
							window.location.href="home.php"
						}

    				},
    				fail: function(xhr, textStatus, errorThrown){
       					alertError.style.display = ""
       					alertError.innerHTML = "Request failed"
    				}
				});
		}

	</script>

</head>
<body class="text-center">
</body>
	<form method="post" class="form-signin" onsubmit='login();return false'>
      	<img src="img/icon.png" alt="icon" width="auto" height="100">
	  
      	<h3 class="signin"><b>Sign In</b></h3>
	  
      	<label for="email" >Email</label>      
	  	<input type="email" name="email" id="email" class="form-control" placeholder="Email" required autofocus>      
	  	<label for="password" >Password</label>      
	  	<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
	  
	  	<div class="alert alert-danger" id="error" style="display: none;"></div>
	  	<a class="forgot-password-link" href="./resetPassword/reset_password.html">Forgot your password?</a>
      
      	<button class="btn btn-md btn-block" type="submit" name="submit">Sign In</button>
	  
	   	<p class="dont-have-account">Don't have an account yet? <a href="./signUp/sign_up.html">Sign Up</a></p>
	</form>
</body>
</html>