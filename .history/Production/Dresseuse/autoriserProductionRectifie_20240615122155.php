<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }
    
    include "../../connexion/conexiondb.php";
    include "./mailProductionCranteuse.php";


    // L'admin permet de donner la main au responsable du pont bascule
        if(isset($_GET['idfichedresseuse'])){
            $id = $_GET['idfichedresseuse']; 
            $dateCreation = $_GET['dateCreation']; 
            $machine = $_GET['machine']; 
            $quart = $_GET['quart']; 
            //$sql = "UPDATE `reception` set `actifapprouvreception`=0, `status` = 'Approuvée'  where idreception=$id";
            //$db->query($sql);

            $sql1 = "UPDATE `fichedresseuse` set `accepteprodmodif`=1 where idfichedresseuse=$id";
            $db->query($sql1);

            $messageD = "
            <html>
            <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                <title></title>
            </head>
            <body>
                <div id='email-wrap' style='background: #3F5EFB; border-radius: 10px;'><br><br>
                    <p align='center' style='margin-top:20px;'>
                        <h2 align='center' style='color:white'>METAL * * * AFRIQUE</h2>
                        <p align='center' style='color:white'>$_SESSION[nomcomplet] a approuvé la demande d'autorisation de modifier ou de supprimer la fiche de production de la machine $machine du $dateCreation (quart $quart) de code : <strong>DRES-$id</strong></p>
                        <p align='center'><a href='http://10.10.10.127:8082/GestionProduction' style='color:white'>Cliquez ici pour y acceder.</a></p>
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
                envoie_mail("Gestion de production réctification",$item['email'],"Demande de réctification de la fiche de code DRES-$idfichedresseuse",$messageD);
            }

            header("location: ficheCranteuse.php?idcranteuseq1=$idcranteuseq1&quart=$quart");
            exit;
        }
    // Fin admin permet de donner la main au responsable du pont bascule
?>