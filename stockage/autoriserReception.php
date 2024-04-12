<?php

    session_start(); 

    if(!$_SESSION['niveau']){
        header('Location: ../../../404.php');
    }
    
    // Pour l'autorisation des demandes de rectifications 
    include "../connexion/conexiondb.php";

    if(isset($_GET['idautoriserreception'])){
        $id = $_GET['idautoriserreception'];
        $sql = "UPDATE `reception` set `acceptereception`=0, `status` = 'Pas encore approuvée' where idreception=$id";
        $db->query($sql);
    
        $sql1 = "UPDATE `matiere` set `actifapprouvreception`=0 where idreception=$id";
        $db->query($sql1);

        header('location: reception.php');
        exit;
    }

?>