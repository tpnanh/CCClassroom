<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password - CC Classroom</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="img/thumbnail.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
		margin: 30px;
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
		margin-top: 20px;
	}
	
	.message{
		display: block;
		text-align: left;
		color: dimgray;
		margin-top: 10px;
	}
	
	input[type="email"] {
		
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
	}
	</style>

</head>
<body class="text-center">
	<form action="" method="post" class="form-signin">
		<img src="img/icon.png" alt="icon" width="auto" height="100">

		<h3 class="reset_password"><b>Reset Password</b></h3>

		<label for="email" >Email</label>     
		<p class="message">Please enter your registered password</p>
		<input type="email" name="email" id="email" class="form-control" placeholder="Enter your email here" required autofocus>     

		<button class="btn btn-lg btn-block" type="submit" name="submit">Send</button>

		<button class="alert alert-success">Request has been send to your email</button>
	</form>
</body>
</html>