<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }
    
    // Pour la supression d'une reception avec un get de idsupreception
    include "../../connexion/conexiondb.php";


    if(isset($_GET['idsupexportation'])){
        $id = $_GET['idsupexportation'];
        $idexportationsup = $_GET['idexportationsup'];
        $sql = "UPDATE `exportationdetails` set `actif`=0 where idexportationdetail=$idexportationsup";
        $db->query($sql);

        header("location: detailExportation.php?idexportation=$id");
        exit;
    }

    if(isset($_GET['idexportationreel'])){
        $id = $_GET['idexportationreel'];
        $sql = "UPDATE `exportation` set `actif`=0 where idexportation=$id";
        $db->query($sql);

        //Pour suprimer tous les details de ce transfert
        $sql = "DELETE from `exportationdetails` where idexportation=$id";
        $db->query($sql);
        
        header("location: exportation.php");
        exit;
    }

?>