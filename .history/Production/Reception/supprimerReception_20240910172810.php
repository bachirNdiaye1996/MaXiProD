<?php

    session_start(); 

    if(!$_SESSION['niveau']){
        header('Location: ../../404.php');
    }

    // Pour la supression d'une reception avec un get de idsupreception pour reception detail
    include "../../connexion/conexiondb.php";


    if(isset($_GET['idsupreceptionDetail'])){
        $id = $_GET['idsupreceptionDetail'];
        $sql = "UPDATE `matiere` set `actif`=0, `couleurhistorique`=1 where idmatiere=$id";
        $db->query($sql);

        header("location: detailsReception.php?idreception=$_GET[idreceptionDemandeAccepter]");
        exit;
    }

?>