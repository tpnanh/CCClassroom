<!DOCTYPE html>
<?php
	session_start();

	if(!isset($_SESSION['user']) || $_SESSION['user']==null){
		header('Location: ../index.php');
		exit();
	}
	$user = $_SESSION['user'];
?>
<html lang="en">
<head>
    <title>User List - CC Classroom</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="../img/thumbnail.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<style>
		h3{
			font-family:verdana;
			font-weight: bold;
			margin-top: 20px;
		}
		span{
			font-family:verdana;
			font-weight: bold;
			color: #101052;
			font-size: 18px;
		}
		i{
			color: #43437B;
			font-size: 19px;
		}
		.navbar{
			margin: 20px;

		}
		.searchButton{
			background-color: #214996;
			color: white;
		}
		.searchButton:hover{
			background-color: #2e446e;
			color: white;
		}
		table{
			width: 95%;
			margin: 20px auto;
			border-collapse: collapse;
		}
		th{
			color: white;
			background-color: #087043;
			padding: 10px;
			font-size: 15px;
		}
		td{
			border: 1px solid lightgrey;
			font-size: 14px;
			padding: 10px;
		}
		.firstCol{
			width: 5px;
		}
		.secondCol{
			border-left-style:hidden;
		}
		.lastCol{
			border-left-style:hidden;
			width: 5px;
		}
		.dropdown-item{
			font-size: 13px;
			font-weight: bold;
		}
		.dropdown-item:focus{
			background-color: #3e946f;
			color: white;
		}
		.modalItem{
			font-size: 13px;
			font-weight: bold;			
		}
		.modalItem:focus{
			background-color: lightgrey;
			color: black;
		}
		.btnPermission, .btnPermission:focus, .btnPermission:hover{
			background-color: #214996;
			color: white;
		}
	</style>
</head>
<body>
	<h3 style="text-align: center;">List of Users</h3>

	<nav class="navbar">
		
		<form class="form-inline" style="margin-left: auto;">
			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
			<button class="btn searchButton" type="submit">Search</button>
		</form>
	</nav>

	<table>
		<thead class="thead-dark">
			<tr>
				<th scope="col"></th>
				<th scope="col">Name</th>
				<th scope="col">Username</th>
				<th scope="col">Email</th>
				<th scope="col">Role</th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			<!-- <tr>
				<td class="firstCol" style="text-align: right;"><img src="../img/person_icon.png" class="rounded-circle" alt="avatar" width="20" height="20"></td>
				<td class="secondCol">Ngọc Anh</td>
				<td>ngocanhtran</td>
				<td>tpna@gmail.com</td>
				<td>Teacher</td>
				<td class="lastCol">
					<div class="dropdown">
				       	<button class="btn" data-toggle="dropdown" id="editUser" href="#">
				       		<i class="fas fa-ellipsis-v" style="color: #087043"></i>
				       	</button>				       	
				        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="editUser">
						    <a class="dropdown-item" href="#">Delete</a>
						    <div class="dropdown-divider"></div>
						    <a class="dropdown-item" data-toggle="modal" href="#modalPermission">Permission</a>
						</div>
					</div>
				</td>
			</tr> -->
			<?php
				$conn = new mysqli('127.0.0.1','root','',"ccclassroom");
				$emailUser = $user["email"];
				$query = "select * from usercc where email!= '$emailUser' ORDER BY FIELD(role,'Admin', 'Teacher', 'Student'),ho_ten";
            	$result = $conn->query($query);
            	while ($row = mysqli_fetch_array($result)) {
        	?>
	               <tr>
						<td class="firstCol" style="text-align: right;"><img src="<?= $row['avatar'] ?>" class="rounded-circle" alt="avatar" width="20" height="20"></td>
						<td class="secondCol"><?= $row['ho_ten'] ?></td>
						<td><?= $row['user_name'] ?></td>
						<td><?= $row['email'] ?></td>
						<td><?= $row['role'] ?></td>
						<td class="lastCol">
							<div class="dropdown">
						       	<button class="btn" data-toggle="dropdown" id="editUser" href="#">
						       		<i class="fas fa-ellipsis-v" style="color: #087043"></i>
						       	</button>				       	
						        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="editUser">
								    <a class="dropdown-item" href="#">Delete</a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item" data-toggle="modal" href="#modalPermission">Permission</a>
								</div>
							</div>
						</td>
					</tr>
            <?php
            	}
            	$conn->close();
			?>
			 <div class="modal" id="modalPermission" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
	    					<div class="modal-content">
	      						<div class="modal-header">
		        					<h5 class="modal-title">Permission</h5>
		        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		         						<span aria-hidden="true">&times;</span>
		        					</button>
	      						</div>
			      				<div class="modal-body">
			        				<p>Choose user permission</p>
			        				<div class="btn-group">
										<button class="btn btn-sm dropdown-toggle btnPermission" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Permission</button>
										<div class="dropdown-menu">
											<a class="dropdown-item modalItem" href="#">Admin</a>
	    									<a class="dropdown-item modalItem" href="#">Student</a>
	    									<a class="dropdown-item modalItem" href="#">Teacher</a>
										</div>
									</div>
			      				</div>
			      				<div class="modal-footer">
				        			<button type="button" class="btn btn-success savePermission">Save changes</button>			        
			      				</div>
	    					</div>
	  					</div>
					</div>
		</tbody>
	</table>


	
</body>
</html>
