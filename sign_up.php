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
		justify-content: flex-start;
		padding-bottom: 80px;
		height: 100%;
		width: 100%;
		font-family:verdana;
	}
	
	img{
		margin-bottom: 10px;
		display: flex;
		justify-content: flex-start;
	}

	.form-signin {
		width: 100%;
		margin: 20px;
		max-width: 500px;
	}	
	
	.form-control{
		position: relative;
		box-sizing: border-box;
		height: auto;
		margin-top: 5px;
		font-size: 13px;
	}
	
	.form-control:focus {
		z-index: 2;
	}
	
	label{
		display: block;
		text-align: left;
		margin-top: 20px;
		color: dimgray;
		font-size: 13px;
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
		<img src="img/icon.png" alt="icon" width="auto" height="50">
		<h3 class="signup"><b>Sign Up</b></h3>

		<label for="email" >Email</label>     
		<input type="email" name="email" id="email" class="form-control" placeholder="Email" required autofocus>    

		<label for="password" >Password</label>     
		<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>   
		
		<label for="confirm-password" >Confirm Password</label>     
		<input type="password" name="password" id="confirm-password" class="form-control" placeholder="Confirm Password" required> 

		<label for="username" >Username</label>     
		<input type="text" name="username" id="username" class="form-control" placeholder="Username" required> 

		<label for="fullname" >Họ và tên</label>     
		<input type="text" name="fullname" id="fullname" class="form-control" placeholder="Họ và tên" required> 

		<label for="date-of-birth" >Ngày sinh</label>     
		<input type="text" name="fullname" id="date-of-birth" class="form-control" placeholder="Ngày sinh" required> 	

		<label for="phone-number" >Số điện thoại</label>     
		<input type="text" name="fullname" id="phone-number" class="form-control" placeholder="Số điện thoại" required> 

		<label for="avatar">Chọn ảnh đại diện</label> 		
		<button class="btn" type="button">Sign Up</button>

		<button class="btn btn-lg btn-block" type="submit" name="submit">Sign Up</button>

		<button class="alert alert-success">Information has been saved</button>
	</form>
	
</body>
</html>