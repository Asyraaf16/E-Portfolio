
<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST['submitemail'])){
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->Username   = 'masyraaf886@gmail.com';                     //SMTP username
        $mail->Password   = 'secret';                               //SMTP password

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('masyraaf886@gmail.com', 'Muhammad Asyraaf');
        $mail->addAddress('masyraaf886@gmail.com', 'Muhammad Asyraaf');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'New Enquiry: Portfolio Contact Form';
        $mail->Body    = '<h3>Hello, you got a new enquiry</h3>
        <p><strong>Fullname: </strong>'.$name.'</p>
        <p><strong>Email: </strong>' .$mail.'</p>
        <p><strong>Subject: </strong> '.$subject.'</p>
        <p><strong>Message: </strong>'.$message.'</p>';

        if($mail->send()){
            $_SESSION['status'] = "Message sent successfully";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit(0);
        }
        else{
            $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit(0);
        }

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
else{
    header('Location: index.html');
    exit(0);
}
?>