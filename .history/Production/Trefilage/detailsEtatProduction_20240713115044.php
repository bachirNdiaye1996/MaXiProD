<?php   

session_start(); 

if(!$_SESSION){
    header("location: ../../404.php");
    return 0;
}

include "../../connexion/conexiondb.php";
//include "./mailTransfert.php";


//Variables
    // Quart 1
    $PoidsObjectifMinimalQ1 = 0;
    $PoidsProduitTotalQ1 = 0;
    $PoidsConsommeTotalQ1 = 0;

    // Quart 1
    $PoidsObjectifMinimalQ2 = 0;
    $PoidsProduitTotalQ2 = 0;
    $PoidsConsommeTotalQ2 = 0;

    // Quart 1
    $PoidsObjectifMinimalQ3 = 0;
    $PoidsProduitTotalQ3 = 0;
    $PoidsConsommeTotalQ3 = 0;

    $dateFichetrefilage = $_GET['dateCreation'];  // On recupére l'ID de la réception par get

    // Quart 1
    $ProdConsommationQ1 = array();
    $ProdRevisionQ1 = array();
    $ProdProductionQ1 = array();

    // Quart 2
    $ProdConsommationQ2 = array();
    $ProdRevisionQ2 = array();
    $ProdProductionQ2 = array();

    // Quart 3
    $ProdConsommationQ3 = array();
    $ProdRevisionQ3 = array();
    $ProdProductionQ3 = array();


/** Quart */
    /** Trefilage Q1 */
        //** Debut select de la production (Pour cranteuse 1)
            $sql = "SELECT * FROM `fichetrefilage` where `actif`=1 and `dateCreation`='$dateFichetrefilage' and `quart`='1';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionTref = $query->fetchAll();
        //** Fin select de la production 

        // Parcourir les tables révisions,cons et prod
        foreach($productionTref as $productionTr => $Key){

            // On recupére l'id des fiches
            $idFicheTrefilage = $Key['idfichetrefilage'];

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageconsommation` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageconsommation` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsQ1 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($consommationsQ1 as $production => $Key){
                array_push($ProdConsommationQ1, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilagerevision` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilagerevision` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $revisionsQ1 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($revisionsQ1 as $production => $Key){
                array_push($ProdRevisionQ1, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageproduction` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageproduction` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsQ1 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($productionsQ1 as $production => $Key){
                array_push($ProdProductionQ1, $Key);
            }
        }
        
    /** Fin Trefilage Q1 */

    /** Trefilage Q2 */
        //** Debut select de la production (Pour trefilage 1)
            $sql = "SELECT * FROM `fichetrefilage` where `actif`=1 and `dateCreation`='$dateFichetrefilage' and `quart`='2';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionTref = $query->fetchAll();
        //** Fin select de la production 

        // Parcourir les tables révisions,cons et prod
        foreach($productionTref as $productionTr => $Key){

            // On recupére l'id des fiches
            $idFicheTrefilage = $Key['idfichetrefilage'];

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageconsommation` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageconsommation` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsQ2 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($consommationsQ2 as $production => $Key){
                array_push($ProdConsommationQ2, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilagerevision` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilagerevision` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $revisionsQ2 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($revisionsQ2 as $production => $Key){
                array_push($ProdRevisionQ2, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageproduction` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageproduction` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsQ2 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($productionsQ2 as $production => $Key){
                array_push($ProdProductionQ2, $Key);
            }
        }
        
    /** Fin Trefilage Q2 */

    /** Trefilage Q3 */
        //** Debut select de la production (Pour trefilage 3)
            $sql = "SELECT * FROM `fichetrefilage` where `actif`=1 and `dateCreation`='$dateFichetrefilage' and `quart`='3';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionTref = $query->fetchAll();
        //** Fin select de la production 

        // Parcourir les tables révisions,cons et prod
        foreach($productionTref as $productionTr => $Key){

            // On recupére l'id des fiches
            $idFicheTrefilage = $Key['idfichetrefilage'];

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageconsommation` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageconsommation` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsQ3 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($consommationsQ3 as $production => $Key){
                array_push($ProdConsommationQ3, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilagerevision` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilagerevision` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $revisionsQ3 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($revisionsQ3 as $production => $Key){
                array_push($ProdRevisionQ3, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageproduction` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageproduction` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsQ3 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($productionsQ3 as $production => $Key){
                array_push($ProdProductionQ3, $Key);
            }
        }
    /** Fin Trefilage Q3 */
/** Fin Quart  */


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

    <link href="../../StyleLoad.css" rel="stylesheet">

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

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php $activeEtatProduction = "active"; ?>

        <!-- Contient la nav bar gauche -->
            <?php include "./navGaucheTrefilage.php" ?>
        <!-- End  -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                 <!-- Topbar -->
                 <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../../indexPage/img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../../indexPage/img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../../indexPage/img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['nomcomplet']; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="../../indexPage/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#InformationProfile" title="Voir votre profile" class="dropdown-item">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <?php if($_SESSION['niveau']=='admin'){ ?>
                                    <a class="dropdown-item" href="../../indexPage/Utilisateur/ParametreUtilisateur.php?idUser=<?php echo $_SESSION['id']; ?>">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Changer paramétres
                                    </a>
                                <?php } ?>
                                <a class="dropdown-item" href="../../indexPage/Utilisateur/utilisateur.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Gestion des utilisateurs
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activités
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../../index.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Déconnexion
                                </a>
                            </div>
                        </li>

                    </ul>
                    <!-- Pour le status !--> 
                    <div class="modal fade " id="InformationProfile" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                        <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                            <div class="modal-content">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                    </div>
                                    <div class="card-body">
                                        <img src="../../image/avatar.jpg" class="img-fluid mx-auto d-block text-center" alt="" style="border-radius: 45%; margin-top:-3%; opacity: 0.9;" width="150">
                                        <h5 class="card-title mt-2 mb-5 text-center"><?php echo $_SESSION['nomcomplet']; ?></h5>
                                        <p class="card-text"><h6 class="d-inline mr-3">Email :</h6><?php echo $_SESSION['email']; ?></p>
                                        <p class="card-text"><h6 class="d-inline mr-3">Section :</h6> <?php echo $_SESSION['section']; ?></p>
                                        <p class="card-text"><h6 class="d-inline mr-3">Matricule :</h6> <?php echo $_SESSION['matricule']; ?></p>
                                        <p class="card-text"><h6 class="d-inline mr-3">Nom d'utilisateur :</h6> <?php echo $_SESSION['username']; ?></p>
                                        <p class="card-text"><h6 class="d-inline mr-3">Numéro téléphone :</h6> <?php echo $_SESSION['numTelephone']; ?></p>
                                        <div class="col text-center">
                                            <a href="" class="btn btn-primary text-center">Retour</a>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-primary text-muted text-center">
                                        <h5 style="color:white">METAL *** AFRIQUE</h5>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-1">
                            <img src="../../image/trefilet.jpg" class="img-fluid" alt="" style="border-radius: 50%; margin:20px; opacity: 1;" width="200">
                        </div>
                    </div>

                    <div class="d-sm-flex align-items-end justify-content-end mb-4 mr-3">
                        <a href="pdfEtatCranteuse.php?dateCreation=<?php echo $_GET['dateCreation'];?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Génerer en PDF</a>
                    </div>
                    <!-- DataTales Example -->
                    <!-- Fade In Utility -->
                    <div class="col-lg-12">
                        <div class="card position-relative">
                            <div class="card-header py-3 bg-primary">
                                <p class="m-0 font-weight-bold text-center h2 text-uppercase mt-2 mb-3" style="color: white;">Etat DE PRODUCTION journalier - section tréfilage </p>
                                <p class="m-0 font-weight-bold text-center h2 text-uppercase mt-2 mb-5" style="color: white;"><span class="mr-4">journee du : </span> <?php echo date("l j F Y", strtotime($_GET['dateCreation'])); ?></p>
                                <div class="">                                </div>
                                    <!--<p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 10%;"><span class="mr-4">Début quart : </span> <?php echo $Cranteuseq1['heuredepartquart']; ?></p>
                                    <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 10%;"><span class="mr-4">Fin quart : </span> <?php echo $Cranteuseq1['heurefinquart']; ?></p>
                                    <p class="m-0 mb-3 h5 d-inline" style="color: white;"><span class="mr-4">Contrôleurs : </span> <?php echo $Cranteuseq1['controleur1']." / ".$Cranteuseq1['controleur2']." / ".$Cranteuseq1['controleur3']; ?></p>
                                </div>
                                <p class="m-0 mb-3 h5 mt-3 ml-3 d-inline" style="color: white; padding-right: 30%;"><span class="mr-4">Compteur Horaire Début : </span> <?php echo $Cranteuseq1['compteurdebut']; ; ?></p>
                                <p class="m-0 mb-3 h5 d-inline" style="color: white;"><span class="mr-4">Observations (Début) : </span> <?php echo $Cranteuseq1['observationdebut']; ; ?></p>
                                <p class="m-0 mt-3  h5 ml-3" style="color: white;"><span class="mr-5">Compteur Horaire Fin : </span> <?php echo $Cranteuseq1['compteurfin']; ; ?></p>-->
                            </div>

                            <!-- Debut quart1 -->
                            <?php
                                if($ProdProductionQ1){
                            ?>
                                <div class="bg-secondary bg-gradient mt-3">
                                    <p class="font-weight-bold  text-center h2 text-uppercase mt-2 mb-2 text-light">Quart 1</p>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="row m-1 mb-3 col-lg-12">
                                <div class="table-responsive col-lg-12">
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
                                    <?php
                                        if($ProdRevisionQ1){
                                    ?>
                                        <div class="row">
                                            <!-- Révisions -->
                                            <div class="col-lg-6">
                                                <h5 class="modal-title mb-3 mt-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Révisions</h5>
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr> 
                                                            <th>Machine</th>
                                                            <th>Opérateurs</th>      
                                                            <th>Matiere 1 ere</th>
                                                            <th>Produit</th>
                                                            <th>Objectif minim</th>
                                                            <th>Diametre en sortie</th>
                                                            <th>Lubrif utiliser</th>
                                                            <th>Dest / Poids Rlx</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($ProdRevisionQ1 as $prodRevision => $Key){
                                                                //echo $prodRevision;
                                                                //print_r($Key[$prodRevision]['matierepremier']);
                                                                //$PoidsConsommeTotal += $consommationC1Q1['piodstotal'];
                                                                //$RebusTotal += $consommationC1Q1['dechet'];

                                                                //** Debut select de la production
                                                                    $sql = "SELECT * FROM `fichetrefilage` where `idfichetrefilage`=$Key[idfichetrefilage] ;";

                                                                    // On prépare la requête
                                                                    $query = $db->prepare($sql);

                                                                    // On exécute
                                                                    $query->execute();

                                                                    // On récupère les valeurs dans un tableau associatif
                                                                    $productionTref = $query->fetch();
                                                                //** Fin select de la production
                                                                
                                                                $PoidsObjectifMinimalQ1 += $Key['objectifminimal'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 16px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#Information" title="Voir details des temps d'arret" class="link-offset-2 link-underline mb-5"><?= $productionTref['machine'] ?></a>
                                                                </td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionTref['controleur1'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['matierepremier'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['produit'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['objectifminimal'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['diametrefilensorti'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['librifiant'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['destinationrouleaux']." / ".$Key['poidsrouleauxdestination']."(KG)" ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                            </div>  
                                            <!-- Consommations -->
                                            <div class="col-lg-3">
                                                <h5 class="modal-title mb-3 mt-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Consommations</h5>
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr> 
                                                            <th>Numéro fil machine</th>
                                                            <th>Nombre rouleaux</th>
                                                            <th>Poids Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $i = 0;
                                                            foreach($ProdConsommationQ1 as $prodConsommation => $Key){
                                                                //echo $prodRevision;
                                                                //print_r($Key[$prodRevision]['matierepremier']);
                                                                $PoidsConsommeTotalQ1 += $Key['poidstotal'];
                                                                //$RebusTotal += $consommationC1Q1['dechet']; 
                                                                $i++;
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 16px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationMatiere<?= $i ?>" title="Voir les details du produit" class="link-offset-2 link-underline mb-5"><?= $Key['numerofilmachine'] ?></a>
                                                                </td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['nombrerouleaux'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['poidstotal'] ?></td>
                                                            </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 

                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <div class="modal fade " id="InformationMatiere<?php echo $i; ?>" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                                    <div class="modal-content">
                                                                        <div class="card">
                                                                            <div class="card-header bg-primary text-center">
                                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details du produit consommé correspondant :</h5>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                                    <?php
                                                                                        $IDM = $Key['numerofilmachine'];
                                                                                        //** Debut select des receptions
                                                                                            $sql = "SELECT * FROM `matiere` where `numbobine`=$IDM;";
                                                                                
                                                                                            // On prépare la requête
                                                                                            $query = $db->prepare($sql);
                                                                                
                                                                                            // On exécute
                                                                                            $query->execute();
                                                                                
                                                                                            // On récupère les valeurs dans un tableau associatif
                                                                                            $Matiere = $query->fetch();
                                                                                        //** Fin select des receptions
                                                                                        
                                                                                        $IDR = $Matiere['idreception'];

                                                                                        $IdMatiere = $Matiere['idmatierereception'];

                                                                                        //** Debut select des receptions
                                                                                            $sql = "SELECT * FROM `matiere` where `idmatiere`=$IdMatiere;";
                                                                                    
                                                                                            // On prépare la requête
                                                                                            $query = $db->prepare($sql);
                                                                                
                                                                                            // On exécute
                                                                                            $query->execute();
                                                                                
                                                                                            // On récupère les valeurs dans un tableau associatif
                                                                                            $MatiereDepart = $query->fetch();
                                                                                        //** Fin select des receptions

                                                                                        //** Debut select des receptions
                                                                                            $sql = "SELECT * FROM `reception` where `actif`=1 and `idreception`=$IDR;";

                                                                                            // On prépare la requête
                                                                                            $query = $db->prepare($sql);

                                                                                            // On exécute
                                                                                            $query->execute();

                                                                                            // On récupère les valeurs dans un tableau associatif
                                                                                            $Reception = $query->fetch();
                                                                                        //** Fin select des receptions       
                                                                                    ?>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nom de la DF : </span><?php echo $Reception['entetedf']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5 style="color:blue;"></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Date réception : </span><?php echo $Reception['datereception']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nombre de bobine : </span><?php echo $MatiereDepart['nbbobine']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids des bobines (KG) : </span><?php echo $MatiereDepart['poidsdeclare']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Lieu de la réception : </span><?php echo $MatiereDepart['lieutransfert']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-8 col-form-label"><h5 style="color: #199AF3">Commentaire associé lors de la réception : </h5></label><br>
                                                                                        <div class="col-sm-8 ml-5">
                                                                                            <h5><?php echo $Reception['commentaire']; ?></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nom du récepteur : </span> <?php echo $Reception['nomrecepteur']; ?></h5></label>
                                                                                        <div class="col-sm-6">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Matricule du camion : </span><?php echo $Reception['matriculecamion']; ?></h5></label>
                                                                                        <div class="col-sm-6">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Numéro de BL : </span><?php echo $Reception['bl']; ?></h5></label>
                                                                                        <div class="col-sm-6">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div> <hr>
                                                                                    <div class="form-group row mt-5">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Code bobine : </span><?php echo "REC00".$Matiere['idreception']."-BOB0-".$MatiereDepart['idmatiere']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-6 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids de la bobine déclaré lors du transfert (KG) : </span><?php echo $Matiere['poidsdeclare']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Etat bobine : </span> <?php echo $Matiere['etatbobine']; ?></h5></label>
                                                                                        <div class="col-sm-6">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col text-center">
                                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>    
                                                                </div>
                                                            </div>
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                            </div> 
                                            <!-- Productions !-->
                                            <div class="col-lg-3">
                                                <h5 class="modal-title mb-3 mt-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Productions</h5>
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr> 
                                                            <th>Nombre rouleaux</th>
                                                            <th>Poids Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($ProdProductionQ1 as $prodProduction => $Key){
                                                                //echo $prodRevision;
                                                                //print_r($Key[$prodRevision]['matierepremier']);
                                                                $PoidsProduitTotalQ1 += $Key['poidstotalproduction'];
                                                                //$RebusTotal += $consommationC1Q1['dechet'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['nombrerouleauxproduction'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['poidstotalproduction'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                            </div>                                      
                                        </div>

                                        <!-- Bouton et pagnination ICI--> 

                                    <?php
                                        }
                                    ?>   
                                </div>
                                <div class="col-lg-12  py-3 mt-5 bg-primary">
                                    <div class="mb-4 mt-3">
                                        <?php 
                                            //** Debut select de la production (Pour cranteuse 1)
                                                $sql = "SELECT * FROM `ficheparquarttrefilage` where `actif`=1 and `datecreation`='$dateFichetrefilage' and `quart`='1';";

                                                // On prépare la requête
                                                $query = $db->prepare($sql);

                                                // On exécute
                                                $query->execute();

                                                // On récupère les valeurs dans un tableau associatif
                                                $ficheParQuart = $query->fetch();
                                            //** Fin select 
                                            //print_r($ficheParQuart);
                                        ?>
                                        <p class="m-0 mb-3 h5 d-inline" style="color: white;  padding-right: 3%;"><span class="mr-4"><span class="mr-4">Productivité prévue (KG / pers) : </span><?php echo round($PoidsObjectifMinimalQ1/(int)$ficheParQuart['nombrepersonne'],2); ?></span> <?php  ?></p>
                                        <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 3%;"><span class="mr-2">Nombre de personne : </span> <?php echo $ficheParQuart['nombrepersonne']; ?></p>
                                        <p class="mt-4 mb-3 h5 d-inline" style="color: white; padding-right: 3%;"><span class="mr-2">Productivité réelle (KG / pers) : </span> <?php echo round($PoidsProduitTotalQ1/(int)$ficheParQuart['nombrepersonne'],2); ?></p>
                                        <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 3%;"><span class="mr-2">Poids total produit (KG) : </span> <?php echo $PoidsProduitTotalQ1; ?></p>
                                        <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 3%;"><span class="mr-2">Poids total consommé (KG) : </span> <?php  echo $PoidsConsommeTotalQ1; ?></p>
                                        <p class="mt-5 mb-3 h5 " style="color: white;"><span class=""></span></p>
                                        <p class="mt-5 mb-3 h5 d-inline" style="color: white; padding-right: 5%;"><span class="mr-3">Peseur : </span> <?php echo $ficheParQuart['nompeseur']; ?></p>
                                        <p class="mt-5 mb-3 h5 d-inline" style="color: white; padding-right: 5%;"><span class="mr-3">Chef d'équipe : </span> <?php echo $ficheParQuart['nomchefequipe']; ?></p>
                                        <p class="mt-5 mb-3 h5 d-inline" style="color: white; padding-right: 5%;"><span class="mr-3">Chef de section : </span> <?php echo $ficheParQuart['nomchefsection']; ?></p>
                                        <p class="mt-5 mb-3 h5 d-inline" style="color: white; padding-right: 5%;"><span class="mr-3">Chef de quart : </span> <?php echo $ficheParQuart['nomchefquart']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin quart1 -->

                            <!-- Debut quart2 -->
                            <?php
                                if($ProdProductionQ2){
                            ?>
                                <div class="bg-secondary bg-gradient mt-3">
                                    <p class="font-weight-bold  text-center h2 text-uppercase mt-2 mb-2 text-light">Quart 2</p>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="row m-1 mb-3 col-lg-12">
                                <div class="table-responsive col-lg-12">
                                    <?php
                                        if($ProdRevisionQ2){
                                    ?>
                                        <div class="row">
                                            <!-- Révisions -->
                                            <div class="col-lg-6">
                                                <h5 class="modal-title mb-3 mt-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Révisions</h5>
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr> 
                                                            <th>Machine</th>
                                                            <th>Opérateurs</th>      
                                                            <th>Matiere 1 ere</th>
                                                            <th>Produit</th>
                                                            <th>Objectif minim</th>
                                                            <th>Diametre en sortie</th>
                                                            <th>Lubrif utiliser</th>
                                                            <th>Dest / Poids Rlx</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($ProdRevisionQ2 as $prodRevision => $Key){
                                                                //echo $prodRevision;
                                                                //print_r($Key[$prodRevision]['matierepremier']);
                                                                //$PoidsConsommeTotal += $consommationC1Q1['piodstotal'];
                                                                //$RebusTotal += $consommationC1Q1['dechet'];

                                                                //** Debut select de la production
                                                                    $sql = "SELECT * FROM `fichetrefilage` where `idfichetrefilage`=$Key[idfichetrefilage] ;";

                                                                    // On prépare la requête
                                                                    $query = $db->prepare($sql);

                                                                    // On exécute
                                                                    $query->execute();

                                                                    // On récupère les valeurs dans un tableau associatif
                                                                    $productionTref = $query->fetch();
                                                                //** Fin select de la production
                                                                
                                                                $PoidsObjectifMinimalQ2 += $Key['objectifminimal'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 16px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#Information" title="Voir details des temps d'arret" class="link-offset-2 link-underline mb-5"><?= $productionTref['machine'] ?></a>
                                                                </td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionTref['controleur1'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['matierepremier'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['produit'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['objectifminimal'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['diametrefilensorti'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['librifiant'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['destinationrouleaux']." / ".$Key['poidsrouleauxdestination']."(KG)" ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                            </div>  
                                            <!-- Consommations -->
                                            <div class="col-lg-3">
                                                <h5 class="modal-title mb-3 mt-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Consommations</h5>
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr> 
                                                            <th>Numéro fil machine</th>
                                                            <th>Nombre rouleaux</th>
                                                            <th>Poids Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $i = 0;
                                                            foreach($ProdConsommationQ2 as $prodConsommation => $Key){
                                                                //echo $prodRevision;
                                                                //print_r($Key[$prodRevision]['matierepremier']);
                                                                $PoidsConsommeTotalQ2 += $Key['poidstotal'];
                                                                //$RebusTotal += $consommationC1Q1['dechet']; 
                                                                $i++;
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 16px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationMatiere<?= $i ?>" title="Voir les details du produit" class="link-offset-2 link-underline mb-5"><?= $Key['numerofilmachine'] ?></a>
                                                                </td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['nombrerouleaux'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['poidstotal'] ?></td>
                                                            </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 

                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <div class="modal fade " id="InformationMatiere<?php echo $i; ?>" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                                    <div class="modal-content">
                                                                        <div class="card">
                                                                            <div class="card-header bg-primary text-center">
                                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details du produit consommé correspondant :</h5>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                                    <?php
                                                                                        $IDM = $Key['numerofilmachine'];
                                                                                        //** Debut select des receptions
                                                                                            $sql = "SELECT * FROM `matiere` where `numbobine`=$IDM;";
                                                                                
                                                                                            // On prépare la requête
                                                                                            $query = $db->prepare($sql);
                                                                                
                                                                                            // On exécute
                                                                                            $query->execute();
                                                                                
                                                                                            // On récupère les valeurs dans un tableau associatif
                                                                                            $Matiere = $query->fetch();
                                                                                        //** Fin select des receptions
                                                                                        
                                                                                        $IDR = $Matiere['idreception'];

                                                                                        $IdMatiere = $Matiere['idmatierereception'];

                                                                                        //** Debut select des receptions
                                                                                            $sql = "SELECT * FROM `matiere` where `idmatiere`=$IdMatiere;";
                                                                                    
                                                                                            // On prépare la requête
                                                                                            $query = $db->prepare($sql);
                                                                                
                                                                                            // On exécute
                                                                                            $query->execute();
                                                                                
                                                                                            // On récupère les valeurs dans un tableau associatif
                                                                                            $MatiereDepart = $query->fetch();
                                                                                        //** Fin select des receptions

                                                                                        //** Debut select des receptions
                                                                                            $sql = "SELECT * FROM `reception` where `actif`=1 and `idreception`=$IDR;";

                                                                                            // On prépare la requête
                                                                                            $query = $db->prepare($sql);

                                                                                            // On exécute
                                                                                            $query->execute();

                                                                                            // On récupère les valeurs dans un tableau associatif
                                                                                            $Reception = $query->fetch();
                                                                                        //** Fin select des receptions       
                                                                                    ?>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nom de la DF : </span><?php echo $Reception['entetedf']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5 style="color:blue;"></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Date réception : </span><?php echo $Reception['datereception']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nombre de bobine : </span><?php echo $MatiereDepart['nbbobine']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids des bobines (KG) : </span><?php echo $MatiereDepart['poidsdeclare']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Lieu de la réception : </span><?php echo $MatiereDepart['lieutransfert']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-8 col-form-label"><h5 style="color: #199AF3">Commentaire associé lors de la réception : </h5></label><br>
                                                                                        <div class="col-sm-8 ml-5">
                                                                                            <h5><?php echo $Reception['commentaire']; ?></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nom du récepteur : </span> <?php echo $Reception['nomrecepteur']; ?></h5></label>
                                                                                        <div class="col-sm-6">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Matricule du camion : </span><?php echo $Reception['matriculecamion']; ?></h5></label>
                                                                                        <div class="col-sm-6">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Numéro de BL : </span><?php echo $Reception['bl']; ?></h5></label>
                                                                                        <div class="col-sm-6">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div> <hr>
                                                                                    <div class="form-group row mt-5">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Code bobine : </span><?php echo "REC00".$Matiere['idreception']."-BOB0-".$MatiereDepart['idmatiere']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-6 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids de la bobine déclaré lors du transfert (KG) : </span><?php echo $Matiere['poidsdeclare']; ?></h5></label>
                                                                                        <div class="col-sm-4">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Etat bobine : </span> <?php echo $Matiere['etatbobine']; ?></h5></label>
                                                                                        <div class="col-sm-6">
                                                                                            <h5></h5>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col text-center">
                                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>    
                                                                </div>
                                                            </div>
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                            </div> 
                                            <!-- Productions !-->
                                            <div class="col-lg-3">
                                                <h5 class="modal-title mb-3 mt-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Productions</h5>
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr> 
                                                            <th>Nombre rouleaux</th>
                                                            <th>Poids Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($ProdProductionQ2 as $prodProduction => $Key){
                                                                //echo $prodRevision;
                                                                //print_r($Key[$prodRevision]['matierepremier']);
                                                                $PoidsProduitTotalQ2 += $Key['poidstotalproduction'];
                                                                //$RebusTotal += $consommationC1Q1['dechet'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['nombrerouleauxproduction'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $Key['poidstotalproduction'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !-->
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                            </div>                                      
                                        </div>
                                        <!-- Bouton et pagnination ICI--> 
                                    <?php
                                        }
                                    ?>   
                                </div>
                            </div>
                            <div class="col-lg-12  py-3 mt-5 bg-primary">
                                <div class="mb-4 mt-3">
                                    <?php 
                                        //** Debut select de la production (Pour cranteuse 1)
                                            $sql = "SELECT * FROM `ficheparquarttrefilage` where `actif`=1 and `datecreation`='$dateFichetrefilage' and `quart`='2';";

                                            // On prépare la requête
                                            $query = $db->prepare($sql);

                                            // On exécute
                                            $query->execute();

                                            // On récupère les valeurs dans un tableau associatif
                                            $ficheParQuart = $query->fetch();
                                        //** Fin select 
                                        //print_r($ficheParQuart);
                                    ?>
                                    <p class="m-0 mb-3 h5 d-inline" style="color: white;  padding-right: 3%;"><span class="mr-4"><span class="mr-4">Productivité prévue (KG / pers) : </span><?php echo round($PoidsObjectifMinimalQ2/(int)$ficheParQuart['nombrepersonne'],2); ?></span> <?php  ?></p>
                                    <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 3%;"><span class="mr-2">Nombre de personne : </span> <?php echo $ficheParQuart['nombrepersonne']; ?></p>
                                    <p class="mt-4 mb-3 h5 d-inline" style="color: white; padding-right: 3%;"><span class="mr-2">Productivité réelle (KG / pers) : </span> <?php echo round($PoidsProduitTotalQ2/(int)$ficheParQuart['nombrepersonne'],2); ?></p>
                                    <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 3%;"><span class="mr-2">Poids total produit (KG) : </span> <?php echo $PoidsProduitTotalQ2; ?></p>
                                    <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 3%;"><span class="mr-2">Poids total consommé (KG) : </span> <?php  echo $PoidsConsommeTotalQ2; ?></p>
                                    <p class="mt-5 mb-3 h5 " style="color: white;"><span class=""></span></p>
                                    <p class="mt-5 mb-3 h5 d-inline" style="color: white; padding-right: 5%;"><span class="mr-3">Peseur : </span> <?php echo $ficheParQuart['nompeseur']; ?></p>
                                    <p class="mt-5 mb-3 h5 d-inline" style="color: white; padding-right: 5%;"><span class="mr-3">Chef d'équipe : </span> <?php echo $ficheParQuart['nomchefequipe']; ?></p>
                                    <p class="mt-5 mb-3 h5 d-inline" style="color: white; padding-right: 5%;"><span class="mr-3">Chef de section : </span> <?php echo $ficheParQuart['nomchefsection']; ?></p>
                                    <p class="mt-5 mb-3 h5 d-inline" style="color: white; padding-right: 5%;"><span class="mr-3">Chef de quart : </span> <?php echo $ficheParQuart['nomchefquart']; ?></p>
                                </div>
                            </div>
                            <!-- Fin quart2 -->
                        </div>
                        <div class="col-md-8 align-items-center mt-5 mb-5">
                            <div class="d-flex gap-2 pt-4">
                                <a href="etatProduction.php" class="btn btn-danger w-lg bouton ml-3"><i class="fa fa-angle-double-left mr-2"></i>Retour</a>
                            </div>
                        </div>
                    </div> 
                </div><!-- div Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.1);">
                        METAL AFRIQUE © <script>document.write(new Date().getFullYear())</script> Copyright:
                        <a class="text-dark" href="https://metalafrique.com//">METALAFRIQUE.COM BY @BACHIR</a>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div><!-- End of Content Wrapper -->
        </div><!-- End of Content Wrapper -->

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