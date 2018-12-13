<?php
ob_start();
session_start(); // On démarre la session AVANT toute chose

if (!isset($_SESSION['ouvert'])) 
{
  { header("Location: erreur.php?erreur="."004" );}
  exit;
}

$NomMembre =  $_SESSION['NomMembre'];
$NumMembre =  $_SESSION['NumMembre'];
$NomClient =  $_SESSION['NomClient'];
$keys = $_SESSION['CleDemande'];
$action="Billets"

?>


<head>
<meta charset="utf-8">
<title>Log-In</title>
<link href="css/style.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="card card-container">
        <img id="profile-img" class="profile-img-card"  src="images/LogoMx75x59.jpg?sz=120" alt="" />
        <?php
          echo "Merci cher $NomMembre de chez $NomClient . <br><br> Votre demande : $keys sera traiter dans les plus bref délais par notre systême automatique MCK ";
          echo "<a href=\"clients.php?id=$NumMembre&action=$action\"   class=\"forgot-password\">";
         ?> 

         <br>
         <br>
                Retour au menu connexion         <br/>
        </a>    
        </div><!-- /card-container -->
    </div><!-- /container -->

</body>
</html>