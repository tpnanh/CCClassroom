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

function getListUserWeb(){
	return new Promise((resolve, reject)=>{
		$.ajax({
			type:"GET",
			url:"getAllUser.php",
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

function findUserWeb(keyword){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('KEY_WORD', keyword)
		$.ajax({
			type:"POST",
			url:"findUser.php",
			cache: false,
            contentType: false,
            processData: false,
			data:fd,
			success: function (response) {
				let result = JSON.parse(response)
				resolve(result)
				
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function savePermissionUser(email, role){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('Email', email)
		fd.append('Role', role)
		$.ajax({
			type:"POST",
			url:"updateRoleUser.php",
			cache: false,
            contentType: false,
            processData: false,
			data:fd,
			success: function (response) {
				let result = JSON.parse(response)
				resolve(result)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function deleteUserWeb(email){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('Email', email)
		$.ajax({
			type:"POST",
			url:"deleteUser.php",
			cache: false,
	        contentType: false,
	        processData: false,
			data:fd,
			success: function (response) {
				resolve("Delete user success")
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function compressFileImage(file){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('avatar', file)

		$.ajax({
			type:"POST",
			url:"../img/base64ImageEncode.php",
			cache: false,
            contentType: false,
            processData: false,
			data:fd,
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
				resolve("Request failed")
			}
		});
	})
}

function updateProfileUser(email, userName,fullname,birth,phone,imageAvatar){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('EMAIL',email)
		fd.append('USER_NAME',userName)
		fd.append('FULL_NAME',fullname)
		fd.append('BIRTH',birth)
		fd.append('PHONE',phone)
		fd.append('AVATAR', imageAvatar)

		$.ajax({
			type:"POST",
			url:"updateProfile.php",
			cache: false,
            contentType: false,
            processData: false,
			data:fd,
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
				resolve("Request failed")
			}
		});
	})
}

function createClassroom(file, className, subject, room){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('avatar', file)
		fd.append('CLASS_NAME', className)
		fd.append('SUBJECT', subject)
		fd.append('ROOM', room)

		$.ajax({
			type:"POST",
			url:"createClassroomFunction.php",
			cache: false,
            contentType: false,
            processData: false,
			data:fd,
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
				resolve("Request failed")
			}
		});
	})
}

function updatePasswordUser(newPass, confirmPass, oldPass){
	return new Promise((resolve, reject)=>{
		if (newPass != confirmPass) {
			resolve("Password and confirm password not match")
		}else if(newPass.length<8){
			resolve("New password must longer 8 characters")
		}else{
			let fd = new FormData();
			fd.append('PASS',newPass)
			fd.append('OLD_PASS',oldPass)

			$.ajax({
				type:"POST",
				url:"changePasswordFuction.php",
				cache: false,
                contentType: false,
                processData: false,
				data:fd,
				success: function (response) {
					resolve(response)
				},
				fail: function(xhr, textStatus, errorThrown){
					resolve("Request failed")
				}
			});
		}
	})
}

function postStreamPost(file, idClass, titlePost, desPost){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('FILE', file)
		fd.append('ID_CLASS',idClass)
		fd.append('TITLE',titlePost)
		fd.append('DES',desPost)
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
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function postStreamAssign(file, idClass, titleAssign, desAssign, dueAssign, linkAssign){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('FILE', file)
		fd.append('ID_CLASS',idClass)
		fd.append('TITLE',titleAssign)
		fd.append('DES',desAssign)
		fd.append('DUE',dueAssign)
		fd.append('TYPE','ASSIGN')
		fd.append('URL_FORM',linkAssign)
		$.ajax({
			type:"POST",
			url:"postMaterial.php",
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

function getDataClassroomById(idClass){
	return new Promise((resolve, reject)=>{
		$.ajax({
			type:"GET",
			url:"../stream/getInfoClass.php?",
			data: { 
    			id: idClass
			},
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function getDataStream(idClass){
	return new Promise((resolve, reject)=>{
		$.ajax({
			type:"GET",
			url:"../stream/getStream.php?",
			data: { 
    			id: idClass
			},
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function deleteItemStream(idMaterial,idClass){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('ID_CLASS', idClass)
		fd.append('ID_MATERIAL', idMaterial)
		$.ajax({
			type:"POST",
			url:"../classroom/deleteMaterial.php",
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

function getPeopleOfClass(idClass){
	return new Promise((resolve, reject)=>{
		$.ajax({
			type:"GET",
			url:"../people/getUserOfClass.php?",
			data: { 
    			id: idClass
			},
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function deleteUserFromClass(idClass, email){
	return new Promise((resolve, reject)=>{
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
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function addPeopleToClass(idClass, inputAddUser){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('ID', idClass)
		fd.append('EMAIL', inputAddUser)
		$.ajax({
			type:"POST",
			url:"../people/addPeople.php",
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

function findUserInClass(idClass, inputTextFindView){
	return new Promise((resolve, reject)=>{
		$.ajax({
			type:"GET",
			url:"../people/findUser.php?",
			data: { 
    			ID: idClass,
    			KEY_WORD: inputTextFindView
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

function updateInfoClassroom(idClass, imageAvatar, className, subject, room){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('id',idClass)
		fd.append('avatar', imageAvatar)
		fd.append('CLASS_NAME', className)
		fd.append('SUBJECT', subject)
		fd.append('ROOM', room)

		$.ajax({
			type:"POST",
			url:"updateClassroom.php",
			cache: false,
            contentType: false,
            processData: false,
			data:fd,
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
				error("Request failed")
			}
		});
	})
}

function getInfoMaterialPost(idMaterial,idClass){
	return new Promise((resolve, reject)=>{
		$.ajax({
			type:"GET",
			url:"getMaterial.php?",
			data: { 
    			id: idMaterial,
    			idClass: idClass
			},
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function updateInfoMaterialPost(idClass, idMaterial, title, description, time, file, nameFileOld, linkAssign){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('ID_CLASS',idClass)
		fd.append('ID_MATERIAL',idMaterial)
		fd.append('TITLE',title)
		fd.append('DES',description)
		fd.append('DUE',time)
		fd.append('FILE', file)
		fd.append('OLD_FILE',nameFileOld)
		fd.append('URL_FORM',linkAssign)

    	$.ajax({
			type:"POST",
			url:"updateMaterial.php",
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

function getInfoPostDetail(idPost){
	return new Promise((resolve, reject)=>{
		$.ajax({
			type:"GET",
			url:"getInfoPost.php?",
			data: { 
    			ID_POST: idPost
			},
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function addCommentToPost(comment, idPost){
	return new Promise((resolve, reject)=>{
		let fd = new FormData();
		fd.append('CONTENT', comment)
		fd.append('MATERIAL', idPost)
		$.ajax({
			type:"POST",
			url:"addComment.php",
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

function getListCommentPost(idPost){
	return new Promise((resolve, reject)=>{
		$.ajax({
			type:"GET",
			url:"getListComment.php?",
			data: { 
    			ID_MATERIAL: idPost
			},
			success: function (response) {
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
}

function deleteCommentPost(idComment){
	return new Promise((resolve, reject)=>{
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
				resolve(response)
			},
			fail: function(xhr, textStatus, errorThrown){
			}
		});
	})
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

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function checkTime(value){
	let timeNow = new Date()
	let timeChoose = new Date(value)
	if (timeNow > timeChoose) {
		return false
	}
	return true
}

function checkRegex(value){
	let str = value
	let regex = /(?:https?\:\/\/docs.google.com.forms.d.e\/)|(?:https?\:\/\/forms.gle\/)/
	let result = str.match(regex);
	if (result!=null){
		return true
	}
	return false
}

function checkStrJustNumber(value){
	return value.match(/^[0-9]+$/);
}
