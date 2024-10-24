<?php

    session_start(); 

    if((strcmp("$_SESSION[niveau]","admin") !== 0)){
        header("location: ../../404.php");
        return 0;
    }

    // Pour la supression d'une reception avec un get de idsupreception pour reception detail
    include "../../connexion/conexiondb.php";


    if(isset($_GET['idgestiontempsarret'])){
        $id = $_GET['idgestiontempsarret'];
        //On supprime l'utilisateur
            $req ="UPDATE gestiontempsarret SET `actif`=0 where `idgestiontempsarret`=?;"; 
            //$db->query($req); 
            $reqtitre = $db->prepare($req);
            $reqtitre->execute(array($id));
        //Fin suppression
    }
?>