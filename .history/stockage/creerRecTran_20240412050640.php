<?php

    session_start(); 

    if(!$_SESSION['niveau']){
        header('Location: ../../../404.php');
    }

    include "../connexion/conexiondb.php";

    // Pour insertion une nouvelle reception
        if(isset($_GET['creerReception'])){

            $user=htmlspecialchars($_GET['user']);

            $insertUser=$db->prepare("INSERT INTO `reception` (`idreception`, `status`, `datecreation`, `user`, `actif`, `actifapprouvreception`) 
                VALUES (NULL, 'Pas encore approuvée', current_timestamp(), ?, '1', '1');");
            $insertUser->execute(array($user));

            header("location: reception.php");
            exit;
        }
    //Fin insertion une nouvelle reception

    // Pour insertion une nouvelle reception planifiée
        if(isset($_GET['creerReceptionPlanifie'])){

            $user=htmlspecialchars($_GET['user']);

            // Pour insertion une nouvelle reception planifiée
            $insertUser=$db->prepare("INSERT INTO `receptionplanifiee` (`idreception`, `status`, `datecreation`, `user`, `actif`) 
                VALUES (NULL, 'Réception planifiée', current_timestamp(), ?, '1');");
            $insertUser->execute(array($user));

            //Pour insertion une nouvelle reception en meme temps
            $insertUser=$db->prepare("INSERT INTO `reception` (`idreception`, `status`, `datecreation`, `user`, `actif`, `actifapprouvreception`) 
            VALUES (NULL, 'Nouvelle reception', current_timestamp(), ?, '1', '1');");
            $insertUser->execute(array($user));

            header("location: receptionPlanifie.php");
            exit;
        }
    //Fin insertion une nouvelle reception planifiée
?>