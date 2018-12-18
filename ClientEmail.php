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
$mail->CharSet = "text/html; charset=UTF-8;";
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
//$mail->SMTPSecure = 'ssl';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
//$mail->Username = "marc@servicesmckinnon.com";
$mail->Username = "noreply@servicesmckinnon.com";
//Password to use for SMTP authentication
$mail->Password = "NoReply2019";
$mail->setFrom($mail->Username, "No Reply");
$mail->AddEmbeddedImage($DirImage . 'logolongmck.png', 'logoimg', 'logo.jpg');
//$mail->AddEmbeddedImage('images/logolongmck.png', 'logoimg', 'logo.jpg'); // attach file logo.jpg, and later link to it using identfier logoimg
$mail->Pied = "<p>Téléphone : (581) 742-1222 <br>  
       Télécopie : (418-914-7045 <br>
    <img src=\"cid:logoimg\" /></p>";
//$mail->SMTPAuth = false;
//$mail->SMTPSecure = false;
?>