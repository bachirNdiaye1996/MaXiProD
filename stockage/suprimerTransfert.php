<?php
    // Pour la supression d'une reception avec un get de idsupreception
    include "../connexion/conexiondb.php";


    if(isset($_GET['idsuptransfert'])){
        $id = $_GET['idsuptransfert'];
        $sql = "UPDATE `transfert` set `actif`=0 where idtransfert=$id";
        $db->query($sql);

        $epaisseur = $_GET['epaisseur'];
        $nbbobine = $_GET['nombrebobine'];
        //Debut inserer le nombre de bobine par epaisseur
        $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ?;";
        $reqtitre = $db->prepare($req);
        $reqtitre->execute(array($nbbobine));
        //Fin inserer le nombre de bobine par epaisseur
    }
    
    header('location: transfert.php');
    exit;
?>