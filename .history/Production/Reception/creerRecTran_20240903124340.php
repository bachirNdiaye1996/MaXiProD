<?php

    session_start(); 

    if(!$_SESSION['niveau']){
        header('Location: ../../../404.php');
    }

    include "../../connexion/conexiondb.php";
    include "./mailReception.php";

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
?>