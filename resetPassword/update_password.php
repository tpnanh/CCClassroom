<?php
	$new_pass = md5($_POST['pass']); 
    $token = $_POST['token'];

    $conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");
    $query = "select email from password_reset where token='$token' LIMIT 1";

    $result = $conn->query($query);
    if ($result->num_rows<=0) {
        echo ("id token not exist");
        exit();
    }
    $delete = "delete from password_reset WHERE token = '$token'";
    if($conn->query($delete)===false){
        echo ("delete token error");
    }else{
        $email = mysqli_fetch_assoc($result)['email'];

        if ($email) {
            $update_mail = "update usercc set password='$new_pass' where email='$email'";
            if($conn->query($update_mail)===false){
                echo ("update error");
            }else{
                echo ("success");  
            }
        }else{
            echo ("error");
        } 
    }
    
    $conn->close();
?> 