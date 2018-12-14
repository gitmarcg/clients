<?php
ob_start();
session_start(); // On démarre la session AVANT toute chose
include 'connect.php';
include 'ClientEmail.php';
include 'FtpBillet.php';

$LigneT = str_repeat("-", 79) . "\n";
$LigneE = str_repeat("*", 79) . "\n";

//On ce connect à la database                                           
$conn = OpenCon();

date_default_timezone_set('America/Toronto');
$date = date("Y-m-d_His");
$myfile = fopen("log/$date.txt", "w");
fwrite($myfile, $LigneE);
$txt = "************************************* DEBUT ************************************\n";
fwrite($myfile, $txt);
fwrite($myfile, $LigneE);
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

//******************************************************************************
//************* Debut Code
//******************************************************************************
//**
//* On regard si on a des demande dans la table CommandeBillet
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
fwrite($myfile, $LigneE);
fwrite($myfile, $txt);
if (mysqli_num_rows($result) == 0) {
   fwrite($myfile,"Aucune ligne trouvée ----> Fin.");
   goto END;
}

//** On a au moins une demande


//** On l'analyse pour chaque demande
while ($row = mysqli_fetch_assoc($result)) {
   // On regarde toute les billets relier a cette demande
   $CleDemande = $row["CleDemande"];
   $NumMembre  = $row["NumMembre"];
   $NumClient = $row["NumClient"];
   fwrite($myfile,"$LigneE");
   fwrite($myfile,"$LigneE");    
   fwrite($myfile,"Demande Numéro : $CleDemande , Demandeur : $NumMembre \n");
   fwrite($myfile,"$LigneE");
   $sql = "SELECT * FROM servi271_McKinnon.DemandeBillet where CleDemande = '$CleDemande'";
   $billets = mysqli_query($conn, $sql);
   if (!$billets) {
       fwrite($myfile,"Erreur - SQLSTATE $billets ->sqlstate.\n");
       $billets->free();
       goto END; 
   }
   //********************************************
   //On a une demande on prépare l'envoie de couriel
   //*

   //********************************************
   //ON va chercher les information du demandeur
   //*
   $sql = "SELECT * FROM servi271_McKinnon.membres where NumMembre = '$NumMembre'";
   $membre = mysqli_query($conn, $sql);;
   if ((!$membre)  ||  (mysqli_num_rows($membre) == 0)  ||   (mysqli_num_rows($membre) > 1)){
       fwrite($myfile,"Erreur - SQLSTATE $membre->sqlstate.\n");
       fwrite($myfile,"Erreur - ReqRow   = mysqli_num_rows($membre).\n");
       echo 'Erreur Chercher Membre ';
       goto END; 
   }
   $rowMembre = mysqli_fetch_assoc($membre);

   $NomMembre = $rowMembre["NomMembre"];
   $CourielMembre = $rowMembre["CourielMembre"];
   $TavailPour = $rowMembre["NumClient"]; 
   //* On libère la mémoire 
   $membre->free();
   $mail->setFrom($CourielMembre, $NomMembre);
   fwrite($myfile,"Nom demandeur : $NomMembre , Couriel : $CourielMembre \n");
   fwrite($myfile,"$LigneT \n"); 
   //Fin des information du demandeur
   //********************************************
   
   //********************************************
   //ON va chercher les informations De la compagnie
   //*

   $sql = "SELECT * FROM servi271_McKinnon.Client where NumClient = '$NumClient'";
   $client = mysqli_query($conn, $sql);;
   //if ((!$membre)  ||  (mysqli_num_rows($membre) == 0)  ||   (mysqli_num_rows($membre) > 1)){
   if ((!$client)){
       fwrite($myfile,"Erreur - SQLSTATE $client->sqlstate.\n");
       fwrite($myfile,"Erreur - ReqRow   = mysqli_num_rows($client).\n");
       echo 'Erreur Chercher Membre ';
       goto END; 
   } 
   $rowclient = mysqli_fetch_assoc($client);
   $NomClient = $rowMembre["NomClient"];
   
   $mail->Subject = 'Demande de billets pour ' .$NomClient . ' par ' . $NomMembre .': ' . $CleDemande;  
   echo $mail->Subject . '<br>'; 
   //Fin des information du demandeur
   //********************************************  
   
   //*** Si la demande ne contient aucun billet
   if (mysqli_num_rows($billets) == 0) {
      $StrMessage ="Aucune Billets pour cette demande\n"; 
      fwrite($myfile,"          " .$StrMessage  );
      //on va fermer le billets
      $mail->Body = $StrMessage;
      if (!$mail->send()) {
          fwrite($myfile,"Erreur - mailsend $mail->ErrorInfo.\n");
       }
      CloseDemande( $CleDemande );
      continue;
   }
   //*** Connection si FTP
   $conn_id = FtpConnect();
   
   //* On analyse chaque demande de billets
   while ($rowBillet = mysqli_fetch_assoc($billets)) {
         
         /**** Vérifier si le billet exist dans un premier temps */
         $NoBillet = $rowBillet["NumBillet"];
        
         $EtatBillet = VerifeBillet($conn_id,$NoBillet,$TavailPour);
         // $FileNotExist      = 0;
         //$FileExistOK       = 1;
         //$FileExistNotAuth  = 2;
         switch ($EtatBillet) {
            case 0:
                $message = str_pad("Numérode Billet : ". str_pad($NoBillet, 6, " ") . " --->  Fichier inexistant", 60, " ", STR_PAD_LEFT);
                fwrite($myfile, $message. "\n");
                echo str_repeat('&nbsp;', 5) . $message . '<br>';
                break;
            case 1:
                $message = str_pad("Numérode Billet : \t". str_pad($NoBillet, 6, " ") . " --->  Fichier existant", 60, " ", STR_PAD_LEFT);
                $message = "Numérode Billet : ". str_pad($NoBillet, 6, " ") . " --->  Fichier existant";
                fwrite($myfile,$message . "\n");
                echo str_repeat('&nbsp;', 5) . $message . '<br>';
                break;
            case 2:
                $message = str_pad("Numérode Billet : ". str_pad($NoBillet, 6, " ") . " --->  Fichier inaccessible pour le moment", 60, " ", STR_PAD_LEFT);
                fwrite($myfile,$message . "\n");
                echo str_repeat('&nbsp;', 5) . $message . '<br>' ; 
                break;
          }
         
         
         
         
  }
  
  //*** Close si FTP
  FtpClose($conn_id);

}




END:
$result->free();

$txt = "********************************************************************************\n";
fwrite($myfile, $txt);
$txt = "************************************** FIN *************************************\n";
fwrite($myfile, $txt);
$txt = "********************************************************************************\n";
fwrite($myfile, $txt);
fclose($myfile);


CloseCon($conn) ;
?>