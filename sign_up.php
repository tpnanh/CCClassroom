<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password - CC Classroom</title>
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
		justify-content: center;
		padding-bottom: 80px;
		height: 100%;
		width: 100%;
		font-family:verdana;
	}
	
	img{
		margin-bottom: 20px;
	}

	.form-signin {
		width: 50%;
		margin: 20px;
	}	
	
	.form-control{
		position: relative;
		box-sizing: border-box;
		height: auto;
		margin-top: 5px;
		font-size: 14px;
	}
	
	.form-control:focus {
		z-index: 2;
	}
	
	label{
		display: block;
		text-align: left;
		margin-top: 20px;
		color: #43437B;
		font-size: 13px;
		font-weight: bold;
	}
	
	.custom-file-label{
		margin: 0;
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
		font-size: 15px;
	}
	</style>

</head>
<body class="text-center">
	
	
	<form action="" method="post" class="form-signin">
		<img src="img/icon.png" alt="icon" width="auto" height="60">
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
		<input type="text" name="date-of-birth" id="date-of-birth" class="form-control" placeholder="Ngày sinh" required> 	

		<label for="phone-number" >Số điện thoại</label>     
		<input type="text" name="phone-number" id="phone-number" class="form-control" placeholder="Số điện thoại" required> 

		<label for="custom-file" >Chọn ảnh đại diện</label> 
		<div class="custom-file">
			<label class="custom-file-label" for="custom-file">Choose file</label>
			<input type="file" name="custom-file" class="custom-file-input" id="custom-file">
			
		</div>

		<button class="btn btn-md btn-block" type="submit" name="submit">Sign Up</button>

		<button class="alert alert-success">Information has been saved</button>
	</form>
	
</body>
</html>