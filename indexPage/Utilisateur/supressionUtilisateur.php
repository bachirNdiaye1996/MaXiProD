<?php

    session_start(); 

    if($_SESSION['niveau'] != 'admin'){
        header('Location: ../../../../404.php');
    }

    // Pour la supression d'une reception avec un get de idsupreception pour reception detail
    include "../../connexion/conexiondb.php";


    if(isset($_GET['idutilisateur'])){
        $id = $_GET['idutilisateur'];
        //On supprime l'utilisateur
            $req ="UPDATE utilisateur SET `actif`=0 where `id`=?;"; 
            //$db->query($req); 
            $reqtitre = $db->prepare($req);
            $reqtitre->execute(array($id));
        //Fin suppression
    }
?>