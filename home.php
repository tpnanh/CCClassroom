<!DOCTYPE html>
<?php
	session_start();
	$user = $_SESSION['user'];
?>
<html lang="en">
<head>
    <title>Home - CC Classroom</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="img/thumbnail.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<style>
		nav{
			margin: 5px;
		}

		.nav-right li{
			margin-left: 20px;
		}
		i{
			color: #43437B;
			font-size: 19px;
		}
		.dropdown-item{
			font-size: 12px;
			font-weight: bold;
		}
		.dropdown-item:focus, .joinClass, .joinClass:hover{
			background-color: #43437B;
			color: white;
		}
		.container-fluid{
			margin-left:10px;
			width: 99%;
			margin-top: 70px;
		}
		a{
			color:white;
		}
		a:hover{
			color:white;
		}
		.card{
			width: 100%;
			margin-top: 5px;
			padding-left: 0px;
			padding-right: 0px;
			background-clip: padding-box;
			border: 10px solid transparent;
		}
		.card-header{
			color: white;
			background-color: #087043;
		}
		.card-title{
			padding-bottom: 4px;
		}
		.card-body{
			background-color: lightgrey;
			height: 60px;
		}
		h5, h6{
			width: 90%;
			white-space: nowrap; 
            overflow: hidden;
            text-overflow: ellipsis; 
		}
	</style>

</head>
<body>
	<div>
		<nav class="navbar navbar-expand-sm fixed-top"> 
	  		<ul class="navbar-nav">
	    		<li class="nav-item">
	       			<a class="navbar-brand" href="#"><i class="fas fa-bars"></i></a>
	    		</li>
				<li class="nav-item">
		      		<img src="../img/brand.png" style="width: auto; height: 36px">
			    </li>
		  	</ul>
		  	<ul class="nav-right navbar-nav ml-auto">
			    <li class="nav-item">
			       <a class="btn" href="listUser/listUser.html">
			       		<i class="fas fa-address-book"></i>
			       </a>
			    </li>
				<li class="nav-item">
					<div class="dropdown">
				       	<button class="btn" data-toggle="dropdown" id="addClass" href="#">
				       		<i class="fas fa-plus"></i>
				       	</button>				       	
				        <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="addClass">
						    <a class="dropdown-item" data-toggle="modal" href="#modalJoin">Join</a>
						    <div class="dropdown-divider"></div>
						    <a class="dropdown-item" href="createClassroom/createClassroom.html">Create</a>
						</div>
					</div>
			    </li>
			   	<li class="nav-item">
			       <a class="btn" href="#"><i class="fas fa-info-circle"></i></a>
			    </li>
		  	</ul>
		</nav>

	</div>

	<div class="modal" id="modalJoin" tabindex="-1" role="dialog">
		<div class="modal-dialog " role="document">
	    	<div class="modal-content w-75">
	      		<div class="modal-header">
	        		<h5 class="modal-title">Join class</h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	         			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
		      	<div class="modal-body">
		        	<form>
		        		<label for="inputClasscode">Classcode</label>
						<input type="text" class="form-control" id="inputClasscode" placeholder="Enter classcode" >
					</form>
		      	</div>
		      	<div class="modal-footer">
			        <button type="button" class="btn joinClass">Join</button>			        
		      	</div>
	    	</div>
	  	</div>
	</div>
	

	<div>
		<div class="container-fluid">
			<div class="row">
			  	<div class="card col-lg-3">
				  	<div class="card-header">				  	 	
				      	<a href="#"><h5 class="card-title">Lập trình web và ứng dụng</h5></a>
				      	<h6 class="card-subtitle">Mai Văn Mạnh - web - N3</h6>
				      	<p class="card-text" style="font-size: 15px;margin-top: 5px">Mai Văn Mạnh</p>
				  	</div>
				  	<div class="card-img-overlay ml-auto" style="max-height: 30px;max-width: 30px;">
				  		<img src="../img/person_icon.png" class="rounded-circle"  alt="avatar" width="70" height="70" style="float: right;margin-top: 48px"> 
				  		<a href="#" style="float: right;">
				  	 		<i class="fas fa-ellipsis-v" style="color: white"></i>
				  	 	</a>
				  	</div>				  	
				    <div class="card-body">	   

				    </div>
				</div>	  

				<div class="card col-lg-3">
				  	<div class="card-header">				  	 	
				      	<a href="#"><h5 class="card-title">Lập trình web và ứng dụng</h5></a>
				      	<h6 class="card-subtitle">Mai Văn Mạnh - web - N3</h6>
				      	<p class="card-text" style="font-size: 15px;margin-top: 5px">Mai Văn Mạnh</p>
				  	</div>
				  	<div class="card-img-overlay ml-auto" style="max-height: 30px;max-width: 30px;">
				  		<img src="../img/person_icon.png" class="rounded-circle"  alt="avatar" width="70" height="70" style="float: right;margin-top: 48px"> 
				  		<a href="#" style="float: right;">
				  	 		<i class="fas fa-ellipsis-v" style="color: white"></i>
				  	 	</a>
				  	</div>	
				    <div class="card-body">	   

				    </div>
				</div>	  

				<div class="card col-lg-3">
				  	<div class="card-header">				  	 	
				      	<a href="#"><h5 class="card-title">Lập trình web và ứng dụng</h5></a>
				      	<h6 class="card-subtitle">Mai Văn Mạnh - web - N3</h6>
				      	<p class="card-text" style="font-size: 15px;margin-top: 5px">Mai Văn Mạnh</p>
				  	</div>
				  	<div class="card-img-overlay ml-auto" style="max-height: 30px;max-width: 30px;">
				  		<img src="../img/person_icon.png" class="rounded-circle"  alt="avatar" width="70" height="70" style="float: right;margin-top: 48px"> 
				  		<a href="#" style="float: right;">
				  	 		<i class="fas fa-ellipsis-v" style="color: white"></i>
				  	 	</a>
				  	</div>	
				    <div class="card-body">	   

				    </div>
				</div>	 

				<div class="card col-lg-3">
				  	<div class="card-header">				  	 	
				      	<a href="#"><h5 class="card-title">Lập trình web và ứng dụng</h5></a>
				      	<h6 class="card-subtitle">Mai Văn Mạnh - web - N3</h6>
				      	<p class="card-text" style="font-size: 15px;margin-top: 5px">Mai Văn Mạnh</p>
				  	</div>
				  	<div class="card-img-overlay ml-auto" style="max-height: 30px;max-width: 30px;">
				  		<img src="../img/person_icon.png" class="rounded-circle"  alt="avatar" width="70" height="70" style="float: right;margin-top: 48px"> 
				  		<a href="#" style="float: right;">
				  	 		<i class="fas fa-ellipsis-v" style="color: white"></i>
				  	 	</a>
				  	</div>	
				    <div class="card-body">	   

				    </div>
				</div>	  

				<div class="card col-lg-3">
				  	<div class="card-header">				  	 	
				      	<a href="#"><h5 class="card-title">Lập trình web và ứng dụng</h5></a>
				      	<h6 class="card-subtitle">Mai Văn Mạnh - web - N3</h6>
				      	<p class="card-text" style="font-size: 15px;margin-top: 5px">Mai Văn Mạnh</p>
				  	</div>
				  	<div class="card-img-overlay ml-auto" style="max-height: 30px;max-width: 30px;">
				  		<img src="../img/person_icon.png" class="rounded-circle"  alt="avatar" width="70" height="70" style="float: right;margin-top: 48px"> 
				  		<a href="#" style="float: right;">
				  	 		<i class="fas fa-ellipsis-v" style="color: white"></i>
				  	 	</a>
				  	</div>	
				    <div class="card-body">	   

				    </div>
				</div>	  

				<div class="card col-lg-3">
				  	<div class="card-header">				  	 	
				      	<a href="#"><h5 class="card-title">Lập trình web và ứng dụng</h5></a>
				      	<h6 class="card-subtitle">Mai Văn Mạnh - web - N3</h6>
				      	<p class="card-text" style="font-size: 15px;margin-top: 5px">Mai Văn Mạnh</p>
				  	</div>
				  	<div class="card-img-overlay ml-auto" style="max-height: 30px;max-width: 30px;">
				  		<img src="../img/person_icon.png" class="rounded-circle"  alt="avatar" width="70" height="70" style="float: right;margin-top: 48px"> 
				  		<a href="#" style="float: right;">
				  	 		<i class="fas fa-ellipsis-v" style="color: white"></i>
				  	 	</a>
				  	</div>	
				    <div class="card-body">	   

				    </div>
				</div>	  
			</div>
		</div>
	</div>
</body>
</html>