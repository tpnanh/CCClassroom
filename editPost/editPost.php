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

	<style>	
		body {
			color: #43437B;
			display: flex;
			justify-content: center;
			padding-bottom: 80px;
			height: 100%;
			width: 100%;
			font-family:verdana;
		}
		
		img{
			margin-bottom: 20px;
		}
		i{
			font-size: 18px;
			color: gray;
		}

		.form-signin {
			width: 35%;
			margin: 30px;
		}	
		
		.form-control{
			position: relative;
			box-sizing: border-box;
			height: auto;
			margin-top: 5px;
			font-size: 14px;
		}
		
		.form-control:focus {
			z-index: 2;
		}
		
		label{
			display: block;
			text-align: left;
			margin-top: 20px;
			color: #43437B;
			font-size: 13px;
			font-weight: bold;
		}
		
		.custom-file-label{
			margin: 0;
		}
		
		input{		
			margin-bottom: 10px;
			border-bottom-right-radius: 0;
			border-bottom-left-radius: 0;
		}
		
		.btn:hover{
			background-color: #43437B;
			color: white;
			margin-top: 20px;
		}
		
		.btn{
			color: white;
			background-color: #7492c4;
			margin-top: 20px;
		}
		
		.alert{
			margin-top: 15px;
			font-size: 15px;
		}
	</style>

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
		window.onload = function(){
			makeTextInputFile()
			title = document.getElementById('title')
			linkAssign = document.getElementById('assignLink')
    		assignAlert = document.getElementById('assignAlert')
			description = document.getElementById('description')
			customFile = document.getElementById('custom_file')
			time = document.getElementById('time')
			link = document.getElementById('link')
			downFile = document.getElementById('downFile')
			deleteFile = document.getElementById('deleteFile')
			labelDue = document.getElementById('labelDue')
			getUrl()
			getInfoMaterial()
		}

		function makeTextInputFile(){
			$(".custom-file-input").on("change", function() {
			  let fileName = $(this).val().split("\\").pop();
			  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
			});
		}

		function getUrl(){
            idMaterial = getParameterByName('idMaterial');
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

        function getInfoMaterial(){
        	$.ajax({
				type:"GET",
				url:"getMaterial.php?",
				data: { 
        			id: idMaterial,
        			idClass: idClass
    			},
				success: function (response) {
					if (response==="Post/Assignment not found") {
						window.location.href="../home/home.php"
					}else{
						let result = JSON.parse(response)
						title.value = result.title
						description.value = result.des
						if (result.type==="ASSIGN") {
							time.style.display = ""
							time.value = result.due
						}else{
							time.style.display = "none"
							labelDue.style.display = "none"
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
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
        }

        function updatePost(){
        	if (checkRegex()){
				assignAlert.style.display = "none"
				let file = customFile.files[0]
				let fd = new FormData();
				fd.append('ID_CLASS',idClass)
				fd.append('ID_MATERIAL',idMaterial)
				fd.append('TITLE',title.value)
				fd.append('DES',description.value)
				fd.append('DUE',time.value)
				fd.append('FILE', file)
				fd.append('OLD_FILE',nameFileOld)

	        	$.ajax({
					type:"POST",
					url:"updateMaterial.php",
					cache: false,
	                contentType: false,
	                processData: false,
					data:fd,
					success: function (response) {
						console.log(response)
						if (response==="Update success") {
							history.go(-1)
						}
					},
					fail: function(xhr, textStatus, errorThrown){
					}
				});
			}
			else{
				assignAlert.style.display = ""
			}
        	
        }

        function deleteViewFile(view){
        	nameFileOld = ""
        	downFile.style.display = "none"
        	view.style.display = "none"
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
	</script>

	
</head>
<body class="text-center">
	<form method="post" class="form-signin" enctype="multipart/form-data" onsubmit='updatePost();return false'>
		<img src="../img/icon.png" alt="icon" width="auto" height="60">
		<h3 class="createClass"><b>Edit Material</b></h3>
		<label for="title">Title</label>
		<input type="text" class="form-control" id="title" placeholder="Title" required >
		<label for="assignLink" style="margin-top: 10px">Assignment</label>
		<input type="url" class="form-control" id="assignLink" placeholder="Link Google Form" required>
		<p id="assignAlert" style="color: red; margin-top: 5px; margin-bottom: 0px; justify-content: flex-start; display: none; font-size: 14px;">Your Google Form link is invalid!</p>
		<label for="description" style="margin-top: 10px">Description</label>
		<textarea class="form-control" id="description" placeholder="Description (optional)"></textarea>
		<label for="custom-file" style="margin-top: 10px; display: block;">Add your file</label>
		<p id="nameFileOld"></p>
		<a id="deleteFile" style="float: right;margin-right: 8px;" onclick="deleteViewFile(this)">
	  	 	<i class="fas fa-minus-circle"></i>
  	 	</a>
		<a href="../file/plan.pdf" style="text-align: left;" id="downFile" download">
			<p id="link">plan.pdf</p>
		</a>
		<div class="custom-file" style=" display: block;">
			<label class="custom-file-label" for="custom-file">Choose file</label>
			<input type='file' name="custom-file" class="custom-file-input" id="custom_file" multiple="multiple">		
		</div>
		<label for="due" style="margin-top: 25px; margin-right: 10px; float: left" id="labelDue">Due</label>
		<input type="datetime-local" style="margin-top: 20px;width: 88%" name="due" id="time">
		<button class="btn btn-md btn-block" type="submit" name="submit">Save</button>
		<div class="alert alert-success" style="display: none;" id="alter-success">Information has been updated</div>
	</form>

	
</body>
</html>