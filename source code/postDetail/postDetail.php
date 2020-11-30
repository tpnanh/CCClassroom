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
    <title>Classroom - CC Classroom</title>
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
		let title, userCreate,timeCreate, timeDue, description, linkFile, nameFile,iconCurrentUser,comment, listComment, labelAssign, linkAssign, errorAssign
		let idPost = ""
		let idClass = ""
		let roleCurrentUser = ""
		let emailCurrentUser = ""
		let emailClassOfUser = ""
		window.onload = function(){
			title = document.getElementById('title')
			userCreate = document.getElementById('userCreate')
			timeCreate = document.getElementById('timeCreate')
			timeDue = document.getElementById('timeDue')
			description = document.getElementById('description')
			linkFile = document.getElementById('linkFile')
			nameFile = document.getElementById('nameFile')
			iconCurrentUser = document.getElementById('iconCurrentUser')
			comment = document.getElementById('comment')
			listComment = document.getElementById('listComment')
			labelAssign = document.getElementById('labelAssign')
			linkAssign = document.getElementById('linkAssign')
			errorAssign = document.getElementById('errorAssign')
			roleCurrentUser = '<?= $user['role'] ?>';
			emailCurrentUser = '<?= $user['email'] ?>';
			getUrl()
			getInfoPost()
			getInfoClass()
			getListComment()
			iconCurrentUser.src = '<?= $user['avatar'] ?>';
		}

		function getUrl(){
			idPost = getParameterByName('idPost')
			idClass = getParameterByName('idClass')
		}

		function getInfoClass(){
			getDataClassroomById(idClass).then(function(response){
				let result = JSON.parse(response)
				emailClassOfUser = result.email
			})
		}

        function getInfoPost(){
        	errorAssign.style.display = "none"
        	getInfoPostDetail(idPost).then(function(response){
				if (response==="Post/Assignment not found") {
					window.location.href="../home/home.php"
				}else{
					let result = JSON.parse(response)
					title.innerHTML = result.title
					userCreate.innerHTML = result.email
					timeCreate.innerHTML = formateDate(result.date_create)
					description.innerHTML = result.des
					if (result.type==="ASSIGN") {
						timeDue.innerHTML = "Due "+formateDate2(result.due)
						linkAssign.href = result.url_form
					}else{
						linkAssign.style.display = "none"
						labelAssign.style.display = "none"
						timeCreate.style.float = ""
						timeDue.innerHTML = ""
					}
					if (result.nameFile!="") {
					 	nameFile.innerHTML = result.nameFile
					 	linkFile.href = "../Uploads/files/"+idClass+"/"+result.nameFile
					}else{
					 	nameFile.style.display = "none"
     					linkFile.style.display = "none"
					}
					checkTimeAssign()
				}
			})
        }

       	function checkTimeAssign(){
       		if (linkAssign.style.display==="") {
       			if(!checkTime(timeDue.innerHTML)){
       				console.log("Tre deadline")
       				timeDue.style.color = "red"
					linkAssign.style.display = "none"
					errorAssign.style.display = ""
       			}else{
       				errorAssign.style.display = "none"
       				console.log("Chua Tre deadline")
       			}
        	}
       	}

        function addComment(){
        	if (comment.value.trim().length !=0) {
        		addCommentToPost(comment.value, idPost).then(function(response){
					comment.value = ""
					getListComment()
				})
        	}
        }

        function getListComment(){
			getListCommentPost(idPost).then(function(response){
				removeAllChildNode(listComment)
				let result = JSON.parse(response)
				for (i = 0; i < result.length; i++) {
				 	addViewComment(result[i])
				}
			})
        }

        function addViewComment(data){
        	let div = document.createElement('div')
        	div.style.marginBottom = "15px"

        	let img = document.createElement('img')
        	img.classList.add('rounded-circle','iconAvatar')
        	img.alt = "avatar"
        	img.src = data.avatar
        	div.appendChild(img)

        	let spanName = document.createElement('span')
        	spanName.classList.add('user','card-subtitle','userPostDetail')
        	spanName.style.margin = "10px"
        	spanName.innerHTML = data.email
        	div.appendChild(spanName)

        	let spanTime = document.createElement('span')
        	spanTime.classList.add('date')
        	spanTime.style.marginLeft = "10px"
        	spanTime.innerHTML = formateDate2(data.time)
        	div.appendChild(spanTime)

        	if (roleCurrentUser === "Admin" || emailCurrentUser === data.email || emailCurrentUser === emailClassOfUser) {
	        	let a = document.createElement('a')
	        	a.href = "#"
	        	a.setAttribute("data-toggle", "dropdown")
	        	a.id = "deleteComment"
	        	a.style.float = "right"
	        	a.style.marginRight = "8px"

	        	let i = document.createElement('i')
	        	i.classList.add('fas','fa-ellipsis-v')
	        	i.style.color = "black"
	        	a.appendChild(i)
	        	div.appendChild(a)

	        	let div2 = document.createElement('div')
				div2.classList.add("dropdown-menu","dropdown-menu-right")
				div2.setAttribute("aria-expanded", "true");
				div2.setAttribute("aria-labelledby", "deleteComment");

				let a2 = document.createElement('a')
				a2.classList.add('dropdown-item')
				a2.setAttribute("data-toggle", "modal");
				a2.style.fontWeight = "bold"
				a2.innerHTML = "Delete"
				a2.onclick = function(){deleteComment(this,data.id_comment)};
				div2.appendChild(a2)
				div.appendChild(div2)
			}
			let p = document.createElement('p')
			p.classList.add('comment')
			p.innerHTML = data.content
			div.appendChild(p)
			listComment.appendChild(div)
        }

        function deleteComment(view,idComment){
        	deleteCommentPost(idComment).then(function(response){
				if (response==="Delete comment success") {
					view.parentNode.parentNode.remove()
				}
			})
        }
		
		function logOut(){
			userLogOut().then(function(response){
				if (response=="LogOut Success") {
					window.location.href = '../index.php'
				}
			})
		}
	</script>

</head>
<body>
	<div>
		<nav class="navbar navbar-expand-sm fixed-top navHome" style="background-color: white"> 
	  		<ul class="navbar-nav nav nav-tabs navTab">
				<li class="nav-item">
					<img src="../img/brand.png" style="width: auto; height: 36px">
		      		<!-- <a href="../classroom/classroom.php">
		      			<img src="../img/brand.png" style="width: auto; height: 36px">
		      		</a> -->
			    </li>
		  	</ul>
		  	<ul class="nav-right navbar-nav ml-auto navRightHome">				
			   	<li class="nav-item">
			       	<div class="dropdown">
				       	<button class="btn" data-toggle="dropdown" id="profile">
				       		<i class="fas fa-info-circle iconPostDetail"></i>
				       	</button>				       	
				        <div class="dropdown-menu dropdown-menu-lg-right  dropdown-profile" aria-expanded="true" aria-labelledby="profile">
						    <a class="dropdown-item logout"  onclick="logOut()" data-toggle="modal" href="#" style="font-weight: bold;">Logout</a>
						</div>
					</div>
			    </li>
		  	</ul>
		</nav>
	</div>
	<div class="container containerPostDetail" >
		<div class="center centerPostDetail">
			<h3 id="title" class="titlePostDetail"></h3>
			<p id="userCreate" style="margin: 0px;"></p>
			<p id="timeCreate" style="float: left"></p>
			<p id="timeDue" style="text-align: right;font-size: 14px; margin-right: 20px;"></p>
			<hr class="first-line">
			<p style="font-weight: bold;color: black;margin-bottom: 0px" id="labelAssign"></p>
			<p style="color: red" id="errorAssign">Assignment has been hidden</p>  
			<a href="#" target="_blank" id="linkAssign"></a>
			<p></p>
			<p id="description"> 
			</p>
			<a href="#" download id="linkFile">
				<p id="nameFile"></p>
			</a>
			<hr class="second-line">
			<div id="listComment">
				<!-- <div>		
			      	<img src="../img/person_icon.png" class="rounded-circle" alt="avatar" width="50" height="50" style="float: left;"> 
			      	<span class="user card-subtitle" style="margin: 10px">Ngọc Tâm</span><span class="date" style="margin-left: 10px">Nov 3</span>		
			      	<a href="#" data-toggle="dropdown" id="deleteComment" style="float: right;margin-right: 8px;">
				  	 	<i class="fas fa-ellipsis-v" style="color: black"></i>
			  	 	</a>
			  	 	<div class="dropdown-menu dropdown-menu-right" aria-expanded="true" aria-labelledby="deleteComment">
					    <a class="dropdown-item" data-toggle="modal" href="#" style="font-weight: bold;">Delete</a>
					</div>   
			      	<p class="comment">Tin bầu cử Tổng thống Mỹ 2020 mới nhất: Tổng thống Mexico nói còn quá sớm để chúc mừng Biden; Chiến dịch của Trump đệ đơn kiện ở Arizona.
			      		Tin bầu cử Tổng thống Mỹ 2020 mới nhất: Tổng thống Mexico nói còn quá sớm để chúc mừng Biden; Chiến dịch của Trump đệ đơn kiện ở Arizona.
					</p>	

		  		</div> -->
			</div>
			
		  	<hr class="third-line">
		  	<div>		
		  		<form onsubmit="addComment();return false;">
					<img src="../img/person_icon.png" id="iconCurrentUser" class="rounded-circle iconAvatar" alt="avatar" > 
			      	<input type="text" name="comment" id="comment" class="commentPostDetail" placeholder="Add class comment">    
			      	<a href="#"><img src="../img/send.png" width="23px" style="position: right;margin-left: 7px;margin-bottom: 3px" onclick="addComment()"></a>
		      	</form>	
		  	</div>

		  		
		      
		</div>
	</div>
		
</body>
</html>