<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }
    
    include "../../connexion/conexiondb.php";
    include "./mailProductionCranteuse.php";


    // L'admin permet de donner la main au responsable du pont bascule
        if(isset($_GET['idcranteuseq1'])){
            $id = $_GET['idcranteuseq1'];
            //$sql = "UPDATE `reception` set `actifapprouvreception`=0, `status` = 'Approuvée'  where idreception=$id";
            //$db->query($sql);

            $sql1 = "UPDATE `cranteuseq1` set `accepteprodmodif`=1 where idcranteuseq1=$id";
            $db->query($sql1);


            /* //C'est pour faire les update des points de départ
                //Debut inserer le nombre de bobine par epaisseur
                $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=4;";  // Cranteuse
                //$db->query($req); 
                $reqtitre = $db->prepare($req);
                $reqtitre->execute(array($nbbobine));
                //Fin inserer le nombre de bobine par epaisseur
            // Fin pour faire les update des points depart */

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
                        <p align='center' style='color:white'>$_SESSION[nomcomplet] a approuvé la demande d'autorisation de modifier ou de supprimer une exportation de code d'exportation : <strong>EXP00-$_GET[idexportationDemandeAccepter] </strong></p>
                        <p align='center'><a href='http://10.10.10.127:8082/GestionProduction' style='color:white'>Cliquez ici pour y acceder.</a></p>
                    </p>
                    <br><br>
                </div>
            </body>
            </html>
                ";

            // Utilisateur admin seul
                $sql = "SELECT * FROM `utilisateur` where `actif`=1 and `niveau`='pontbascule';";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $UserMails = $query->fetchAll();
            //** Fin select 
            foreach($UserMails as $user => $item){
                envoie_mail("Gestion de production réctification",$item['email'],"Demande de réctification pour le transfert de code TRAN00-$_GET[idexportationDemandeAccepter]",$messageD);
            }

            header("location: detailExportation.php?idexportation=$_GET[idexportationDemandeAccepter]");
            exit;
        }
    // Fin admin permet de donner la main au responsable du pont bascule
?>