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
            $idcranteuseq1 = $_GET['idcranteuseq1']; 
            //$sql = "UPDATE `reception` set `actifapprouvreception`=0, `status` = 'Approuvée'  where idreception=$id";
            //$db->query($sql);

            $sql1 = "UPDATE `fichecranteuseq1` set `accepteprodmodif`=1 where idfichecranteuseq1=$id";
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
                        <p align='center' style='color:white'>$_SESSION[nomcomplet] a approuvé la demande d'autorisation de modifier ou de supprimer la fiche de cranteuse de code : <strong>CRANQ1-$id</strong></p>
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
                envoie_mail("Gestion de production réctification",$item['email'],"Demande de réctification de la fiche de code CRANQ1-$id",$messageD);
            }

            header("location: quart1.php");
            exit;
        }
    // Fin admin permet de donner la main au responsable du pont bascule
?>