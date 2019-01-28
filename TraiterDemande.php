<?php
/*
<-- /home/servi271/public_html/new2/clients/TraiterDemande.php --->

Programme est appeler par un cronjob ce qui vérfie dans al database si on eu des demandes
Ensuite analyses ces demandes et dans le cas que tout est ok envoie les billets
demander aux utilisateurs (demandeurs)
*/


ob_start();
session_start(); // On démarre la session AVANT toute chose
include 'SetRepertoire.php';
include 'config.php';
include 'connect.php';
include 'FtpBillet.php';
include 'ClientEmail.php';


$LigneT = str_repeat("-", 79) . "\n";
$LigneE = str_repeat("*", 79) . "\n";

//On ce connect à la database                                           
$conn = OpenCon($servername, $username, $password, $dbname);

$DirLogFile =  $DirLog . $date . '.txt';
$myfile = fopen($DirLogFile, "w");
if (!$myfile) {
  echo "Erreur de création du fichier de log dans TraiterDemande.php";
  echo $DirFile . "\n";
  exit;
}

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
 
   $mail->addAddress($CourielMembre, "=?utf-8?b?". base64_encode($NomMembre)  ."?=");
   
   //$mail->setFrom('marc@servicesmckinon.com', 'Marcccc');
   //$mail->addAddress('pmkatelier@gmail.com', 'Pkmatelier');
   
   fwrite($myfile,"Nom demandeur : $NomMembre , Couriel : $CourielMembre \n");
   fwrite($myfile,"$LigneT \n"); 
   //Fin des information du demandeur
   //********************************************
   
   //********************************************
   //ON va chercher les informations De la compagnie
   //*

   $sql = "SELECT * FROM servi271_McKinnon.Client where NumClient = '$NumClient'";
   $client = mysqli_query($conn, $sql);
   //if ((!$membre)  ||  (mysqli_num_rows($membre) == 0)  ||   (mysqli_num_rows($membre) > 1)){
   if ((!$client)){
       fwrite($myfile,"Erreur - SQLSTATE $client->sqlstate.\n");
       fwrite($myfile,"Erreur - ReqRow   = mysqli_num_rows($client).\n");
       echo 'Erreur Chercher Membre ';
       goto END; 
   } 
   $rowclient = mysqli_fetch_assoc($client);
   $NomClient = $rowMembre["NomClient"];
   
   $sujet = 'Demande de billets pour ' .$NomClient . ' par ' . $NomMembre .' : ' . $CleDemande;
   $mail->Subject = "=?utf-8?b?". base64_encode($sujet)  ."?=";  
   //$mail->Subject = "Demande de billetssss pour " .$NomClient . " par " . $NomMembre . " :  " . $CleDemande;
   //echo $mail->Subject . '<br>'; 
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
   $StrMessage = "";
   $mail->Body  = "";
   //* On analyse chaque demande de billets
   
   while ($rowBillet = mysqli_fetch_assoc($billets)) {
         
         /**** Vérifier si le billet exist dans un premier temps */
         $NoBillet = $rowBillet["NumBillet"];
        
         $EtatBillet = VerifeBillet($conn,$conn_id,$NoBillet,$TavailPour,$DirTempoFile);
        /* $FileNotExist      = 0;
           $FileExistOK       = 1;
           $FileExistNotAuth  = 2;
           $FileExistNotDBA   = 3;
           $CopyFtpFailed     = 4;
         */  
         switch ($EtatBillet) {
            case 0:
                $message = str_pad(str_pad("Numérode Billet : ". str_pad($NoBillet, 6, " ") . " --->  Fichier inexistant", 70, " ", STR_PAD_RIGHT),80, " ", STR_PAD_LEFT);
                fwrite($myfile, $message. "\n");
                //$message = str_repeat('&nbsp;', 5) . $message . '<br>';
                $mail->Body =  $mail->Body . $message . "<br>"; 
                //echo $message;
                break;
            case 1:
                $message = str_pad(str_pad("Numérode Billet : ". str_pad($NoBillet, 6, " ") . " --->  Fichier existant", 70, " ", STR_PAD_RIGHT),80, " ", STR_PAD_LEFT);
                fwrite($myfile,$message . "\n");
                //$message = str_repeat('&nbsp;', 5) . $message . '<br>';
                $pdffile = $DirTempoFile . $NoBillet . ".pdf";
                $mail->AddAttachment($pdffile);
                $mail->Body =  $mail->Body . $message . "<br>"; 
                //echo $message;
                break;
            case 2:
                $message = str_pad(str_pad("Numérode Billet : ". str_pad($NoBillet, 6, " ") . " --->  Fichier inaccessible pour le moment", 70, " ", STR_PAD_RIGHT),80, " ", STR_PAD_LEFT);
                fwrite($myfile,$message . "\n");
                $mail->Body =  $mail->Body . $message . "<br>"; 
                //echo $message;
                break;
            case 3:
                $message = str_pad(str_pad("Numérode Billet : ". str_pad($NoBillet, 6, " ") . " --->  ERREUR Billet inexistant dans la DBA", 70, " ", STR_PAD_RIGHT),80, " ", STR_PAD_LEFT);
                fwrite($myfile,$message . "\n");
                $mail->Body =  $mail->Body . $message . "<br>"; 
                //echo $message;
                break;    
            case 4:
                $message = str_pad(str_pad("Numérode Billet : ". str_pad($NoBillet, 6, " ") . " --->  ERREUR COPY FTP FILE FAILED", 70, " ", STR_PAD_RIGHT),80, " ", STR_PAD_LEFT);
                fwrite($myfile,$message . "\n");
                $mail->Body =  $mail->Body . $message . "<br>"; 
                //echo $message;
                break;                               
          }
    }     
   $mail->Body = '<h2>Voici, en fichier attaché, le(s) billet(s) demandé(s) et produit par notre système automatisé MCK<br></h2>' . "<br>".  $mail->Body . $mail->Pied ; 
   if (!$mail->send()) {
       fwrite($myfile,"Erreur - mailsend $mail->ErrorInfo.\n");
   }else{
       fwrite($myfile,"Mail envoyer\n");
       // echo "Mail envoyer";
   }  
   
   $mail->ClearAddresses();  // each AddAddress add to list
   $mail->clearAttachments(); 
       
    //The name of the folder.
    //Get a list of all of the file names in the folder.
    $files = glob($DirTempoFile . '*');
     
    //Loop through the file list.
    foreach($files as $file){
        //Make sure that this is a file and not a directory.
        if(is_file($file)){
            //Use the unlink function to delete the file.
            unlink($file);
            //echo "Delete File " . $file; 
        }
    }
   // Remettre image de la signature
   $mail->AddEmbeddedImage($DirImage . 'logolongmck.png', 'logoimg', 'logo.jpg');
 // echo "mail.body <br>" . $mail->Body . "FIN <br>";
  CloseDemande( $CleDemande );
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