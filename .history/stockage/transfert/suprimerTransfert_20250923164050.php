<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }
    
    // Pour la supression d'un transfert avec un get de idsupreception
    include "../../connexion/conexiondb.php";


    if(isset($_GET['idsuptransfert'])){
        $id = $_GET['idsuptransfert'];
        $numbobine=$_GET['numbobine'];
        $idtransfertsup = $_GET['idtransfertsup'];

        $sql = "UPDATE `transfertdetails` set `actif`=0, `couleurhistorique`=1 where idtransfertdetail=$idtransfertsup";
        $db->query($sql);

        // Enlever le num bobine
            $req ="UPDATE matiere SET `numbobine` = '' where `numbobine`=?;";
            $reqtitre = $db->prepare($req);
            $reqtitre->execute(array($numbobine));
        // Fin enlever le num bobine

        header("location: detailTransfert.php?idtransfert=$id");
        exit;
    }

    if(isset($_GET['idtransfertreel'])){
        $id = $_GET['idtransfertreel'];
        $sql = "UPDATE `transfert` set `actif`=0 where idtransfert=$id";
        $db->query($sql);

        //Pour suprimer tous les details de ce transfert
        $sql = "UPDATE `transfertdetails` set `actif`=0, `couleurhistorique`=1 where idtransfert=$id";
        $db->query($sql);
        
        header("location: transfert.php");
        exit;
    }

?>