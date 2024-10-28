<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";
    include "./mailReception.php";
    include "../../variables.php";


    // Pour la supression d'une reception avec un get de idsupreception
        if(isset($_GET['idmatiereDemandeRectifier'])){
            $id = $_GET['idmatiereDemandeRectifier'];
            //$sql = "UPDATE `reception` set `actifapprouvreception`=0, `status` = 'Approuvée'  where idreception=$id";
            //$db->query($sql);

            $sql1 = "UPDATE `receptionmachinedetails` set `actifapprouvreception`=1 where idreceptionmachinedetails=$id";
            $db->query($sql1);

            //Pour enlever la couleur rouge
            $sql1 = "UPDATE `receptionmachinedetails` set `acceptereceptionmodif`=1 where idreceptionmachinedetails=$id";
            $db->query($sql1);

            header("location: detailsReception.php?idreception=$_GET[idreceptionDemandeRectifier]");
            exit;
        }
    // Fin pour la supression d'une reception avec un get de idsupreception

    // L'admin permet de donner la main au responsable du pont bascule
        if(isset($_GET['idmatiereDemandeAccepter'])){
            $id = $_GET['idmatiereDemandeAccepter'];

            $sql1 = "UPDATE `receptionmachinedetails` set `acceptereceptionmodif`=1 where idreceptionmachinedetails=$id";
            $db->query($sql1);

            $idRecep = $_GET['idreceptionDemandeAccepter'];  //Id reception

            $messageD = "
            <html>
            <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                <title>Nouveau compte</title>
            </head>
            <body>
                <div id='email-wrap' style='background: #3F5EFB; border-radius: 10px;'><br><br>
                    <p align='center' style='margin-top:20px;'>
                        <h2 align='center' style='color:white'>METAL * * * AFRIQUE</h2>
                        <p align='center' style='color:white'>$_SESSION[nomcomplet] a approuvé la demande d'autorisation de modifier ou de supprimer une réception (Trefilage ou Cranteuse) de code de réception : <strong>REC00-$idRecep </strong></p>
                        <p align='center'><a href=$HOST style='color:white'>Cliquez ici pour y acceder.</a></p>
                    </p>
                    <br><br>
                </div>
            </body>
            </html>
                ";

            // Utilisateur admin seul
                $sql = "SELECT * FROM `utilisateur` where `actif`=1 and `niveau`='chefquart';";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $UserMails = $query->fetchAll();
            //** Fin select 
            foreach($UserMails as $user => $item){
                envoie_mail("Gestion de production réctification",$item['email'],"Demande de réctification pour la réception de code de réception REC00-$idRecep",$messageD);
            }

            header("location: detailsReception.php?idreception=$idRecep");
            exit;
        }
    // Fin admin permet de donner la main au responsable du pont bascule

?>