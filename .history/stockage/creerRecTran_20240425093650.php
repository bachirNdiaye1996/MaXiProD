<?php

    session_start(); 

    if(!$_SESSION['niveau']){
        header('Location: ../../../404.php');
    }

    include "../connexion/conexiondb.php";
    include "./mailReception.php";

    // Pour insertion une nouvelle reception
        if(isset($_GET['creerReception'])){

            $user=htmlspecialchars($_GET['user']);

            $insertUser=$db->prepare("INSERT INTO `reception` (`idreception`, `status`, `datecreation`, `user`, `actif`, `actifapprouvreception`) 
                VALUES (NULL, 'Pas encore approuvée', current_timestamp(), ?, '1', '1');");
            $insertUser->execute(array($user));

            header("location: reception.php");
            exit;
        }
    //Fin insertion une nouvelle reception

    // Pour insertion une nouvelle reception planifiée
        if(isset($_GET['creerReceptionPlanifie'])){

            $user=htmlspecialchars($_GET['user']);

            // Pour insertion une nouvelle reception planifiée
            $insertUser=$db->prepare("INSERT INTO `receptionplanifiee` (`idreception`, `status`, `datecreation`, `user`, `actif`) 
                VALUES (NULL, 'Réception planifiée', current_timestamp(), ?, '1');");
            $insertUser->execute(array($user));

            //Pour insertion une nouvelle reception en meme temps
            $insertUser=$db->prepare("INSERT INTO `reception` (`idreception`, `status`, `datecreation`, `user`, `actif`, `actifapprouvreception`) 
            VALUES (NULL, 'Nouvelle reception', current_timestamp(), ?, '1', '1');");
            $insertUser->execute(array($user));

            $mid = $pdo->lastInsertId() ;

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
                        <p align='center' style='color:white'>$_SESSION[nomcomplet] a créé une nouvelle réception.</p>
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
                envoie_mail("Gestion de production, nouvelle réception",$item['email'],"Nouvelle réception",$messageD);
            }

            header("location: receptionPlanifie.php");
            exit;
        }
    //Fin insertion une nouvelle reception planifiée
?>