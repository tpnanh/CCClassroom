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
    <title>Edit Material- CC Classroom</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="img/thumbnail.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="../main.js"></script> 
	<link rel="stylesheet" type="text/css" href="../style.css">

	<script>
		let idMaterial
		let idClass
		let title
		let linkAssign;
    	let assignAlert;
		let description
		let customFile
		let time
		let link
		let downFile
		let deleteFile
		let labelDue
		let nameFileOld = ""
		let labelAssignment
		let dueAlert
		window.onload = function(){
			makeTextInputFile()
			title = document.getElementById('title')
			linkAssign = document.getElementById('assignLink')
    		assignAlert = document.getElementById('assignAlert')
    		dueAlert = document.getElementById('dueAlert')
			description = document.getElementById('description')
			customFile = document.getElementById('custom_file')
			time = document.getElementById('time')
			link = document.getElementById('link')
			downFile = document.getElementById('downFile')
			deleteFile = document.getElementById('deleteFile')
			labelDue = document.getElementById('labelDue')
			labelAssignment = document.getElementById('labelAssignment')
			getUrl()
			getInfoMaterial()
		}

		function getUrl(){
            idMaterial = getParameterByName('idMaterial');
            idClass = getParameterByName('idClass');
        }

        function getInfoMaterial(){
        	getInfoMaterialPost(idMaterial, idClass).then(function(response){
				if (response==="Post/Assignment not found") {
					window.location.href="../home/home.php"
				}else{
					let result = JSON.parse(response)
					title.value = result.title
					description.value = result.des.replace(new RegExp('<br />', 'g'),"")
					if (result.type==="ASSIGN") {
						time.style.display = ""
						time.value = result.due
						linkAssign.style.display = ""
						linkAssign.value = result.url_form
					}else{
						time.style.display = "none"
						labelDue.style.display = "none"
						linkAssign.style.display = "none"
						labelAssignment.style.display = "none"
					}
					if (result.nameFile!="") {
						nameFileOld = result.nameFile
						link.innerHTML = "File previous: "+result.nameFile
						downFile.href = "../Uploads/files/"+idClass+"/"+result.nameFile
					}else{
						downFile.style.display = "none"
    					deleteFile.style.display = "none"
					}
				}
			})
        }

        function updatePost(){
        	if (checkTime(time.value) || time.style.display === "none") {
        		dueAlert.style.display = "none"
        		if (checkRegex(linkAssign.value) || linkAssign.style.display === "none"){
					assignAlert.style.display = "none"
					let file = customFile.files[0]
					updateInfoMaterialPost(idClass, idMaterial, title.value, description.value, time.value, file, nameFileOld, linkAssign.value ).then(function(response){
						if (response==="Update success") {
							history.go(-1)
						}
					})
		        }else{
					assignAlert.style.display = ""
				}
			}else{
				dueAlert.style.display = ""
        	}
        }

        function deleteViewFile(view){
        	nameFileOld = ""
        	downFile.style.display = "none"
        	view.style.display = "none"
        }
	</script>

	
</head>
<body class="text-center bodyLogin">
	<form method="post" class="form-signin formSigninProfile" enctype="multipart/form-data" onsubmit='updatePost();return false'>
		<img class="imgProfile" src="../img/icon.png" alt="icon" width="auto" height="60">
		<h3 class="createClass"><b>Edit Material</b></h3>
		<label class="labelSignUp" for="title">Title</label>
		<input type="text" class="form-control formControlLogin inputPassLogin" id="title" placeholder="Title" required maxlength="100">
		<label class="labelSignUp" for="assignLink" style="margin-top: 10px" id="labelAssignment">Assignment</label>
		<input type="url" class="form-control formControlLogin inputPassLogin" id="assignLink" placeholder="Link Google Form">
		<p id="assignAlert" style="color: red; margin-top: 5px; margin-bottom: 0px; justify-content: flex-start; font-size: 14px; text-align: left; display: none">Your Google Form link is invalid!</p>
		<label class="labelSignUp" for="description" style="margin-top: 10px">Description</label>
		<textarea class="form-control formControlLogin" id="description" placeholder="Description (optional)" wrap="hard" rows="3" maxlength="1000"></textarea>
		<label class="labelSignUp" for="custom-file" style="margin-top: 10px; display: block;">Add your file</label>
		<p id="nameFileOld"></p>
		<a id="deleteFile" style="float: right;margin-right: 8px;" onclick="deleteViewFile(this)">
	  	 	<i class="fas fa-minus-circle"></i>
  	 	</a>
		<a href="../file/plan.pdf" style="text-align: left;" id="downFile" download>
			<p id="link">plan.pdf</p>
		</a>
		<div class="custom-file" style="text-overflow: ellipsis;" style=" display: block;">
			<label class="custom-file-label labelSignUp" width="100%" style="margin:0px;" for="custom-file">Choose file</label>
			<input type='file' name="custom-file" style="text-overflow: ellipsis;" class="custom-file-input inputPassLogin" id="custom_file" multiple="multiple">		
		</div>
		<label class="labelSignUp" for="due" style="margin-top: 25px; margin-right: 10px; float: left" id="labelDue">Due</label>
		<input class="inputPassLogin" type="datetime-local" style="margin-top: 20px;width: 88%" name="due" id="time">
		<p id="dueAlert" style="color: red; margin-top: 5px; margin-bottom: 0px; justify-content: flex-start; font-size: 14px; text-align: left;display: none">Time assignment is invalid!</p>
		<button class="btn btnSaveProfile btn-md btn-block" type="submit" name="submit">Save</button>
		<div class="alert alertSignUp alert-success" style="display: none;" id="alter-success">Information has been updated</div>
	</form>

	
</body>
</html>