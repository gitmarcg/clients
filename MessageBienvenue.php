<?php
ob_start();
session_start(); // On démarre la session AVANT toute chose
$NomMembre  = $_SESSION['NomMembre']; 
$NomClient  = $_SESSION['NomClient'];
$CourielMembre = $_SESSION['CourielMembre'] ; 
?>
<head>
<meta charset="utf-8">
<title>Log-In</title>
<link href="css/style.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="images/LogoMx75x59.jpg?sz=120" alt="" />
          <?php {
          echo 'Nous avons bien reçu votre demande pour ajouter un compte pour '. $NomClient . ' par ' . $NomMembre . '<br/>';
          echo 'Dès que votre compte sera activer par notre équipe technique , un couriel vous sera evoyer à ' . $CourielMembre . '<br/>'. '<br/>'.'<br/>';
          }
          ?>
         <a href="index.php" class="forgot-password">
                Retour au menu connexion         <br/>
        </a>    
        </div><!-- /card-container -->
    </div><!-- /container -->

</body>
</html>

