<head>
<meta charset="utf-8">
<title>Log-In</title>
<link href="css/style.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="images/LogoMx75x59.jpg?sz=120" alt="" />
          <?php
          switch($_GET['erreur'])
          {
             case '001':
             echo 'L\'adresse courriel est vide ou invalide  <br/>';
             break;
             case '002':
                echo 'Cette adresse Couriel n\'exist pas dans notre base de données  <br/>';
             break;
              case '003':
                echo 'Mot de passe invalide  <br/>';
             break;
             case '004':
                echo 'Vous devez être connecté <br/>';
             default:
             echo 'Erreur !';
          }
          ?>
         <a href="index.php" class="forgot-password">
                Retour au menu connexion         <br/>
        </a>    
        </div><!-- /card-container -->
    </div><!-- /container -->

</body>
</html>

