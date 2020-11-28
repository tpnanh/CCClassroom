<!DOCTYPE html>
<?php
	session_start();

	if(!isset($_SESSION['user']) || $_SESSION['user']==null){
		header('Location: ../index.php');
		exit();
	}
	$user = $_SESSION['user'];
	#include ('../stream/stream.php');
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
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../main.js"></script> 

    <script>

    	let idClass; 
    	let btnSumitPost;
    	let titlePost;
    	let desPost;
    	let filePost;

    	let titleAssign;
    	let linkAssign;
    	let assignAlert;
    	let desAssign;
    	let fileAssign;
    	let dueAssign;
    	let dueAlert;
    	let btnSumitAssign;

    	window.onload = function(){
    		
    		makeTextInputFile()
    		$("#streamTab").load("../stream/stream.php"); 
    		$("#peopleTab").load("../people/people.php");
    		getUrl()
    		btnSumitPost = document.getElementById('btnSumitPost')
    		titlePost = document.getElementById('postTitle')
    		desPost = document.getElementById('postDescription')
    		filePost = document.getElementById('custom-file-post')

    		titleAssign = document.getElementById('assignmentTitle')
    		linkAssign = document.getElementById('assignmentLink')
    		assignAlert = document.getElementById('assignAlert')
    		desAssign = document.getElementById('assignmentDescription')
    		fileAssign = document.getElementById('custom-file-assignment')
    		dueAssign = document.getElementById('dueAssign')
    		dueAlert = document.getElementById('dueAlert')
    		btnSumitAssign = document.getElementById('btnSumitAssign')

    		$('#modalPost').on('hidden.bs.modal', function () {
 				deleteTextInputPost()
			})

			$('#modalAssignment').on('hidden.bs.modal', function () {
 				deletTeTextInputAssignment()
			})
    	}


    	function getUrl(){
            idClass = getParameterByName('idClass');
        }

         function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

	    function makeTextInputFile(){
			$(".custom-file-input").on("change", function() {
			  let fileName = $(this).val().split("\\").pop();
			  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
			});
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

		function callBtnPostPost(){
			btnSumitPost.click()
		}

		function checkTime(){
			let timeNow = new Date()
			let timeChoose = new Date(dueAssign.value)
			if (timeNow > timeChoose) {
				return false
			}
			return true
		}

		function callBtnPostAssign(){
			if(checkTime()){
				dueAlert.style.display = "none"
				if (checkRegex()){
					assignAlert.style.display = "none"
					btnSumitAssign.click()
				}
				else{
					assignAlert.style.display = ""
				}
			}else{
				dueAlert.style.display = ""
			}
		
		}

		function checkRegex(){
			let str = linkAssign.value
			let regex = /(?:https?\:\/\/docs.google.com.forms.d.e\/)|(?:https?\:\/\/forms.gle\/)/
			let result = str.match(regex);
			if (result!=null){
				return true
			}
			return false
		}

		function postNewPost(){

			let file = filePost.files[0]
			let fd = new FormData();
			fd.append('FILE', file)
			fd.append('ID_CLASS',idClass)
			fd.append('TITLE',titlePost.value)
			fd.append('DES',desPost.value)
			fd.append('DUE','')
			fd.append('TYPE','POST')
			fd.append('URL_FORM','')
			$.ajax({
				type:"POST",
				url:"postMaterial.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					console.log(response)
					if (response==="Insert success") {
						$("#streamTab").load("../stream/stream.php");
					}
					$("#modalPost .close").click();
					$("#modalPost .close").trigger("click"); 
				},
				fail: function(xhr, textStatus, errorThrown){
					$("#modalPost .close").click();
					$("#modalPost .close").trigger("click"); 
				}
			});
		}

		function postNewAssign(){
			let file = fileAssign.files[0]
			let fd = new FormData();
			fd.append('FILE', file)
			fd.append('ID_CLASS',idClass)
			fd.append('TITLE',titleAssign.value)
			fd.append('DES',desAssign.value)
			fd.append('DUE',dueAssign.value)
			fd.append('TYPE','ASSIGN')
			fd.append('URL_FORM',linkAssign.value)
			$.ajax({
				type:"POST",
				url:"postMaterial.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					console.log(response)
					if (response==="Insert success") {
						$("#streamTab").load("../stream/stream.php");
					}
					$("#modalAssignment .close").click();
					$("#modalAssignment .close").trigger("click"); 
				},
				fail: function(xhr, textStatus, errorThrown){
					$("#modalAssignment .close").click();
					$("#modalAssignment .close").trigger("click"); 
				}
			});
		}

		function deleteTextInputPost(){  
			titlePost.value = ''
			desPost.value = ''
			filePost.value = ''
			$(".custom-file-input").siblings(".custom-file-label").addClass("selected").html('Choose file')
		}

		function deletTeTextInputAssignment(){
			assignAlert.style.display = "none"
			dueAlert.style.display = "none"
			titleAssign.value = ''
			linkAssign.value = ''
    		desAssign.value = ''
    		fileAssign.value = ''
    		dueAssign.value = ''
    		$(".custom-file-input").siblings(".custom-file-label").addClass("selected").html('Choose file')

		}
    </script>

</head>
<body>

	<div>
		<nav class="navbar navbar-expand-lg fixed-top navClassroom" style="padding: 20px;"> 
	  		<ul class="navbar-nav nav nav-tabs navTab">
				<li class="nav-item">
		      		<a href="../home/home.php">
		      			<img src="../img/brand.png" style="width: auto; height: 36px">
		      		</a>
			    </li>
			    <li class="nav-item stream">
					<a class="nav-link active" data-toggle="tab" href="#streamTab">Stream</a>
				</li>
				<li class="nav-item people">
					<a class="nav-link" data-toggle="tab" href="#peopleTab">People</a>
				</li>
		  	</ul>
		  	<ul class="nav-right navbar-nav ml-auto navRightHome">
				<li class="nav-item">
					<div class="dropdown">
				       	<button class="btn" data-toggle="dropdown" data-target="#assignment" aria-expanded="true" id="btnAssignment" href="#">
				       		<i class="fas fa-plus"></i>
				       	</button>				       	
				        <div class="dropdown-menu dropdown-menu-lg-right dropdown-add" aria-expanded="true" id = "assignment" aria-labelledby="btnAssignment">
						    <a class="dropdown-item" data-toggle="modal" href="#modalAssignment" style="font-weight: bold;">Assignment</a>
						    <div class="dropdown-divider"></div>
						    <a class="dropdown-item" data-toggle="modal" href="#modalPost" style="font-weight: bold;">Post
						    </a>
						</div>
					</div>
			    </li>
			   	<li class="nav-item">
			       	<div class="dropdown">
				       	<button class="btn" data-toggle="dropdown" id="profile">
				       		<i class="fas fa-info-circle"></i>
				       	</button>				       	
				        <div class="dropdown-menu dropdown-menu-lg-right  dropdown-profile" aria-expanded="true" aria-labelledby="profile">
						    <a class="dropdown-item logout" data-toggle="modal" href="#" style="font-weight: bold;" onclick="logOut()">Logout</a>
						</div>
					</div>
			    </li>
		  	</ul>
		</nav>

	</div>

	<main role="main" class="container">
      	<div class="tab-content">
        	<div class="tab-pane active" id="streamTab">
        	</div>
        	<div class="tab-pane" id="peopleTab">
        	</div>
      	</div>
    </main>

	<div class="modal" style="margin-top: 20px" id="modalAssignment" tabindex="-1" role="dialog">
		<div class="modal-dialog " role="document">
	    	<div class="modal-content w-75">
	      		<div class="modal-header">
	        		<h5 class="modal-title modelTitle">Assignment</h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	         			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
		      	<div class="modal-body">
		        	<form method="post" class="form-signin" onsubmit='postNewAssign();return false'>
		        		<label class="labelClassroom" for="assignmentTitle">Title</label>
						<input type="text" class="form-control" id="assignmentTitle" placeholder="Title" required>
						<label class="labelClassroom" for="assignmentLink" style="margin-top: 10px">Assignment</label>
						<input type="url" class="form-control" id="assignmentLink" placeholder="Link Google Form" 
						 required>
						<p id="assignAlert" style="color: red; margin-top: 5px; margin-bottom: 0px; display: none; font-size: 14px;">Your Google Form link is invalid!</p>
						<label class="labelClassroom" for="assignmentDescription" style="margin-top: 10px">Description</label>
						<textarea class="form-control" id="assignmentDescription" placeholder="Description (optional)" rows="3"></textarea>
						<label class="labelClassroom" for="custom-file" style="margin-top: 10px; display: block;">Add your file</label>
						<div class="custom-file" style=" display: block;">
							<label class="custom-file-label labelClassroom" for="custom-file-assignment">Choose file</label>
							<input type='file' name="custom-file" class="custom-file-input" id="custom-file-assignment" multiple="multiple" >		
						</div>	
							
						<label class="labelClassroom" for="due" style="margin-top: 10px; margin-right: 20px">Due</label>
 						<input type="datetime-local" style="margin-top: 20px;" name="due" id="dueAssign" required>
 						<p id="dueAlert" style="color: red; margin-top: 5px; margin-bottom: 0px; font-size: 14px; display: none">Time assignment is invalid!</p>
 						

 						<button type="submit" style="display: none;" id="btnSumitAssign"></button>
					</form>

		      	</div>
		      	<div class="modal-footer">
		      		<button type="button" class="btn postAssignment" style="background-color: #43437B;color: white; float: right;" onclick="callBtnPostAssign()">Post
			        </button>			        
		      	</div>
	    	</div>
	  	</div>
	</div>

	
	<div class="modal" style="margin-top: 50px" id="modalPost" tabindex="-1" role="dialog">
		<div class="modal-dialog " role="document">
	    	<div class="modal-content w-75">
	      		<div class="modal-header">
	        		<h5 class="modal-title modelTitle">Post</h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	         			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
		      	<div class="modal-body">
		        	<form method="post" class="form-signin" onsubmit='postNewPost();return false'>
		        		<label for="postTitle">Title</label>
						<input type="text" class="form-control" id="postTitle" placeholder="Title" required>
						<label for="postDescription" style="margin-top: 10px">Description</label>
						<textarea class="form-control" id="postDescription" placeholder="Description (optional)" rows="3"></textarea>
						<label for="custom-file" style="margin-top: 10px; display: block;">Add your file</label>
						<div class="custom-file" style=" display: block;">
							<label class="custom-file-label" for="custom-file-post">Choose file</label>
							<input type='file' name="custom-file" class="custom-file-input" id="custom-file-post" multiple="multiple">		
						</div>
						<button type="submit" style="display: none;" id="btnSumitPost"></button>
					</form>
		      	</div>
		      	<div class="modal-footer">
			        <button type="button" class="btn postpost" style="background-color: #43437B;color: white;" onclick="callBtnPostPost()">Post
			        </button>			        
		      	</div>
	    	</div>
	  	</div>
	</div>
	
</body>
</html>