<?php
include 'connect.php';

$email = $_POST['email'];
$email ='';
$mot = sha1($_POST['passe']);


//vérifie si email est vide 
if(empty($email))
{
   
    /* Redirection vers une page différente du même dossier */
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'erreur.php?erreur=001';
    $location = "Location: http://$host$uri/$extra";
    header($location);
    //header('Location: /erreur.php?erreur=001' );
    echo  $location;
    exit;
}

//On ce connect à la database
$conn = OpenCon();

//Vérifie si l'adresse email existe dans la data base
$sql = "SELECT count(*) as somme FROM servi271_McKinnon.membres where email='$email'";

$result = mysqli_query($conn, $sql);
$check = mysqli_fetch_assoc($result);

// Si exist pas on affiche la page d'erreur
$NbrRows = $check['somme'] ;
echo 'etstert ' . $NbrRows; 
if ($NbrRows == 0) 
{
   echo 'etstert ' . $NbrRows;
   header("Location: erreur.php?erreur="."002" );
}

// On va vérifier le mot de passe
$sql = "SELECT * FROM mckinnon.membres where email='$email'";

$request = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($request);
$passe = $row['passe'] ;
            
if ($passe != $mot) 
{
   header("Location: erreur.php?erreur="."003" );
}


// Vérifie si Souvenir de moi est cocher
$biscuit = false;
if ((isset($_POST['remember'])) && ($_POST['remember'] == 'true'))  {
  $biscuit = true; 
  setcookie("cookie[two]", $passe,time() + (10 * 365 * 24 * 60 * 60));
  setcookie("cookie[one]", $email,time() + (10 * 365 * 24 * 60 * 60));
  echo "set cookie <br />\n";
}
else 
{
     if (isset($_COOKIE['cookie'])) 
     {
        foreach ($_COOKIE['cookie'] as $name => $value) 
        {
           $name = htmlspecialchars($name);
           //unset($_COOKIE[$name]); 
           setcookie("cookie[$name]", '', time() - 3600);
           echo "remove cookie[$name] <br />\n";
        }
     
     }
}
  
if(count($_COOKIE) > 0) {
    echo "Cookies are enabled. = " . count($_COOKIE);
} else {
    echo "Cookies are disabled.";
}

// Après le rechargemet de la page, nous les affichons
if (isset($_COOKIE['cookie'])) {
    foreach ($_COOKIE['cookie'] as $name => $value) {
        $name = htmlspecialchars($name);
        $value = htmlspecialchars($value);        
        echo "$name : $value <br />\n";
    }
 }
else  {

 echo 'trouve pas cookie';    
}


echo 'on continue';

CloseCon($conn) ;
?>
