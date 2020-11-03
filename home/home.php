<!DOCTYPE html>
<?php
	session_start();

	if(!isset($_SESSION['user']) || $_SESSION['user']==null){
		header('Location: index.php');
		exit();
	}
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
			/*violet*/
			color: #43437B;
			font-size: 19px;
		}
		.dropdown-item{
			font-size: 13px;
			font-weight: bold;
		}
		.dropdown-item:focus, .joinClass, .joinClass:hover, .deleteClass{
			background-color: #43437B;
			color: white;
		}
		.logout:hover{
			color: red;
		}
		.deleteClass:hover, .deleteClass:focus{
			background-color: red;
			color: white;
		}
		.deleteClass:not(:disabled):not(.disabled):focus {
			border-color: red;
		    box-shadow: 0 1px 1px rgba(255, 255, 255, 0.075);
		}
		.logout:focus{
			background-color: lightgray;
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
			/*green*/
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

	<script>
		
		function logOut(){
			$.ajax({
				type:"POST",
				url:"../logOut/logOut.php",
				cache: false,
                contentType: false,
                processData: false,
				success: function (response) {
					if (response=="LogOut Success") {
						window.location.href = '../index.php'
					}
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
		}
	</script>

</head>
<body>
	<div>
		<nav class="navbar navbar-expand-sm fixed-top"> 
	  		<ul class="navbar-nav">
	    		<!-- <li class="nav-item">
	       			<a class="navbar-brand" href="#"><i class="fas fa-bars"></i></a>
	    		</li> -->
				<li class="nav-item">
		      		<img src="../img/brand.png" style="width: auto; height: 36px">
			    </li>
		  	</ul>
		  	<ul class="nav-right navbar-nav ml-auto">
			    <li class="nav-item">
			    	<?php
			    		if ($user["role"]==="Admin") {
			    	?>
							<a class="btn" href="listUser/listUser.php">
			       				<i class="fas fa-address-book"></i>
			      		 	</a>
					<?php
						}
			    	?>
			       
			    </li>
				<li class="nav-item">
					<div class="dropdown">
				       	<button class="btn" data-toggle="dropdown" id="joinClass" href="#">
				       		<i class="fas fa-plus"></i>
				       	</button>				       	
				        <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="joinClass">
						    <a class="dropdown-item" data-toggle="modal" href="#modalJoin">Join</a>
						    <?php
						    	if ($user["role"] === 'Admin' || $user["role"] === 'Teacher') {
						    ?>
						    	<div class="dropdown-divider"></div>
						    	<a class="dropdown-item" href="../createClassroom/createClassroom.php">Create</a>
						    <?php
						    	}
						    ?>
						    
						</div>
					</div>
			    </li>
			   	<li class="nav-item">
			       <div class="dropdown">
				       	<button class="btn" data-toggle="dropdown" id="profile" href="#">
				       		<i class="fas fa-info-circle"></i>
				       	</button>				       	
				        <div class="dropdown-menu dropdown-menu-lg-right  dropdown-profile" aria-labelledby="profile">
						    <a class="dropdown-item" href="../profile/profile.html">Edit profile</a>
						    <div class="dropdown-divider"></div>
						    <a class="dropdown-item logout" data-toggle="modal" href="#" onclick="logOut()">Logout</a>
						</div>
					</div>
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
			        <a type="button" href="../classroom/Classroom.html" class="btn joinClass">Join</a>			        
		      	</div>
	    	</div>
	  	</div>
	</div>

	<div class="modal" id="modalDelete" tabindex="-1" role="dialog">
		<div class="modal-dialog " role="document">
	    	<div class="modal-content w-75">
	      		<div class="modal-header">
	        		<h5 class="modal-title">Delete</h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	         			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
		      	<div class="modal-body">
		        	<p>Are you sure you want to delete this class?</p>
		      	</div>
		      	<div class="modal-footer">
			        <button type="button" class="btn deleteClass">Delete</button>			        
		      	</div>
	    	</div>
	  	</div>
	</div>
	

	<div>
		<div class="container-fluid">
			<div class="row">
			  	<div class="card col-lg-3">
				  	<div class="card-header">				  	 	
				      	<a href="../classroom/classroom.html"><h5 class="card-title">Lập trình web và ứng dụng</h5></a>
				      	<h6 class="card-subtitle">Mai Văn Mạnh - web - N3</h6>
				      	<p class="card-text" style="font-size: 15px;margin-top: 5px">Mai Văn Mạnh</p>
				  	</div>
				  	<div class="card-img-overlay ml-auto" style="max-height: 30px;max-width: 30px;">
				  		<img src="../img/person_icon.png" class="rounded-circle"  alt="avatar" width="70" height="70" style="float: right;margin-top: 48px"> 
				  		<a href="#" data-toggle="dropdown" id="classOption" style="float: right;">
				  	 		<i class="fas fa-ellipsis-v" style="color: white"></i>
				  	 	</a>
				  	 	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="classOption">
						    <a class="dropdown-item" href="../editClassroom/editClassroom.html">Edit</a>
						    <div class="dropdown-divider"></div>
						    <a class="dropdown-item" data-toggle="modal" href="#modalDelete">Delete</a>
						</div>
				  	</div>				  	
				    <div class="card-body">	   

				    </div>
				</div>	  

			</div>
		</div>
	</div>
</body>
</html>