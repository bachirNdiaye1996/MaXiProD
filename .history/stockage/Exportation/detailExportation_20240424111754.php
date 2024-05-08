<?php   

session_start(); 

if(!$_SESSION){
    header("location: ../../404.php");
    return 0;
}

include "../../connexion/conexiondb.php";
include "./mailTransfert.php";


//Variables
// Il faut savoir que metal3 est remplacer par niambour
$valideTransfert="";
$idmatierearrive="";
$idtransfert = $_GET['idexportation'];  // On recupére l'ID de la réception par get

// Pour insertion details reception
    if(isset($_POST['CreerReception'])){
        if(!empty($_POST['referenceusine']) && !empty($_POST['epaisseur'])  && !empty($_POST['lieutransfert'])  && !empty($_POST['poidsdeclare'])){
            $referenceusine=htmlspecialchars($_POST['referenceusine']);
            $epaisseur=htmlspecialchars($_POST['epaisseur']);
            //$largeur=htmlspecialchars($_POST['largeur']);
            $lieutransfert=htmlspecialchars($_POST['lieutransfert']);
            $commentaire=htmlspecialchars($_POST['commentaire']);
            $user=htmlspecialchars($_POST['user']);
            $poidsdeclare=htmlspecialchars($_POST['poidsdeclare']);
            //$poidspese=htmlspecialchars($_POST['poidspese']);
            //$idLot=htmlspecialchars($_POST['idLot']);
            $idbobine=htmlspecialchars($_POST['idbobine']);
            //$idreception=htmlspecialchars($_POST['idreception']);
            $nbbobine=htmlspecialchars($_POST['nbbobine']);

            if($nbbobine == 0){
                $valideTransfert="erreurEpaisseur";
            }else{
                $insertUser=$db->prepare("INSERT INTO `matiere` (`idmatiere`, `referenceusine`, `epaisseur`, `largeur`, `poidsdeclare`, `laminage`, `poidspese`, `produitfini`,
                `travaille`, `idlot`, `annee`, `numprod`, `dateajout`, `idbobine`,`user`,`nbbobine`,`commentaire`,`lieutransfert`, `idreception`) VALUES (NULL, ?, ?, '', ?, '', '', '', '', '', '', '', current_timestamp(), '1',?,?,?,?,?);");
               $insertUser->execute(array($referenceusine,$epaisseur,$poidsdeclare,$user,$nbbobine,$commentaire,$lieutransfert,$idreception));

               header("location: detailsReception.php?idreception=$idreception");
               exit;
            }
            
        }else{
            $valideTransfert="erreurInsertion";
        }
    }
//Fin insertion details reception

//Pour send mail approuveTransfertRectifie
    if(isset($_POST['approuveExportationRectifie'])){
        if(!empty($_POST['motifRectifier'])){
            $idexportationDemandeRectifier=htmlspecialchars($_POST['idexportationDemandeRectifier']);
            $idmatiereDemandeRectifier=htmlspecialchars($_POST['idmatiereDemandeRectifier']);
            $epaisseur=htmlspecialchars($_POST['epaisseur']);
            $nombrebobine=htmlspecialchars($_POST['nombrebobine']);
            $user=htmlspecialchars($_POST['user']);
            $idexportation=htmlspecialchars($_POST['idexportation']);
            $pointdepart=htmlspecialchars($_POST['pointdepart']);
            $poidspese=htmlspecialchars($_POST['poidspese']);
            $pointarrive=htmlspecialchars($_POST['pointarrive']);
            $motifRectifier=htmlspecialchars($_POST['motifRectifier']);
            //$idmatierearrive=htmlspecialchars($_POST['idmatierearrive']);

            //Rechercher le nombre de piéces sur le lieu d'arrive
                $sqlEpaisseur = "SELECT * FROM `matiere` where `lieutransfert`='$pointarrive' and `epaisseur`='$epaisseur' and `nbbobineactuel` != 0 and `nbbobineactuel`>=$nombrebobine LIMIT 1;";
                // On prépare la requête
                $queryEpaisseur = $db->prepare($sqlEpaisseur);

                // On exécute
                $queryEpaisseur->execute();

                // On récupère le nombre d'articles
                $resultMatiereArrive = $queryEpaisseur->fetch();
            //Fin Rechercher le nombre de piéces d'arrive

            if($resultMatiereArrive){
                $sql1 = "UPDATE `exportationdetails` set `actifapprouvexportation`=1 where idexportationdetail=$idexportationDemandeRectifier";
                $db->query($sql1);
    
                //Pour enlever la couleur rouge
                $sql1 = "UPDATE `exportationdetails` set `acceptereceptionmodif`=1 where idexportationdetail=$idexportationDemandeRectifier";
                $db->query($sql1);

                $messageD = "
                <html>
                <head>
                <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <title>Nouveau compte</title>
                <
                <body>
                    <div id='email-wrap' style='background: linear-gradient(45deg, #FC466B, #3F5EFB); border-radius: 10px;'>
                        <p align='center' style='margin-top:20px;'>
                            <h2 align='center' style='color:white'>METAL * * * AFRIQUE</h2>
                            <p align='center' style='color:white'>$_SESSION[nomcomplet] vous demande l'autorisation de modifier ou supprimer une exportation de code d'exportation : <strong>EXP00-$idtransfert </strong></p>
                            <p align='center' style='color:white'>Avec comme motif : <strong>$motifRectifier</strong></p>
                            <p align='center'><a href='http://10.10.10.127:8082/GestionProduction' style='color:white'>Cliquez ici pour y acceder.</a></p>
                        </p>
                        <br>
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
                    envoie_mail("METAL AFRIQUE",$item['email'],"Demande de réctification pour l'exportation de code EXP00-$idexportation",$messageD);
                }

                
                header("location: detailEportation.php?idexportation=$idmatiereDemandeRectifier");
                exit;
            }else{
                $idmatierearrive="erreurIdmatierearrive";
            }

        }else{
            $valideTransfert="erreurInsertion";
        }
    }
//Fin send mail approuveTransfertRectifie


//** Debut select des receptions
    $sql = "SELECT * FROM `exportationdetails` where `actif`=1 and `idexportation`=$idexportation ORDER BY `idexportationdetail` DESC;";

    // On prépare la requête
    $query = $db->prepare($sql);

    // On exécute
    $query->execute();

    // On récupère les valeurs dans un tableau associatif
    $Exportation = $query->fetchAll();
//** Fin select des receptions


//** Nombre des bobines total
    $sql = "SELECT SUM(`3`) + SUM(`3.5`) + SUM(`4`) + SUM(`4.5`) + SUM(`5`) + SUM(`5.5`) + SUM(`6`) + SUM(`6.5`) + SUM(`7`) + SUM(`7.5`)
    + SUM(`8`) + SUM(`8.5`) + SUM(`9`) + SUM(`9.5`) + SUM(`10`) + SUM(`10.5`) + SUM(`11`) + SUM(`11.5`) + SUM(`12`) + SUM(`12.5`) + SUM(`13`) + SUM(`13.5`) + 
    SUM(`14`) + SUM(`14.5`) + SUM(`15`) + SUM(`15.5`) + SUM(`16`) + SUM(`16.5`) + SUM(`17`) AS nb_reception_total FROM `epaisseur`;";
    // On prépare la requête
    $query = $db->prepare($sql);

    // On exécute
    $query->execute();

    // On récupère le nombre d'articles
    $result = $query->fetch();

    $nbReception = (int) $result['nb_reception_total'];
//** Fin nombre des bobines total

//** Debut select des epaisseurs pour Metal1
    $sqlepaisseur = "SELECT * FROM `epaisseur` where `id`=1;";

    // On prépare la requête
    $queryepaisseur = $db->prepare($sqlepaisseur);

    // On exécute
    $queryepaisseur->execute();

    // On récupère les valeurs dans un tableau associatif
    $EpaisseurM1 = $queryepaisseur->fetch();
//** Fin select des epaisseurs pour Metal1

//** Debut select des epaisseurs pour Metal3
    $sqlepaisseur = "SELECT * FROM `epaisseur` where `id`=3;";

    // On prépare la requête
    $queryepaisseur = $db->prepare($sqlepaisseur);

    // On exécute
    $queryepaisseur->execute();

    // On récupère les valeurs dans un tableau associatif
    $EpaisseurM3 = $queryepaisseur->fetch();
//** Fin select des epaisseurs pour Metal3

//** Debut select des epaisseurs pour Cranteuse
    $sqlepaisseur = "SELECT * FROM `epaisseur` where `id`=4;";

    // On prépare la requête
    $queryepaisseur = $db->prepare($sqlepaisseur);

    // On exécute
    $queryepaisseur->execute();

    // On récupère les valeurs dans un tableau associatif
    $EpaisseurCrant = $queryepaisseur->fetch();
//** Fin select des epaisseurs pour Cranteuse

//** Debut select des epaisseurs pour Tref
    $sqlepaisseur = "SELECT * FROM `epaisseur` where `id`=5;";

    // On prépare la requête
    $queryepaisseur = $db->prepare($sqlepaisseur);

    // On exécute
    $queryepaisseur->execute();

    // On récupère les valeurs dans un tableau associatif
    $EpaisseurTref = $queryepaisseur->fetch();
//** Fin select des epaisseurs pour Tref

//** Debut select des epaisseurs pour Metal Mbao
    $sqlepaisseur = "SELECT * FROM `epaisseur` where `id`=6;";

    // On prépare la requête
    $queryepaisseur = $db->prepare($sqlepaisseur);

    // On exécute
    $queryepaisseur->execute();

    // On récupère les valeurs dans un tableau associatif
    $EpaisseurMB = $queryepaisseur->fetch();
//** Fin select des epaisseurs pour Metal Mbao


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

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

             <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../indexPage/accueil.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../../indexPage/accueil.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Accueil Dashboard</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Tables -->

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReception"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa fa-book fa-fw"></i>
                    <span>Pont Bascule</span>
                </a>
                <div id="collapseReception" class="collapse show" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Stockage :</h6>
                        <a class="collapse-item" href="../../stockage/reception.php">Réception</a>
                        <a class="collapse-item" href="../../stockage/receptionPlanifie.php">Réception planifiée</a>
                        <a class="collapse-item" href="../../stockage/transfert/transfert.php">Transfert</a>
                        <a class="collapse-item active" href="../../stockage/Exportation/exportation.php">Export</a>
                        <a class="collapse-item" href="../../stockage/stockage/stockage.php">Stockage</a>
                        <a class="collapse-item" href="../../stockage/graphe.php">Graphique</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Tables -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <span>Production Cranteuse</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Les différents quarts :</h6>
                        <a class="collapse-item" href="quart1.php">Quart 1</a>
                        <a class="collapse-item" href="quart2.php">Quart 2</a>
                        <a class="collapse-item" href="quart3.php">Quart 3</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tables.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Production</span></a>
            </li>


            <div class="sidebar-heading">
                Section 3
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Productions</span></a>
            </li>


            <div class="sidebar-heading">
                Section 4
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider">



            <!-- Nav Item - Utilities Collapse Menu -->
            <!--<li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>-->

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Productions</span></a>
            </li>

            <div class="sidebar-heading">
                Section 5
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

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
                            <img src="../../image/stockage/ferabeton.jpg" class="img-fluid" alt="" style="border-radius: 50%; margin:20px; opacity: 0.7;" width="200">
                        </div>
                    </div>
                    <!-- DataTales Example -->
                       <!-- Fade In Utility -->
                       <div class="col-lg-12">
                            <div class="card position-relative">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Liste des bobines réceptionnées</h6>
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
                                                    <th>Code exportation</th>                                                                                
                                                    <th>Epaisseur</th>
                                                    <th>Nombre bobine</th>
                                                    <th>Poids déclaré (KG)</th>
                                                    <th>Poids pesé (KG)</th>
                                                    <th>Etat bobine</th>
                                                    <th>Point de départ</th>
                                                    <th>Point d'arrivée</th>
                                                    <th>Derniére modification</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $i=0;
                                                    foreach($Exportation as $exportation){
                                                        $i++;
                                                        //if($article['status'] == 'termine'){
                                                ?>
                                                    <tr>
                                                        <td style="<?php if($exportation['actifapprouvexportation'] == 1){ echo 'background-color:#D72708 ; color:white;';}else{echo 'background-color:#4e73df ; color:white;';}?>">
                                                            <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" title="Allez vers la reception planifiée correspondante" href="detailsReceptionPlanifie.php?idexportation=<?= $exportation['idexportation'] ?>" class="link-offset-2 link-underline"><?php echo "EXP-0".$exportation['idexportation']."-BOB-0".$exportation['idexportationdetail'] ?></a>
                                                        </td>
                                                        <td style="<?php if($exportation['actifapprouvexportation'] == 1){ echo 'background-color:#D72708 ; color:white;';}else{echo 'background-color:#4e73df ; color:white;';}?>"><?= $exportation['epaisseur'] ?></td>
                                                        <td style="<?php if($exportation['actifapprouvexportation'] == 1){ echo 'background-color:#D72708 ; color:white;';}else{echo 'background-color:#4e73df ; color:white;';}?>"><?= $exportation['nbbobine'] ?></td>
                                                        <td style="<?php if($exportation['actifapprouvexportation'] == 1){ echo 'background-color:#D72708 ; color:white;';}else{echo 'background-color:#4e73df ; color:white;';}?>"><?= $exportation['poidsdeclare'] ?></td>
                                                        <td style="<?php if($exportation['actifapprouvexportation'] == 1){ echo 'background-color:#D72708 ; color:white;';}else{echo 'background-color:#4e73df ; color:white;';}?>"><?= $exportation['poidspese'] ?></td>
                                                        <td style="<?php if($exportation['actifapprouvexportation'] == 1){ echo 'background-color:#D72708 ; color:white;';}else{echo 'background-color:#4e73df ; color:white;';}?>"><?= $exportation['etatbobine'] ?></td>
                                                        <td style="<?php if($exportation['actifapprouvexportation'] == 1){ echo 'background-color:#D72708 ; color:white;';}else{echo 'background-color:#4e73df ; color:white;';}?>"><?= $exportation['pointdepart'] ?></td>
                                                        <td style="<?php if($exportation['actifapprouvexportation'] == 1){ echo 'background-color:#D72708 ; color:white;';}else{echo 'background-color:#4e73df ; color:white;';}?>"><?= $exportation['pointarrive'] ?></td>
                                                        <td style="<?php if($exportation['actifapprouvexportation'] == 1){ echo 'background-color:#D72708 ; color:white;';}else{echo 'background-color:#4e73df ; color:white;';}?>"><?= $exportation['dateajout'] ?></td>
                                                        <td >
                                                            <?php if($exportation['actifapprouvexportation'] == 0 && $_SESSION['niveau']=='pontbascule'){ ?>
                                                                <a href="javascript:void(0);" data-toggle="modal" data-target=".approuveReceptionRectifie<?= $i ?>" class="px-2" title="Demander l'autorisation de modifier ou suprimer cette exportation au prêt du DSI">
                                                                <i class="fas fa-file-signature"></i></a>
                                                            <?php }?>
                                                            <?php if($exportation['acceptereceptionmodif'] == 1 && $_SESSION['niveau']=='admin'){ ?>
                                                                <a href="javascript:void(0);" class="accepteExportationmod<?= $i ?> px-2" class="px-2" title="Permettre au responsable du pont bascule de modifier ou suprimer cette exportation">
                                                                <i class="fas fa-paper-plane"></i></a>
                                                            <?php }?>
                                                            <?php if(($exportation['acceptereceptionmodif'] == 0) && ($exportation['actifapprouvexportation'] == 1) && $_SESSION['niveau']=='pontbascule'){ ?>
                                                                <a href="modifierExportation.php?idexportation=<?= $_GET['idexportation'] ?>&idexportationModifSimp=<?= $exportation['idexportationdetail'] ?>&epaisseur=<?= $exportation['epaisseur'] ?>&nombrebobine=<?= $exportation['nbbobine'] ?>&idPointdepart=<?= $exportation['idmatieredepart'] ?>&idPointarrive=<?= $exportation['idmatierearrive'] ?>" class="px-2" title="Modifier l'exportation"><i class="far fa-edit"></i></a>
                                                            <?php }?>
                                                            <?php if(($exportation['acceptereceptionmodif'] == 0) && ($exportation['actifapprouvexportation'] == 1) && $_SESSION['niveau']=='pontbascule'){ ?>
                                                                <a href="javascript:void(0);" id="suprimerExportation<?= $i ?>" class=" px-2 text-danger" title="Suprimer l'exportation"><i class="fa fa-cut"></i></a>
                                                            <?php }?>
                                                        </td>
                                                    </tr>

                                                    
                                                    <!-- Pour la rectification des receptions !-->
                                                    <div class="modal fade approuveReceptionRectifie<?php echo $i; ?>" id="" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="myExtraLargeModalLabel">Demander la rectification de cette exportation au prét de l'administrateur</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                                                                        <div class="row">
                                                                            <div class="invisible">
                                                                                <div class="">
                                                                                    <input class="" type="text" value="<?= $exportation['idexportationdetail'] ?>" name="idexportationDemandeRectifier">
                                                                                </div>
                                                                            </div> 
                                                                            <div class="col-md-10 mb-5">
                                                                                <label class="form-label fw-bold" for="rectification"><h4>Motif de la rectification</h4></label>
                                                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="motifRectifier" placeholder="Mettez en quelques mots le motif de la rectification qui sera recu par le DSI par MAIL svp."></textarea>
                                                                            </div>
                                                                            <div class="invisible">
                                                                                <div class="">
                                                                                    <input class="" type="text" value="<?= $exportation['idexportation'] ?>" name="idmatiereDemandeRectifier">
                                                                                </div>
                                                                            </div> 
                                                                            <div class="invisible">
                                                                                <div class="">
                                                                                    <input class="" type="text" value="<?= $exportation['epaisseur'] ?>" name="epaisseur">
                                                                                </div>
                                                                            </div>
                                                                            <div class="invisible">
                                                                                <div class="">
                                                                                    <input class="" type="text" value="<?= $_GET['idexportation'] ?>" name="idexportation">
                                                                                </div>
                                                                            </div>
                                                                            <div class="invisible">
                                                                                <div class="">
                                                                                    <input class="" type="text" value="<?= $exportation['idmatierearrive'] ?>" name="idmatierearrive">
                                                                                </div>
                                                                            <div class="invisible">
                                                                                <div class="">
                                                                                    <input class="" type="text" value="<?= $exportation['nbbobine'] ?>" name="nombrebobine">
                                                                                </div>
                                                                            </div>
                                                                            <div class="invisible">
                                                                                <div class="">
                                                                                    <input class="" type="text" value="<?= $exportation['pointarrive'] ?>" name="pointarrive">
                                                                                </div>
                                                                            </div>
                                                                            <div class="invisible">
                                                                                <div class="">
                                                                                    <input class="" type="text" value="<?= $exportation['pointdepart'] ?>" name="pointdepart">
                                                                                </div>
                                                                            </div>
                                                                            <div class="invisible">
                                                                                <div class="">
                                                                                    <input class="" type="text" value="<?= $exportation['poidspese'] ?>" name="poidspese">
                                                                                </div>
                                                                            </div>
                                                                            <div class="invisible">
                                                                                <div class="">
                                                                                    <input class="" type="text" value="<?php echo $_SESSION['nomcomplet'];?>" name="user" id="example-date-input">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="">
                                                                            <div class="">
                                                                                <?php 
                                                                                    if($valideExportation == "erreurInsertion"){ 
                                                                                ?> 
                                                                                    <script>    Swal.fire({
                                                                                        text: 'Veillez entrer le motif de la rectification svp!',
                                                                                        icon: 'error',
                                                                                        timer: 3500,
                                                                                        showConfirmButton: false,
                                                                                        });
                                                                                    </script> 
                                                                                <?php
                                                                                    } 
                                                                                ?>
                                                                                <?php 
                                                                                    if($idmatierearrive == "erreurIdmatierearrive"){ 
                                                                                ?> 
                                                                                    <script>    Swal.fire({
                                                                                        text: 'Vous ne pouvez pas modifier cette exportation car le nombre de bobine en stock pour cette épaisseur est insuffisant!',
                                                                                        icon: 'error',
                                                                                        timer: 6000,
                                                                                        showConfirmButton: false,
                                                                                        });
                                                                                    </script> 
                                                                                <?php
                                                                                    } 
                                                                                ?>
                                                                                    <div class="d-flex gap-2 pt-5">                           
                                                                                        <a href="#"><input class="btn btn-danger  w-lg bouton" name="" type="submit" value="Annuler"></a>
                                                                                        <input class="btn btn-success  w-lg bouton ml-4" name="approuveExportationRectifie" type="submit" value="Enregistrer">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>                             
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal --> 

                                                    <!-- Pour le sweetAlert Suprimer transfert !-->
                                                    <script>
                                                        console.log("approuveExportation.php?idexportationDemandeAccepter=<?= $_GET['idexportation'] ?>&idmatiereDemandeAccepter=<?= $exportation['idexportationdetail'] ?>&epaisseur=<?= $exportation['epaisseur'] ?>&nombrebobine=<?= $exportation['nbbobine'] ?>&pointdepart=<?= $exportation['pointdepart'] ?>&pointarrive=<?= $exportation['pointarrive'] ?>&idPointdepart=<?= $exportation['idmatieredepart'] ?>&idPointarrive=<?= $exportation['idmatierearrive'] ?>");
                                                        $(document).ready( function(){
                                                            $('.accepteExportationmod<?= $i ?>').click(function(e) {
                                                                e.preventDefault();
                                                                Swal.fire({
                                                                title: 'En es-tu sure?',
                                                                text: 'Voulez-vous vraiment permettre au responsable du pont bascule de modifier ou suprimer cette exportation?',
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: "Permettre la modification",
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {                                                                                                                  
                                                                        $.ajax({
                                                                                type: "POST",
                                                                                url: "approuveExportation.php?idexportationDemandeAccepter=<?= $_GET['idexportation'] ?>&idmatiereDemandeAccepter=<?= $exportation['idexportationdetail'] ?>&epaisseur=<?= $exportation['epaisseur'] ?>&nombrebobine=<?= $exportation['nbbobine'] ?>&pointdepart=<?= $exportation['pointdepart'] ?>&pointarrive=<?= $exportation['pointarrive'] ?>&idPointdepart=<?= $exportation['idmatieredepart'] ?>&idPointarrive=<?= $exportation['idmatierearrive'] ?>",
                                                                                //data: str,
                                                                                success: function( response ) {
                                                                                    Swal.fire({
                                                                                        text: 'Exportation approuvé avec succes!',
                                                                                        icon: 'success',
                                                                                        timer: 3000,
                                                                                        showConfirmButton: false,
                                                                                    });
                                                                                    location.reload();
                                                                                },
                                                                                error: function( response ) {
                                                                                    $('#status').text('Impossible approuver cette exportation : '+ response.status + " " + response.statusText);
                                                                                    //console.log( response );
                                                                                }						
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    </script>
                                                    <!-- Pour le sweetAlert Suprimer transfert !--> 

                                                    <!-- Pour le sweetAlert Suprimer transfert !-->
                                                    <script>
                                                        //console.log(<?= $i ?>);
                                                        $(document).ready( function(){
                                                            $('#suprimerExportation<?= $i ?>').click(function(e) {
                                                                e.preventDefault();
                                                                Swal.fire({
                                                                title: 'En es-tu sure?',
                                                                text: 'Voulez-vous vraiment suprimer cette exportation ?',
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: "Suprimer la exportation",
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {                                                                                                                  
                                                                        $.ajax({
                                                                                type: "POST",
                                                                                url: "suprimerExportation.php?idsupexportation=<?=  $_GET['idexportation'] ?>&idexportationsup=<?= $exportation['idexportationdetail'] ?>&epaisseur=<?= $exportation['epaisseur'] ?>&lieuDepart=<?= $exportation['pointdepart'] ?>&nombrebobine=<?= $exportation['nbbobine'] ?>",
                                                                                //data: str,
                                                                                success: function( response ) {
                                                                                    Swal.fire({
                                                                                        text: 'Réception suprimée avec succes!',
                                                                                        icon: 'success',
                                                                                        timer: 3000,
                                                                                        showConfirmButton: false,
                                                                                    });
                                                                                    location.reload();
                                                                                },
                                                                                error: function( response ) {
                                                                                    $('#status').text('Impossible de supprimer cette réception : '+ response.status + " " + response.statusText);
                                                                                    //console.log( response );
                                                                                }						
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    </script>
                                                <!-- Pour le sweetAlert Suprimer transfert !--> 

                                                <!-- Pour le sweetAlert approuveTransfert !-->
                                                <script>
                                                    //console.log(<?= $i ?>);
                                                    $(document).ready( function(){
                                                        $('.approuverReception<?= $i ?>').click(function(e) {
                                                            e.preventDefault();
                                                            Swal.fire({
                                                            title: 'En es-tu sure?',
                                                            text: 'Voulez-vous vraiment approuver cette réception ?',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: "Approuver la réception",
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {                                                                                                                  
                                                                    $.ajax({
                                                                            type: "POST",
                                                                            url: 'approuveReception.php?idappreception=<?= $exportation['idexportation']?>',
                                                                            //data: str,
                                                                            success: function( response ) {
                                                                                Swal.fire({
                                                                                    text: 'Réception approuvée avec succes!',
                                                                                    icon: 'success',
                                                                                    timer: 3000,
                                                                                    showConfirmButton: false,
                                                                                });
                                                                                location.reload();
                                                                            },
                                                                            error: function( response ) {
                                                                                $('#status').text('Impossible dapprouver ce réception : '+ response.status + " " + response.statusText);
                                                                                //console.log( response );
                                                                            }						
                                                                    });
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <?php
                                                    }
                                                ?> 
                                            </tbody>
                                        </table>
                                        <!-- Bouton et pagnination--> 
                                        <?php 
                                            //if($_SESSION['niveau']=='kemc'){
                                        ?>
                                            <div class="col-md-8 align-items-center">
                                                <div class="d-flex gap-2 pt-4">
                                                    <?php
                                                        if($_SESSION['niveau']=='pontbascule'){
                                                            /*$id = $_GET['idreception'];
                                                            $sql = "select * from reception where idreception=$id";
                                                            $result = $db->query($sql);
                                                            $row = $result->fetch();
                                                            if($row ['actifapprouvreception']== 1){*/
                                                    ?>
                                                        <a href="ajouterTransfertFormulaire.php?idtransfert=<?= $_GET['idtransfert']?>&NombreLigne=0" class="btn btn-success w-lg bouton"><i class="fa fa-plus me-1"></i> Ajouter transfert</a>
                                                    <?php
                                                            //} 
                                                        }
                                                    ?>
                                                        <a href="transfert.php" class="btn btn-danger w-lg bouton ml-3"><i class="fa fa-angle-double-left mr-2"></i>Retour</a>
                                                </div>
                                            </div>
                                        <?php
                                            //}
                                        ?>
                                    </div>
                                </div>
                                <!-- Tableau d'en bas -->
                            </div>
                        </div>
                        <!-- Modale pour ajouter reception -->
                        <div class="modal fade add-new" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myExtraLargeModalLabel">Ajouter une réception</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-6 text-start">
                                                        <label class="form-label fw-bold" for="nom">Usine de provenance</label>
                                                        <input class="form-control" type="text" name="referenceusine" value="" id="example-date-input4" placeholder="Taper la référence de l'usine">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 text-start">
                                                        <label class="form-label fw-bold" for="prenom" >Epaisseur</label>
                                                        <select class="form-control" name="epaisseur" placeholder="Taper l'épaisseur de la bobine" value="">
                                                            <option>3</option>
                                                            <option>3.5</option>
                                                            <option>4</option>
                                                            <option>4.5</option>
                                                            <option>5</option>
                                                            <option>5.5</option>
                                                            <option>6</option>
                                                            <option>6.5</option>
                                                            <option>7</option>
                                                            <option>7.5</option>
                                                            <option>8</option>
                                                            <option>8.5</option>
                                                            <option>9</option>
                                                            <option>9.5</option>
                                                            <option>10</option>
                                                            <option>10.5</option>
                                                            <option>11</option>
                                                            <option>11.5</option>
                                                            <option>12</option>
                                                            <option>12.5</option>
                                                            <option>13</option>
                                                            <option>13.5</option>
                                                            <option>14</option>
                                                            <option>14.5</option>
                                                            <option>15</option>
                                                            <option>15.5</option>
                                                            <option>16</option>
                                                            <option>16.5</option>
                                                            <option>17</option>
                                                        </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-6 text-start">
                                                        <label class="form-label fw-bold" for="nom">Nombre de bobine</label>
                                                        <input class="form-control" type="number" name="nbbobine" value="" id="example-date-input4" placeholder="Taper le nombre de bobine">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-6 text-start">
                                                        <label class="form-label fw-bold" for="nom">Lieu de réception</label>
                                                        <select class="form-control" name="lieutransfert" value="">
                                                            <option>Metal1</option>
                                                            <option>Niambour</option>
                                                            <option>Metal Mbao</option>
                                                        </select>                                                  
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-4">
                                                    <div class="mb-3 text-start">
                                                        <label class="form-label fw-bold" for="prenom" >Poids déclare</label>
                                                        <input class="form-control designa" type="number" name="poidsdeclare" id="example"  placeholder="Taper le poids déclaré">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-4">
                                                    <div class="mb-6 text-start">
                                                        <label class="form-label fw-bold" for="priorites">Bobine</label>
                                                        <select class="form-control" name="idbobine" value="">
                                                            <option>B0015</option>
                                                            <option>B0014</option>
                                                            <option>B006</option>
                                                            <option>B00945</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-4 invisible">
                                                    <div class="mb-3 text-start">
                                                        <label class="form-label fw-bold" for="user" ></label>
                                                        <input class="form-control " type="text" value="<?php
                                                            $array = explode(' ', $_SESSION['nomcomplet']);
                                                            echo $array[0]; 
                                                        ?>" name="user" id="example-date-input2">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="mb-3 text-start">
                                                        <label class="form-label fw-bold" for="commentaire" >Commentaire</label>
                                                        <textarea class="form-control"  name="commentaire" rows="4" cols="50"  placeholder="Commentaire en quelques mots ( pas obligatoire... )"></textarea>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12 text-end">
                                                    <div class="col-md-8 align-items-center col-md-12 text-end">
                                                        <?php if($valideTransfert == "erreurInsertion"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Veiller remplir tous les champs svp!',
                                                                    icon: 'error',
                                                                    timer: 2500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($valideTransfert == "erreurEpaisseur"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Vérifiez le nombre de bobine svp!',
                                                                    icon: 'error',
                                                                    timer: 2500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($valideTransfert == "ValideInsertion"){?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Réception enregistrée avec succès merci!',
                                                                    icon: 'success',
                                                                    timer: 3000,
                                                                    showConfirmButton: false,
                                                                    });
                                                            </script> 
                                                        <?php } ?>
                                                        <div class="d-flex gap-2 pt-4">                           
                                                            <a href="#"><input class="btn btn-danger  w-lg bouton mr-3" name="" type="submit" value="Annuler"></a>
                                                            <input class="btn btn-success  w-lg bouton mr-3" name="CreerReception" type="submit" value="Enregistrer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>  
                                    </div>
                                </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <div class="card position-relative mb-4 col-lg-12 mt-5 ml-2 mr-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Nombre de bobines par épaisseur</h6>
                        </div>
                        <div class="row m-2">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="" cellspacing="0">
                                    <thead>
                                        <tr>    
                                            <td>Epaisseurs</td> 
                                            <th>3</th>
                                            <th>3.5</th>
                                            <th>4</th>
                                            <th>4.5</th>
                                            <th>5</th>
                                            <th>5.5</th>
                                            <th>6</th>
                                            <th>6.5</th>
                                            <th>7</th>
                                            <th>7.5</th>
                                            <th>8</th>
                                            <th>8.5</th>
                                            <th>9</th>
                                            <th>9.5</th>
                                            <th>10</th>
                                            <th>10.5</th>
                                            <th>11</th>
                                            <th>11.5</th>
                                            <th>12</th>
                                            <th>12.5</th>
                                            <th>13</th>
                                            <th>13.5</th>
                                            <th>14</th>
                                            <th>14.5</th>
                                            <th>15</th>
                                            <th>15.5</th>
                                            <th>16</th>
                                            <th>16.5</th>
                                            <th>17</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>METAL 1</td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['3'] == 0){echo "";}else{echo $EpaisseurM1['3'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['3.5'] == 0){echo "";}else{echo $EpaisseurM1['3.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['4'] == 0){echo "";}else{echo $EpaisseurM1['4'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['4.5'] == 0){echo "";}else{echo $EpaisseurM1['4.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['5'] == 0){echo "";}else{echo $EpaisseurM1['5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['5.5'] == 0){echo "";}else{echo $EpaisseurM1['5.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['6'] == 0){echo "";}else{echo $EpaisseurM1['6'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['6.5'] == 0){echo "";}else{echo $EpaisseurM1['6.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['7'] == 0){echo "";}else{echo $EpaisseurM1['7'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['7.5'] == 0){echo "";}else{echo $EpaisseurM1['7.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['8'] == 0){echo "";}else{echo $EpaisseurM1['8'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['8.5'] == 0){echo "";}else{echo $EpaisseurM1['8.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['9'] == 0){echo "";}else{echo $EpaisseurM1['9'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['9.5'] == 0){echo "";}else{echo $EpaisseurM1['9.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['10'] == 0){echo "";}else{echo $EpaisseurM1['10'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['10.5'] == 0){echo "";}else{echo $EpaisseurM1['10.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['11'] == 0){echo "";}else{echo $EpaisseurM1['11'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['11.5'] == 0){echo "";}else{echo $EpaisseurM1['11.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['12'] == 0){echo "";}else{echo $EpaisseurM1['12'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['12.5'] == 0){echo "";}else{echo $EpaisseurM1['12.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['13'] == 0){echo "";}else{echo $EpaisseurM1['13'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['13.5'] == 0){echo "";}else{echo $EpaisseurM1['13.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['14'] == 0){echo "";}else{echo $EpaisseurM1['14'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['14.5'] == 0){echo "";}else{echo $EpaisseurM1['14.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['15'] == 0){echo "";}else{echo $EpaisseurM1['15'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['15.5'] == 0){echo "";}else{echo $EpaisseurM1['15.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['16'] == 0){echo "";}else{echo $EpaisseurM1['16'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['16.5'] == 0){echo "";}else{echo $EpaisseurM1['16.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM1['17'] == 0){echo "";}else{echo $EpaisseurM1['17'];} ?></td>
                                        <tr>
                                            <td>NIAMBOUR</td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['3'] == 0){echo "";}else{echo $EpaisseurM3['3'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['3.5'] == 0){echo "";}else{echo $EpaisseurM3['3.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['4'] == 0){echo "";}else{echo $EpaisseurM3['4'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['4.5'] == 0){echo "";}else{echo $EpaisseurM3['4.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['5'] == 0){echo "";}else{echo $EpaisseurM3['5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['5.5'] == 0){echo "";}else{echo $EpaisseurM3['5.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['6'] == 0){echo "";}else{echo $EpaisseurM3['6'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['6.5'] == 0){echo "";}else{echo $EpaisseurM3['6.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['7'] == 0){echo "";}else{echo $EpaisseurM3['7'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['7.5'] == 0){echo "";}else{echo $EpaisseurM3['7.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['8'] == 0){echo "";}else{echo $EpaisseurM3['8'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['8.5'] == 0){echo "";}else{echo $EpaisseurM3['8.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['9'] == 0){echo "";}else{echo $EpaisseurM3['9'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['9.5'] == 0){echo "";}else{echo $EpaisseurM3['9.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['10'] == 0){echo "";}else{echo $EpaisseurM3['10'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['10.5'] == 0){echo "";}else{echo $EpaisseurM3['10.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['11'] == 0){echo "";}else{echo $EpaisseurM3['11'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['11.5'] == 0){echo "";}else{echo $EpaisseurM3['11.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['12'] == 0){echo "";}else{echo $EpaisseurM3['12'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['12.5'] == 0){echo "";}else{echo $EpaisseurM3['12.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['13'] == 0){echo "";}else{echo $EpaisseurM3['13'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['13.5'] == 0){echo "";}else{echo $EpaisseurM3['13.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['14'] == 0){echo "";}else{echo $EpaisseurM3['14'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['14.5'] == 0){echo "";}else{echo $EpaisseurM3['14.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['15'] == 0){echo "";}else{echo $EpaisseurM3['15'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['15.5'] == 0){echo "";}else{echo $EpaisseurM3['15.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['16'] == 0){echo "";}else{echo $EpaisseurM3['16'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['16.5'] == 0){echo "";}else{echo $EpaisseurM3['16.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurM3['17'] == 0){echo "";}else{echo $EpaisseurM3['17'];} ?></td>
                                        </tr>
                                        <tr>
                                            <td>METAL MBAO</td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['3'] == 0){echo "";}else{echo $EpaisseurMB['3'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['3.5'] == 0){echo "";}else{echo $EpaisseurMB['3.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['4'] == 0){echo "";}else{echo $EpaisseurMB['4'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['4.5'] == 0){echo "";}else{echo $EpaisseurMB['4.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['5'] == 0){echo "";}else{echo $EpaisseurMB['5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['5.5'] == 0){echo "";}else{echo $EpaisseurMB['5.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['6'] == 0){echo "";}else{echo $EpaisseurMB['6'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['6.5'] == 0){echo "";}else{echo $EpaisseurMB['6.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['7'] == 0){echo "";}else{echo $EpaisseurMB['7'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['7.5'] == 0){echo "";}else{echo $EpaisseurMB['7.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['8'] == 0){echo "";}else{echo $EpaisseurMB['8'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['8.5'] == 0){echo "";}else{echo $EpaisseurMB['8.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['9'] == 0){echo "";}else{echo $EpaisseurMB['9'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['9.5'] == 0){echo "";}else{echo $EpaisseurMB['9.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['10'] == 0){echo "";}else{echo $EpaisseurMB['10'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['10.5'] == 0){echo "";}else{echo $EpaisseurMB['10.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['11'] == 0){echo "";}else{echo $EpaisseurMB['11'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['11.5'] == 0){echo "";}else{echo $EpaisseurMB['11.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['12'] == 0){echo "";}else{echo $EpaisseurMB['12'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['12.5'] == 0){echo "";}else{echo $EpaisseurMB['12.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['13'] == 0){echo "";}else{echo $EpaisseurMB['13'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['13.5'] == 0){echo "";}else{echo $EpaisseurMB['13.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['14'] == 0){echo "";}else{echo $EpaisseurMB['14'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['14.5'] == 0){echo "";}else{echo $EpaisseurMB['14.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['15'] == 0){echo "";}else{echo $EpaisseurMB['15'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['15.5'] == 0){echo "";}else{echo $EpaisseurMB['15.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['16'] == 0){echo "";}else{echo $EpaisseurMB['16'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['16.5'] == 0){echo "";}else{echo $EpaisseurMB['16.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurMB['17'] == 0){echo "";}else{echo $EpaisseurMB['17'];} ?></td>
                                        </tr>
                                        <tr> 
                                            <td>Cranteuse</td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['3'] == 0){echo "";}else{echo $EpaisseurCrant['3'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['3.5'] == 0){echo "";}else{echo $EpaisseurCrant['3.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['4'] == 0){echo "";}else{echo $EpaisseurCrant['4'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['4.5'] == 0){echo "";}else{echo $EpaisseurCrant['4.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['5'] == 0){echo "";}else{echo $EpaisseurCrant['5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['5.5'] == 0){echo "";}else{echo $EpaisseurCrant['5.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['6'] == 0){echo "";}else{echo $EpaisseurCrant['6'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['6.5'] == 0){echo "";}else{echo $EpaisseurCrant['6.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['7'] == 0){echo "";}else{echo $EpaisseurCrant['7'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['7.5'] == 0){echo "";}else{echo $EpaisseurCrant['7.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['8'] == 0){echo "";}else{echo $EpaisseurCrant['8'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['8.5'] == 0){echo "";}else{echo $EpaisseurCrant['8.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['9'] == 0){echo "";}else{echo $EpaisseurCrant['9'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['9.5'] == 0){echo "";}else{echo $EpaisseurCrant['9.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['10'] == 0){echo "";}else{echo $EpaisseurCrant['10'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['10.5'] == 0){echo "";}else{echo $EpaisseurCrant['10.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['11'] == 0){echo "";}else{echo $EpaisseurCrant['11'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['11.5'] == 0){echo "";}else{echo $EpaisseurCrant['11.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['12'] == 0){echo "";}else{echo $EpaisseurCrant['12'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['12.5'] == 0){echo "";}else{echo $EpaisseurCrant['12.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['13'] == 0){echo "";}else{echo $EpaisseurCrant['13'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['13.5'] == 0){echo "";}else{echo $EpaisseurCrant['13.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['14'] == 0){echo "";}else{echo $EpaisseurCrant['14'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['14.5'] == 0){echo "";}else{echo $EpaisseurCrant['14.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['15'] == 0){echo "";}else{echo $EpaisseurCrant['15'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['15.5'] == 0){echo "";}else{echo $EpaisseurCrant['15.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['16'] == 0){echo "";}else{echo $EpaisseurCrant['16'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['16.5'] == 0){echo "";}else{echo $EpaisseurCrant['16.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurCrant['17'] == 0){echo "";}else{echo $EpaisseurCrant['17'];} ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tréfilage</td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['3'] == 0){echo "";}else{echo $EpaisseurTref['3'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['3.5'] == 0){echo "";}else{echo $EpaisseurTref['3.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['4'] == 0){echo "";}else{echo $EpaisseurTref['4'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['4.5'] == 0){echo "";}else{echo $EpaisseurTref['4.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['5'] == 0){echo "";}else{echo $EpaisseurTref['5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['5.5'] == 0){echo "";}else{echo $EpaisseurTref['5.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['6'] == 0){echo "";}else{echo $EpaisseurTref['6'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['6.5'] == 0){echo "";}else{echo $EpaisseurTref['6.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['7'] == 0){echo "";}else{echo $EpaisseurTref['7'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['7.5'] == 0){echo "";}else{echo $EpaisseurTref['7.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['8'] == 0){echo "";}else{echo $EpaisseurTref['8'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['8.5'] == 0){echo "";}else{echo $EpaisseurTref['8.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['9'] == 0){echo "";}else{echo $EpaisseurTref['9'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['9.5'] == 0){echo "";}else{echo $EpaisseurTref['9.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['10'] == 0){echo "";}else{echo $EpaisseurTref['10'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['10.5'] == 0){echo "";}else{echo $EpaisseurTref['10.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['11'] == 0){echo "";}else{echo $EpaisseurTref['11'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['11.5'] == 0){echo "";}else{echo $EpaisseurTref['11.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['12'] == 0){echo "";}else{echo $EpaisseurTref['12'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['12.5'] == 0){echo "";}else{echo $EpaisseurTref['12.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['13'] == 0){echo "";}else{echo $EpaisseurTref['13'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['13.5'] == 0){echo "";}else{echo $EpaisseurTref['13.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['14'] == 0){echo "";}else{echo $EpaisseurTref['14'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['14.5'] == 0){echo "";}else{echo $EpaisseurTref['14.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['15'] == 0){echo "";}else{echo $EpaisseurTref['15'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['15.5'] == 0){echo "";}else{echo $EpaisseurTref['15.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['16'] == 0){echo "";}else{echo $EpaisseurTref['16'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['16.5'] == 0){echo "";}else{echo $EpaisseurTref['16.5'];} ?></td>
                                            <td style="background-color:#CFFEDA ; color:black;"><?php if($EpaisseurTref['17'] == 0){echo "";}else{echo $EpaisseurTref['17'];} ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Tableau d'en bas -->
                    <div class="card position-relative mb-4 col-lg-2 mt-3 ml-5 ">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Nombre total de bobine</h6>
                        </div>
                        <div class="row m-2">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="" cellspacing="0">
                                    <thead>
                                        <tr>    
                                            <td></td>                                                                                   
                                            <th rowspan="2">Bobines</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-center" style="background-color:#CFFEDA;" rowspan="2"><?= $nbReception ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Tableau d'en bas -->
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