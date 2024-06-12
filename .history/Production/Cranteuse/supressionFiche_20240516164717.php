<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }
    
    // Pour la supression d'une reception avec un get de idsupreception
    include "../../connexion/conexiondb.php";


    if(isset($_GET['idsupfiche'])){
        $idsupfiche = $_GET['idsupfiche'];
        $sql = "UPDATE `fichecranteuseq1` set `actif`=0, `couleurhistorique`=1 where `idfichecranteuseq1`=$idsupfiche";
        $db->query($sql);

        header("location: ficheCranteuse.php?idcranteuseq1=$idcranteuseq1&quart=$quart"");
        exit;
    }

    /*if(isset($_GET['idexportationreel'])){
        $id = $_GET['idexportationreel'];
        $sql = "UPDATE `exportation` set `actif`=0 where idexportation=$id";
        $db->query($sql);

        //Pour suprimer tous les details de ce transfert
        $sql = "UPDATE `exportationdetails` set `actif`=0, `couleurhistorique`=1 where idexportation=$id";
        $db->query($sql);
        
        header("location: exportation.php");
        exit;
    }*/

?>