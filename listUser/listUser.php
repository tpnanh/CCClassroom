<!DOCTYPE html>
<?php
	session_start();

	if(!isset($_SESSION['user']) || $_SESSION['user']==null){
		header('Location: ../index.php');
		exit();
	}

	$user = $_SESSION['user'];
	if ($user["role"]!="Admin") {
		header('Location: ../home.php');
		exit();
	}
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
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../main.js"></script>  

	<script>
		let listUserView;
		let inputTextFindView;
		let modalDialogPermission;
		let emailTemp = ''
		let btnPermission;
		window.onload = function(){
			listUserView = document.getElementById("listUserView");
			inputTextFindView = document.getElementById("inputTextFindView");
			modalDialogPermission = document.getElementById("modalPermission");
			btnPermission = document.getElementById("btnPermission");

			$('#modalPermission').on('hidden.bs.modal', function () {
 				unsaveEmailTemp()
			})

			$('#modalPermission').on('shown.bs.modal', function () {
 				btnPermission.innerHTML = 'Permission'
			})	
		}


		$(document).ready(function () {
        	getAllUser();
    	});

		function getAllUser(){
			getListUserWeb().then(function(result){
				for (i = 0; i < result.length; i++) {
					appendViewIntoTable(result[i])
				}
			})
		}

		function findUser(){
			removeAllChildNode(listUserView)
			findUserWeb(inputTextFindView.value).then(function(result){
				for (i = 0; i < result.length; i++) {
					appendViewIntoTable(result[i])
				}
			})
		}

		function appendViewIntoTable(data){
			let tr = document.createElement('tr')

			let td1 = document.createElement('td')
			td1.classList.add('firstCol')
			td1.style.text_align = 'right'
			let img = document.createElement('img')
			img.classList.add('rounded-circle')
			img.src = data.avatar
			img.width = '20'
			img.height = '20'
			td1.appendChild(img)

			let td2 = document.createElement('td')
			td2.classList.add('secondCol')
			td2.innerHTML = data.ho_ten

			let td3 = document.createElement('td')
			td3.innerHTML = data.user_name

			let td4 = document.createElement('td')
			td4.innerHTML = data.email

			let td5 = document.createElement('td')
			td5.innerHTML = data.role

			let td6 = document.createElement('td')
			td6.classList.add('lastCol')

			let div1 = document.createElement('div')
			div1.classList.add('dropdown')

			let btn = document.createElement('button')
			btn.classList.add('btn')
			btn.setAttribute("data-toggle", "dropdown");
			btn.id = "editUser"
			btn.aria_expanded = 'true'

			let i = document.createElement('i')
			i.classList.add('fas','fa-ellipsis-v')
			i.style.color = '#087043'

			btn.appendChild(i)

			let div2 =  document.createElement('div')
			div2.classList.add('dropdown-menu','dropdown-menu-right')
			div2.aria_labelledby = 'editUser'

			let a = document.createElement('a')
			a.classList.add('dropdown-item','dropdownItemUser')
			a.href="#"
			a.onclick = function(){ deleteUser(data.email,tr) }
			a.innerHTML = 'Delete'

			let div3 = document.createElement('div')
			div3.classList.add('dropdown-divider')

			let a2 = document.createElement('a')
			a2.classList.add('dropdown-item','dropdownItemUser')
			a2.setAttribute("data-toggle", "modal")
			a2.href = "#modalPermission"
			a2.onclick = function(){ saveEmailTemp(data.email,td5) }
			a2.innerHTML = 'Permission'

			div2.appendChild(a)
			div2.appendChild(div3)
			div2.appendChild(a2)

			div1.appendChild(btn)
			div1.appendChild(div2)
			td6.appendChild(div1)

			tr.appendChild(td1)
			tr.appendChild(td2)
			tr.appendChild(td3)
			tr.appendChild(td4)
			tr.appendChild(td5)
			tr.appendChild(td6)

			listUserView.appendChild(tr)
		}

		function saveEmailTemp(email, viewRole){
			emailTemp = email
		}

		function unsaveEmailTemp(){
			emailTemp = ''
		}

		function savePermissionPerson(){
			savePermissionUser(emailTemp,btnPermission.innerHTML).then(function(result){
				removeAllChildNode(listUserView)
				for (i = 0; i < result.length; i++) {
					appendViewIntoTable(result[i])
				}	
			})
			$("#modalPermission").modal('hide');
		}

		function changeViewPermission(permission){
			btnPermission.innerHTML = permission
		}

		function deleteUser(email,view){
			deleteUserWeb(email).then(function(result){
				if (result==="Delete user success") {
					view.remove()
				}
			})
		}

	</script>
</head>
<body>
	<h3 class="titleListUser">List of Users</h3>

	<nav class="navbar navListuser">
		
		<form class="form-inline" style="margin-left: auto;" onsubmit="findUser();return false;">
			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="inputTextFindView">
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
		<tbody id="listUserView">
		
			<div class="modal" id="modalPermission" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
  						<div class="modal-header">
	        					<h5 class="modal-title">Permission</h5>
	        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	         						<span class="spanListUser" aria-hidden="true">&times;</span>
	        					</button>
  						</div>
	      				<div class="modal-body">
	        				<p>Choose user permission</p>
	        				<div class="btn-group">
								<button class="btn btn-sm dropdown-toggle btnPermission" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btnPermission">Permission</button>
								<div class="dropdown-menu">
									<a class="dropdown-item dropdownItemUser modalItem" onclick="changeViewPermission('Admin')">Admin</a>
									<a class="dropdown-item dropdownItemUser modalItem" onclick="changeViewPermission('Student')">Student</a>
									<a class="dropdown-item dropdownItemUser modalItem" onclick="changeViewPermission('Teacher')">Teacher</a>
								</div>
							</div>
	      				</div>
	      				<div class="modal-footer">
		        			<button type="button" class="btn btn-success savePermission" onclick="savePermissionPerson()">Save changes</button>			        
	      				</div>
					</div>
				</div>
			</div>
		</tbody>
		
	</table>
	
</body>
</html>
