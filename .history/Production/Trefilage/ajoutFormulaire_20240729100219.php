<?php
    
    session_start(); 
    
    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";


    //Variables
    // Il faut savoir que metal3 est remplacer par niambour
    $valideFiche="";
    $ProblemeQuart="";
    $ProblemeCompteur="";
    $ProblemeFicheExist="";
    $ProblemeFilMachine="";


    //Insertion une fiche
    if(isset($_POST['CreerFicheProduction'])){

        $compteurdebut=htmlspecialchars( $_POST['compteurdebut']);
        $compteurfin=htmlspecialchars( $_POST['compteurfin']);
        $controleur1=htmlspecialchars( $_POST['controleur1']);
        $controleur2=htmlspecialchars($_POST['controleur2']);
        $machine=htmlspecialchars( $_POST['machine']);
        $datecreationfiche=htmlspecialchars( $_GET['dateCreation']);
        $heuredepartquart=htmlspecialchars($_POST['heuredepartquart']);
        $heurefinquart=htmlspecialchars( $_POST['heurefinquart']);
        $user=htmlspecialchars( $_POST['user']);
        $quart=htmlspecialchars($_GET['quart']);
        $vitesse=htmlspecialchars( $_POST['vitesse']);
        $observationfin=htmlspecialchars($_POST['observationfin']);
        $idficheparquarttrefilage=htmlspecialchars($_GET['idficheparquarttrefilage']);

        //print_r($_POST);

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
            //

            //On vérifie si la fiche existe ou pas
                $sqlEpaisseur = "SELECT * FROM `fichetrefilage` WHERE `actif`=1 AND `quart`='$quart' AND `machine`='$machine' AND `dateCreation`='$datecreationfiche';";
                // On prépare la requête
                $queryEpaisseur = $db->prepare($sqlEpaisseur);
                $queryEpaisseur->execute();
                $resultEpaisseur = $queryEpaisseur->fetch();
                
                if($resultEpaisseur){
                    $ProblemeFicheExist="erreurProblemeFicheExist";
                }
            // Fin

            // Compteur
            if(($ProblemeQuart != "erreurProblemeQuart") && ($ProblemeFicheExist != "erreurProblemeFicheExist")){
                if(($compteurfin > $compteurdebut)){
                }else{
                    $ProblemeCompteur="erreurProblemeCompteur";
                }
            }

            /*//Consommations
            for ($i = 0; $i < count($_POST['diametre']); $i++){   
                $diametre=htmlspecialchars( $_POST['diametre'][$i]);
                $numerofin=htmlspecialchars($_POST['numerofin'][$i]);
                $heuremontagebobine=htmlspecialchars($_POST['heuremontagebobine'][$i]);
                $poids=htmlspecialchars($_POST['poids'][$i]);

                if($numerofin == ""){
                    $ProblemeFilMachine="erreurProblemeFilMachine";
                }                 
            }*/

            /*//Productions
            for ($i = 0; $i < count($_POST['Proddiametre']); $i++){   
                $diametre=htmlspecialchars( $_POST['Proddiametre'][$i]);
                $numerofin=htmlspecialchars($_POST['Prodnumerofin'][$i]);
                $poids=htmlspecialchars($_POST['Prodpoids'][$i]);

                if($numerofin == ""){
                    $ProblemeFilMachine="erreurProblemeFilMachine";
                }  
            }*/
        //Fin verification
        
        if($ProblemeCompteur != "erreurProblemeCompteur" && $ProblemeQuart != "erreurProblemeQuart" && $ProblemeFilMachine != "erreurProblemeFilMachine" && ($ProblemeFicheExist != "erreurProblemeFicheExist")){            
            $insertUser=$db->prepare("INSERT INTO `fichetrefilage` (`idfichetrefilage`, `user`, `dateajout`, `quart`, `actif`, `dateCreation`, `compteurdebut`,
             `compteurfin`, `controleur1`, `controleur2`, `machine`, `heuredepartquart`, `heurefinquart`, `saisisseur`, `idficheparquarttrefilage`, `vitesse`,
              `observationfin`, `accepteprodmodif`, `actifapprouvprod`) VALUES (NULL, ?, current_timestamp(), ?, '1', ?, ?,
              ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', '0');");
            $insertUser->execute(array($user,$quart,$datecreationfiche,$compteurdebut,$compteurfin,$controleur1,$controleur2,$machine,$heuredepartquart,$heurefinquart,$user,$idficheparquarttrefilage,$vitesse,$observationfin));

            // Récuperer le dernier id de la fiche
                $sqlEpaisseur = "SELECT MAX(idfichetrefilage)  AS idMax FROM `fichetrefilage`";
                // On prépare la requête
                $queryEpaisseur = $db->prepare($sqlEpaisseur);
                $queryEpaisseur->execute();
                $resultEpaisseur = $queryEpaisseur->fetch();
                $idficheTrefilageMax = (int) $resultEpaisseur['idMax'];
            // Fin

            // Révisions
                for ($i = 0; $i < count($_POST['matierepremier']); $i++){
                    $matierepremier=htmlspecialchars( $_POST['matierepremier'][$i]);
                    $produit=htmlspecialchars($_POST['produit'][$i]);
                    $objectifminimal=htmlspecialchars($_POST['objectifminimal'][$i]);
                    $diametrefilensorti=htmlspecialchars( $_POST['diametrefilensorti'][$i]);
                    $librifiant=htmlspecialchars($_POST['librifiant'][$i]);
                    $destinationrouleaux=htmlspecialchars($_POST['destinationrouleaux'][$i]);
                    $poidsrouleauxdestination=htmlspecialchars( $_POST['poidsrouleauxdestination'][$i]);

                    $insertUser=$db->prepare("INSERT INTO `trefilagerevision` (`idtrefilagerevision`, `matierepremier`, `produit`, `objectifminimal`, `diametrefilensorti`, `actif`, `librifiant`, `destinationrouleaux`, `poidsrouleauxdestination`, `idfichetrefilage`) 
                    VALUES (NULL, ?, ?, ?, ?, '1', ?, ?, ?, ?);");
                    $insertUser->execute(array($matierepremier,$produit,$objectifminimal,$diametrefilensorti,$librifiant,$destinationrouleaux,$poidsrouleauxdestination,$idficheTrefilageMax));
                }
            //

            // Consommations
                for ($i = 0; $i < count($_POST['numerofilmachine']); $i++){   
                    $numerofilmachine=htmlspecialchars( $_POST['numerofilmachine'][$i]);
                    $nombrerouleauxconsommation = htmlspecialchars("1");
                    $poidstotalconsommation=htmlspecialchars($_POST['poidstotalconsommation'][$i]);

                    /*// On enleve une bobine dans la table cranteuseq1production
                    $req ="UPDATE cranteuseq1production SET `prodnbbobine`=`prodnbbobine`-1 where `prodnumerofin`='$numerofin';";
                    //$db->query($req);
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute();*/

                    $insertUser=$db->prepare("INSERT INTO `trefilageconsommation` (`idtrefilageconsommation`, `numerofilmachine`, `nombrerouleaux`, `actif`, `poidstotal`, `idfichetrefilage`) 
                    VALUES (NULL, ?, ?, '1', ?, ?);");
                    $insertUser->execute(array($numerofilmachine,$nombrerouleauxconsommation,$poidstotalconsommation,$idficheTrefilageMax));
                }
            //

            // Productions
                for ($i = 0; $i < count($_POST['nombrerouleauxproduction']); $i++){   
                    $nombrerouleauxproduction=htmlspecialchars( $_POST['nombrerouleauxproduction'][$i]);
                    $poidstotalproduction=htmlspecialchars( $_POST['poidstotalproduction'][$i]);

                    $insertUser=$db->prepare("INSERT INTO `trefilageproduction` (`idtrefilageproduction`, `nombrerouleauxproduction`, `poidstotalproduction`, `actif`,`idfichetrefilage`) 
                    VALUES (NULL, ?, ?, '1', ?);");
                    $insertUser->execute(array($nombrerouleauxproduction,$poidstotalproduction,$idficheTrefilageMax));
                }
            //

            header("location: detailsFicheTrefilage.php?idficheparquarttrefilage=$idficheparquarttrefilage&idfichetrefilage=$idficheTrefilageMax&quart=$quart&dateCreation=$datecreationfiche");
            exit;
        }
    }

    //** Nombre des bobines total
        $sql = "SELECT SUM(`3`) + SUM(`3.5`) + SUM(`4`) + SUM(`4.5`) + SUM(`5`) + SUM(`5.5`) + SUM(`6`) + SUM(`6.5`) + SUM(`7`) + SUM(`7.5`)
        + SUM(`8`) + SUM(`8.5`) + SUM(`9`) + SUM(`9.5`) + SUM(`10`) + SUM(`10.5`) + SUM(`11`) + SUM(`11.5`) + SUM(`12`) + SUM(`12.5`) + SUM(`13`) + SUM(`13.5`) + 
        SUM(`14`) + SUM(`14.5`) + SUM(`15`) + SUM(`15.5`) + SUM(`16`) + SUM(`16.5`) + SUM(`17`) AS nb_reception_total FROM `epaisseur` where `lieu`='Tréfilage';";
        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère le nombre d'articles
        $result = $query->fetch();

        $nbReception = (int) $result['nb_reception_total'];
    //** Fin nombre des bobines total

    //** Debut select de stockage pour Metal1
        $sqlepaisseur = "SELECT * FROM `matiere` where `actif`=1 and `nbbobineactuel`>0 and `lieutransfert`='Tréfilage'  ORDER BY `idmatiere` DESC;";

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
            $('#dynamicaddProductions').on('click', '.removeProductions', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });

            // Removing Row on click to Remove button
            $('#dynamicaddRevisions').on('click', '.removeRevisions', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });

            // Removing Row on click to Remove button
            $('#dynamicaddEchantillons').on('click', '.removeEchantillons', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });

            // Removing Row on click to Remove button
            $('#dynamicaddConsommations').on('click', '.removeConsommations', function () {
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
        $(document).ready(function(){  
            var i = 1; 
            $('#addConsommations').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicaddConsommations').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control" id="validationDefault04" type="number" step="0.01" name="numerofilmachine[]" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control" id="validationDefault04" type="number" step="0.01" name="nombrerouleauxconsommation[]" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control" id="validationDefault04" type="number" step="0.01" name="poidstotalconsommation[]" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA;" class="text-center"> 
                    <button class="btn btn-danger removeConsommations"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>`
            );});

            $('#addProductions').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicaddProductions').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="nombrerouleauxproduction[]" id="nombrerouleauxproduction" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="poidstotalproduction[]" id="poidstotalproduction" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger removeProductions"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>`
            );});  
            
            
            $('#addRevisions').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicaddRevisions').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="text" name="matierepremier[]" id="matierepremier" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="produit[]" id="produit" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="objectifminimal[]" id="objectifminimal" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="diametrefilensorti[]" id="diametrefilensorti" value="">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="text" name="librifiant[]" id="librifiant" value="">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="text" name="destinationrouleaux[]" id="destinationrouleaux" value="">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="poidsrouleauxdestination[]" id="poidsrouleauxdestination" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger removeRevisions"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>`
            );});
            ;}); 
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
                                        <h5 class="modal-title" id="myExtraLargeModalLabel" style="color:white; text-align: center;">Ajout fiche de production tréfilage</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                                            <div class="row">
                                                <?php if($valideFiche != "erreurFiche" && $ProblemeFilMachine != "erreurProblemeFilMachine" && $ProblemeCompteur != "erreurProblemeCompteur" && $ProblemeQuart != "erreurProblemeQuart" && ($ProblemeFicheExist != "erreurProblemeFicheExist")){ // Lorsqu'il y a pas de erreur ?> 
                                                    <div class="col-md-2 ml-5 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur début</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurdebut" value="" placeholder="Mettez le compteur du début">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur fin</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurfin" value="" placeholder="Mettez le Compteur de la fin">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Nom complet du contrôleur 1</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur1" value="" placeholder="Mettez le nom complet du contrôleur 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Nom complet du contrôleur 2</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur2" value="" placeholder="Mettez le nom complet du contrôleur 2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-4 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Machine</label>
                                                            <select class="form-control" name="machine">
                                                                <option id="togg2">TR4</option>
                                                                <option id="togg1">TR4-1</option>
                                                                <option id="togg3">TR4-2</option>
                                                                <option id="togg4">TR5</option>
                                                                <option id="togg5">TR6-1</option>
                                                                <option id="togg6">TR6-2</option>
                                                                <option id="togg7">TR7-2</option>
                                                                <option id="togg8">TR8</option>
                                                                <option id="togg9">TR10</option>
                                                            </select>                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Heure réelle départ du quart</label>
                                                            <input class="form-control" id="validationDefault03" type="time" name="heuredepartquart" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Heure réelle fin du quart</label>
                                                            <input class="form-control" id="validationDefault03" type="time" name="heurefinquart" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mt-5">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Prévisions</h5>
                                                        <table class="table table-bordered" id="" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Matiere 1 ere</th>
                                                                    <th>Produit</th>
                                                                    <th>Objectif minimal</th>
                                                                    <th>Diametre fil en sortie</th>
                                                                    <th>Lubrifiant à utiliser</th>
                                                                    <th>Destination Rlx</th>
                                                                    <th>Poids Rlx destination</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddRevisions">
                                                                <?php
                                                                    //$i=0;
                                                                    //for ($i = 0; $i <= $NombreLigne; $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="text" name="matierepremier[]" id="matierepremier" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="produit[]" id="produit" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="objectifminimal[]" id="objectifminimal" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="diametrefilensorti[]" id="diametrefilensorti" value="">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="text" name="librifiant[]" id="librifiant" value="">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="destinationrouleaux[]" id="destinationrouleaux">
                                                                                        <option>Four</option>
                                                                                        <option>Clou</option>
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="poidsrouleauxdestination[]" id="poidsrouleauxdestination" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                            <button class="btn btn-danger removeRevisions"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                // }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Consommations</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Numéro fil machine</th>
                                                                    <th>Poids Total</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddConsommations">
                                                                <?php
                                                                    //$i=0;
                                                                    //for ($i = 0; $i <= $NombreLigne; $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA;" id="d1">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="numerofilmachine1" type="number" step="0.01" name="numerofilmachine[]" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA; display:none" id="d2">
                                                                            <select class="form-control" id="numerofilmachine2" name="">
                                                                                <option></option> 
                                                                                <?php
                                                                                    foreach($stockCranteuse as $stock){
                                                                                ?>   
                                                                                    <option value=""> <?php echo $stock['numbobine']; ?></option>                                                                                     
                                                                                <?php
                                                                                    }
                                                                                ?>
                                                                            </select> 
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault04" type="number" step="0.01" name="poidstotalconsommation[]" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;" class="text-center"> 
                                                                            <button class="btn btn-danger removeConsommations"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                // }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <script>
                                                        // Pour faire appaittre notre input si la machine tr-4 est selectionnée
                                                        let numerofilmachine1 = document.getElementById("numerofilmachine1");
                                                        let numerofilmachine2 = document.getElementById("numerofilmachine2");
                                                        console.log(numerofilmachine1.name);
                                                        console.log(numerofilmachine2.name);

                                                        let togg1 = document.getElementById("togg1");
                                                        let togg2 = document.getElementById("togg2");
                                                        let togg3 = document.getElementById("togg3");
                                                        let togg4 = document.getElementById("togg4");
                                                        let togg5 = document.getElementById("togg5");
                                                        let togg6 = document.getElementById("togg6");
                                                        let togg7 = document.getElementById("togg7");
                                                        let togg8 = document.getElementById("togg8");
                                                        let togg9 = document.getElementById("togg9");
                                                        let d1 = document.getElementById("d1");
                                                        let d2 = document.getElementById("d2");
                                                        togg1.addEventListener("click", () => {
                                                            d1.style.display = "none";
                                                            d2.style.display = "block";

                                                            numerofilmachine1.setAttribute("name", "");
                                                            numerofilmachine2.setAttribute("name", "numerofilmachine[]");
                                                            console.log(numerofilmachine1.name);
                                                            console.log(numerofilmachine2.name);

                                                        })
                                                        togg3.addEventListener("click", () => {
                                                            d1.style.display = "block";
                                                            d2.style.display = "none"; 
                                                        })
                                                        togg4.addEventListener("click", () => {
                                                            d1.style.display = "block";
                                                            d2.style.display = "none"; 
                                                        })
                                                        togg5.addEventListener("click", () => {
                                                            d1.style.display = "block";
                                                            d2.style.display = "none"; 
                                                        })
                                                        togg6.addEventListener("click", () => {
                                                            d1.style.display = "block";
                                                            d2.style.display = "none"; 
                                                        })
                                                        togg7.addEventListener("click", () => {
                                                            d1.style.display = "block";
                                                            d2.style.display = "none"; 
                                                        })
                                                        togg8.addEventListener("click", () => {
                                                            d1.style.display = "block";
                                                            d2.style.display = "none"; 
                                                        })
                                                        togg2.addEventListener("click", () => {
                                                            d1.style.display = "block";
                                                            d2.style.display = "none"; 
                                                        })
                                                        togg9.addEventListener("click", () => {
                                                            d1.style.display = "block";
                                                            d2.style.display = "none"; 
                                                        })
                                                    </script>
                                                    <div class="col-lg-6">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Productions</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Nombre rouleaux</th>
                                                                    <th>Poids Total</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddProductions">
                                                                <?php
                                                                    //$i=0;
                                                                    //for ($i = 0; $i <= $NombreLigne; $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="nombrerouleauxproduction[]" id="nombrerouleauxproduction" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="poidstotalproduction[]" id="poidstotalproduction" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                            <button class="btn btn-danger removeProductions"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                // }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php }else{  // Lorsqu'il y a une erreur ?>
                                                    <div class="col-md-2 ml-5 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur début</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurdebut" value="<?php echo $_POST['compteurdebut']; ?>" placeholder="Mettez le compteur du début">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur fin</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurfin" value="<?php echo $_POST['compteurfin']; ?>" placeholder="Mettez le Compteur de la fin">
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
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur2" value="<?php echo $_POST['controleur2']; ?>" placeholder="Mettez le nom complet du contrôleur 2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-4 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Machine</label>
                                                            <select class="form-control" name="machine">
                                                                <option <?php if ( $_POST['machine']=="TR4")   {echo "selected='selected'";}   ?>>TR4</option>
                                                                <option <?php if ( $_POST['machine']=="TR4-1") {echo "selected='selected'";}   ?>>TR4-1</button>
                                                                </option>
                                                                <option <?php if ( $_POST['machine']=="TR4-2") {echo "selected='selected'";}   ?>>TR4-2</option>
                                                                <option <?php if ( $_POST['machine']=="TR5")   {echo "selected='selected'";}   ?>>TR5</option>
                                                                <option <?php if ( $_POST['machine']=="TR6-1") {echo "selected='selected'";}   ?>>TR6-1</option>
                                                                <option <?php if ( $_POST['machine']=="TR6-2") {echo "selected='selected'";}   ?>>TR6-2</option>
                                                                <option <?php if ( $_POST['machine']=="TR7-2") {echo "selected='selected'";}   ?>>TR7-2</option>
                                                                <option <?php if ( $_POST['machine']=="TR8")   {echo "selected='selected'";}   ?>>TR8</option>
                                                                <option <?php if ( $_POST['machine']=="TR10")  {echo "selected='selected'";}   ?>>TR10</option>
                                                            </select>                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4 ml-5">
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
                                                    <div class="col-lg-12 mt-5">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Prévisions</h5>
                                                        <table class="table table-bordered" id="" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Matiere 1 ere</th>
                                                                    <th>Produit</th>
                                                                    <th>Objectif minimal</th>
                                                                    <th>Diametre fil en sortie</th>
                                                                    <th>Lubrifiant à utiliser</th>
                                                                    <th>destination Rlx</th>
                                                                    <th>Poids Rlx destination</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddRevisions">
                                                                <?php
                                                                    //$i=0;
                                                                    for ($i = 0; $i < count($_POST['matierepremier']); $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="text" name="matierepremier[]" id="matierepremier" value="<?php echo $_POST['matierepremier'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="produit[]" id="produit" value="<?php echo $_POST['produit'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="objectifminimal[]" id="objectifminimal" value="<?php echo $_POST['objectifminimal'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="diametrefilensorti[]" id="diametrefilensorti" value="<?php echo $_POST['diametrefilensorti'][$i]; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="text" name="librifiant[]" id="librifiant" value="<?php echo $_POST['librifiant'][$i]; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="destinationrouleaux[]" id="destinationrouleaux">
                                                                                        <option <?php if ( $_POST['destinationrouleaux'][$i]=="Four")   {echo "selected='selected'";} ?>>Four</option>
                                                                                        <option <?php if ( $_POST['destinationrouleaux'][$i]=="Clou")   {echo "selected='selected'";} ?>>Clou</option>
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="poidsrouleauxdestination[]" id="poidsrouleauxdestination" value="<?php echo $_POST['poidsrouleauxdestination'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                            <button class="btn btn-danger removeRevisions"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Consommations</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Numéro fil machine</th>
                                                                    <th>Poids Total</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddConsommations">
                                                                <?php
                                                                    //$i=0;
                                                                    for ($i = 0; $i < count($_POST['matierepremier']); $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault04" type="number" step="0.01" name="numerofilmachine[]" value="<?php echo $_POST['numerofilmachine'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault04" type="number" step="0.01" name="poidstotalconsommation[]" value="<?php echo $_POST['poidstotalconsommation'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;" class="text-center"> 
                                                                            <button class="btn btn-danger removeConsommations"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Productions</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Nombre rouleaux</th>
                                                                    <th>Poids Total</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddProductions">
                                                                <?php
                                                                    //$i=0;
                                                                    for ($i = 0; $i < count($_POST['matierepremier']); $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="nombrerouleauxproduction[]" id="nombrerouleauxproduction" value="<?php echo $_POST['nombrerouleauxproduction'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="poidstotalproduction[]" id="poidstotalproduction" value="<?php echo $_POST['poidstotalproduction'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                            <button class="btn btn-danger removeProductions"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
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
                                                <?php if($valideFiche != "erreurFiche" && $ProblemeFilMachine != "erreurProblemeFilMachine"  && $ProblemeCompteur != "erreurProblemeCompteur" && $ProblemeQuart != "erreurProblemeQuart" && ($ProblemeFicheExist != "erreurProblemeFicheExist")){ // Lorsqu'il y a pas de erreur ?> 
                                                    <div class="col-md-2 mr-5 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Vitésse</label>
                                                            <input class="form-control" id="validationDefault01" type="number" step="0.01" name="vitesse" value="" placeholder="Mettez la vitesse de la machine">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 ml-5">
                                                        <div class="mb-1">
                                                            <label class="form-label font-weight-bold text-primary" for="commentaire" >Explications</label>
                                                            <textarea class="form-control" name="observationfin" rows="4" cols="90"  placeholder="Elles doivent inclure les raisons qui ont fait que les quantités prévues n'ont pas été attintes dans le cas échéant."></textarea>
                                                        </div>
                                                    </div> 
                                                <?php }else{  // Lorsqu'il y a une erreur ?>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Vitésse</label>
                                                            <input class="form-control" id="validationDefault01" type="number" step="0.01" name="vitesse" value="<?php echo $_POST['vitesse']; ?>" placeholder="Mettez la vitesse de la machine">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 ml-5">
                                                        <div class="mb-1">
                                                            <label class="form-label font-weight-bold text-primary" for="commentaire" >Explications </label>
                                                            <textarea class="form-control" name="observationfin" rows="4" cols="90"  placeholder="Elles doivent inclure les raisons qui ont fait que les quantités prévues n'ont pas été attintes dans le cas échéant."><?php echo $_POST['observationfin']; ?></textarea>
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
                                                                    });
                                                            </script> 
                                                        <?php } ?>
                                                        <div class="d-flex gap-2 pt-4">                           
                                                            <a href="ficheTrefilage.php?idficheparquarttrefilage=<?= $_GET['idficheparquarttrefilage'] ?>&quart=<?= $_GET['quart'] ?>&dateCreation=<?= $_GET['dateCreation'] ?>"><input class="btn btn-danger  w-lg bouton mr-3" name=""  value="Annuler"></a>
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
                                <h6 class="m-0 font-weight-bold text-primary">Nombre de bobine stocké à la machine Tréfilage : <?php echo $nbReception; ?></h6>
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
                                                <th>Poids pesé</th>
                                                <th>Etat bobine</th>
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
                                                    <td style="background-color:#4e73df ; color:white;"> <?= $stock['numbobine'] ?> </td>
                                                    <td style="background-color:#4e73df ; color:white;"> <?= $stock['epaisseur'] ?> </td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['nbbobineactuel'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['poidsdeclare'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['poidspese'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['etatbobine'] ?></td>
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