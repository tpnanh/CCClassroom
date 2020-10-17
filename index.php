<!DOCTYPE html>
<?php
	session_start();
	// if(isset($_SESSION['login'])){
	// 	if($_SESSION['login']){
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

</head>
<body class="text-center">
</body>
	<?php
		$mail = '';
		$pass = '';
		$error = '';
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$mail = $_POST['email'];
			$pass = $_POST['password'];
			if ($mail!='1@gmail.com') {
				$error = "User not found";
			}else if ($pass != '123'){
				$error = "Password wrong";
			}else{
				$_SESSION['login'] = true;
				$error = "";
				header('Location: home.php');
				exit();
			}
		}
	?>
	<form method="post" class="form-signin">
      	<img src="img/icon.png" alt="icon" width="auto" height="200">
	  
      	<h3 class="signin"><b>Sign In</b></h3>
	  
      	<label for="email" >Email</label>      
	  	<input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?= $mail ?>" required autofocus>      
	  	<label for="password" >Password</label>      
	  	<input type="password" name="password" id="password" class="form-control" placeholder="Password" value="<?= $pass ?>" required>
	  
	  	<div class="alert alert-danger" <?php if($error ===''){?> style="display: none" <?php } ?> id="error">
    		<?php 
    			if($error!=''){
    				echo($error);
    			}
    		?>
  		</div>
	  	<a class="forgot-password-link" href="reset_password.php">Forgot your password?</a>
      
      	<button class="btn btn-lg btn-block" type="submit" name="submit">Sign In</button>
	  
	   	<p class="dont-have-account">Don't have an account yet? <a href="sign_up.php">Sign Up</a></p>
	</form>
</body>
</html>