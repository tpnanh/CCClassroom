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
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../main.js"></script>  
	<script>
		let boardView;
		let idTemp = ''
		let viewTemp = null
		let inputClasscode
		let errorJoinClass
		let inputTextFindView
		window.onload = function(){
			boardView = document.getElementById('boardView');
			errorJoinClass = document.getElementById('errorJoinClass');
			inputClasscode = document.getElementById('inputClasscode');
			inputTextFindView = document.getElementById('inputTextFindView')
			

			$('#modalDelete').on('hidden.bs.modal', function () {
 				unsaveClassTemp()
			})

			$('#modalJoin').on('hidden.bs.modal', function () {
 				inputClasscode.value = ''
 				errorJoinClass.style.display = 'none'
			})
		}

		$(document).ready(function () {
        	getClass();
    	});

		function getClass(){
		    getAllClassUser().then(function(result){
				for (i = 0; i < result.length; i++) {
					appendViewIntoBoardView(result[i])
				}
			})
		}

		function appendViewIntoBoardView(data){
				
			let div = document.createElement('div')
			div.classList.add('card','col-lg-3','cardHome')

			let div1 = document.createElement('div')
			div1.classList.add('card-header','cardHeaderHome')

			let a = document.createElement('a')
			a.classList.add('linkHome')
			a.href = "../classroom/classroom.php?idClass="+data.id_class

			let h = document.createElement('h5')
			h.classList.add('card-title','joinClassHome','cardTitleHome')
			h.innerHTML = data.name_class

			a.appendChild(h)
			div1.appendChild(a)

			let h2 = document.createElement('h6')
			h2.classList.add('card-subtitle','joinClassHome')
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
			let mailCurrentUser = '<?= $user['email'] ?>';
			let mailClassUser = data.email;
			if (check!='Student') {
				if (check =='Teacher' && mailClassUser!= mailCurrentUser) {

				}else{
					let a2 = document.createElement('a')
					a2.classList.add('linkHome')
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
				
			}
			
			div.appendChild(div2)

			let div5 = document.createElement('div')
			div5.classList.add('card-body','cardBodyHome') 
			div.appendChild(div5)
			boardView.appendChild(div)

		}

		function deleteClass(){
			deleteClassById(idTemp)
		}

		function saveClassTemp(id, view){
			idTemp = id
			viewTemp = view
		}

		function unsaveClassTemp(){
			idTemp = ''
			viewTemp = null
		}

		function userJoinClass(){
			if(checkStrJustNumber(inputClasscode.value)){
				joinClassById(inputClasscode.value).then(function(response){
					if (response==="Join success") {	
						window.location.href="../classroom/classroom.php?idClass="+inputClasscode.value
						$("#modalJoin").modal('hide');
					}else{
						errorJoinClass.style.display = ''
						errorJoinClass.innerHTML = response
					}
				})
			}else{
				errorJoinClass.style.display = ''
				errorJoinClass.innerHTML = "ID is invalid"
			}
			
		}

		function logOut(){
			userLogOut().then(function(response){
				if (response=="LogOut Success") {
					window.location.href = '../index.php'
				}
			})
		}

		function findClass(){
			findClassByKeyWord(inputTextFindView.value).then(function(response){
				removeAllChildNode(boardView)
				for (i = 0; i < response.length; i++) {
					appendViewIntoBoardView(response[i])
				}
			})
		}
	</script>

</head>
<body>
	<div>
		<nav class="navbar navbar-expand-sm fixed-top" style="background-color: white"> 
	  		<ul class="navbar-nav navHome">
	    		<li class="nav-item" >
	       			<i class="fa fa-home navbar-brand" style="font-size: 27px; color: #D24848"></i>
	    		</li>
				<li class="nav-item">
		      		<img src="../img/brand.png" style="width: auto; height: 36px">
			    </li>
		  	</ul>		  	
		  	<ul class="nav-right navbar-nav ml-auto navRightHome">		  	
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
						    <a class="dropdown-item" href="../profile/profile.php">Edit profile</a>
						    <div class="dropdown-divider"></div>
						    <a class="dropdown-item" href="../profile/changePassword.php">Update password</a>
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
	        		<h5 class="modal-title joinClassHome">Join class</h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	         			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
		      	<div class="modal-body">
		        	<form onsubmit="userJoinClass();return false;">
		        		<label for="inputClasscode">Classcode</label>
						<input type="text" class="form-control" id="inputClasscode" placeholder="Enter classcode" >
						<p style="font-size: 13px;color: red;margin-top: 10px; margin-bottom: 0px;display: none" id="errorJoinClass">ID Class is not available</p>
					</form>
		      	</div>

		      	<div class="modal-footer">

			        <a type="button" onclick="userJoinClass()" class="btn joinClass">Join</a>			        
		      	</div>
	    	</div>
	  	</div>
	</div>

	<div class="modal" id="modalDelete" tabindex="-1" role="dialog">
		<div class="modal-dialog " role="document">
	    	<div class="modal-content w-75">
	      		<div class="modal-header">
	        		<h5 class="modal-title joinClassHome">Delete</h5>
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
	<div style="float: left;width: 100%">
		<form class="form-inline"  style="float: right;margin-right: 15px; margin-bottom: 15px;" onsubmit="findClass();return false;">
			<input class="form-control ml-sm-2" placeholder="Find Class" style="margin-right: 10px;" aria-label="Search" id="inputTextFindView">
			<button class="btn findClass" type="submit">Search</button>
		</form>
	</div>

	<div>
			
		<div class="container-fluid" style="margin-left:10px; width: 99%; margin-top: 70px;">
			<div class="row" id="boardView">
			  	  

			</div>
		</div>
	</div>


</body>
</html>