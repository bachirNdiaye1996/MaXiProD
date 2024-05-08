<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }
    
    include "../../connexion/conexiondb.php";

    // Pour insertion une nouvelle reception
        if(isset($_GET['creerExportation'])){

            $user=htmlspecialchars($_GET['user']);

            //Fin inserer le nombre de bobine par epaisseur
            $insertUser=$db->prepare("INSERT INTO `exportation` (`idexportation`, `dateajout`,
            `user`, `commentaire`) VALUES (NULL, current_timestamp(),?,'');");
            $insertUser->execute(array($user));
            //** Fin nombre des bobines total

            header("location: transfert.php");
            exit;
        }
    //Fin insertion une nouvelle reception
?>