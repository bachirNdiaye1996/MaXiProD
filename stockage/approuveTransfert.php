<?php
    // Pour la supression d'une reception avec un get de idsupreception
    include "../connexion/conexiondb.php";

    if(isset($_GET['idapptransfert'])){
        $id = $_GET['idapptransfert'];
        $sql = "UPDATE `transfert` set `actifapprouvreception`=1 where idtransfert=$id";
        $db->query($sql);
    }
    header('location:transfert.php');
    exit;
?>