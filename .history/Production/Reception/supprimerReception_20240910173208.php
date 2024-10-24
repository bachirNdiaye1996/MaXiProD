<?php

    session_start(); 

    if(!$_SESSION){
        header('Location: ../../404.php');
    }

    // Pour la supression d'une reception avec un get de idsupreception pour reception detail
    include "../../connexion/conexiondb.php";


    if(isset($_GET['idsupreceptionDetail'])){
        $id = $_GET['idsupreceptionDetail'];
        $sql = "UPDATE `receptionmachinedetails` set `actif`=0, `couleurhistorique`=1 where idreceptionmachinedetails=$id";
        $db->query($sql);

        header("location: detailsReception.php?idreception=$_GET[idreceptionDemandeAccepter]");
        exit;
    }

?>