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

	<style>
		nav{
			margin: 5px;
		}

		.nav-right li{
			margin-left: 20px;
		}
		.nav-tabs{
			z-index: 2;
		    float: left;
		    width: 100%;
		    text-align: center;
		}
		.container {
		  	display: flex;
		  	justify-content: center;
		  	margin-top: 80px;
		  	margin-bottom: 50px;
		  	margin-left: 100px;
		  	width: 100%;
		  	padding: 0px;
		}
		.center {
		 	width: 80%;
		}
		body{
			width: 100%;
		}
		i{
			font-size: 16px;
			margin-top: 8px;
		}
		h3{
			color: #087043;			
		}
		p{
			color: gray;
			font-weight: 400;
		}
		#time{
			margin-top: 3px;
			font-size: 14px;
		}
		.first-line{
			color: #087043;
			background-color: #087043;
			height: 1px;
			border-width:0
		}
		.second-line{
			color: lightgray;
			background-color: lightgray;
			height: 2px;
			border-width:0;
		}
		.third-line{
			color: lightgray;
			background-color: lightgray;
			height: 1px;
			border-width:0;
			margin-top: 0px;
		}
		#description{
			color: black;
			font-size: 14px;
			line-height: 1.6;
			margin-bottom: 2px;
		}
		#link{
			color: blue;
			margin-top: 5px;
		}
		.user{
			font-weight: bold;
			font-size: 15px;
		}
		.date{
			font-size: 13px;
			color: gray;
			font-weight: 400;
		}
		.comment{
			margin-left: 60px;
			margin-top: 5px;
			color: black;
			margin-bottom: 0px;
			width: 90%;
		}
		input{
			border-radius: 80px; 
			padding: 9px;
			padding-left: 18px;
			padding-right: 18px;
			margin-left: 8px;
			margin-top: 5px;
			border-top-color: white; 
			border-bottom-color: darkgray; 
			border-left-color: lightgray;
			border-right-color: gray;
			width: 87%;
/*			background-image:url('../img/send.png');
    		background-repeat:no-repeat;
    		background-position: right 14px center;
    		background-size: 23px;*/

		}
		input:focus{
			outline: none;
			border-width: 3px;
		}
		a{
			font-size: 14px;
		}
		/*.turnIn{
			background-color: #214996;
			color: white;
			width: 87%;
			margin-left: 20px;
			margin-right: 10px;
			margin-top: 10px;
			margin-bottom: 20px;
		}
		.turnIn:hover{
			background-color: #2e446e;
			color: white;
		}*/

	</style>

	<script>
		// let url = "https://www.youtube.com/watch?v=5C7rn-FgYTI"
		// function get_youtube($url){

		// 	let youtube = "http://www.youtube.com/oembed?url="+url+"&format=json";

		// 	let curl = curl_init(youtube);
		// 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// 	let return1 = curl_exec($curl);
		// 	curl_close(curl);
		// 	return json_decode($return1, true);

		//  }
		let title, userCreate,timeCreate, timeDue, description, linkFile, nameFile,iconCurrentUser,comment, listComment, labelAssign, linkAssign
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
			$.ajax({
				type:"GET",
				url:"../stream/getInfoClass.php?",
				data: { 
        			id: idClass
    			},
				success: function (response) {
					let result = JSON.parse(response)
					emailClassOfUser = result.email
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			})
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

        function getInfoPost(){
        	$.ajax({
				type:"GET",
				url:"getInfoPost.php?",
				data: { 
        			ID_POST: idPost
    			},
				success: function (response) {
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
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
        }

       	function checkTimeAssign(){
       		if (linkAssign.style.display==="") {
				let timeNow = new Date()
				let timeDeadline = new Date(timeDue.innerHTML)
				if (timeNow > timeDeadline) {
					console.log("Tre deadline")
					timeDue.style.color = "red"
					linkAssign.style.display = "none"
				}else{
					console.log("Chua Tre deadline")
				}
        	}
       	}

        function formateDate(value){
        	let date = new Date(value).toDateString()
			let [, month, day, year] = date.split(' ')
			let MmDD = `${month} ${day}`
			return MmDD
        }

        function formateDate2(value){
        	let date = new Date(value).toDateString()
        	let hour = new Date(value).getHours()
        	let minute = new Date(value).getMinutes()
			let [, month, day, year] = date.split(' ')
			let MmDdYyHhMm = `${month} ${day}, ${year} ${hour}:${minute}`
			return MmDdYyHhMm
        }

        function addComment(){
        	let fd = new FormData();
			fd.append('CONTENT', comment.value)
			fd.append('MATERIAL', idPost)
			$.ajax({
				type:"POST",
				url:"addComment.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					console.log(response)
					comment.value = ""
					getListComment()
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
        }

        function getListComment(){
			
			$.ajax({
				type:"GET",
				url:"getListComment.php?",
				data: { 
        			ID_MATERIAL: idPost
    			},
				success: function (response) {
					removeAllChildNodes(listComment)
					let result = JSON.parse(response)
					for (i = 0; i < result.length; i++) {
					 	addViewComment(result[i])
					}
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
        }

        function addViewComment(data){
        	let div = document.createElement('div')

        	let img = document.createElement('img')
        	img.classList.add('rounded-circle')
        	img.alt = "avatar"
        	img.width = "50"
        	img.style.float = "left"
        	img.src = data.avatar
        	div.appendChild(img)

        	let spanName = document.createElement('span')
        	spanName.classList.add('user','card-subtitle')
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
			p.innerHTML = data.content
			div.appendChild(p)
			listComment.appendChild(div)
        }

        function deleteComment(view,idComment){
        	let fd = new FormData();
			fd.append('ID_COMMENT', idComment)
			$.ajax({
				type:"POST",
				url:"deleteComment.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					console.log(response)
					if (response==="Delete comment success") {
						view.parentNode.parentNode.remove()
					}
				},
				fail: function(xhr, textStatus, errorThrown){
				}
			});
        }

        function removeAllChildNodes(parent) {
    		while (parent.firstChild) {
        		parent.removeChild(parent.firstChild);
    		}
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
		<nav class="navbar navbar-expand-sm fixed-top" style="background-color: white"> 
	  		<ul class="navbar-nav nav nav-tabs">
				<li class="nav-item">
		      		<a href="../classroom/classroom.php">
		      			<img src="../img/brand.png" style="width: auto; height: 36px">
		      		</a>
			    </li>
		  	</ul>
		  	<ul class="nav-right navbar-nav ml-auto">				
			   	<li class="nav-item">
			       	<div class="dropdown">
				       	<button class="btn" data-toggle="dropdown" id="profile">
				       		<i class="fas fa-info-circle"></i>
				       	</button>				       	
				        <div class="dropdown-menu dropdown-menu-lg-right  dropdown-profile" aria-expanded="true" aria-labelledby="profile">
						    <a class="dropdown-item logout"  onclick="logOut()" data-toggle="modal" href="#" style="font-weight: bold;">Logout</a>
						</div>
					</div>
			    </li>
		  	</ul>
		</nav>
	</div>
<!-- 	<div class="card" style="width: 22%;float: right; margin-top: 90px; margin-right: 60px;">
		<div class="card-body" style="padding-bottom:0px;">
			<h5 class="card-title" style="float: left">Your work</h5>
			<a href="#"><img src="../img/add_folder.png" style="float: right;" width="25px"></a>
		</div>
		<p style="text-align: right;font-size: 14px; margin-right: 20px;">Due Nov 3</p>
		<div style="margin-left: 20px; margin-right: 20px; border: 1px solid lightgray;" >
			<a href="#" id="addFile" style="float: right;margin-right: 10px;margin-top: 5px;">
	  	 		<i class="fas fa-minus-circle"></i>
  	 		</a>
			<a href="../file/17050202chungtayCoronabayxa.pdf" download>
				<p id="link" style="margin-left: 15px; padding-right:40px;margin-top: 10px;">17050202chungtayCoronabayxa.pdf</p>
			</a>
			
		</div>
		<button class="btn turnIn" type="submit">Turn In</button>
	</div> -->
	<div class="container" >
		<div class="center">
			<h3 id="title">Đề tài đồ án cuối kì</h3>
			<p id="userCreate" style="margin: 0px;">Mai Văn Mạnh</p>
			<p id="timeCreate" style="float: left">Nov 3</p>
			<p id="timeDue" style="text-align: right;font-size: 14px; margin-right: 20px;">Due Nov 3</p>
			<hr class="first-line">
			<p style="font-weight: bold;color: black;margin-bottom: 0px" id="labelAssign">Assignment</p>     
			<a href="https://forms.gle/QCaVodHtHs5xkVWq8" target="_blank" id="linkAssign">https://forms.gle/QCaVodHtHs5xkVWq8</a>
			<p></p>
			<p id="description"> Các em xem mô tả đề tài cuối kỳ trong tập tin đính kèm.
			<br>- Tất cả các nhóm đều làm cùng đề bài này.
			<br>- Deadline nộp bài là 30/11/2020.
			<br>- Nếu có các vấn đề thắc mắc các em trao đổi trực tiếp với thầy.
			<br>- Các nhóm có thể bắt đầu thực hiện từ hôm nay
			</p>
			<a href="../file/plan.pdf" download id="linkFile">
				<p id="nameFile">plan.pdf</p>
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
			      	<p class="comment">Tui comment gì đó nè. Tin bầu cử Tổng thống Mỹ 2020 mới nhất: Tổng thống Mexico nói còn quá sớm để chúc mừng Biden; Chiến dịch của Trump đệ đơn kiện ở Arizona.
			      		Tui comment gì đó nè. Tin bầu cử Tổng thống Mỹ 2020 mới nhất: Tổng thống Mexico nói còn quá sớm để chúc mừng Biden; Chiến dịch của Trump đệ đơn kiện ở Arizona.
					</p>	

		  		</div> -->
			</div>
			
		  	<hr class="third-line">
		  	<div>		
		  		<form onsubmit="addComment();return false;">
					<img src="../img/person_icon.png" id="iconCurrentUser" class="rounded-circle" alt="avatar" width="50" height="50" style="float: left;margin-top: 5px"> 
			      	<input type="text" name="comment" id="comment" placeholder="Add class comment">    
			      	<img src="../img/send.png" width="23px" style="position: right;margin-left: 7px;margin-bottom: 3px" onclick="addComment()">
		      	</form>	
		  	</div>

		  		
		      
		</div>
	</div>
		
</body>
</html>