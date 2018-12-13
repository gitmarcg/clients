<?php
ob_start();
session_start(); // On démarre la session AVANT toute chose


include 'connect.php';

$Pseudo = $_POST['PseudoMembre'];
$mot = sha1($_POST['passe']);


//vérifie si email est vide 
if(empty($Pseudo)){ header("Location: erreur.php?erreur="."002" );}

//On ce connect à la database                                           
$conn = OpenCon();

//Vérifie si l'adresse email existe dans la data base
$sql = "SELECT count(*) as somme FROM servi271_McKinnon.membres where PseudoMembre='$Pseudo'";

$result = mysqli_query($conn, $sql);
$check = mysqli_fetch_assoc($result);

// Si exist pas on affiche la page d'erreur
$NbrRows = $check['somme'] ;
if ($NbrRows == 0){ header("Location: erreur.php?erreur="."002" );}
                                                                 
// On va vérifier le mot de passe
$sql = "SELECT * FROM servi271_McKinnon.membres where PseudoMembre='$Pseudo'";

$request = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($request);
$passe = $row['passe'] ;
$NumMembre = $row['NumMembre'] ;

if ($passe != $mot){ header("Location: erreur.php?erreur="."003" ); }

$passe = $row['passe'] ;

// Vérifie si Souvenir de moi est cocher
if ((isset($_POST['remember'])) && ($_POST['remember'] == 'true'))  {
  setcookie("cookie[two]", $passe,time() + (10 * 365 * 24 * 60 * 60));
  setcookie("cookie[one]", $Pseudo,time() + (10 * 365 * 24 * 60 * 60));
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
        }
     
     }
}

$_SESSION['ouvert']=true; 
  
CloseCon($conn) ;

$action = "Billets";
header("Location: clients.php?id=$NumMembre&action=$action");
?>