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
        return $conn_id;

}

function VerifeBillet($conn_id,$Billets) {
        echo "Current directory is now: " . ftp_pwd($conn_id) . "<br>";
         //  Récupération de la date de dernière modification
       $file = $billet . "pdf";
       $buff = ftp_mdtm($conn_id, $file);
       if ($buff != -1) {
       // somefile.txt was last modified on: March 26 2003 14:16:41.
       echo "$file a été modifié pour la dernière fois : " . date("F d Y H:i:s.", $buff);
    
       } else {
         echo "Impossible de récupérer mdtime";
       }
        return;
       
}  


function Ftpclose($conn_id) {
    ftp_close($conn_id);
}        
?>        