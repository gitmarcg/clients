<?php

function Ftp() {
  // the server you wish to connect to - you can also use the server ip ex. 107.23.17.20
        $ftp_server = "ftp.servicesmckinnon.com";

        
        // echo $ftp_server . " not found in directory : ";
        
// set up a connection to the server we chose or die and show an error
        $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");
       //  echo $ftp_server . " 2 not found in directory : ";
        ftp_login($conn_id,"cbillet@servicesmckinnon.com","Billets2018");
      //  echo $ftp_server . " 3 not found in directory : ";

        
         
// check if a file exist
        $path = "/"; //the path where the file is located

        $file = "33388.pdf"; //the file you are looking for

        $check_file_exist = $path.$file; //combine string for easy use

        //$contents_on_server = ftp_nlist($conn_id, $path); //Returns an array of filenames from the specified directory on success or FALSE on error. 
        //  echo $ftp_server . " 3 not found in directory : ";
        
        echo "Current directory is now: " . ftp_pwd($conn_id) . "<br>";
         //  Récupération de la date de dernière modification
$buff = ftp_mdtm($conn_id, $file);
if ($buff != -1) {
    // somefile.txt was last modified on: March 26 2003 14:16:41.
    echo "$file a été modifié pour la dernière fois : " . date("F d Y H:i:s.", $buff);
    
} else {
    echo "Impossible de récupérer mdtime";
}
        return;
        
        $fileSize = $ftp->GetSizeByName($file);
        echo $check_file_exist . " 5 not found in directory : ";
        exit;
 
        if ($fileSize < 0) {
            echo "file does not exist\n";
        }
        else {
            echo "file exists and is " . $fileSize . " bytes in size\n";
        }
        exit;
      


// Test if file is in the ftp_nlist array
        if (in_array($check_file_exist, $contents_on_server)) 
        {
            echo "<br>";
            echo "I found ".$check_file_exist." in directory : ".$path;
        }
        else
        {
            echo "<br>";
            echo $check_file_exist." not found in directory : ".$path;  
        };

        // output $contents_on_server, shows all the files it found, helps for debugging, you can use print_r() as well
        var_dump($contents_on_server);

// remember to always close your ftp connection
        ftp_close($conn_id);
        exit;
}        
?>        