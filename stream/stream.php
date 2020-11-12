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

	<style>
		.container{
			margin-top: 70px;	
		}
		.card{
			padding: 0px;
			margin-top: 20px;
		}
		.col-lg{
			margin-top: 15px;
			border: 1px solid #50a350;

		}
		a:hover{
			text-decoration: none;
		}
		a:active{
			text-decoration: none;
		}
		h6{
			color: black;
			padding: 2px;
			display: block;
		}
		.col-lg p{
			color: black;
			font-size: 14px;
		}
		.dropdown-item{
			font-size: 13px;
			font-weight: bold;
		}
	</style>
	<script>
		try{
			let cardNameClass;
			let cardSubjectClass;
			let cardRoomClass;
			let streamList;
			let emailClassOfUser = '';
			let emailCurrentUser = '';
			let roleCurrentUser = '';
			getIdElement()
		}
		catch(err){
			getStream()
		}
		
		function getIdElement(){
			cardNameClass = document.getElementById('cardNameClass')
			cardSubjectClass = document.getElementById('cardSubjectClass')
			cardRoomClass = document.getElementById('cardRoomClass')
			stream = document.getElementById('stream')
			emailCurrentUser = '<?= $user['email'] ?>';
			roleCurrentUser = '<?= $user['role'] ?>';
			getDataClassById()
			getStream()
			// var d = new Date();
			// var n = d.toUTCString();
			// console.log(n)
		}

		function getDataClassById(){
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
						cardNameClass.innerHTML = result.name_class
						cardSubjectClass.innerHTML = result.subject
						cardRoomClass.innerHTML = result.room
						emailClassOfUser = result.email
					}
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
		}

		function getStream(){
			$.ajax({
				type:"GET",
				url:"../stream/getStream.php?",
				data: { 
        			id: idClass
    			},
				success: function (response) {
					
					if (response==="Classroom not found") {
						//window.location.href="../home/home.php"
					}else{
						let result = JSON.parse(response)
						console.log(result)
						for (i = 0; i < result.length; i++) {
							appendViewIntoTable(result[i])
						}
					}
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
		}

		function appendViewIntoTable(data){
			let div = document.createElement('div')
			div.classList.add('card','col-lg-12')

			let div1 = document.createElement('div')
			div1.classList.add('card-header')

			let a = document.createElement('a')
			a.href = "../postDetail/postDetail.html"
			a.style.backgroundColor = "transparent"

			let img = document.createElement('img')
			if (data.type === "POST") {
				img.src = "../img/postt.png"
			}else{
				img.src = "../img/due.png"
			}

			img.alt = "avatar"
			img.width = "60"
			img.height = "60"
			img.style.float = "left"
			img.style.margin = "25px"
			img.style.marginRight = "20px"
			a.appendChild(img)

			let h6 = document.createElement('h6')
			h6.classList.add('card-subtitle')
			h6.style.marginTop = "30px"
			if (data.type === "POST") {
				h6.innerHTML = data.email + ' posted a new material: '+data.title
			}else{
				h6.innerHTML = data.email + ' posted a new assignment: '+data.title
			}
			
			a.appendChild(h6)

			
			let date = new Date(data.dateCreate).toDateString()
			let [, month, day, year] = date.split(' ')
			let MmDD = `${month} ${day}`
			let p1 = document.createElement('p')
			p1.innerHTML = MmDD

			a.appendChild(p1)
			div1.appendChild(a)

			if (roleCurrentUser === "Admin" || emailCurrentUser === data.email || emailCurrentUser === emailClassOfUser) {
				let div2 = document.createElement('div')
				div2.classList.add('card-img-overlay','ml-auto')
				div2.style.maxHeight = "30px"
				div2.style.maxWidth = "30px"

				let a2 = document.createElement('div')
				a2.href = "#"
				a2.setAttribute("data-toggle", "dropdown");
				a2.id = "postOption"
				a2.style.float = "right"

				let i = document.createElement('i')
				i.classList.add('fas','fa-ellipsis-v')
				i.style.color = "black"
				a2.appendChild(i)
				div2.appendChild(a2)

				let div3 = document.createElement('div')
				div3.classList.add('dropdown-menu','dropdown-menu-right')
				div3.setAttribute("aria-expanded", 'true')
				div3.setAttribute("aria-labelledby", 'postOption')

				let a3 = document.createElement('a')
				a3.classList.add('dropdown-item')
				a3.href = "../editPost/editPost.html"
				a3.style.fontWeight = "bold"
				a3.innerHTML = "Edit"
				div3.appendChild(a3)

				let div4 = document.createElement('div')
				div4.classList.add('dropdown-divider')
				div3.appendChild(div4)

				let a4 = document.createElement('a')
				a4.classList.add('dropdown-item')
				a4.href = "#"
				a4.style.fontWeight = "bold"
				a4.innerHTML = "Delete"
				div3.appendChild(a4)
				div2.appendChild(div3)
				div1.appendChild(div2)
			}

			
			div.appendChild(div1)
			stream.appendChild(div)
		}
		

		
	</script>
</head>

<body>
	<div class="container">
		<div class="row" id="stream">
		  	<div class="card col-lg-12">
			  	<div class="card-header" style="background-color: #087043">			
			      	<h4 class="card-title" id="cardNameClass">HK1_2020_505404_WEB</h5>
			      	<h5 class="card-subtitle" id="cardSubjectClass">Lập trình web và ứng dụng</h6>
			      	<p class="card-text" style="font-size: 15px;margin-top: 5px" id="cardRoomClass">Phòng B206-A</p>
			  	</div>	
			</div>	 
		<!-- 	<div class="card col-lg-12">
			  	<div class="card-header">		
			  		<a  href="../postDetail/postDetail.html" style="background-color: transparent;">	
				      	<img src="../img/postt.png" alt="avatar" width="60" height="60" style="float: left; margin: 25px; margin-right: 20px;"> 
				      	<h6 class="card-subtitle" style="margin-top: 30px;">MVM posted a new material: Restful Web Service</h6>
				      	<p>Nov 3</p>
			      	</a>			      	
			  	</div>
			  	<div class="card-img-overlay ml-auto" style="max-height: 30px;max-width: 30px;">
					<a href="#" data-toggle="dropdown" id="postOption" style="float: right;">
			  	 		<i class="fas fa-ellipsis-v" style="color: black"></i>
			  	 	</a>
			  	 	<div class="dropdown-menu dropdown-menu-right" aria-expanded="true" aria-labelledby="postOption">
					    <a class="dropdown-item" href="../editPost/editPost.html" style="font-weight: bold;">Edit</a>
					    <div class="dropdown-divider"></div>
					    <a class="dropdown-item" data-toggle="modal" href="#" style="font-weight: bold;">Delete</a>
					</div>
			  	</div>
			</div>	
			<div class="card col-lg-12">
			  	<div class="card-header">		
			  		<a  href="../postDetail/postDetail.html" style="background-color: transparent;">	
				      	<img src="../img/due.png" alt="avatar" width="60" height="60" style="float: left; margin: 25px; margin-right: 20px;"> 
				      	<h6 class="card-subtitle" style="margin-top: 30px;">MVM posted a new assignment: Đồ án cuối kì</h6>
				      	<p>Nov 3</p>
			      	</a>			      	
			  	</div>
			  	<div class="card-img-overlay ml-auto" style="max-height: 30px;max-width: 30px;">
					<a href="#" data-toggle="dropdown" id="postOption" style="float: right;">
			  	 		<i class="fas fa-ellipsis-v" style="color: black"></i>
			  	 	</a>
			  	 	<div class="dropdown-menu dropdown-menu-right" aria-expanded="true" aria-labelledby="postOption">
					    <a class="dropdown-item" href="#" style="font-weight: bold;">Edit</a>
					    <div class="dropdown-divider"></div>
					    <a class="dropdown-item" data-toggle="modal" href="#" style="font-weight: bold;">Delete</a>
					</div>
			  	</div>
			</div> -->	
		</div>
	</div> 
	

</body>
</html>