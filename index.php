<?php
session_start(); // On démarre la session AVANT toute chose
$ch1 = 'unchecked';
$mot = '';
$pass = '';
$mot = "";
if (isset($_COOKIE['cookie']))
{
  $ch1 = 'checked';
  foreach ($_COOKIE['cookie'] as $name => $value) 
        {
           $name = htmlspecialchars($name);
           if ($name = "two") {
              $pass = $value;
           }
           if ($name = "one") {
              $mot = $value;
           }
        }
} 
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
            <!-- <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />' --> 
            <p id="profile-name" class="profile-name-card"></p>
            <form action="validation.php" method="post" class="form-signin">
                <span id="reauth-email" class="reauth-email"></span>
                
                <?php 
                if(empty($mot)){
                echo '<input type="text" name="PseudoMembre" id="inputEmail" class="form-control" placeholder="Pseudo" required autofocus>';
                }
                else{
                echo '<input type="text" name="PseudoMembre" id="inputEmail" class="form-control" placeholder="Pseudo" Value=' . $mot . ' required autofocus>';
                }
                ?>
                <input type="password" name="passe" id="inputPassword" class="form-control" placeholder="Mot passe" required>
                <input type="checkbox" name="remember" value="true" <?PHP print $ch1; ?>> Souvenenir de moi<br>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Connexion</button>
            </form><!-- /form -->
            
            <a href="#" class="forgot-password">
                Mot de passe Oublié ? <br/>
            </a>
            <a href="inscription.php" class="forgot-password">
                S'inscrire         <br/>
            </a>
           
        </div><!-- /card-container -->
      </div><!-- /container -->


</body>
</html>