<?php
ob_start();
session_start(); // On démarre la session AVANT toute chose

if (!isset($_SESSION['ouvert'])) 
{
  { header("Location: erreur.php?erreur="."004" );}
  exit;
}
include 'connect.php';
//On ce connect à la database                                           
$conn = OpenCon();

$NumMembre = $_GET['id'];
$action = $_GET['action'];
// On va vérifier le mot de passe
$sql = "SELECT * FROM servi271_McKinnon.membres where NumMembre='$NumMembre'";

$request = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($request);
$NomClient = $row['NomClient'] ;
$NumClient = $row['NumClient'] ;
$NomMembre = $row['NomMembre'];
$Bienvenue = $NomMembre . ' , ' .$NomClient ;



?>

<!-- Topmenu -->
<!DOCTYPE html>

<head>
<meta charset="utf-8">
<title>Section Clients</title>
<link href="css/style.css" rel="stylesheet" />
</head>

<div id="header">
      <p>
		  <img src="images/logolongmck.png"  style="margin:25px 50px">
      
   <div style="position:absolute;top:65px; width:1200px; height:500px; z-index:2;font-size:200%; color:white":>
      <center><b>Bienvenue cher clients</b> <br> <?php echo $Bienvenue . $action ?></center>
      <ul id="nav">
	        <li><a href="#">Billet</a></li>
	        <li><a href="#">Services</a></li>
	        <li><a href="#">À propos</a></li>
	        <li><a href="#">Contact</a></li>
      </ul>
 
    
    
<?php
if ($action == "Billets"):
    echo "a égale 5";
    echo "...";
elseif ($a == 6):
    echo "a égale 6";
    echo "!!!";
else:
    echo "a ne vaut ni 5 ni 6";
endif;
?>
    </div>
</html>