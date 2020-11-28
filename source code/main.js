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