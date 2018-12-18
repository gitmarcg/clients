<?php

function OpenCon($servername, $username, $password, $dbname)
{

 $conn = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
   } 
  /* Modification du jeu de résultats en utf8 */
  if (!$conn->set_charset("utf8")) {
       echo 'Erreur lors du chargement du jeu de caractères utf8 : ' . $conn->error ;
      exit();
      } 
  return $conn;
}
  
function CloseCon($conn)
{
 $conn -> close();
}

function remember()
{
  return $conn;
}

?>


