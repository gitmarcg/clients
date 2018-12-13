<?php
ob_start();
session_start(); // On démarre la session AVANT toute chose
include 'connect.php';
//On ce connect à la database                                           
$conn = OpenCon();

date_default_timezone_set('America/Toronto');
$date = date("Y-m-d_His");
$myfile = fopen("log/$date.txt", "w");
$txt = "********************************************************************************\n";
fwrite($myfile, $txt);
$txt = "************************************* DEBUT ************************************\n";
fwrite($myfile, $txt);
$txt = "********************************************************************************\n";
fwrite($myfile, $txt);
$txt = "Log : $date\n";
fwrite($myfile, $txt);


function CloseDemande($CleDemande) {
    global $myfile,$conn; 
    $sql = "UPDATE servi271_McKinnon.CommandeBillet SET Status = 'OLD' WHERE CleDemande = '$CleDemande'";
    $Req_Close_demande = mysqli_query($conn, $sql);
    if (!$Req_Close_demande) {
        fwrite($myfile,"Erreur - SQLSTATE $Req_Close_demande->sqlstate.\n"); 
    }
    fwrite($myfile,"La demande $CleDemande est fermée \n"); 
}



$sql = "SELECT * FROM servi271_McKinnon.CommandeBillet where Status = 'NEW'";

$result = mysqli_query($conn, $sql);
if (!$result) {
    fwrite($myfile,"Erreur - SQLSTATE $result->sqlstate.\n");
    goto END; 
  }
  
// On imprime le nombre de record qu'on vca traiter    
$NombreDemande = mysqli_num_rows($result);
$txt = "Nombre dse demande à traiter : $NombreDemande \n";
fwrite($myfile, $txt);
$txt = "********************************************************************************\n";
fwrite($myfile, $txt);
if (mysqli_num_rows($result) == 0) {
   fwrite($myfile,"Aucune ligne trouvée ----> Fin.");
    goto END;
}
while ($row = mysqli_fetch_assoc($result)) {
   $CleDemande = $row["CleDemande"];
   $NumMembre  = $row["NumMembre"];
   fwrite($myfile,"Demande Numéro : $CleDemande , Demandeur : $NumMembre \n");
   $sql = "SELECT * FROM servi271_McKinnon.DemandeBillet where CleDemande = '$CleDemande'";
   $biletts = mysqli_query($conn, $sql);
   if (!$biletts) {
       fwrite($myfile,"Erreur - SQLSTATE $biletts ->sqlstate.\n");
       goto END; 
   }
   if (mysqli_num_rows($biletts) == 0) {
      fwrite($myfile,"          Aucune Billets pour cette demande\n");
      //on va fermer le billets
      //CloseDemande( $CleDemande );
      continue;
   }
   while ($rowBillet = mysqli_fetch_assoc($biletts)) {
         $NoBillet = $rowBillet["NumBillet"];
         fwrite($myfile,"          Numérode Billet : $NoBillet \n");
  }

}

END:
$txt = "********************************************************************************\n";
fwrite($myfile, $txt);
$txt = "************************************** FIN *************************************\n";
fwrite($myfile, $txt);
$txt = "********************************************************************************\n";
fwrite($myfile, $txt);
fclose($myfile);


CloseCon($conn) ;
?>