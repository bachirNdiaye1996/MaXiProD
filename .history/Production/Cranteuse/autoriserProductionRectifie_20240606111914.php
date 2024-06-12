<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }
    
    include "../../connexion/conexiondb.php";
    include "./mailProductionCranteuse.php";


    // L'admin permet de donner la main au responsable du pont bascule
        if(isset($_GET['idfichecranteuseq1'])){
            $id = $_GET['idfichecranteuseq1']; 
            $quart = $_GET['quart']; 
            //$sql = "UPDATE `reception` set `actifapprouvreception`=0, `status` = 'Approuvée'  where idreception=$id";
            //$db->query($sql);

            $sql1 = "UPDATE `fichecranteuseq1` set `accepteprodmodif`=1 where idfichecranteuseq1=$id";
            $db->query($sql1);

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuse ORDER BY `idcranteuseq1consommation` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau 
                $consommations = $query->fetchAll();
            //** Fin select de la production 

            foreach($consommations as $consommation => $key){  
                $diametre = $key['diametre'];
                $numerofin = $key['numerofin'];

                // On enleve une bobine dans la table epaisseur
                $req ="UPDATE epaisseur SET `$diametre` = `$diametre` + 1 where `lieu`='Cranteuse';";
                //$db->query($req);
                $reqtitre = $db->prepare($req);
                $reqtitre->execute();

                //On enleve une bobine dans la table matiere
                $req ="UPDATE matiere SET `nbbobineactuel` = `nbbobineactuel` + 1 where `numbobine`= ?;";
                $reqtitre = $db->prepare($req);
                $reqtitre->execute(array($numerofin));      
            }


            $messageD = "
            <html>
            <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                <title>Nouveau compte</title>
            </head>
            <body>
                <div id='email-wrap' style='background: #3F5EFB; border-radius: 10px;'><br><br>
                    <p align='center' style='margin-top:20px;'>
                        <h2 align='center' style='color:white'>METAL * * * AFRIQUE</h2>
                        <p align='center' style='color:white'>$_SESSION[nomcomplet] a approuvé la demande d'autorisation de modifier ou de supprimer la fiche de cranteuse (quart $quart) de code : <strong>CRAN-$id</strong></p>
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
                envoie_mail("Gestion de production réctification",$item['email'],"Demande de réctification de la fiche de code CRANQ1-$idcranteuseq1",$messageD);
            }

            header("location: ficheCranteuse.php?idcranteuseq1=$idcranteuseq1&quart=$quart");
            exit;
        }
    // Fin admin permet de donner la main au responsable du pont bascule
?>