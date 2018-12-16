<?php
//** Contient les fonction de connection au site FTP

function FtpConnect() {
        // the server you wish to connect to - you can also use the server ip ex. 107.23.17.20
        $ftp_server = "ftp.servicesmckinnon.com";

        // set up a connection to the server we chose or die and show an error
        $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");
       //  echo $ftp_server . " 2 not found in directory : ";
        ftp_login($conn_id,"cbillet@servicesmckinnon.com","Billets2018");
        //  echo $ftp_server . " 3 not found in directory : ";
        
        // check if a file exist
        $path = "/"; //the path where the file is located
        ftp_pasv($conn_id, true);
        return $conn_id;

}

function VerifeBillet($conn,$conn_id,$Billet,$TavailPour) {
       //Prépare les varibale de retour
       $FileNotExist      = 0;
       $FileExistOK       = 1;
       $FileExistNotAuth  = 2;
       $FileExistNotDBA   = 3;
       $CopyFtpFailed     = 4;
       
       //* Ajout PDF au nom de fichier
       $file = $Billet . ".pdf";
       
       $buff = ftp_mdtm($conn_id, $file);
       if ($buff != -1) {
          //*** Le fichier exist mais on vérifie si il appartient au client de la demande
          //On ce connect à la database                                           
          $sql = "SELECT * FROM servi271_McKinnon.Billets where NumBillet = '$Billet'";
          $ReqBillet = mysqli_query($conn, $sql);                          
          $nbrRow = mysqli_num_rows($ReqBillet);
          if ($nbrRow == 0) {
              return $FileExistNotDBA;
          }
          $sql = "SELECT * FROM servi271_McKinnon.Billets where NumBillet = '$Billet' and NumClient = '$TavailPour'";
          $ReqBillet = mysqli_query($conn, $sql);                          
          $nbrRow = mysqli_num_rows($ReqBillet);
          $FileTarget = getcwd() . "\\Tempo\\" . $file ;
          //echo $FileTarget;
          if ($nbrRow == 1) {
              // on copie le billets demander dans un répertoire local dans le but de l'ajouter a l'attachement
              if (!ftp_get($conn_id, $FileTarget, $file, FTP_BINARY)) {
                 return $CopyFtpFailed;                   
              }
              return $FileExistOK;
          } else {
              return  $FileExistNotAuth;
          }
          

             
       } else {
         return $FileNotExist;
        // echo "Impossible de récupérer mdtime";
       }
}  


function Ftpclose($conn_id) {
    ftp_close($conn_id);
}        
?>        