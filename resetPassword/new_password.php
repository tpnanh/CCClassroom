<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset PHP</title>
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
	<script>
		
		let pass;
		let confirmPass;
		let token;
		window.onload = function(){
			pass = document.getElementById('pass');
			confirmPass = document.getElementById('confirm_pass');
			token = document.getElementById('token');
		}

		function resetPassword(){
			if(pass.value!==confirm_pass.value){
				console.log("Password and Confirm password not match")
			}else if(pass.value.length<8){
				console.log("Password must longer 8 characters")
			}else{
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
							console.log(response)
						}
    				},
    				fail: function(xhr, textStatus, errorThrown){
    		// 			alertError.style.display = ""
						// alertError.innerHTML = "Request failed"
						// alertSuccess.style.display = "none"
    				}
				});
			}
		}
	</script>
<body>
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
	<form method="post" class="form-signin" onsubmit='resetPassword();return false'>
		<h2 class="form-title">New password</h2>
		<div class="form-group">
			<label>New password</label>
			<input type="password" name="new_pass" id="pass">
		</div>
		<div class="form-group">
			<label>Confirm new password</label>
			<input type="password" name="new_pass_c" id="confirm_pass">
		</div>
		<div class="form-group">
			<button type="submit" name="new_password" class="login-btn">Submit</button>
		</div>
	</form>
</body>
</html>