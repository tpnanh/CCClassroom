<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../phpMailer/Exception.php';
    require '../phpMailer/PHPMailer.php';
    require '../phpMailer/SMTP.php';
	$email = $_POST['emai'];
	$conn = new mysqli('remotemysql.com','Cz31yg7sMY','3358RVPU9F',"Cz31yg7sMY");

	$query = "select * from usercc where email='$email'";

	$result = $conn->query($query);

    if($result->num_rows<=0){
    	die("User not found");
    }

    $data = $result->fetch_assoc();
    $token = bin2hex(random_bytes(50));
    $sql = "INSERT INTO password_reset(email, token) VALUES ('$email', '$token')";
    $results = mysqli_query($conn, $sql);

    $to = $email ;

    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();               
    //$mail->SMTPDebug  = 1;                             // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->SMTPSecure = "tls";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for 
    $mail->Username    = 'tai01264195883@gmail.com';                     // SMTP username
    $mail->Password   = 'Github58';                               // SMTP password
   
    $mail->Subject = "Reset your password";
    $mail->setFrom('tai01264195883@gmail.com');
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Body    = "Hi there, click on this <a href=\"https://ccclassroom.herokuapp.com/resetPassword/new_password.php?token=" . $token . "\">link</a> to reset your password on our site";
    
 
    
    $mail->addAddress("$to"); 

    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message has been sent";
    }

    $mail->smtpClose();
?> 