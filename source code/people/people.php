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
    <title>Stream - CC Classroom</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="img/thumbnail.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="../main.js"></script> 
	<link rel="stylesheet" type="text/css" href="../style.css">

	<script>
		try{
			let peopleList;
			let emailClassOfUser = '';
			let emailCurrentUser = '';
			let roleCurrentUser = '';
			let inputAddUser;
			let inputTextFindView;
			let formAddUser
			getId()
		}
		catch(err){
			getPeople()
		}

		function getId(){
			peopleList = document.getElementById('people')
			inputAddUser = document.getElementById('inputAddUser')
			inputTextFindView = document.getElementById('inputTextFindView')
			formAddUser = document.getElementById('formAddUser')
			emailCurrentUser = '<?= $user['email'] ?>';
			roleCurrentUser = '<?= $user['role'] ?>';
			getDataClassById()
			getPeople()
		}

		function getDataClass(){
			$.ajax({
				type:"GET",
				url:"../stream/getInfoClass.php?",
				data: { 
        			id: idClass
    			},
				success: function (response) {
					if (response==="Classroom not found") {
						window.location.href="../home/home.php"
					}else{
						let result = JSON.parse(response)
						emailClassOfUser = result.email
					}
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
		}
		
		function getPeople(){
			$.ajax({
				type:"GET",
				url:"../people/getUserOfClass.php?",
				data: { 
        			id: idClass
    			},
				success: function (response) {
					if (response==="Classroom not found") {
						//window.location.href="../home/home.php"
					}else{
						let result = JSON.parse(response)
						removeAllChildNode(peopleList)
						for (i = 0; i < result.length; i++) {
						 	appendView(result[i])
						}
					}
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
		}

		function appendView(data){
			let div = document.createElement('div')
			div.style.marginBottom = "28px"

			let img = document.createElement('img')
			img.classList.add('rounded-circle','imgPeople')
			img.src = data.img
			img.alt = "avatar"
			img.width = "50"
			img.height = "50"
			img.style.float = "left"
			div.appendChild(img)
			if (roleCurrentUser === "Admin" || emailCurrentUser === emailClassOfUser) {
				if (data.emailPeople !== data.emailUserOfClass) {
					let a = document.createElement('a')
					a.href="#"
					a.setAttribute("data-toggle", "dropdown");
					a.id = "deleteUser"

					let i = document.createElement('i')
					i.classList.add("fas","fa-ellipsis-v")
					i.style.color = "black"
					a.appendChild(i)
					div.appendChild(a)

					let div2 = document.createElement('div')
					div2.classList.add("dropdown-menu","dropdown-menu-right")
					div2.setAttribute("aria-expanded", "true");
					div2.setAttribute("aria-labelledby", "deleteUser");

					let a2 = document.createElement('a')
					a2.classList.add('dropdown-item')
					a2.setAttribute("data-toggle", "modal");
					a2.style.fontWeight = "bold"
					a2.innerHTML = "Delete"
					a2.onclick = function(){deleteUser(this,data.id_class,data.emailPeople)};
					div2.appendChild(a2)
					div.appendChild(div2)
				}else{
					formAddUser.style.display = "none"
				}
			}else{
				formAddUser.style.display = "none"
			}

			let p = document.createElement('p')
			p.classList.add('studentName')
			p.innerHTML = data.emailPeople
			div.appendChild(p)
			let hr = document.createElement('hr')
			div.appendChild(hr)
			peopleList.appendChild(div)
			
		}

		function deleteUser(view, idClass, email){
			let fd = new FormData();
			fd.append('ID_CLASS', idClass)
			fd.append('EMAIL', email)
			$.ajax({
				type:"POST",
				url:"../people/deleteUser.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					console.log(response)
					if (response==="Delete user success") {
						view.parentNode.parentNode.remove()
					}
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
		}

		function removeAllChildNode(parent) {
    		while (parent.firstChild) {
        		parent.removeChild(parent.firstChild);
    		}
		}

		function addPeople(){
			let fd = new FormData();
			fd.append('ID', idClass)
			fd.append('EMAIL', inputAddUser.value)
			$.ajax({
				type:"POST",
				url:"../people/addPeople.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					console.log(response)
					if (response==="Add success") {
						getPeople()
					}else{
						alert(response)
					}
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
		}

		function findUser(){
			$.ajax({
				type:"GET",
				url:"../people/findUser.php?",
				data: { 
        			ID: idClass,
        			KEY_WORD: inputTextFindView.value
    			},
				success: function (response) {
					let result = JSON.parse(response)
					removeAllChildNode(peopleList)
					for (i = 0; i < result.length; i++) {
						appendView(result[i])
					}
					
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
		}

	</script>

</head>
<body>
	<br>
	<br>
	<br>
	<nav class="navbar">	
		<form class="form-inline" style="margin-right: auto;margin-top: 10px;" onsubmit="addPeople();return false;" id="formAddUser">
			<input class="form-control ml-sm-2" placeholder="Student Email" style="margin-right: 10px;" aria-label="Add" id="inputAddUser" required>
			<button class="btn addButton" type="submit">Add</button>
		</form>	
		<form class="form-inline" style="margin-left: auto;margin-top: 10px" onsubmit="findUser();return false;">
			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="inputTextFindView">
			<button class="btn searchButton" type="submit">Search</button>
		</form>
	</nav>
	<hr class="divideLine">
	<div id="people">
		<!-- <div style="margin-bottom: 28px">		
			<img src="../img/person_icon.png" class="rounded-circle" alt="avatar" width="50" height="50" style="float: left;"> 		
			<a href="#" data-toggle="dropdown" id="deleteUser" style="">
	  	 		<i class="fas fa-ellipsis-v" style="color: black"></i>
  	 		</a>
  	 		<div class="dropdown-menu dropdown-menu-right" aria-expanded="true" aria-labelledby="deleteUser">
		    	<a class="dropdown-item" data-toggle="modal" href="#" style="font-weight: bold;">Delete</a>
			</div>
			<p class="studentName">Huỳnh Anh Tài</p> 
		</div> -->
	</div>
</body>
</html>