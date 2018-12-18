<?php
ob_start();
session_start(); // On démarre la session AVANT toute chose

include 'connect.php';
//On ce connect à la database                                           
$conn = OpenCon();

//Crééer une clé unique
$keys = uniqid();
$NumMembre=$_SESSION['NumMembre'];
$NumClient=$_SESSION['NumClient'];

 
//On ajoute la demande dans la table CommandeBillet

date_default_timezone_set('America/Toronto');
$date = date("Y-m-d H:i:s");
echo $date;

$sql = "INSERT INTO servi271_McKinnon.CommandeBillet (CleDemande, NumClient, NumMembre, DateDemande) VALUES ('$keys','$NumClient','$NumMembre','$date')";

if (!mysqli_query($conn, $sql)) {
    printf("Erreur - SQLSTATE %s.\n", $mysqli->sqlstate);
}

$fields = $_POST['IntBillet'];
foreach($fields as $f)
{
  if (!empty($f) && $f != 0 ) {
      $sql = "INSERT INTO servi271_McKinnon.DemandeBillet (CleDemande, NumBillet) VALUES ('$keys','$f')";

      if (!mysqli_query($conn, $sql)) {
            printf("Erreur - SQLSTATE %s.\n", $mysqli->sqlstate);
      }
 
  
  } 
  
}

$_SESSION['CleDemande'] = $keys;

header("Location: ConfDemande.php");
exit;

?>


    