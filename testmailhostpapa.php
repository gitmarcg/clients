<?php                                            
/**
 * This example shows how to use a callback function from PHPMailer.
 */
include "PHPMailer/src/PHPMailer.php";
include "PHPMailer/src/SMTP.php";
include "PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('America/Toronto');

$mail     = new PHPMailer();

$mail->IsHTML(true);
//$mail->CharSet = "text/html; charset=UTF-8;";
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 3;
//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
//$mail->Host = "ssl://smtp.gmail.com";
$CourielMembre = "marc@servicesmckinnon.com";
$NomMembre = "Marc Gagné local";
$mail->setFrom($CourielMembre, "=?utf-8?b?". base64_encode($NomMembre)  ."?=");
// use
// $mail->Host = gethostbyname('smtp.gmail.com'); 
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
//$mail->SMTPSecure = 'ssl';
//$mail->Port = 465;        
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
//$mail->SMTPSecure = 'ssl';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "marc@servicesmckinnon.com";
//Password to use for SMTP authentication
$mail->Password = "pakel2018";
$mail->addAddress('marc@servicesmckinnon.com', 'Marc Gagné');
$mail->AddEmbeddedImage('images/logolongmck.png', 'logoimg', 'logo.jpg'); // attach file logo.jpg, and later link to it using identfier logoimg
//$mail->SMTPAuth = false;
//$mail->SMTPSecure = false;
$mail->Body = '<h2>Voici , un test d\'envoie du serveur VPS avec hostpapa <br></h2>' . "<br>".  $mail->Body ; 
if (!$mail->send()) {
       //fwrite($myfile,"Erreur - mailsend $mail->ErrorInfo.\n");
       echo "------------------------------- Erreur ----------------------------";
   }else{
       //fwrite($myfile,"Mail envoyer\n");
       echo "Mail envoyer";
   }
?>