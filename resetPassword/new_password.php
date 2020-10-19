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

		input{		
			margin-bottom: 10px;
			border-bottom-right-radius: 0;
			border-bottom-left-radius: 0;
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

		.alert{
			margin-top: 15px;
			font-size: 15px;
		}
	</style>

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
			if(pass.value!==confirmPass.value){
				alertError.innerHTML = "Password and Confirm password not match"
				alertError.style.display = ""
			}else if(pass.value.length<8){
				alertError.style.display = ""
				alertError.innerHTML = "Password must longer 8 characters"
			}else{
				alertError.style.display = "none"
				let fd = new FormData();
				fd.append('token',token.innerHTML)
				fd.append('pass', pass.value)
				$.ajax({
					type:"POST",
					url:"update_password.php",
					cache: false,
                    contentType: false,
                    processData: false,
					data:fd,
					success: function (response) {
						console.log(response)
						if (response==="success ") {
							window.location.href="../index.php"
						}else{
							alertError.style.display = ""
							alertError.innerHTML = response
						}
    				},
    				fail: function(xhr, textStatus, errorThrown){
    					alertError.style.display = ""
						alertError.innerHTML = "Request failed"
    				}
				});
			}
		}
	</script>
</head>

<body class="text-center">
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
		<img src="../img/icon.png" alt="icon" width="auto" height="80">

   
		<br><br>
		<label for="password" >Password</label>  
		<input type="password" name="password" id="new_pass" class="form-control" placeholder="Password" required autofocus>
		<label for="confirm-password" >Confirm Password</label>
		<input type="password" name="confirm_password" id="new_pass_c" class="form-control" placeholder="Confirm Password" required>     

		<button class="btn btn-md btn-block" type="submit" name="submit">Submit</button>
		<div class="alert alert-danger" style="display: none;" id="alter-error"></div>

	</form>
	
</body>
</html>