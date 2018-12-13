<?php
ob_start();
session_start(); // On démarre la session AVANT toute chose

header("Location: email.php");
exit;

if (!isset($_SESSION['ouvert'])) 
{
  { header("Location: erreur.php?erreur="."004" );}
  exit;
}

include 'connect.php';

$email = "marc.gagne@servicesmckinnon.com";


foreach ($_POST['IntBillet'] as $value) {
    // Do something with each valid friend entry ...
    if ($value) {
        echo $value."<br />";
        header("Location: email.php?);
        exit;
    }
}

?>




<!-- Topmenu -->
<!DOCTYPE html>

<head>
<meta charset="utf-8">
<title>Section Clients</title>
<link href="css/style.css" rel="stylesheet" />
</head>

<body>
<div id="header">
      <p>
		  <img src="images/logolongmck.png"  style="margin:25px 50px">
      
   <div style="position:absolute;top:65px; width:1200px; height:500px; z-index:2;font-size:100%; color:white">
      <center><b>Vérifiez votre couriel, la demande est envoyé à</b> <br> <?php echo $email ?></center>
      <form>
        <input type="button" value="Retour" onclick="history.go(-1)">
    </form>
   
 </div>
</body>
   
</html>