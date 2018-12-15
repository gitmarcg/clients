<?php                                            
ob_start();
session_start(); // On démarre la session AVANT toute chose
/**
 * This example shows how to use a callback function from PHPMailer.
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
include "PHPMailer/src/PHPMailer.php";
include "PHPMailer/src/SMTP.php";
include "PHPMailer/src/Exception.php";

date_default_timezone_set('America/Toronto');

$mail     = new PHPMailer();

$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
//$mail->SMTPSecure = 'tls';
$mail->SMTPSecure = 'ssl';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "marc@servicesmckinnon.com";
//Password to use for SMTP authentication
$mail->Password = "pakel2018";
//Set who the message is to be sent from
$mail->setFrom('pmkatelier@gmail.com', 'First Last');
//Set an alternative reply-to address
$mail->addReplyTo('pmkatelier@gmail.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress('marc@servicesmckinnon.com', 'John Doe');
//Set the subject line
$mail->Subject = 'Demande de billets pour ' . $_SESSION['NomClient'] . ' par ' . $_SESSION['NomMembre'];
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
$mail->msgHTML = "his Mail Check .Mail send Using SMTP Gmail Server";
//Replace the plain text body with one created manually



$mail->AddEmbeddedImage('images/logolongmck.png', 'logoimg', 'logo.jpg'); // attach file logo.jpg, and later link to it using identfier logoimg
$mail->Body = "<h1>Voici , en fichier attacher, le(s) Billet(s) demandé par notre système automatisé MCK<br></h1>
    <p>Téléphone : (581) 742-1222 <br>  
       Télécopie : (418-914-7045 <br>
    <img src=\"cid:logoimg\" /></p>";


$mail->AltBody = 'This is a plain-text message body';
//Attach an image file



//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
