 function loginUser(email, password){
 	return new Promise((resolve,reject)=>{
 		let result = ""
	 	let fd = new FormData();
		fd.append('email', email)
		fd.append('password', password)
		$.ajax({
				type:"POST",
				url:"./login/login.php",
				cache: false,
	            contentType: false,
	            processData: false,
				data:fd,
				success: function (response) {
					if (response === "User not found") {
						resolve("User not found") 
					}else if(response === "Password wrong"){
						resolve("Password wrong")
					}else if (response === "Login success"){
						resolve("Login success")
					}else{
						resolve("Error")
					}
				},
				fail: function(xhr, textStatus, errorThrown){
					resolve("Error")
				}
			});
 	})
}

//Make text input file has name
function makeTextInputFile(){
	$(".custom-file-input").on("change", function() {
	  let fileName = $(this).val().split("\\").pop();
	  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
}

 function signUp(confirmPass, pass, file, mail, username, hoTen, birth, sdt){
 	return new Promise((resolve,reject)=>{
 		if(confirmPass !== pass){
			resolve("Password and Confirm password not match") 
		}else if(pass.length<8){
			resolve("Password must longer 8 characters")
		}else{
			let fd = new FormData();
			fd.append('avatar', file)
			fd.append('mail', mail)
			fd.append('pass', pass)
			fd.append('username', username)
			fd.append('hoTen', hoTen)
			fd.append('birth', birth)
			fd.append('sdt', sdt)
			$.ajax({
				type:"POST",
				url:"sign_up.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					console.log(response)
					if(response==="File so big"){
						resolve("File so big")
					}else if(response.includes("Duplicate entry")){
						resolve("Duplicate entry")
					}else if (response === "Insert success"){
						resolve("Insert success")
					}else{
						resolve(response)
					}
				},
				fail: function(xhr, textStatus, errorThrown){
					resolve("Request failed")
				}
			});
			
		}
 	})
}

function sendLinkRsPassword(email){
	return new Promise((resolve,reject)=>{
		let fd = new FormData();
		fd.append('emai', email)
		$.ajax({
			type:"POST",
			url:"send_email_reset_pass.php",
			cache: false,
            contentType: false,
            processData: false,
			data:fd,
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
				resolve("Error") 
			}
		});
 	})
}

function resetPasswordUser(pass, confirmPass,token){
	return new Promise((resolve,reject)=>{
		if(pass!==confirmPass){
			resolve("Password and Confirm password not match")
		}else if(pass.length<8){
			resolve("Password must longer 8 characters")
		}else{
			let fd = new FormData();
			fd.append('token',token)
			fd.append('pass', pass)
			$.ajax({
				type:"POST",
				url:"update_password.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					resolve(response)
				},
				fail: function(xhr, textStatus, errorThrown){
					resolve("Error")
				}
			});
		}
 	})
}

function getAllClassUser(){
	return new Promise((resolve,reject)=>{
		$.ajax({
			type:"GET",
			url:"getClass.php",
			cache: false,
            contentType: false,
            processData: false,
			success: function (response) {
				let result = JSON.parse(response)
				resolve(result)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
 	})
}

function deleteClassById(id){
	return new Promise((resolve,reject)=>{
		let fd = new FormData();
		fd.append('id', id)
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
 	})
}

function joinClassById(id){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('ID', id)
		$.ajax({
			type:"POST",
			url:"joinClass.php",
			cache: false,
            contentType: false,
            processData: false,
			data:fd,
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function userLogOut(){
	return new Promise((resolve, reject)=>{
		$.ajax({
			type:"POST",
			url:"../logOut/logOut.php",
			cache: false,
            contentType: false,
            processData: false,
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function removeAllChildNode(parent) {
	while (parent.firstChild) {
		parent.removeChild(parent.firstChild);
	}
}

function findClassByKeyWord(keyword){
	return new Promise((resolve, reject)=>{
		$.ajax({
			type:"GET",
			url:"findClass.php",
			data: { 
    			KEY_WORD: keyword
			},
			success: function (response) {
				let result = JSON.parse(response)
				resolve(result)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}