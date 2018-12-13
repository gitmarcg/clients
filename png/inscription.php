<?php
     
include 'connect.php';

//On ce connect à la database                                           
$conn = OpenCon();
 
    
    //la table est créée avec les paramètres suivants:
    //champ "NumMembre": en auto increment pour un id unique, peux vous servir pour une identification future
    //champ "PseudoMembre": en varchar de 0 à 25 caractères
    //champ "mdp": en char fixe de 32 caractères, soit la longueur de la fonction md5()
    //fin création automatique


 
//par défaut, on affiche le formulaire (quand il validera le formulaire sans erreur avec l'inscription validée, on l'affichera plus)
$AfficherFormulaire=1;
//traitement du formulaire:
if(isset($_POST['PseudoMembre'],$_POST['PasseMembre'])){//l'utilisateur à cliqué sur "S'inscrire", on demande donc si les champs sont défini avec "isset"
    
    if(empty($_POST['PseudoMembre'])){//le champ pseudo est vide, on arrête l'exécution du script et on affiche un message d'erreur
        echo "Le champ Pseudo est vide.";
    } elseif(!preg_match("#^[a-z0-9]+$#",$_POST['PseudoMembre'])){//le champ pseudo est renseigné mais ne convient pas au format qu'on souhaite qu'il soit, soit: que des lettres minuscule + des chiffres (je préfère personnellement enregistrer le pseudo de mes membres en minuscule afin de ne pas avoir deux pseudo identique mais différents comme par exemple: Admin et admin)
        echo "Le Pseudo doit être renseigné en lettres minuscules sans accents, sans caractères spéciaux.";
    } elseif(strlen($_POST['PseudoMembre'])>25){//le pseudo est trop long, il dépasse 25 caractères
        echo "Le pseudo est trop long, il dépasse 25 caractères.";
    } elseif($_POST['PasseMembre'] != $_POST['PasseMembre2'] ){//le champ mot de passe est vide
        echo "Les mots de passe ne correspond pas";
    } elseif(empty($_POST['PasseMembre'])){//le champ mot de passe est vide
        echo "Le champ Mot de passe est vide.";
        
    } elseif(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM servi271_McKinnon.membres WHERE PseudoMembre='".$_POST['PseudoMembre']."'"))==1){//on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
        echo "Ce pseudo est déjà utilisé.";
    } else {                                                                                                                  
        //toutes les vérifications sont faites, on passe à l'enregistrement dans la base de données:
        //Bien évidement il s'agit là d'un script simplifié au maximum, libre à vous de rajouter des conditions avant l'enregistrement comme la longueur minimum du mot de passe par exemple
        $SqlInsert = "INSERT INTO servi271_McKinnon.membres set PseudoMembre='".$_POST['PseudoMembre']."',NomMembre ='".$_POST['NomMembre']."',PasseMembre ='".sha1($_POST['PasseMembre'])."',NomClient ='".$_POST['NomClient']."',CourielMembre ='".$_POST['CourielMembre']."'";
        
        if(!mysqli_query($conn,$SqlInsert)){//on crypte le mot de passe avec la fonction propre à PHP: md5()
            echo "Une erreur s'est produite: ".mysqli_error($conn);//je conseille de ne pas afficher les erreurs aux visiteurs mais de l'enregistrer dans un fichier log
        } else {
            echo "Vous êtes inscrit avec succès!"; 
            
            //on affiche plus le formulaire
            $AfficherFormulaire=0;
        }
    }
}
if($AfficherFormulaire==1){
    ?>
    <!-- 
    Les balises <form> sert à dire que c'est un formulaire
    on lui demande de faire fonctionner la page inscription.php une fois le bouton "S'inscrire" cliqué
    on lui dit également que c'est un formulaire de type "POST"
      
    Les balises <input> sont les champs de formulaire
    type="text" sera du texte
    type="password" sera des petits points noir (texte caché)
    type="submit" sera un bouton pour valider le formulaire
    name="nom de l'input" sert à le reconnaitre une fois le bouton submit cliqué, pour le code PHP
     -->
<head>
<meta charset="utf-8">
<title>Log-In</title>
<link href="css/style.css" rel="stylesheet" />
</head>
     <div class="container">
        <div class="card card-container">
             <center><b>Inscription</b></center>
            <img id="profile-img" class="profile-img-card" src="images/LogoMx75x59.jpg?sz=120" alt="" /> 
            <!-- <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />' --> 
            <p id="profile-name" class="profile-name-card"></p>

            <form method="post" action="inscription.php">
                <TABLE BORDER="2"> 
                 <center><CAPTION> Les champs sont TOUS obligatoire </CAPTION> <center> 
                 <TR> 
                    <col align="right">
                    <TH>Pseudo :</TH> 
                    <TH><input type="text" name="PseudoMembre" class="form-control" placeholder="Pseudo (a-z0-9)" required> <br></TH> 
                </TR> 
                <TR> 
                    <TH> Mot de passe :</TH> 
                    <TH> <input type="password" name="PasseMembre" id="inputPassword" class="form-control" placeholder="Mot passe" required> <br></TH> 
                </TR>
                <TR> 
                    <TH> Confirmation :</TH> 
                    <TH> <input type="password" name="PasseMembre2" id="inputPassword" class="form-control" placeholder="Confirmation" required> <br></TH> 
                </TR>
                 <TR> 
                    <TH> Couriel :</TH> 
                    <TH> <input type="text" name="CourielMembre" class="form-control" placeholder="Adresse Couriel" required> <br></TH> 
                </TR>
                 <TR> 
                    <TH> Compagnie :</TH> 
                    <TH> <input type="text" name="NomClient" class="form-control" placeholder="Compagnie" required> <br></TH> 
                </TR>
                <TR> 
                    <TH> Nom :</TH> 
                    <TH> <input type="text" name="NomMembre"  class="form-control" placeholder="Nom" required> <br></TH> 
                </TR> 
 
              </TABLE>  
                 <center> <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">S'inscrire</button> </center>

    </form>
           
           
        </div><!-- /card-container -->
      </div><!-- /container -->       
     
    <?php
}
?>