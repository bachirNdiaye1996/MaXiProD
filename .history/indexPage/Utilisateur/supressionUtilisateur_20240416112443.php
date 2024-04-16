<?php

    session_start(); 

    if((strcmp("$_SESSION[niveau]","admin") !== 0) && $_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    // Pour la supression d'une reception avec un get de idsupreception pour reception detail
    include "../../connexion/conexiondb.php";


    if(isset($_GET['idutilisateur'])){
        $id = $_GET['idutilisateur'];
        //On supprime l'utilisateur
            $req ="UPDATE utilisateur SET `actif`=0 where `id`=?;"; 
            //$db->query($req); 
            $reqtitre = $db->prepare($req);
            $reqtitre->execute(array($id));
        //Fin suppression
    }
?>