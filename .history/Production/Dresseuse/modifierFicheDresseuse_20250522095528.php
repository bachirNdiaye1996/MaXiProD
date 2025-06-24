<?php
    
    session_start(); 
    
    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";
    include "./mailProductionDresseuse.php";
    include "../../variables.php";



    //Variables
    $valideFiche="";
    $ProblemeQuart="";
    $ProblemeCompteur="";
    $ProblemeArret="";
    $ProblemeFicheExist="";
    $ProblemeFilMachine="";

    $idsupfiche = $_GET['idsupfiche'];  // On recupére l'ID idcranteuseq1 par get
    $quart = $_GET['quart'];


    if($_SERVER["REQUEST_METHOD"]=='GET'){
        if(!isset($_GET['idsupfiche'])){
            header("location: ficheDresseuse.php");
            exit;
        }
        $sql = "select * from fichedresseuse where idfichedresseuse=$idsupfiche and actif = 1";
        $result = $db->query($sql);
        $rowEntete = $result->fetch();

        $sql = "select * from dresseusearret where idfichedresseuse=$idsupfiche and actif = 1";
        $result = $db->query($sql);
        $rowErreurs = $result->fetchAll();

        $sql = "select * from dresseuseconsommation where idfichedresseuse=$idsupfiche and actif = 1";
        $result = $db->query($sql);
        $rowConsommations = $result->fetchAll();

        $sql = "select * from dresseuseproduction where idfichedresseuse=$idsupfiche and actif = 1";
        $result = $db->query($sql);
        $rowProductions = $result->fetchAll();

        while(!$rowEntete){
            header("location: ficheDresseuse.php");
            exit;
        }
        if($rowEntete['accepteprodmodif'] == 0 && $rowEntete['actifapprouvprod'] == 0){
            header("location: ficheDresseuse.php");
            exit;
        }
    }else{  
        //Update une fiche
        if(isset($_POST['CreerFicheProduction'])){

            // Pour obtenir le nombre de rowConsommations en d'erreur
            $sql = "select * from dresseuseconsommation where idfichedresseuse=$idsupfiche and actif = 1";
            $result = $db->query($sql);
            $rowConsommations = $result->fetchAll();

            $compteurdebut=htmlspecialchars( $_POST['compteurdebut']);
            $compteurfin=htmlspecialchars( $_POST['compteurfin']);
            $controleur1=htmlspecialchars( $_POST['controleur1']);
            $controleur2=htmlspecialchars($_POST['controleur2']);
            $machine=htmlspecialchars( $_POST['machine']);
            $datecreationfiche=htmlspecialchars( $_POST['datecreationfiche']);
            $observationdebut=htmlspecialchars($_POST['observationdebut']);
            $heuredepartquart=htmlspecialchars($_POST['heuredepartquart']);
            $heurefinquart=htmlspecialchars( $_POST['heurefinquart']);
            $user=htmlspecialchars( $_POST['user']);
            $quart=htmlspecialchars($_POST['quart']);
            $vitesse=htmlspecialchars( $_POST['vitesse']);
            $observationfin=htmlspecialchars($_POST['observationfin']);
            $poidsestimetravaillenonnote=htmlspecialchars($_POST['poidsestimetravaillenonnote']);

            // Vérifie si les heures du quart sont correctes
                $heures = explode(":", $heuredepartquart);
                $heuredepartquartHeure = $heures[0]; 
                $heuredepartquartMin = $heures[1]; 

                $heures = explode(":", $heurefinquart);
                $heurefinquartHeure = $heures[0]; 
                $heurefinquartMin = $heures[1];
            // Fin

            //On verifie avant d'inserer
                // Quart
                    if(($heurefinquartHeure > $heuredepartquartHeure) || (( $heurefinquartHeure == $heuredepartquartHeure)&&( $heurefinquartMin > $heuredepartquartMin))){
                    }else{
                        $ProblemeQuart="erreurProblemeQuart";
                    }

                //On vérifie si la fiche existe ou pas
                    $sqlEpaisseur = "SELECT * FROM `fichedresseuse` WHERE `actif`=1 AND `quart`='$quart' AND `machine`='$machine' AND `dateCreation`='$datecreationfiche' AND `accepteprodmodif`=0 AND `actifapprouvprod`=0;";
                    // On prépare la requête
                    $queryEpaisseur = $db->prepare($sqlEpaisseur);
                    $queryEpaisseur->execute();
                    $resultEpaisseur = $queryEpaisseur->fetch();
                    
                    if($resultEpaisseur){
                        $ProblemeFicheExist="erreurProblemeFicheExist";
                    }
                // Fin

                // Compteur
                if(($ProblemeQuart != "erreurProblemeQuart")){
                    if(($compteurfin > $compteurdebut)){
                        for ($i = 0; $i < count($_POST['debutarret']); $i++){
                            $debutarret=htmlspecialchars( $_POST['debutarret'][$i]);
                            $finarret=htmlspecialchars($_POST['finarret'][$i]);
                            $raisonerreur=htmlspecialchars($_POST['raisonerreur'][$i]);

                            $heures = explode(":", $finarret);
                            $heureFinHeure = $heures[0]; 
                            $heureFinMin = $heures[1]; 

                            $heures = explode(":", $debutarret);
                            $heureDebutHeure = $heures[0]; 
                            $heureDebutMin = $heures[1]; 

                            if(( $heureFinHeure > $heureDebutHeure) || (( $heureFinHeure == $heureDebutHeure)&&( $heureFinMin > $heureDebutMin))){
                                //echo ($heureFinHeure-$heureDebutHeure).":".($heureFinMin-$heureDebutMin);
                            }else{
                                $ProblemeArret="erreurProblemeArret";
                            }
                        }
                    }else{
                        $ProblemeCompteur="erreurProblemeCompteur";
                    }
                }

                //Consommations
                    for ($i = 0; $i < count($_POST['diametre']); $i++){   
                        $diametre=htmlspecialchars( $_POST['diametre'][$i]);
                        $numerofin=htmlspecialchars($_POST['numerofin'][$i]);

                        if($numerofin == ""){
                            $ProblemeFilMachine="erreurProblemeFilMachine";
                        }                 
                    }

                //Productions
                    for ($i = 0; $i < count($_POST['Proddiametre']); $i++){   
                        $diametre=htmlspecialchars( $_POST['Proddiametre'][$i]);
                        $numerofin=htmlspecialchars($_POST['Prodnumerofin'][$i]);

                        if($numerofin == ""){
                            $ProblemeFilMachine="erreurProblemeFilMachine";
                        } 
                    }
            //Fin verification
            
            if($ProblemeArret != "erreurProblemeArret" && $ProblemeCompteur != "erreurProblemeCompteur" && $ProblemeQuart != "erreurProblemeQuart" && $ProblemeFicheExist != "erreurProblemeFicheExist" && $ProblemeFilMachine != "erreurProblemeFilMachine"){  

                // Inserer dans le log
                    $sql = "select * from fichedresseuse where idfichedresseuse=$idsupfiche and actif = 1";
                    $result = $db->query($sql);
                    $rowEntete = $result->fetch();
            
                    $sql = "select * from dresseusearret where idfichedresseuse=$idsupfiche and actif = 1";
                    $result = $db->query($sql);
                    $rowErreurs = $result->fetchAll();
            
                    $sql = "select * from dresseuseconsommation where idfichedresseuse=$idsupfiche and actif = 1";
                    $result = $db->query($sql);
                    $rowConsommations = $result->fetchAll();
            
                    $sql = "select * from dresseuseproduction where idfichedresseuse=$idsupfiche and actif = 1";
                    $result = $db->query($sql);
                    $rowProductions = $result->fetchAll();

                    $Rcompteurdebut=htmlspecialchars( $rowEntete['compteurdebut']);
                    $Rcompteurfin=htmlspecialchars( $rowEntete['compteurfin']);
                    $Rcontroleur1=htmlspecialchars( $rowEntete['controleur1']);
                    $Rcontroleur2=htmlspecialchars($rowEntete['controleur2']);
                    $Rmachine=htmlspecialchars( $rowEntete['machine']);
                    $Rdatecreationfiche=htmlspecialchars( $rowEntete['dateCreation']);
                    $Robservationdebut=htmlspecialchars($rowEntete['observationdebut']);
                    $Rheuredepartquart=htmlspecialchars($rowEntete['heuredepartquart']);
                    $Rheurefinquart=htmlspecialchars( $rowEntete['heurefinquart']);
                    $Ruser=htmlspecialchars( $rowEntete['user']);
                    $Rquart=htmlspecialchars($rowEntete['quart']);
                    $Rvitesse=htmlspecialchars( $rowEntete['vitesse']);
                    $Robservationfin=htmlspecialchars($rowEntete['observationfin']);
                    $Rpoidsestimetravaillenonnote=htmlspecialchars($rowEntete['poidsestimetravaillenonnote']);

                    $insertUser=$db->prepare("INSERT INTO `logfichedresseuse` (`idlogfichedresseuse`, `user`, `dateajout`, `quart`, `actif`, `dateCreation`, `compteurdebut`,
                    `compteurfin`, `controleur1`, `controleur2`, `machine`, `observationdebut`, `heuredepartquart`, `heurefinquart`, `saisisseur`, `vitesse`,
                     `observationfin`, `poidsestimetravaillenonnote`, `idfichedresseuse`, `accepteprodmodif`, `actifapprouvprod`) VALUES (NULL, ?, current_timestamp(), ?, '1', ?, ?,
                     ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', '0');");
                    $insertUser->execute(array($Ruser,$Rquart,$Rdatecreationfiche,$Rcompteurdebut,$Rcompteurfin,$Rcontroleur1,$Rcontroleur2,$Rmachine,$Robservationdebut,$Rheuredepartquart,$Rheurefinquart,$Ruser,$Rvitesse,$Robservationfin,$Rpoidsestimetravaillenonnote,$idsupfiche));

                    // Récuperer le dernier id de la matiére
                        $sqlEpaisseur = "SELECT MAX(idlogfichedresseuse)  AS idMax FROM `logfichedresseuse`";
                        // On prépare la requête
                        $queryEpaisseur = $db->prepare($sqlEpaisseur);
                        $queryEpaisseur->execute();
                        $resultEpaisseur = $queryEpaisseur->fetch();
                        $idMax = (int) $resultEpaisseur['idMax'];
                    // Fin

                    // Arrets
                        foreach($rowErreurs as $rowErreur => $key){
                            $debutarret=htmlspecialchars( $key['debutarret']);
                            $finarret=htmlspecialchars($key['finarret']);
                            $raisonerreur=htmlspecialchars($key['raison']);

                            $insertUser=$db->prepare("INSERT INTO `logdresseusearret` (`idlogdresseusearret`, `debutarret`, `finarret`, `raison`, `idfichedresseuse`, `actif`) 
                            VALUES (NULL, ?, ?, ?, ?, '1');");
                            $insertUser->execute(array($debutarret,$finarret,$raisonerreur,$idMax));
                        }

                    // Consommations
                        foreach($rowConsommations as $rowConsommation => $key){
                            $diametre=htmlspecialchars($key['diametre']);
                            $numerofin=htmlspecialchars($key['numerofin']);
                            $poids=htmlspecialchars($key['poids']);
                            $heuremontagebobine=htmlspecialchars($key['heuremontagebobine']);

                            $insertUser=$db->prepare("INSERT INTO `logdresseuseconsommation` (`idlogdresseuseconsommation`, `diametre`, `numerofin`, `poids`, `idfichedresseuse`, `actif`,`heuremontagebobine`) 
                            VALUES (NULL, ?, ?, ?, ?, '1', ?);");
                            $insertUser->execute(array($diametre,$numerofin,$poids,$idMax,$heuremontagebobine));
                        }

                    // Productions
                        foreach($rowProductions as $rowProduction => $key){
                            $diametre=htmlspecialchars( $key['proddiametre']);
                            $numerofin = htmlspecialchars($key['prodnumerofin']);
                            $poids=htmlspecialchars($key['Prodpoids'][$i]);
                            $ProdnbBarreColis=htmlspecialchars($key['prodnbBarreColis']);
                            $Prodnbcolis=htmlspecialchars($key['prodnbcolis']);
                            $Prodnbbarrerestant=htmlspecialchars($key['prodnbbarrerestant']);
                            $Prodlongueurbarre=htmlspecialchars($key['prodlongueurbarre']);
                            $Proddechet=htmlspecialchars($key['proddechet']);

                            $insertUser=$db->prepare("INSERT INTO `logdresseuseproduction` (`idlogdresseuseproduction`, `proddiametre`, `prodnumerofin`, `prodpoids`, `idfichedresseuse`, `actif`, `prodnbBarreColis`, `prodnbcolis`, `prodnbbarrerestant`, `proddechet`, `prodlongueurbarre`) 
                            VALUES (NULL, ?, ?, ?, ?, '1', ?, ?, ?, ?, ?);");
                            $insertUser->execute(array($diametre,$numerofin,$poids,$idMax, $ProdnbBarreColis,$Prodnbcolis,$Prodnbbarrerestant,$Proddechet,$Prodlongueurbarre));
                        }
                    //

                // Fin inserer dans le log


                $insertUser=$db->prepare("UPDATE `fichedresseuse` SET `user`=?, `quart`=? ,`actifapprouvprod`= 0, `accepteprodmodif`= 0, `dateCreation`=?, `compteurdebut`=?,
                `compteurfin`=?, `controleur1`=?, `controleur2`=?, `machine`=?, `observationdebut`=?, `heuredepartquart`=?, `heurefinquart`=?, `saisisseur`=?, `vitesse`=?, `couleurhistoriquemodif`=1,
                `observationfin`=?, `poidsestimetravaillenonnote`=? where `idfichedresseuse`= $idsupfiche;");
                $insertUser->execute(array($user,$quart,$datecreationfiche,$compteurdebut,$compteurfin,$controleur1,$controleur2,$machine,$observationdebut,$heuredepartquart,$heurefinquart,$user,$vitesse,$observationfin,$poidsestimetravaillenonnote));


                // Arrets
                for ($i = 0; $i < count($_POST['debutarret']); $i++){
                    $debutarret=htmlspecialchars( $_POST['debutarret'][$i]);
                    $finarret=htmlspecialchars($_POST['finarret'][$i]);
                    $raisonerreur=htmlspecialchars($_POST['raisonerreur'][$i]);
                    $idErreur=htmlspecialchars($_POST['idErreur'][$i]);

                    if($idErreur != ""){
                        $insertUser=$db->prepare("UPDATE `dresseusearret` SET `debutarret`=?, `finarret`=?, `raison`=? where `iddresseusearret`=?;");
                        $insertUser->execute(array($debutarret,$finarret,$raisonerreur,$idErreur));

                        // Supprimer la ligne
                        if(isset($_POST['suprimerArret'.$i])){
                            $insertUser=$db->prepare("UPDATE `dresseusearret` SET `actif`=0 where `iddresseusearret`=?;");
                            $insertUser->execute(array($idErreur));
                        }
                    }else{
                        $insertUser=$db->prepare("INSERT INTO `dresseusearret` (`iddresseusearret`, `debutarret`, `finarret`, `raison`, `idfichedresseuse`, `actif`) 
                        VALUES (NULL, ?, ?, ?, ?, '1');");
                        $insertUser->execute(array($debutarret,$finarret,$raisonerreur,$idsupfiche));
                    }

                }

                // Consommations
                for ($i = 0; $i < count($_POST['diametre']); $i++){   
                    $diametre=htmlspecialchars( $_POST['diametre'][$i]);
                    $numerofinString = explode("/", htmlspecialchars($_POST['numerofin'][$i]));
                    $numerofin=$numerofinString[0];
                    $idcranteuseq1prod=$numerofinString[1];
                    $poids=htmlspecialchars($_POST['poids'][$i]);
                    $heuremontagebobine=htmlspecialchars($_POST['heuremontagebobine'][$i]);
                    $idConsommation=htmlspecialchars($_POST['idConsommation'][$i]);

                    // On enleve une bobine dans la table cranteuseq1production
                        if(isset($_POST['finirfm'.$i])){ 
                            if($idConsommation != ""){
                                $insertUser=$db->prepare("UPDATE `dresseuseconsommation` SET `diametre`=?, `finirfm`=1, `numerofin`=?, `poids`=?,
                                `heuremontagebobine`=? where `iddresseuseconsommation`=?;");
                               $insertUser->execute(array($diametre,$numerofin,$poids,$heuremontagebobine,$idConsommation));

                                // Supprimer la ligne
                                if(isset($_POST['suprimerCons'.$i])){
                                    $insertUser=$db->prepare("UPDATE `dresseuseconsommation` SET `actif`=0 where `iddresseuseconsommation`=?;");
                                    $insertUser->execute(array($idConsommation));
                                }else{
                                    $req ="UPDATE cranteuseq1production SET `prodnbbobine`=0 where `idcranteuseq1production`='$idcranteuseq1prod';";
                                    //$db->query($req);
                                    $reqtitre = $db->prepare($req);  
                                    $reqtitre->execute();
                                }

                            }else{
                                $insertUser=$db->prepare("INSERT INTO `dresseuseconsommation` (`iddresseuseconsommation`, `diametre`, `numerofin`, `poids`, `idfichedresseuse`, `actif`, `heuremontagebobine`, `finirfm`) 
                                VALUES (NULL, ?, ?, ?, ?, '1', ?, '1');");
                                $insertUser->execute(array($diametre,$numerofin,$poids,$idsupfiche,$heuremontagebobine));

                                $req ="UPDATE cranteuseq1production SET `prodnbbobine`=0 where `idcranteuseq1production`='$idcranteuseq1prod';";
                                //$db->query($req);
                                $reqtitre = $db->prepare($req);  
                                $reqtitre->execute();
                            }
                        }else{
                            if($idConsommation != ""){
                                $insertUser=$db->prepare("UPDATE `dresseuseconsommation` SET `diametre`=?, `finirfm`=0, `numerofin`=?, `poids`=?,
                                `heuremontagebobine`=? where `iddresseuseconsommation`=?;");
                                $insertUser->execute(array($diametre,$numerofin,$poids,$heuremontagebobine,$idConsommation));
                                
                                // Supprimer la ligne
                                if(isset($_POST['suprimerCons'.$i])){
                                    $insertUser=$db->prepare("UPDATE `dresseuseconsommation` SET `actif`=0 where `iddresseuseconsommation`=?;");
                                    $insertUser->execute(array($idConsommation));
                                }
                            }else{
                                $insertUser=$db->prepare("INSERT INTO `dresseuseconsommation` (`iddresseuseconsommation`, `diametre`, `numerofin`, `poids`, `idfichedresseuse`, `actif`, `heuremontagebobine`) 
                                VALUES (NULL, ?, ?, ?, ?, '1', ?);");
                                $insertUser->execute(array($diametre,$numerofin,$poids,$idsupfiche,$heuremontagebobine));
                            }
                        }
                    //
                }

                // Productions
                    for ($i = 0; $i < count($_POST['Proddiametre']); $i++){   
                        $diametre=htmlspecialchars( $_POST['Proddiametre'][$i]);
                        $numerofinString = explode("/", htmlspecialchars($_POST['Prodnumerofin'][$i]));
                        $numerofin=$numerofinString[0];
                        $poids=htmlspecialchars($_POST['Prodpoids'][$i]);
                        $ProdnbBarreColis=htmlspecialchars($_POST['ProdnbBarreColis'][$i]);
                        $Prodnbcolis=htmlspecialchars($_POST['Prodnbcolis'][$i]);
                        $Prodnbbarrerestant=htmlspecialchars($_POST['Prodnbbarrerestant'][$i]);
                        $Prodlongueurbarre=htmlspecialchars($_POST['Prodlongueurbarre'][$i]);
                        $Proddechet=htmlspecialchars($_POST['Proddechet'][$i]);
                        $iddresseuseproduction=htmlspecialchars($_POST['iddresseuseproduction'][$i]);
                        
                        if($iddresseuseproduction != ""){
                            $insertUser=$db->prepare("UPDATE `dresseuseproduction` SET `proddiametre`=?, `prodnumerofin`=?, `prodpoids`=?, `prodnbBarreColis`=?, `prodnbcolis`=?, `prodnbbarrerestant`=?,
                            `prodlongueurbarre`=?, `proddechet`=?, `idfichedresseuse`=? where `iddresseuseproduction`=?;");
                            $insertUser->execute(array($diametre,$numerofin,$poids,$ProdnbBarreColis,$Prodnbcolis,$Prodnbbarrerestant,$Prodlongueurbarre,$Proddechet,$idsupfiche,$iddresseuseproduction));

                            // Supprimer la ligne
                            if(isset($_POST['suprimerProd'.$i])){
                                $insertUser=$db->prepare("UPDATE `dresseuseproduction` SET `actif`=0 where `iddresseuseproduction`=?;");
                                $insertUser->execute(array($iddresseuseproduction));
                            }
                        }else{
                            $insertUser=$db->prepare("INSERT INTO `dresseuseproduction` (`iddresseuseproduction`, `proddiametre`, `prodnumerofin`, `prodpoids`, `idfichedresseuse`, `actif`, `prodnbBarreColis`, `prodnbcolis`, `prodnbbarrerestant`, `proddechet`, `prodlongueurbarre`,`dateCreation`) 
                            VALUES (NULL, ?, ?, ?, ?, '1', ?, ?, ?, ?, ?, ?);");
                            $insertUser->execute(array($diametre,$numerofin,$poids,$idsupfiche, $ProdnbBarreColis,$Prodnbcolis,$Prodnbbarrerestant,$Proddechet,$Prodlongueurbarre,$datecreationfiche));
                        }
                    }
                //


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
                            <p align='center' style='color:white'>$_SESSION[nomcomplet] a modifié la fiche de production cranteuse (quart $quart) de code de production : <strong>DRESS-$idsupfiche</strong></p>
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
                    envoie_mail("Gestion de production modification fiche",$item['email'],"Modification de la fiche de code CRAN-$idsupfiche",$messageD);
                }

                header("location: detailsFicheDresseuse.php?idfichedresseuse=$idsupfiche&quart=$quart");
                exit;
            }
        }
    }

    //** Debut select de stockage pour Metal1
        $sqlepaisseur = "SELECT * FROM `cranteuseq1production` where `actif`=1 and `prodnbbobine`>0  ORDER BY `idcranteuseq1production` DESC;";

        // On prépare la requête
        $queryepaisseur = $db->prepare($sqlepaisseur);

        // On exécute
        $queryepaisseur->execute();

        // On récupère les valeurs dans un tableau associatif
        $stockCranteuse = $queryepaisseur->fetchAll();
    //** Fin select de stockage pour Metal1
    

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="../../image/iconOnglet.png" />
    <title>METAL AFRIQUE</title>

    <!-- Custom fonts for this template -->
    <link href="../../indexPage/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="../../libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <script src="../../libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../libs/sweetalert2/jquery-1.12.4.js"></script>

    <!-- Custom styles for this template -->
    <link href="../../indexPage/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../indexPage/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script>
        $(document).ready(() => { 
            // Removing Row on click to Remove button
            $('#dynamicaddConsommations').on('click', '.removeConsommations', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });

            // Removing Row on click to Remove button
            $('#dynamicaddProductions').on('click', '.removeProductions', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });

            // Removing Row on click to Remove button
            $('#dynamicaddErreurs').on('click', '.removeErreurs', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });
        })
    </script>

    <script>
        // Pour le loading
            //const loader = document.querySelector('.loader');

            document.addEventListener('DOMContentLoaded', () => {
                //console.log(loader);
                //document.getElementById('loader').className = "fondu-out";
                document.getElementById("loader").remove();
                //loader.classList.add('fondu-out');

            })
        //Pour le loading
    </script>

    <script type="text/javascript"> 
        var foo1 = "<script>";
        var foo2 = "</scr"+"ipt>";
        $(document).ready(function(){  
            var i = <?php echo sizeof($rowConsommations); ?>-1;
            var j = <?php echo sizeof($rowProductions); ?>-1;
            var k = <?php echo sizeof($rowErreurs); ?>-1;
            //console.log()
            $('#addErreurs').click(function(){           
            //alert('ok');           
            k++;           
            $('#dynamicaddErreurs').append(`
            <tr id="row'+k+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control" id="validationDefault04" type="time" name="debutarret[]" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="time" name="finarret[]" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control" id="validationDefault01" type="text" name="raisonerreur[]" value="" placeholder="Mettez la raison d'erreur" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger removeErreurs"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>
            <div class="invisible">
                <div class="">
                    <input class="form-control designa" type="number" step="0.01" name="idErreur[]" id="example" value="">
                </div>
            </div>`
            );});

            $('#addConsommations').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicaddConsommations').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="diametre[]" id="diametre`+i+`" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="numerofin[]" id="numerofin`+i+`" required>
                                <option></option> 
                                <?php
                                    foreach($stockCranteuse as $stock){
                                ?>                                                                                        
                                    <option value="<?php echo $stock['prodnumerofin'].'/'.$stock['idcranteuseq1production'].'/'.$stock['proddiametre'].'/'.$stock['prodpoids']; ?>"> <?php echo $stock['prodnumerofin']; ?></option>                                                                                     
                                <?php
                                    }
                                ?>
                            </select>                                                
                        </div>
                    </div>
                </td>
                `+foo1+`
                    $(document).ready(function(){
                        $('#numerofin`+i+`').change(function(){
                            //Selected value
                            var inputValue = $(this).val();
                            var myArray = inputValue.split('/');
                            document.getElementById("diametre`+i+`").value = myArray[2];
                            document.getElementById("poids`+i+`").value = myArray[3];
                        });
                    });
                `+foo2+`
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="time" name="heuremontagebobine[]" id="example" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="poids[]" id="poids`+i+`" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="" id="finirfm`+i+`">
                            </label>
                        </div>
                    </div>  
                </td>
                `+foo1+`
                    $('#finirfm`+i+`').click(function(){
                        $('#finirfm`+i+`').attr('name', 'finirfm`+i+`[]');
                    });
                `+foo2+`
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger removeConsommations" 
                        type="button">Enlever
                    </button> 
                </td>
            </tr>
            <div class="invisible">
                <div class="">
                    <input class="" type="number" step="0.01" name="idConsommation[]" id="example" value="">
                </div>
            </div>`
            );});
            $(document).on('click','.remove_row',function(){ 
            var row_id = $(this).attr("id");          
            $('#row'+row_id+'').remove();})


            $('#addProductions').click(function(){           
            //alert('ok');           
            j++;           
            $('#dynamicaddProductions').append(`
            <tr id="row'+j+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Proddiametre[]" id="Proddiametre`+j+`" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="ProdnbBarreColis[]" id="ProdnbBarreColis" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Prodnbcolis[]" id="Prodnbcolis" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Prodnbbarrerestant[]" id="Prodnbbarrerestant" value="">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Prodlongueurbarre[]" id="Prodlongueurbarre" value="">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-12">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="Prodnumerofin[]" id="numerofinProd`+j+`" required>
                                <option></option> 
                                <?php
                                    foreach($stockCranteuse as $stock){
                                ?>                                                                                        
                                    <option value="<?php echo $stock['prodnumerofin'].'/'.$stock['idcranteuseq1production'].'/'.$stock['proddiametre'].'/'.$stock['prodpoids']; ?>"> <?php echo $stock['prodnumerofin']; ?></option>                                                                                     
                                <?php
                                    }
                                ?>
                            </select>                                                
                        </div>
                    </div>
                </td>
                `+foo1+`
                    $(document).ready(function(){
                        $('#numerofinProd`+j+`').change(function(){
                            //Selected value
                            var inputValue = $(this).val();
                            var myArray = inputValue.split('/');
                            document.getElementById("Proddiametre`+j+`").value = myArray[2];
                            document.getElementById("Prodpoids`+j+`").value = myArray[3];
                        });
                    });
                `+foo2+`
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Prodpoids[]" id="Prodpoids`+j+`" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Proddechet[]" id="example" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger removeProductions"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>
            <div class="invisible">
                <div class="">
                    <input class="form-control designa" type="number" step="0.01" name="idcranteuseq1production[]" id="example" value="">
                </div>
            </div>`
            );});
            });      
    </script> 

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" style="background: #C2C3C3;">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" style="margin-bottom: 200px;">
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Modale pour ajouter reception -->
                        <div class="col-lg-12">
                            <div class="modal-dialog-centered">
                                <div class="modal-content col-lg-12">
                                    <div class="modal-header col-lg-12 bg-primary" >
                                        <h5 class="modal-title" id="myExtraLargeModalLabel" style="color:white; text-align: center;">Modification de la fiche de production dresseuse</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                                            <div class="row">
                                                <?php if($valideFiche != "erreurFiche" && $ProblemeArret != "erreurProblemeArret" && $ProblemeCompteur != "erreurProblemeCompteur" && $ProblemeQuart != "erreurProblemeQuart" && $ProblemeFicheExist != "erreurProblemeFicheExist" && $ProblemeFilMachine != "erreurProblemeFilMachine"){ // Lorsqu'il y a pas de erreur ?> 
                                                    <div class="col-md-2 ml-5 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur début</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurdebut" value="<?php echo $rowEntete['compteurdebut']; ?>" placeholder="Mettez le compteur du début" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur fin</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurfin" value="<?php echo $rowEntete['compteurfin']; ?>" placeholder="Mettez le Compteur de la fin" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Nom complet du contrôleur 1</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur1" value="<?php echo $rowEntete['controleur1']; ?>" placeholder="Mettez le nom complet du contrôleur 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Nom complet du contrôleur 2</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur2" value="<?php echo $rowEntete['controleur2']; ?>" placeholder="Mettez le nom complet du contrôleur 2" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-4 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Machine</label>
                                                            <select class="form-control" name="machine">
                                                                <option <?php if ( $rowEntete['machine']=="Dresseuse 1") {echo "selected='selected'";} ?>>Dresseuse 1</option>
                                                                <option <?php if ( $rowEntete['machine']=="Dresseuse 2") {echo "selected='selected'";} ?>>Dresseuse 2</option>
                                                                <option <?php if ( $rowEntete['machine']=="Dresseuse 4") {echo "selected='selected'";} ?>>Dresseuse 4</option>
                                                                <option <?php if ( $rowEntete['machine']=="Dresseuse 5") {echo "selected='selected'";} ?>>Dresseuse 5</option>
                                                                <option <?php if ( $rowEntete['machine']=="Dresseuse 6") {echo "selected='selected'";} ?>>Dresseuse 6</option>
                                                                <option <?php if ( $rowEntete['machine']=="Dresseuse 7") {echo "selected='selected'";} ?>>Dresseuse 7</option>
                                                            </select>                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Date de production</label>
                                                            <input class="form-control" id="validationDefault03" type="date" name="datecreationfiche" value="<?= $rowEntete['dateCreation']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Heure réelle départ du quart</label>
                                                            <input class="form-control" id="validationDefault03" type="time" name="heuredepartquart" value="<?php echo $rowEntete['heuredepartquart']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Heure réelle fin du quart</label>
                                                            <input class="form-control" id="validationDefault03" type="time" name="heurefinquart" value="<?php echo $rowEntete['heurefinquart']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-4 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Quart</label>
                                                            <select class="form-control" name="quart">
                                                                <option <?php if ( $rowEntete['quart']=="1") {echo "selected='selected'";} ?>>1</option>
                                                                <option <?php if ( $rowEntete['quart']=="2") {echo "selected='selected'";} ?>>2</option>
                                                                <option <?php if ( $rowEntete['quart']=="3") {echo "selected='selected'";} ?>>3</option>
                                                            </select>                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-5">
                                                        <div class="mb-5 float-right mr-5">
                                                            <label class="form-label font-weight-bold text-primary" for="commentaire" >Observations (début) </label>
                                                            <textarea class="form-control" name="observationdebut" rows="4" cols="120"  placeholder="Mettez ici les observations ( pas obligatoire... )"><?php echo $rowEntete['observationdebut']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 ">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Gestion des temps d'arret</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Début arrets</th>
                                                                    <th>Fin arrets</th>
                                                                    <th>Raisons</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddErreurs">
                                                                <?php
                                                                    $i=-1;
                                                                    //print_r($rowErreurs);
                                                                    foreach($rowErreurs as $rowErreur){
                                                                        $i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault04" type="time" value="<?php echo $rowErreur['debutarret']; ?>"  name="debutarret[]" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="time" name="finarret[]" value="<?php echo $rowErreur['finarret']; ?>"  required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <!--<td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="raisonerreur[]">
                                                                                        <option <?php if ( $rowErreur['raison']=="Raison 1") {echo "selected='selected'";} ?>>Raison 1</option>
                                                                                        <option <?php if ( $rowErreur['raison']=="Raison 2") {echo "selected='selected'";} ?>>Raison 2</option>
                                                                                        <option <?php if ( $rowErreur['raison']=="Raison 3") {echo "selected='selected'";} ?>>Raison 3</option> 
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>:!-->
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault01" type="text" name="raisonerreur[]" value="<?php echo $rowErreur['raison']; ?>" placeholder="Mettez la raison d'erreur" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="suprimerArret<?php echo $i; ?>[]">
                                                                                    </label>
                                                                                </div>
                                                                            </div>  
                                                                        </td>
                                                                    </tr>
                                                                    <div class="invisible">
                                                                        <div class="">
                                                                            <input class="" type="number" step="0.01" name="idErreur[]" id="example" value="<?php echo $rowErreur['iddresseusearret']; ?>">
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </tbody>
                                                        </table>

                                                        <div class="col-md-7  d-flex gap-2">
                                                            <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                                <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="addErreurs" type="button" value="Ajouter une ligne">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Consommations</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Diametre</th>
                                                                    <th>N° fil machine</th>
                                                                    <th>Heure montage</th>
                                                                    <th>Poids</th>
                                                                    <th>Finir FM</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddConsommations">
                                                                <?php
                                                                    $i=-1;
                                                                    foreach($rowConsommations as $rowConsommation){
                                                                        $i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="diametre[]" id="diametre<?php echo $i; ?>" value="<?php echo $rowConsommation['diametre']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="numerofin[]" id="numerofin<?php echo $i; ?>" required>
                                                                                        <option value="<?php echo $rowConsommation['numerofin'].'/' ?>"><?php $numerofinString = explode("/", $rowConsommation['numerofin']); echo $numerofinString[0]; ?></option> 
                                                                                        <?php
                                                                                            foreach($stockCranteuse as $stock){
                                                                                        ?>       
                                                                                            <option value="<?php echo $stock['prodnumerofin'].'/'.$stock['idcranteuseq1production'].'/'.$stock['proddiametre'].'/'.$stock['prodpoids']; ?>"> <?php echo $stock['prodnumerofin']; ?></option>                                                                                     
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <script>
                                                                            $(document).ready(function(){
                                                                                $('#numerofin<?php echo $i; ?>').change(function(){
                                                                                    //Selected value
                                                                                    var inputValue = $(this).val();
                                                                                    var myArray = inputValue.split('/');
                                                                                    document.getElementById("diametre<?php echo $i; ?>").value = myArray[2];
                                                                                    document.getElementById("poids<?php echo $i; ?>").value = myArray[3];
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="time" name="heuremontagebobine[]" id="example" value="<?php echo $rowConsommation['heuremontagebobine']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="poids[]" id="poids<?php echo $i; ?>" value="<?php echo $rowConsommation['poids']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="finirfm<?php echo $i;?>[]" <?php if($rowConsommation['finirfm'] == "1"){ echo "checked"; } ?>>
                                                                                    </label>
                                                                                </div>
                                                                            </div>  
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="suprimerCons<?php echo $i; ?>[]">
                                                                                    </label>
                                                                                </div>
                                                                            </div>  
                                                                        </td>
                                                                    </tr>
                                                                    <div class="invisible">
                                                                        <div class="">
                                                                            <input class="" type="number" step="0.01" name="idConsommation[]" id="example" value="<?php echo $rowConsommation['iddresseuseconsommation']; ?>">
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </tbody>
                                                        </table>

                                                        <div class="col-md-4  d-flex gap-2">
                                                            <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                                <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="addConsommations" type="button" value="Ajouter une ligne">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Productions</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>   
                                                                    <th>Diametre</th>
                                                                    <th>Nombre barres par colis</th>
                                                                    <th>Nombre colis</th>
                                                                    <th>barres restantes</th>
                                                                    <th>Longueur barres</th>
                                                                    <th>N° fil machine</th>
                                                                    <th>Poids</th>
                                                                    <th>Déchets</th>    
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddProductions">
                                                                <?php
                                                                    $i=-1;
                                                                    foreach($rowProductions as $rowProduction){
                                                                        $i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Proddiametre[]" id="Proddiametre<?php echo $i; ?>" value="<?php echo $rowProduction['proddiametre']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="ProdnbBarreColis[]" id="ProdnbBarreColis" value="<?php echo $rowProduction['prodnbBarreColis']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Prodnbcolis[]" id="Prodnbcolis" value="<?php echo $rowProduction['prodnbcolis']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Prodnbbarrerestant[]" id="Prodnbbarrerestant" value="<?php echo $rowProduction['prodnbbarrerestant']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Prodlongueurbarre[]" id="Prodlongueurbarre" value="<?php echo $rowProduction['prodlongueurbarre']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-12">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="Prodnumerofin[]" id="numerofinProd<?php echo $i; ?>" required>
                                                                                        <option value="<?php echo $rowProduction['prodnumerofin'].'/'.$rowProduction['proddiametre'].'/'.$rowProduction['prodpoids']; ?>"> <?php echo $rowProduction['prodnumerofin']; ?></option> 
                                                                                        <?php
                                                                                            foreach($stockCranteuse as $stock){
                                                                                        ?>                                                                                        
                                                                                           <option value="<?php echo $stock['prodnumerofin'].'/'.$stock['proddiametre'].'/'.$stock['prodpoids']; ?>"><?php echo $stock['prodnumerofin']; ?></option>                                                                                     
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Prodpoids[]" id="Prodpoids<?php echo $i; ?>" value="<?php echo $rowProduction['prodpoids']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Proddechet[]" id="example" value="<?php echo $rowProduction['proddechet']; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <script>
                                                                            $(document).ready(function(){
                                                                                $('#numerofinProd<?php echo $i; ?>').change(function(){
                                                                                    //Selected value
                                                                                    var inputValue = $(this).val();
                                                                                    var myArray = inputValue.split('/');
                                                                                    document.getElementById("Proddiametre<?php echo $i; ?>").value = myArray[1];
                                                                                    document.getElementById("Prodpoids<?php echo $i; ?>").value = myArray[2];
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="suprimerProd<?php echo $i; ?>[]">
                                                                                    </label>
                                                                                </div>
                                                                            </div>  
                                                                        </td>
                                                                    </tr>
                                                                    <div class="invisible">
                                                                        <div class="">
                                                                            <input class="" type="number" step="0.01" name="iddresseuseproduction[]" id="example" value="<?php echo $rowProduction['iddresseuseproduction']; ?>">
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        <div class="col-md-4  d-flex gap-2">
                                                            <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                                <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="addProductions" type="button" value="Ajouter une ligne">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }else{  // Lorsqu'il y a une erreur ?>
                                                    <div class="col-md-2 ml-5 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur début</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurdebut" value="<?php echo $_POST['compteurdebut']; ?>" placeholder="Mettez le compteur du début" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur fin</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurfin" value="<?php echo $_POST['compteurfin']; ?>" placeholder="Mettez le Compteur de la fin" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Nom complet du contrôleur 1</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur1" value="<?php echo $_POST['controleur1']; ?>" placeholder="Mettez le nom complet du contrôleur 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Nom complet du contrôleur 2</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur2" value="<?php echo $_POST['controleur2']; ?>" placeholder="Mettez le nom complet du contrôleur 2" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-4 mt-3 mb-5 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Machine</label>
                                                            <select class="form-control" name="machine">
                                                                <option <?php if ( $_POST['machine']=="Dresseuse 1") {echo "selected='selected'";} ?>>Dresseuse 1</option>
                                                                <option <?php if ( $_POST['machine']=="Dresseuse 2") {echo "selected='selected'";} ?>>Dresseuse 2</option>
                                                                <option <?php if ( $_POST['machine']=="Dresseuse 4") {echo "selected='selected'";} ?>>Dresseuse 4</option>
                                                                <option <?php if ( $_POST['machine']=="Dresseuse 5") {echo "selected='selected'";} ?>>Dresseuse 5</option>
                                                                <option <?php if ( $_POST['machine']=="Dresseuse 6") {echo "selected='selected'";} ?>>Dresseuse 6</option>
                                                                <option <?php if ( $_POST['machine']=="Dresseuse 7") {echo "selected='selected'";} ?>>Dresseuse 7</option>
                                                            </select>                                             
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Date de production</label>
                                                            <input class="form-control" id="validationDefault03" type="date" name="datecreationfiche" value="<?php echo $_POST['datecreationfiche']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Heure réelle départ du quart</label>
                                                            <input class="form-control" id="validationDefault03" type="time" name="heuredepartquart" value="<?php echo $_POST['heuredepartquart']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Heure réelle fin du quart</label>
                                                            <input class="form-control" id="validationDefault03" type="time" name="heurefinquart" value="<?php echo $_POST['heurefinquart']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-4 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Quart</label>
                                                            <select class="form-control" name="quart">
                                                                <option <?php if ( $_POST['quart']=="1") {echo "selected='selected'";} ?>>1</option>
                                                                <option <?php if ( $_POST['quart']=="2") {echo "selected='selected'";} ?>>2</option>
                                                                <option <?php if ( $_POST['quart']=="3") {echo "selected='selected'";} ?>>3</option>
                                                            </select>                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-5">
                                                        <div class="mb-5 float-right mr-5">
                                                            <label class="form-label font-weight-bold text-primary" for="commentaire" >Observations (début) </label>
                                                            <textarea class="form-control" name="observationdebut" rows="4" cols="120"  placeholder="Mettez ici les observations ( pas obligatoire... )"><?php echo $_POST['observationdebut']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 ">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Gestion des erreurs</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Début arrets</th>
                                                                    <th>Fin arrets</th>
                                                                    <th>Raisons</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddErreurs">
                                                                <?php
                                                                    //$i=0;
                                                                    for ($i = 0; $i < count($_POST['debutarret']); $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault04" type="time" value="<?php echo $_POST['debutarret'][$i]; ?>" name="debutarret[]" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="time" name="finarret[]" value="<?php echo $_POST['finarret'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <!--<td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="raisonerreur[]">
                                                                                        <option <?php if ( $_POST['raisonerreur']=="Raison 1") {echo "selected='selected'";} ?>>Raison 1</option>
                                                                                        <option <?php if ( $_POST['raisonerreur']=="Raison 2") {echo "selected='selected'";} ?>>Raison 2</option>
                                                                                        <option <?php if ( $_POST['raisonerreur']=="Raison 3") {echo "selected='selected'";} ?>>Raison 3</option> 
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>!-->
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault01" type="text" name="raisonerreur[]" value="<?php echo $_POST['raisonerreur'][$i]; ?>" placeholder="Mettez la raison d'erreur" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <div class="invisible">
                                                                            <div class="">
                                                                                <input class="" type="number" step="0.01" name="idErreur[]" id="example" value="<?php echo $_POST['idErreur'][$i]; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="suprimerArret<?php echo $i; ?>[]" <?php if(isset($_POST['suprimerArret'.$i])){ echo "checked";} ?>>
                                                                                    </label>
                                                                                </div>
                                                                            </div> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-lg-7 ">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Consommations</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Diametre</th>
                                                                    <th>N° fil machine</th>
                                                                    <th>Heure montage</th>
                                                                    <th>Poids</th>
                                                                    <th>Finir FM</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddConsommations">
                                                                <?php
                                                                    //$i=-1;
                                                                    for ($i = 0; $i < count($_POST['diametre']); $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="diametre[]" id="diametre<?php echo $i; ?>" value="<?php echo $_POST['diametre'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="numerofin[]" id="numerofin<?php echo $i; ?>" required>
                                                                                        <option value="<?php echo $_POST['numerofin'][$i]; ?>"><?php $numerofinString = explode("/", $_POST['numerofin'][$i]); echo $numerofinString[0]; ?></option> 
                                                                                        <?php
                                                                                            foreach($stockCranteuse as $stock){
                                                                                        ?>                                                                                        
                                                                                           <option value="<?php echo $stock['prodnumerofin'].'/'.$stock['idcranteuseq1production'].'/'.$stock['proddiametre'].'/'.$stock['prodpoids']; ?>"> <?php echo $stock['prodnumerofin']; ?> </option>                                                                                                                                                                       
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <script>
                                                                            $(document).ready(function(){
                                                                                $('#numerofin<?php echo $i; ?>').change(function(){
                                                                                    //Selected value
                                                                                    var inputValue = $(this).val();
                                                                                    var myArray = inputValue.split('/');
                                                                                    document.getElementById("diametre<?php echo $i; ?>").value = myArray[2];
                                                                                    document.getElementById("poids<?php echo $i; ?>").value = myArray[3];
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="time" name="heuremontagebobine[]" id="example" value="<?php echo $_POST['heuremontagebobine'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="poids[]" id="poids<?php echo $i; ?>" value="<?php echo $_POST['poids'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="finirfm<?php echo $i;?>[]" <?php if(isset($_POST['finirfm'.$i])){ echo "checked"; } ?> >
                                                                                    </label>
                                                                                </div>
                                                                            </div>  
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="suprimerCons<?php echo $i; ?>[]" <?php if(isset($_POST['suprimerCons'.$i])){ echo "checked";} ?>>
                                                                                    </label>
                                                                                </div>
                                                                            </div> 
                                                                        </td>
                                                                    </tr>
                                                                    <div class="invisible">
                                                                        <div class="">
                                                                            <input class="" type="number" step="0.01" name="idConsommation[]" id="example" value="<?php echo $_POST['idConsommation'][$i]; ?>">
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Productions</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Diametre</th>
                                                                    <th>Nombre barres par colis</th>
                                                                    <th>Nombre colis</th>
                                                                    <th>barres restantes</th>
                                                                    <th>Longueur barres</th>
                                                                    <th>N° fil machine</th>
                                                                    <th>Poids</th>
                                                                    <th>Déchets</th> 
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddProductions">
                                                                <?php
                                                                    //$i=0;
                                                                    for ($i = 0; $i < count($_POST['Proddiametre']); $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Proddiametre[]" id="Proddiametre<?php echo $i; ?>" value="<?php echo $_POST['Proddiametre'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="ProdnbBarreColis[]" id="ProdnbBarreColis" value="<?php echo $_POST['ProdnbBarreColis'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Prodnbcolis[]" id="Prodnbcolis" value="<?php echo $_POST['Prodnbcolis'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Prodnbbarrerestant[]" id="Prodnbbarrerestant" value="<?php echo $_POST['Prodnbbarrerestant'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Prodlongueurbarre[]" id="Prodlongueurbarre" value="<?php echo $_POST['Prodlongueurbarre'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-12">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="Prodnumerofin[]" id="numerofinProd<?php echo $i; ?>" required>
                                                                                        <option value="<?php echo $_POST['Prodnumerofin'][$i]; ?>"><?php $numerofinString = explode("/", $_POST['Prodnumerofin'][$i]); echo $numerofinString[0]; ?></option> 
                                                                                        <?php
                                                                                            foreach($stockCranteuse as $stock){
                                                                                        ?>                                                                                        
                                                                                           <option value="<?php echo $stock['prodnumerofin'].'/'.$stock['proddiametre'].'/'.$stock['prodpoids']; ?>"><?php echo $stock['prodnumerofin']; ?></option>                                                                                     
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Prodpoids[]" id="Prodpoids<?php echo $i; ?>" value="<?php echo $_POST['Prodpoids'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Proddechet[]" id="example" value="<?php echo $_POST['Proddechet'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <script>
                                                                            $(document).ready(function(){
                                                                                $('#numerofinProd<?php echo $i; ?>').change(function(){
                                                                                    //Selected value
                                                                                    var inputValue = $(this).val();
                                                                                    var myArray = inputValue.split('/');
                                                                                    document.getElementById("Proddiametre<?php echo $i; ?>").value = myArray[1];
                                                                                    document.getElementById("Prodpoids<?php echo $i; ?>").value = myArray[2];
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="suprimerProd<?php echo $i; ?>[]" <?php if(isset($_POST['suprimerProd'.$i])){ echo "checked";} ?>>
                                                                                    </label>
                                                                                </div>
                                                                            </div> 
                                                                        </td>
                                                                    </tr>
                                                                    <div class="invisible">
                                                                        <div class="">
                                                                            <input class="" type="number" step="0.01" name="iddresseuseproduction[]" id="example" value="<?php echo $_POST['iddresseuseproduction'][$i]; ?>">
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php } ?>
                                                
                                                <div class="col-md-6 invisible">
                                                    <div class="mb-1 text-start">
                                                        <label class="form-label fw-bold" for="user" ></label>
                                                        <input class="form-control " type="text" value="<?php
                                                            echo $_SESSION['nomcomplet']; 
                                                        ?>" name="user" id="example-date-input2">
                                                    </div>
                                                </div>
                                                <?php if($valideFiche != "erreurFiche" && $ProblemeArret != "erreurProblemeArret"  && $ProblemeCompteur != "erreurProblemeCompteur" && $ProblemeQuart != "erreurProblemeQuart" && $ProblemeFicheExist != "erreurProblemeFicheExist" && $ProblemeFilMachine != "erreurProblemeFilMachine"){ // Lorsqu'il y a pas de erreur ?> 
                                                    <div class="col-md-2 mr-5 mt-3 mb-5 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Vitésse</label>
                                                            <input class="form-control" id="validationDefault01" type="number" step="0.01" name="vitesse" value="<?php echo $rowEntete['vitesse']; ?>" placeholder="Mettez la vitesse" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mb-5 ">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Poids estimatif travaillé et non noté </label>
                                                            <input class="form-control" id="validationDefault01" type="number" step="0.01" name="poidsestimetravaillenonnote" value="<?php echo $rowEntete['poidsestimetravaillenonnote']; ?>" placeholder="Mettez le nom complet du contrôleur">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="commentaire" >Observations (fin) </label>
                                                            <textarea class="form-control" name="observationfin" rows="4" cols="90"  placeholder="Mettez ici les observations ( pas obligatoire... )"><?php echo $rowEntete['observationfin']; ?></textarea>
                                                        </div>
                                                    </div> 
                                                <?php }else{  // Lorsqu'il y a une erreur ?>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Vitésse</label>
                                                            <input class="form-control" id="validationDefault01" type="number" step="0.01" name="vitesse" value="<?php echo $_POST['vitesse']; ?>" placeholder="Mettez la vitesse" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Poids estimatif travaillé et non noté </label>
                                                            <input class="form-control" id="validationDefault01" type="number" step="0.01" name="poidsestimetravaillenonnote" value="<?php echo $_POST['poidsestimetravaillenonnote']; ?>" placeholder="Mettez le nom complet du contrôleur">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="commentaire" >Observations (fin) </label>
                                                            <textarea class="form-control" name="observationfin" rows="4" cols="90"  placeholder="Mettez ici les observations ( pas obligatoire... )"><?php echo $_POST['observationfin']; ?></textarea>
                                                        </div>
                                                    </div> 
                                                <?php } ?>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12 text-end">
                                                    <div class="col-md-8 align-items-center col-md-12 text-end"> 
                                                        <?php if($ProblemeCompteur == "erreurProblemeCompteur"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Le compteur de fin doit etre soupérieur au compteur de départ svp!',
                                                                    icon: 'error',
                                                                    timer: 4000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeQuart == "erreurProblemeQuart"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Veiller revoir les heures de depart et de fin du quart svp!',
                                                                    icon: 'error',
                                                                    timer: 4000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeFicheExist == "erreurProblemeFicheExist"){ ?>
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Desolé mais cette fiche existe déja, veillez revoir les champs (Machine, Quart ou la Date) svp!',
                                                                    icon: 'error',
                                                                    timer: 4500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeArret == "erreurProblemeArret"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: "Veiller revoir les heures de depart et de fin des arrets svp!",
                                                                    icon: 'error',
                                                                    timer: 4000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeFilMachine == "erreurProblemeFilMachine"){ ?>
                                                            <script>    
                                                                Swal.fire({
                                                                    text: "Veiller remplir le champs numéro fil machine svp!",
                                                                    icon: 'error',
                                                                    timer: 4000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($valideFiche == "ValideInsertion"){?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Exportation enregistrée avec succès merci!',
                                                                    icon: 'success',
                                                                    timer: 3000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <div class="d-flex gap-2 pt-4">                           
                                                            <a href="ficheDresseuse.php"><input class="btn btn-danger  w-lg bouton mr-3" name=""  value="Annuler"></a>
                                                            <input class="btn btn-success  w-lg bouton mr-3" name="CreerFicheProduction" type="submit" value="ENREGISTRER">
                                                        </div>
                                                        <hr/>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>  
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div>

                    <div class="col-lg-12 mt-5">
                        <div class="card position-relative">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Nombre de rouleau cranté et non encore utilisé à la machine Cranteuse : <?php echo sizeof($stockCranteuse); ?></h6>
                            </div>
                            <div class="row m-2">
                                <div class="table-responsive">
                                    <!-- Page Loader -->
                                        <div id="loader">
                                            <span class="lettre">M</span>
                                            <span class="lettre">E</span>
                                            <span class="lettre">T</span>
                                            <span class="lettre">A</span>
                                            <span class="lettre">L</span>
                                            <span class="lettre">*</span>
                                            <span class="lettre">*</span>
                                            <span class="lettre">*</span>
                                            <span class="lettre">A</span>
                                            <span class="lettre">F</span>
                                            <span class="lettre">R</span>
                                            <span class="lettre">I</span>
                                            <span class="lettre">Q</span>
                                            <span class="lettre">U</span>
                                            <span class="lettre">E</span>
                                        </div>
                                    <!-- Page Loader -->
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>       
                                                <th>Numéro fil machine</th>                                                                                
                                                <th>Epaisseur</th>
                                                <th>Nombre rouleaux</th>
                                                <th>Poids déclaré</th>
                                                <th>Londgueur échantillon</th>
                                                <th>Poids échantillon</th>
                                                <th>DF échantillon</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i=0;
                                                foreach($stockCranteuse as $stock){
                                                    $i++;
                                                    //if($article['status'] == 'termine'){
                                            ?>
                                                <tr>
                                                    <td style="background-color:#4e73df ; color:white;"> <?= $stock['prodnumerofin'] ?> </td>
                                                    <td style="background-color:#4e73df ; color:white;"> <?= $stock['proddiametre'] ?> </td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['prodnbbobine'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['prodpoids'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['echanlongueur'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['echanpoids'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['echandf'] ?></td>
                                                </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.1);">
                    METAL AFRIQUE © <script>document.write(new Date().getFullYear())</script> Copyright:
                    <a class="text-dark" href="https://metalafrique.com//">METALAFRIQUE.COM BY @BACHIR</a>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="../../indexPage/vendor/jquery/jquery.min.js"></script>
    <script src="../../indexPage/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../indexPage/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../indexPage/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../indexPage/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../indexPage/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../indexPage/js/demo/datatables-demo.js"></script>

</body>

</html>