<?php

    session_start(); 

    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }
    
    include "../../connexion/conexiondb.php";
    include "./mailTransfert.php";

    //print_r($_GET)

    // L'admin permet de donner la main au responsable du pont bascule
        if(isset($_GET['idmatiereDemandeAccepter'])){
            $id = $_GET['idmatiereDemandeAccepter'];
            //$sql = "UPDATE `reception` set `actifapprouvreception`=0, `status` = 'Approuvée'  where idreception=$id";
            //$db->query($sql);

            $sql1 = "UPDATE `transfertdetails` set `acceptereceptionmodif`=0 where idtransfertdetail=$id";
            $db->query($sql1);


            //foreach ($Reception as $key => $value) {
            //C'est pour faire les update des points de départ
                $epaisseur     = $_GET['epaisseur'];
                $nbbobine      = $_GET['nombrebobine'];
                $pointdepart   = $_GET['pointdepart'];
                $pointarrive   = $_GET['pointarrive'];
                $idPointdepart = $_GET['idPointdepart'];
                $idPointarrive = $_GET['idPointarrive'];

                // ajouter le nombre de bobine dans le lieu de depart
                    $req ="UPDATE matiere SET `nbbobineactuel` = `nbbobineactuel` + ? where `idmatiere`='$idPointdepart';";
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                // Fin ajouter le nombre de bobine dans le lieu de depart

                // Retrancher le nombre de bobine dans le lieu de depart
                    $req ="UPDATE matiere SET `nbbobineactuel` = `nbbobineactuel` - ? where `idmatiere`='$idPointarrive';";
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                // Fin ajouter le nombre de bobine dans le lieu de depart


                if(("$pointdepart" == "Metal1")){ // Vérifie le type de transfert
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=1;";  //Metal 1
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                    //Fin inserer le nombre de bobine par epaisseur
                }elseif(("$pointdepart" == "Niambour")){
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=3;";  // Metal 3 dit Niambour
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                    //Fin inserer le nombre de bobine par epaisseur
                }
                elseif(("$pointdepart" == "Metal Mbao")){
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=6;";  // Metal Mbao 
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                    //Fin inserer le nombre de bobine par epaisseur
                }elseif(("$pointdepart" == "Cranteuse")){
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=4;";  // Cranteuse
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                    //Fin inserer le nombre de bobine par epaisseur
                }
                elseif(("$pointdepart" == "Tréfilage")){
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=5;";  // Tréfilage
                    //$db->query($req);
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                    //Fin inserer le nombre de bobine par epaisseur
                }
            // Fin pour faire les update des points depart

            // C'est pour faire les update des points d'arrive
                if(("$pointarrive" == "Metal1")){ // Vérifie le type de transfert
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` - ? where `id`=1;";  //Metal 1
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                    //Fin inserer le nombre de bobine par epaisseur
                }elseif(("$pointarrive" == "Niambour")){
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` - ? where `id`=3;";  // Metal 3 dit Niambour
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                    //Fin inserer le nombre de bobine par epaisseur
                }
                elseif(("$pointarrive" == "Metal Mbao")){
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` - ? where `id`=6;";  // Metal Mbao dit Niambour
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                    //Fin inserer le nombre de bobine par epaisseur
                }elseif(("$pointarrive" == "Cranteuse")){
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` - ? where `id`=4;";  // Cranteuse
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                    //Fin inserer le nombre de bobine par epaisseur
                }
                elseif(("$pointarrive" == "Tréfilage")){
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` - ? where `id`=5;";  // Tréfilage
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                    //Fin inserer le nombre de bobine par epaisseur
                }
            // Fin pour faire les update des points d'arrive
            //}

            
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
                        <p align='center' style='color:white'>$_SESSION[nomcomplet] a approuvé la demande d'autorisation de modifier ou de supprimer du transfert de code de transfert : <strong>TRAN00-$_GET[idtransfertDemandeAccepter] </strong></p>
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
                envoie_mail("Gestion de production réctification",$item['email'],"Demande de réctification pour le transfert de code TRAN00-$_GET[idtransfertDemandeAccepter]",$messageD);
            }

            header("location: detailTransfert.php?idtransfert=$_GET[idtransfertDemandeAccepter]");
            exit;
        }
    // Fin admin permet de donner la main au responsable du pont bascule
?>