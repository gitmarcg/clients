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
$NomMembre =  $_SESSION['NomMembre'];
$NomClient =  $_SESSION['NomClient'];

$NbrBillet = 10;

CloseCon($conn) ;
?>

<!-- Topmenu -->
<!DOCTYPE html>

<head>
<meta charset="utf-8">
<title>Section Clients</title>
<link href="css/style.css" rel="stylesheet" />
</head>

<body>
<div id="header">
      <p>
		  <img src="images/logolongmck.png"  style="margin:25px 50px">
      
   <div style="position:absolute;top:65px; width:1200px; height:500px; z-index:2;font-size:200%; color:white">
      <center><b>Bienvenue cher client</b> <br> <?php echo $NomMembre . ' - ' . $NomClient ?> </center>
   
<div class="topnav">
  <a class="active" href="#home">Billets</a>
  <a href="#news">News</a>
  <a class="rigth" href="clients.php?id=$NumMembre&action=contact";">Contact</a>
  <a class="rigth" href="clients.php?id=$NumMembre&action=logout";">Déconnexion</a>
</div>
  <fieldset  style="width:950px;">
        <legend style="text-align:center" >Entrez les numéros de billets (Maximum 10)  </legend>
        <form action="inscriredemande.php" method="post" class="form-signin">
        <?php
           $x = 1; 
           while($x <= $NbrBillet) {
               if ($x !=1) {                                                          
               
               $StrInput = $x . ") <input align=\"left\" style=\"font-size:75%;left: 100px;position: absolute;\" class=\"form-control\" name=\"IntBillet[]\"  maxlength=\"6\" size=\"7\" /><br />";
               }
               else {
               
               $StrInput = $x . ") <input align=\"left\" style=\"font-size:75%;left: 100px;position: absolute;\" class=\"form-control\" required  name=\"IntBillet[]\" maxlength=\"6\" size=\"7\" autofocus/><br />";
               } 
               echo $StrInput;
               $x++;
           }
        ?>
        
        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Envoyer</button>
        </form><!-- /form -->   

    </fieldset>

    
<?php

if ($action == "Billets"): {
      
      }
     
elseif ($action == "logout" || $action == "contact"):  {
        session_destroy();
        if  ($action == "logout") {
             header('location: index.php');
             exit;
        }
        if  ($action == "contact") {
             header('location: http://www.servicesmckinnon.com');
             exit;
        }
      } 

else:
    echo "a ne vaut ni 5 ni 6";
endif;

?>
 </div>
</body>
   
</html>