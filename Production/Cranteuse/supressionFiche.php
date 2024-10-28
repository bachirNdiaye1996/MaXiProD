<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }
    
    // Pour la supression d'une reception avec un get de idsupreception
    include "../../connexion/conexiondb.php";
    include "./mailProductionCranteuse.php";
    include "../../variables.php";



    if(isset($_GET['idsupfiche'])){
        $idsupfiche = $_GET['idsupfiche'];
        $quart = $_GET['quart'];

        $sql = "UPDATE `fichecranteuseq1` set `actif`=0, `couleurhistoriqueSup`=1, `actifapprouvprod`= 0, `accepteprodmodif`= 0 where `idfichecranteuseq1`=$idsupfiche";
        $db->query($sql);

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
                    <p align='center' style='color:white'>$_SESSION[nomcomplet] a supprimé la fiche de production cranteuse (quart $quart) de code de production : <strong>CRAN-$idsupfiche</strong></p>
                    <p align='center'><a href=$HOST style='color:white'>Cliquez ici pour y acceder.</a></p>
                </p>
                <br><br>
            </div>
        </body>
        </html>
            ";

        // Utilisateur admin seul
            $sql = "SELECT * FROM `utilisateur` where `actif`=1 and `niveau`='admin';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $UserMails = $query->fetchAll();
        //** Fin select 
        foreach($UserMails as $user => $item){
            envoie_mail("Gestion de production suppression fiche",$item['email'],"Suppression de la fiche de code CRAN-$idsupfiche",$messageD);
        }

        header("location: ficheCranteuse.php");
        exit;
    }

    /*if(isset($_GET['idexportationreel'])){
        $id = $_GET['idexportationreel'];
        $sql = "UPDATE `exportation` set `actif`=0 where idexportation=$id";
        $db->query($sql);

        //Pour suprimer tous les details de ce transfert
        $sql = "UPDATE `exportationdetails` set `actif`=0, `couleurhistorique`=1 where idexportation=$id";
        $db->query($sql);
        
        header("location: exportation.php");
        exit;
    }*/

?>