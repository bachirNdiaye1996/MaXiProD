<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }
    
    include "../../connexion/conexiondb.php";

    // Pour insertion une nouvelle exportation
        if(isset($_GET['creerExportation'])){
            $user=htmlspecialchars($_GET['user']);

            $insertUser=$db->prepare("INSERT INTO `exportation` (`idexportation`, `dateajout`,
            `user`, `commentaire`) VALUES (NULL, current_timestamp(),?,'');");
            $insertUser->execute(array($user));

            header("location: exportation.php");
            exit;
        }
    //Fin insertion une nouvelle exportation
?>