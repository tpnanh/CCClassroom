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
		let boardView;
		let idTemp = ''
		let viewTemp = null
		window.onload = function(){
			boardView = document.getElementById('boardView');
			getClass()

			$('#modalDelete').on('hidden.bs.modal', function () {
 				unsaveClassTemp()
			})
		}

		function getClass(){
			$.ajax({
				type:"GET",
				url:"getClass.php",
				cache: false,
                contentType: false,
                processData: false,
				success: function (response) {
					let result = JSON.parse(response)
					for (i = 0; i < result.length; i++) {
						appendViewIntoBoardView(result[i])
					}
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
		}

		function appendViewIntoBoardView(data){
				
			let div = document.createElement('div')
			div.classList.add('card','col-lg-3')

			let div1 = document.createElement('div')
			div1.classList.add('card-header')

			let a = document.createElement('a')
			a.href = '../classroom/classroom.html'

			let h = document.createElement('h5')
			h.classList.add('card-title')
			h.innerHTML = data.name_class

			a.appendChild(h)
			div1.appendChild(a)

			let h2 = document.createElement('h6')
			h2.classList.add('card-subtitle')
			h2.innerHTML = data.subject
			div1.appendChild(h2)

			let p = document.createElement('p')
			p.classList.add('card-text')
			p.style.font_size = '15px'
			p.style.marginTop  = '5px'
			p.innerHTML = data.room
			div1.appendChild(p)
			div.appendChild(div1)
		
			let div2 = document.createElement('div')
			div2.classList.add('card-img-overlay','ml-auto')
			div2.style.maxHeight = '30px'
			div2.style.maxWidth = '30px'

			let img = document.createElement('img')
			img.classList.add('rounded-circle')
			img.src = data.avatar
			img.alt = 'avatar'
			img.width = '70'
			img.height = '70'
			img.style.float = 'right'
			img.style.marginTop = '48px'
			div2.appendChild(img)

			let check = '<?= $user['role'] ?>';
			if (check!='Student') {
				let a2 = document.createElement('a')
				a2.href = '#'
				a2.setAttribute("data-toggle", "dropdown");
				a2.id = 'classOption'
				a2.style.float = 'right'
				a2.setAttribute("aria-expanded", 'true')

				let i = document.createElement('i')
				i.classList.add('fas','fa-ellipsis-v')
				i.style.color='white'
				a2.appendChild(i)
				div2.appendChild(a2)

				let div3 = document.createElement('div')
				div3.classList.add('dropdown-menu','dropdown-menu-right')
				div3.aria_labelledby = 'classOption'

				let a3 = document.createElement('a')
				a3.classList.add('dropdown-item')
				a3.href = "../editClassroom/editClassroom.php?id="+data.id_class
				a3.innerHTML = 'Edit'
				div3.appendChild(a3)

				let div4 = document.createElement('div')
				div4.classList.add('dropdown-divider')
				div3.appendChild(div4)

				let a4 = document.createElement('a')
				a4.classList.add('dropdown-item')
				a4.setAttribute("data-toggle", "modal");
				a4.href = '#modalDelete'
				a4.innerHTML = 'Delete'
				a4.onclick = function(){ saveClassTemp(data.id_class,div) }
				div3.appendChild(a4)

				div2.appendChild(div3)
			}
			
			div.appendChild(div2)

			let div5 = document.createElement('div')
			div5.classList.add('card-body') 
			div.appendChild(div5)
			boardView.appendChild(div)

		}

		function deleteClass(){
			let fd = new FormData();
			fd.append('id', idTemp)
			$.ajax({
				type:"POST",
				url:"deleteClass.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					if (response==="Delete class success") {
						let a = viewTemp
						viewTemp.remove()
					}

					$("#modalDelete").modal('hide');
				},
				fail: function(xhr, textStatus, errorThrown){
					$("#modalDelete").modal('hide');
				}
			});
		}

		function saveClassTemp(id, view){
			idTemp = id
			viewTemp = view
		}

		function unsaveClassTemp(){
			idTemp = ''
			viewTemp = null
		}

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
	    		<li class="nav-item" >
	       			<i class="fa fa-home navbar-brand" style="font-size: 27px; color: #D24848"></i>
	    		</li>
				<li class="nav-item">
		      		<img src="../img/brand.png" style="width: auto; height: 36px">
			    </li>
		  	</ul>
		  	<ul class="nav-right navbar-nav ml-auto">
			    <li class="nav-item">
			    	<?php
			    		if ($user["role"]==="Admin") {
			    	?>
							<a class="btn" href="../listUser/listUser.php">
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
				        <div class="dropdown-menu dropdown-menu-lg-right" aria-expanded="true" aria-labelledby="joinClass">
				        	<?php
						    	if ($user["role"] != 'Admin') {
						    ?>
						    	<a class="dropdown-item" data-toggle="modal" href="#modalJoin">Join</a>
						    <?php
						    	}
						    ?>
						    <?php
						    	if ($user["role"] === 'Teacher') {
						    ?>
						    	<div class="dropdown-divider"></div>
						    <?php
						    	}
						    ?>
						    <?php
						    	if ($user["role"] === 'Admin' || $user["role"] === 'Teacher') {
						    ?>
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
				        <div class="dropdown-menu dropdown-menu-lg-right  dropdown-profile" aria-expanded="true" aria-labelledby="profile">
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
			        <button type="button" class="btn deleteClass" onclick="deleteClass()">Delete</button>			        
		      	</div>
	    	</div>
	  	</div>
	</div>
	

	<div>
		<div class="container-fluid">
			<div class="row" id="boardView">
			  	  

			</div>
		</div>
	</div>
</body>
</html>