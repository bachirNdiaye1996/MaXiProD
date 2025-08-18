<?php   
    session_start(); 

    if(!$_SESSION){
        header("location: ../404.php");
        return 0;
    }

    include "../connexion/conexiondb.php";
    //Variables
    
    //** Debut select des receptions
        $sql = "SELECT * FROM `utilisateur` where `actif`=1 ORDER BY `id` DESC;";
    
        // On prépare la requête
        $query = $db->prepare($sql);
    
        // On exécute
        $query->execute();
    
        // On récupère les valeurs dans un tableau associatif
        $Utilisateurs = $query->fetchAll();
    //** Fin select des receptions

    $NBUSERS = count($Utilisateurs);

    $dt = time();
    $dtm = date( "m", $dt );  // On extrait le mois courant.

    //** Debut select des production cranteuse
        $sql = "SELECT * FROM `fichecranteuseq1` WHERE `actif`=1 AND MONTH(`dateCreation`)='07';";          // On tire les fiches du mois courant
    
        // On prépare la requête
        $query = $db->prepare($sql);
    
        // On exécute
        $query->execute();
    
        // On récupère les valeurs dans un tableau associatif
        $FichesCranteuse = $query->fetchAll();
    //** Fin select des production cranteuse

    //** Debut select des production (Poids,...)
        $sql = "SELECT SUM(prodpoids) as prodpoids, idfichecranteuseq1 as idfichecranteuseq1 FROM `cranteuseq1production` WHERE `actif`=1 AND MONTH(`dateCreation`)='07' GROUP BY `idfichecranteuseq1`;";          
    
        // On prépare la requête
        $query = $db->prepare($sql);
    
        // On exécute
        $query->execute();
    
        // On récupère les valeurs dans un tableau associatif
        $CrantProduction = $query->fetchAll();
    //** Fin select des production (Poids,...)

    //** Debut select des temps d'arret (duree,...)
        $sql = "SELECT SUM(duree) as duree, idfichecranteuseq1 as idfichecranteuseq1 FROM `cranteuseq1arret` WHERE `actif`=1 AND MONTH(`dateCreation`)='07' GROUP BY `idfichecranteuseq1`;";          
    
        // On prépare la requête
        $query = $db->prepare($sql);
    
        // On exécute
        $query->execute();
    
        // On récupère les valeurs dans un tableau associatif
        $CrantTempsArret = $query->fetchAll();
    //** Fin select des temps d'arret (duree,...)

    
    $controleur1 = array_unique(array_column($FichesCranteuse,'controleur1'));
    $controleur2 = array_unique(array_column($FichesCranteuse,'controleur2'));
    $array3 = $controleur1 + $controleur2;

    $unions = array_unique(array_merge($controleur1,$controleur2));

    // Récupération des fiches par controleur
    $ArrayFichesParControleur = array(array());
    $IdFichesCranteuse = array(array());
    $CompteurFichesCranteuse = array(array());
    foreach($unions as $union){
        foreach($FichesCranteuse as $fichesCranteuse){
            if($fichesCranteuse['controleur1']=="$union" || $fichesCranteuse['controleur2']=="$union"){
                $ArrayFichesParControleur["$union"][] = $fichesCranteuse;
                $IdFichesCranteuse["$union"][] = $fichesCranteuse['idfichecranteuseq1'];
                $CompteurFichesCranteuse["$union"][] = $fichesCranteuse['compteurfin']-$fichesCranteuse['compteurdebut'];
            }
        }
    }

    // Récupération des productions par controleur
    $i=0;
    //$ProductionParControleur = array(array());
    $ProductionParControleur = array ( array ());
    foreach($IdFichesCranteuse as $key => $idFichesCranteuses){
        $tempProductionParControleur=null;
        foreach($idFichesCranteuses as $idFichesCranteuse){
            //printf($compteurFichesCranteuse." ");
            foreach($CrantProduction as $crantProduction){
                if($crantProduction['idfichecranteuseq1'] == $idFichesCranteuse){
                    $tempProductionParControleur += $crantProduction['prodpoids'];
                }
            }
        }
        $tempTempsArretParControleur=null;
        foreach($idFichesCranteuses as $idFichesCranteuse){
            //printf($compteurFichesCranteuse." ");
            foreach($CrantTempsArret as $crantTempsArret){
                if($crantTempsArret['idfichecranteuseq1'] == $idFichesCranteuse){
                    $tempTempsArretParControleur += $crantTempsArret['duree'];
                }
            }
        }
        $ProductionParControleur[$key]["poids"] = $tempProductionParControleur;
        $ProductionParControleur[$key]["tempsarret"] = $tempTempsArretParControleur;
        $i++;
    }

    /*foreach($unions as $union){
        //print_r($arrayFichesParControleur[3]);
        $ProductionParPersonne;
        foreach($ArrayFichesParControleur as $arrayFichesParControleur){
            if($arrayFichesParControleur["$union"]=$union || $fichesCranteuse['controleur2']=$union){
                $ArrayFichesParControleur[$union][] = $fichesCranteuse;
            }
        }
    }*/
            /*foreach($CompteurFichesCranteuse as $compteurFichesCranteuse){
                //print_r($compteurFichesCranteuse['Bachir Ndiaye']);
                //print_r($compteurFichesCranteuse);
            }*/
    //print_r(($ProductionParControleur));

?>

 
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="../image/iconOnglet.png" />
    <title>METAL AFRIQUE</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>

    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="accueil.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB  <?php echo $_SESSION['username'];?> <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="accueil.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Accueil Dashboard</span></a>
            </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Nav Item - Tables -->
            <?php if($_SESSION['niveau']=='admin' || $_SESSION['niveau']=='pontbascule' || $_SESSION['niveau']=='chefquart'){ ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReception"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fa fa-book fa-fw"></i>
                        <span>Pont Bascule</span>
                    </a>
                    <div id="collapseReception" class="collapse show" aria-labelledby="headingReception"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Stockage :</h6>
                            <a class="collapse-item" href="../stockage/reception.php">Réception</a>
                            <a class="collapse-item" href="../stockage/receptionPlanifie.php">Réception planifiée</a>
                            <a class="collapse-item" href="../stockage/transfert/transfert.php">Transfert</a>
                            <a class="collapse-item" href="../stockage/Exportation/exportation.php">Export</a>
                            <a class="collapse-item" href="../stockage/historique.php">Historique</a>
                            <a class="collapse-item" href="../stockage/stockage/stockage.php">Stockage</a>
                            <a class="collapse-item" href="../stockage/graphe.php">Graphe Niambour</a>
                            <a class="collapse-item" href="../stockage/grapheMetal1.php">Graphe Metal 1</a>
                            <a class="collapse-item" href="../stockage/grapheMetalMbao.php">Graphe Metal Mbao</a>
                        </div>
                    </div>
                </li>
            <?php } ?>

            <?php if($_SESSION['niveau'] != 'pontbascule'){ ?>
                <!-- Divider -->
                <hr class="sidebar-divider">
                
                <!-- Nav Item - Tables -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesReception"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fa fa-book fa-fw"></i>
                        <span>Reception FM</span>
                    </a>
                    <div id="collapseUtilitiesReception" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Les informations :</h6>
                            <a class="collapse-item" href="../Production/Reception/reception.php">reception</a>
                        </div>
                    </div>
                </li>
            <?php } ?>

            <?php if($_SESSION['niveau'] != 'pontbascule'){ ?>
                <!-- Divider -->
                <hr class="sidebar-divider">
                
                <!-- Nav Item - Tables -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fa fa-book fa-fw"></i>
                        <span>Production Cranteuse</span>
                    </a>
                    <div id="collapseUtilities" class="collapse <?php //if($_SESSION['niveau'] == 'chefquart'){ echo 'show'; }?>" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Les informations :</h6>
                            <a class="collapse-item" href="../Production/Cranteuse/ficheCranteuse.php">Fiches Productions</a>
                            <a class="collapse-item" href="../Production/Cranteuse/etatProduction.php">Etats Productions</a>
                            <a class="collapse-item" href="../Production/Cranteuse/historiqueCranteuse.php">Historiques</a>
                        </div>
                    </div>
                </li>

                <hr class="sidebar-divider">

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesDresseuse"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fa fa-book fa-fw"></i>
                        <span>Production Dresseuse</span>
                    </a>
                    <div id="collapseUtilitiesDresseuse" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Les informations :</h6>
                            <a class="collapse-item" href="../Production/Dresseuse/ficheDresseuse.php">Fiches Productions</a>
                            <a class="collapse-item" href="../Production/Dresseuse/etatProduction.php">Etats Productions</a>
                            <a class="collapse-item" href="../Production/Dresseuse/historiqueDresseuse.php">Historiques</a>
                        </div>
                    </div>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesTrefilage"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fa fa-book fa-fw"></i>
                        <span>Production Tréfilage</span>
                    </a>
                    <div id="collapseUtilitiesTrefilage" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Les informations :</h6>
                            <a class="collapse-item" href="../Production/Trefilage/ficheParQuartTrefilage.php">Fiches Productions</a>
                            <a class="collapse-item" href="../Production/Trefilage/etatProduction.php">Etats Productions</a>
                            <a class="collapse-item" href="../Production/Trefilage/historiqueTrefilage.php">Historiques</a>
                        </div>
                    </div>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

            <?php } ?>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

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
                    <div class="mb-3">
                        <div class="col-xl-9 col-md-8 mb-1">
                        <img src="../image/logoAppli.jpg" class="img-fluid mx-auto d-block text-center" alt="" style="border-radius: 50%; margin:20px; opacity: 1;" width="200">
                        </div>
                    </div>

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
                                        290.29 has been deposited into your account!
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
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
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
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
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
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
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
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#InformationProfile" title="Voir votre profile" class="dropdown-item">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="./Utilisateur/ParametreUtilisateur.php?idUser=<?php echo $_SESSION['id']; ?>">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Changer paramétres
                                </a>
                                <?php if($_SESSION['niveau']=='admin' || $_SESSION['niveau']=='chefquart'){ ?>
                                    <a class="dropdown-item" href="../Production/GestionTempsArret/gestionTempsArrets.php">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Gestion des temps d'arrets
                                    </a>
                                <?php } ?>
                                <?php if($_SESSION['niveau']=='admin'){ ?>
                                    <a class="dropdown-item" href="./Utilisateur/utilisateur.php">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Gestion des utilisateurs
                                    </a>
                                <?php } ?>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activités
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../index.php">
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
                                        <img src="../image/avatar.jpg" class="img-fluid mx-auto d-block text-center" alt="" style="border-radius: 45%; margin-top:-3%; opacity: 0.9;" width="150">
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
                <div class="container-fluid mt-5">
                    <!-- Page Heading -->
                    <!-- DataTales Example -->

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="tempsArret.php" class="text-decoration-none">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    <h5>TEMPS D'ARRETS</h5>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-clock fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="productivite.php" class="text-decoration-none">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    <h5>PRODUCTIVITES</h5>
                                                </div> 
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-bolt fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Taux de remplissage
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                            if("$_SESSION[niveau]" == "admin"){ 
                        ?>
                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./Utilisateur/utilisateur.php" class="text-decoration-none">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Nombre d'utilisateurs</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php   echo $NBUSERS; ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php 
                            }
                        ?>
                    </div>

                    <div class="col-lg-12 mr-5">
                        <ul class="row list-group-horizontal mt-4 ml-5">
                            <li class="list-group mr-4"><a href="productiviteCrant.php" class="list-group-item list-group-item-action active" aria-current="true">CRANTEUSE</a></li>
                            <li class="list-group mr-4"><a href="productiviteDress.php" class="list-group-item list-group-item-action">DRESSEUSE</a></li>
                            <li class="list-group mr-4"><a href="productiviteTref.php" class="list-group-item list-group-item-action">TREFILAGE</a></li>
                        </ul>
                    </div>

                    <!-- RECHERCHE -->
                        <div class="mt-5 mr-3">
                            <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                                <div class="col-md-2 mt-3">
                                    <div class="mb-1 text-start">
                                        <select class="form-control" name="machine">
                                            <option>Cranteuse 1</option>
                                            <option>Cranteuse 2</option>
                                            <option>Dresseuse 1</option>
                                            <option>Dresseuse 2</option>
                                            <option>Dresseuse 4</option>
                                            <option>Dresseuse 5</option>
                                            <option>Dresseuse 6</option>
                                            <option>Dresseuse 7</option>
                                        </select>                                                
                                    </div>
                                </div>
                                <div class="col-md-2 mt-3 ml-2">
                                    <div class="mb-1 text-start">
                                        <input class="form-control" id="validationDefault03" type="date" name="dateFiche" value="" required>
                                    </div>
                                </div>
                                <div class="mt-3">                           
                                    <input class="btn btn-success bouton mr-3 ml-5" name="ChercheTempsArret" type="submit" value="RECHERCHER">
                                </div>
                                <hr/>
                            </form> 
                        </div>
                    <!-- RECHERCHE -->

                    <!-- Content Row -->
                    <div class="row">
                        <!-- A mettre le body -->
                        <?php  if($ProductionParControleur){ ?>
                            <div class="col-lg-12">
                            <div class="card position-relative mt-3">
                                <div class="card-header py-3 mb-4">
                                    <h6 class="m-0 font-weight-bold text-primary">Voici la productivité des opérateurs dans la période de ... à la machine cranteuse.</h6>
                                </div>
                                <div class="row m-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>      
                                                    <th>Prenom et Nom opérateur</th>    
                                                    <th>Poids produit par opérateur (KG)</th>  
                                                    <th>Temps arret par opérateur (KG)</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $i=0;
                                                    foreach($ProductionParControleur as $key  => $productionParControleur){
                                                        if($i>0){
                                                ?>
                                                    <tr>
                                                        <td class="">
                                                            <?= $key ?>                                                    
                                                        </td>
                                                        <td class="">
                                                            <?= $productionParControleur["poids"] ?>                                                    
                                                        </td>
                                                        <td class="">
                                                            <?php 
                                                                $TotalArret = $productionParControleur["tempsarret"];
                                                                $TotalArret = explode(":",date("H:i",$TotalArret) );
                                                                if(($TotalArret[0]-1) == 0){
                                                                    if($TotalArret[1] == 0){}else{echo $TotalArret[1]." minutes";}
                                                                }else{
                                                                    echo ($TotalArret[0]-1)." Heures ";
                                                                    if($TotalArret[1] == 0){}else{echo $TotalArret[1]." minutes";}
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>    
                                                <?php
                                                        }
                                                        $i++;
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- Bouton et pagnination--> 
                                    </div>
                                </div>
                            </div>
                            </div>
                        <?php  } ?>
                    </div>


                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script type="text/javascript">
                        var production = <?php echo json_encode($ProductionParControleur); ?>;
                        console.log(production[1]);

                    </script>
                    
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->

    <script src="js/demo/diagrammes.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>