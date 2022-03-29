<?php
error_reporting(E_ERROR | E_PARSE);
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$email=$_POST['email'];
$subject=$_POST['subject'];
$mail_content=$_POST['mail_content'];
$mail_content=nl2br($mail_content);
$mail_content=wordwrap($mail_content,70,"<br>\n");

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'auth.smtp.1and1.co.uk';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'mcr@iqbroadcast.tv';                 // SMTP username
    $mail->Password = 'prInce55';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('info@cloudq.co.in');
    $mail->AddAddress($email);

$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);
    //Attachments

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $mail_content;
    //$mail->AltBody = '';

// $file_to_attach = 'PATH_OF_YOUR_FILE_HERE';
// $email->AddAttachment( $file_to_attach , 'NameOfFile.pdf' );

    $mail->send();
    header('Location: mailbox.php');


} catch (Exception $e) {
     echo 'Mailer error: ' . $mail->ErrorInfo;
}
?>