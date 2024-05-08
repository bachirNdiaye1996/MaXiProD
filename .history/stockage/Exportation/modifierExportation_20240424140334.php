<?php

session_start(); 

if(!$_SESSION){
    header("location: ../../404.php");
    return 0;
}

include "../../connexion/conexiondb.php";

// Variables 
$ProblemeNbBobineDepart="";

//La partie de recupe de l'id et script pour modifier
    $lieutransfert="";
    $epaisseur="";
    $poidsroulaux="";
    $idlot="";
    $dateajout="";
    $idbobine="";
    $user="";
    $nbbobine="";


    $error="";
    $success="";

    //print_r($_GET['idtransfert']);
    $idExportation = $_GET['idexportation'];

    if($_SERVER["REQUEST_METHOD"]=='GET'){
        if(!isset($_GET['idexportationModifSimp'])){
            header("location: exportation.php");
            exit;
        }
        $id = $_GET['idexportationModifSimp'];
        $sql = "select * from exportationdetails where idexportationdetail=$id";
        $result = $db->query($sql);
        $row = $result->fetch();
        while(!$row){
            header("location: transfert.php");
        exit;
        }
        $pointdepart=$row['pointdepart'];
        $pointarrive=$row['pointarrive'];
        $epaisseur=$row['epaisseur'];
        $poidspese=$row['poidspese'];
        $poidsdeclare=$row['poidsdeclare'];
        //$idlot=$row['idlot'];
        //$dateajout=$row['datetransfert'];
        //$idbobine=$row['idbobine'];
        $user=$row['user'];
        $nbbobine=$row['nbbobine'];
        //echo $EstDemande;
    }else{    
        if(isset($_POST['modifierTransfert'])){
            $id = $_GET['idtransfertModifSimp'];
            $pointdepart=$_POST['pointdepart'];
            $pointarrive=$_POST['pointarrive'];
            $epaisseur=$_POST['epaisseur'];
            $poidsdeclare=$_POST['poidsdeclare'];
            $poidspese=$_POST['poidspese'];
            //$idlot=$_POST['idlot'];
            $etatbobine=$_POST['etatbobine'];
            $nbbobine=$_POST['nbbobine'];

            //** On vérifie si le nombre est exact
            $idepais = 0;
            /*
                1 -> Metal1
                3 -> Niambour
                4 -> Cranteuse
                5 -> Tréfilage
                6 -> Metal Mbao
            */

            //Depart epaisseur
                $sqlEpaisseur = "SELECT `$epaisseur` AS epaisseurVeriDepart FROM `epaisseur` where `lieu`='$pointdepart';";
                // On prépare la requête
                $queryEpaisseur = $db->prepare($sqlEpaisseur);

                // On exécute
                $queryEpaisseur->execute();

                // On récupère le nombre d'articles
                $resultEpaisseur = $queryEpaisseur->fetch();

                $nbEpaisseurDepart = (int) $resultEpaisseur['epaisseurVeriDepart'];
            //Fin Depart epaisseur

            if(($nbEpaisseurDepart < $nbbobine) || ($nbbobine == 0)){
                $error="erreurEpaisseur";
                //echo "<script language=\"javascript\">";
                    //echo"alert('bonjour')";
                    //echo "$('#erreurEpaisseur').append(`<p color:'red'>Renvoyer</p>`)";                
                //echo "</script>";
                $row = $_POST;
            }else{
                //if(($pointdepart == "Cranteuse vers Metal1")){ // Vérifie le type de transfert
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` - ? where `lieu`='$pointdepart';";
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);

                    $reqtitre->execute(array($nbbobine));
                //}elseif(($lieutransfert == "Tréfilage vers Metal1")){
                    //Debut inserer le nombre de bobine par epaisseur
                    $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `lieu`='$pointarrive';";
                    //$db->query($req); 
                    $reqtitre = $db->prepare($req);
                    $reqtitre->execute(array($nbbobine));
                //}

                // |--> Pour update transfert
                    $sql = "UPDATE `transfertdetails` SET `pointdepart` = '$pointdepart',`epaisseur` = '$epaisseur',`pointarrive` = '$pointarrive', `poidsdeclare` = '$poidsdeclare'
                    , `poidspese` = '$poidspese', `etatbobine` = '$etatbobine', `nbbobine` = '$nbbobine' WHERE `idtransfertdetail` = ?;";
                    //$result = $db->query($sql); 
                    $sth = $db->prepare($sql);    
                    $sth->execute(array($id));
                // |--> Fin update transfert
                
                // Pour revenir à l'etat initial.
                    $sql1 = "UPDATE `transfertdetails` set `actifapprouvtransfert`=0 where idtransfertdetail=$_GET[idtransfertModifSimp]";
                    $db->query($sql1);
                // Pour revenir à l'etat initial.

                // |--> Pour le update des nombres de bobines dans matiere
                    $idPointdepart = $_GET['idPointdepart'];
                    $idPointarrive = $_GET['idPointarrive'];

                    //Rechercher le nombre de piéces sur le lieu de depart
                        $sqlEpaisseur = "SELECT * FROM `matiere` where `lieutransfert`='$pointdepart' and `epaisseur`='$epaisseur' and `nbbobineactuel` != 0 and `nbbobineactuel`>=$nbbobine LIMIT 1;";
                        // On prépare la requête
                        $queryEpaisseur = $db->prepare($sqlEpaisseur);

                        // On exécute
                        $queryEpaisseur->execute();

                        // On récupère le nombre d'articles
                        $resultEpaisseur = $queryEpaisseur->fetch();

                        if($resultEpaisseur){
                            $Iddepart = $resultEpaisseur['idmatiere'];
                        }
                    //Fin Rechercher le nombre de piéces 

                    //Rechercher le nombre de piéces sur le lieu d'arrive
                        $sqlEpaisseur = "SELECT * FROM `matiere` where `lieutransfert`='$pointarrive' and `poidsdeclare`='$poidsdeclare' and `epaisseur`='$epaisseur' LIMIT 1;";
                        // On prépare la requête
                        $queryEpaisseur = $db->prepare($sqlEpaisseur);

                        // On exécute
                        $queryEpaisseur->execute();

                        // On récupère le nombre d'articles
                        $resultMatiereArrive = $queryEpaisseur->fetch();
                    //Fin Rechercher le nombre de piéces d'arrive

                    if($resultEpaisseur){
                        // Enlever le nombre de bobine dans le lieu de depart
                            $req ="UPDATE matiere SET `nbbobineactuel` = `nbbobineactuel` - ? where `idmatiere`='$resultEpaisseur[idmatiere]';";
                            $reqtitre = $db->prepare($req);
                            $reqtitre->execute(array($nbbobine));
                        // Fin enlever le nombre de bobine dans le lieu de depart
                        if($resultMatiereArrive){
                            // ajouter le nombre de bobine dans le lieu de depart
                                $req ="UPDATE matiere SET `nbbobineactuel` = `nbbobineactuel` + ? where `idmatiere`='$resultMatiereArrive[idmatiere]';";
                                $reqtitre = $db->prepare($req);
                                $reqtitre->execute(array($nbbobine));
                            // Fin ajouter le nombre de bobine dans le lieu de depart
                        }else{
                            // Ajouter le nombre de bobine dans le lieu d'arrive
                                $insertUser=$db->prepare("INSERT INTO `matiere` (`idmatiere`, `epaisseur`, `poidsdeclare`, `poidspese`, `dateajout`,`nbbobine`,`lieutransfert`, `etatbobine`,`nbbobineactuel`) 
                                VALUES (NULL, ?, ?, ?, current_timestamp(), ?, ?, ?, ?);");
                                $insertUser->execute(array($epaisseur,$poidsdeclare, $poidspese,$nbbobine,$pointarrive, $etatbobine, $nbbobine));  
                            // Fin ajouter le nombre de bobine dans le lieu d'arrive
                        }
                    }else{
                        $ProblemeNbBobineDepart="erreurProblemeNbDepart";
                    }
                // |--> Fin pour le update des nombres de bobines dans matiere
                
                if($ProblemeNbBobineDepart != "erreurProblemeNbDepart" && $error != "erreurEpaisseur"){
                    header("location: detailTransfert.php?idtransfert=$idTransfert");
                    exit;
                }
            }
        } 
    }
//Fin modif

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
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseReception"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa fa-book fa-fw"></i>
                    <span>Pont Bascule</span>
                </a>
                <div id="collapseReception" class="collapse show" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Stockage :</h6>
                        <a class="collapse-item" href="../../stockage/reception.php">Réception</a>
                        <a class="collapse-item" href="../receptionPlanifie.php">Réception planifiée</a>
                        <a class="collapse-item active" href="./transfert.php">Transfert</a>
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
                                    src="../../indexPage/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <?php if($_SESSION['niveau']=='admin'){ ?>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Changer paramétres
                                    </a>
                                <?php } ?>
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

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->     
                <div class="container-fluid">
                    <!-- Modale pour ajouter reception -->
                    <div class="mt-5" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" >
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myExtraLargeModalLabel">Modifier la reception</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="#" method="POST" enctype="multipart/form-data" class="">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-6 text-start">
                                                    <label class="form-label fw-bold" for="prenom" >Epaisseur</label>
                                                    <select class="form-control" name="epaisseur" placeholder="Taper l'épaisseur de la bobine" value="">
                                                        <option <?php if ( $row['epaisseur']=='3') {echo "selected='selected'";} ?> >3</option>
                                                        <option  <?php if ( $row['epaisseur']=='3.5') {echo "selected='selected'";} ?> >3.5</option>
                                                        <option <?php if ( $row['epaisseur']=='4') {echo "selected='selected'";} ?> >4</option>
                                                        <option <?php if ( $row['epaisseur']=='4.5') {echo "selected='selected'";} ?> >4.5</option>
                                                        <option <?php if ( $row['epaisseur']=='5') {echo "selected='selected'";} ?> >5</option>
                                                        <option <?php if ( $row['epaisseur']=='5.5') {echo "selected='selected'";} ?> >5.5</option>
                                                        <option <?php if ( $row['epaisseur']=='6') {echo "selected='selected'";} ?> >6</option>
                                                        <option <?php if ( $row['epaisseur']=='6.5') {echo "selected='selected'";} ?> >6.5</option>
                                                        <option <?php if ( $row['epaisseur']=='7') {echo "selected='selected'";} ?> >7</option>
                                                        <option <?php if ( $row['epaisseur']=='7.5') {echo "selected='selected'";} ?> >7.5</option>
                                                        <option <?php if ( $row['epaisseur']=='8') {echo "selected='selected'";} ?> >8</option>
                                                        <option <?php if ( $row['epaisseur']=='8.5') {echo "selected='selected'";} ?> >8.5</option>
                                                        <option <?php if ( $row['epaisseur']=='9') {echo "selected='selected'";} ?> >9</option>
                                                        <option <?php if ( $row['epaisseur']=='9.5') {echo "selected='selected'";} ?> >9.5</option>
                                                        <option <?php if ( $row['epaisseur']=='10') {echo "selected='selected'";} ?> >10</option>
                                                        <option <?php if ( $row['epaisseur']=='10.5') {echo "selected='selected'";} ?> >10.5</option>
                                                        <option <?php if ( $row['epaisseur']=='11') {echo "selected='selected'";} ?> >11</option>
                                                        <option <?php if ( $row['epaisseur']=='11.5') {echo "selected='selected'";} ?> >11.5</option>
                                                        <option <?php if ( $row['epaisseur']=='12') {echo "selected='selected'";} ?> >12</option>
                                                        <option <?php if ( $row['epaisseur']=='12.5') {echo "selected='selected'";} ?> >12.5</option>
                                                        <option <?php if ( $row['epaisseur']=='13') {echo "selected='selected'";} ?> >13</option>
                                                        <option <?php if ( $row['epaisseur']=='13.5') {echo "selected='selected'";} ?> >13.5</option>
                                                        <option <?php if ( $row['epaisseur']=='14') {echo "selected='selected'";} ?> >14</option>
                                                        <option <?php if ( $row['epaisseur']=='14.5') {echo "selected='selected'";} ?> >14.5</option>
                                                        <option <?php if ( $row['epaisseur']=='15') {echo "selected='selected'";} ?> >15</option>
                                                        <option <?php if ( $row['epaisseur']=='15.5') {echo "selected='selected'";} ?> >15.5</option>
                                                        <option <?php if ( $row['epaisseur']=='16') {echo "selected='selected'";} ?> >16</option>
                                                        <option <?php if ( $row['epaisseur']=='16.5') {echo "selected='selected'";} ?>>16.5</option>
                                                        <option <?php if ( $row['epaisseur']=='17') {echo "selected='selected'";} ?> >17</option>
                                                    </select> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-6 text-start">
                                                    <label class="form-label fw-bold" for="nom">Nombre de bobine</label>
                                                    <input class="form-control" id="validationDefault01" type="number" name="nbbobine" value="<?php echo $row['nbbobine'];?>" placeholder="Taper le nombre de bobine" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-6 mt-3 text-start">
                                                    <label class="form-label fw-bold" for="nom">Point de départ</label>
                                                    <select class="form-control" name="pointdepart" value="<?php echo $row['pointdepart'];?>">
                                                        <option <?php if ( $row['pointdepart']=='Metal1') {echo "selected='selected'";} ?> >Metal1</option>
                                                        <option <?php if ( $row['pointdepart']=='Niambour') {echo "selected='selected'";} ?> >Niambour</option>
                                                        <option <?php if ( $row['pointdepart']=='Metal Mbao') {echo "selected='selected'";} ?> >Metal Mbao</option>
                                                        <option <?php  if ( $row['pointdepart']=='Tréfilage') {echo "selected='selected'";} ?> >Tréfilage</option>
                                                        <option <?php  if ( $row['pointdepart']=='Cranteuse') {echo "selected='selected'";} ?> >Cranteuse</option>
                                                    </select>                                                  
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-6 mt-3 text-start">
                                                    <label class="form-label fw-bold" for="nom">Point d'arrivée</label>
                                                    <select class="form-control" name="pointarrive" value="<?php echo $row['pointarrive'];?>">
                                                        <option <?php if ( $row['pointarrive']=='Metal1') {echo "selected='selected'";} ?> >Metal1</option>
                                                        <option <?php if ( $row['pointarrive']=='Niambour') {echo "selected='selected'";} ?> >Niambour</option>
                                                        <option <?php if ( $row['pointarrive']=='Metal Mbao') {echo "selected='selected'";} ?> >Metal Mbao</option>
                                                        <option <?php  if ( $row['pointarrive']=='Tréfilage') {echo "selected='selected'";} ?> >Tréfilage</option>
                                                        <option <?php  if ( $row['pointarrive']=='Cranteuse') {echo "selected='selected'";} ?> >Cranteuse</option>
                                                    </select>                                                  
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="mb-6 text-start">
                                                    <label class="form-label fw-bold" for="prenom" >Poids déclare</label>
                                                    <input class="form-control designa" type="number" value="<?php echo $row['poidsdeclare'];?>" name="poidsdeclare" id="validationDefault02"  placeholder="Taper le poids déclaré" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="mb-6 mt-3 text-start">
                                                    <label class="form-label fw-bold" for="nom">Poids pesé</label>
                                                    <input class="form-control" type="number" name="poidspese" value="<?php echo $row['poidspese'];?>" placeholder="Taper le poids pesé">
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="mb-6 mt-3 text-start">
                                                    <label class="form-label fw-bold" for="nom">Etat bobine</label>
                                                    <select class="form-control" name="etatbobine" value="">
                                                        <option <?php if ( $row['etatbobine']=='Normale') {echo "selected='selected'";} ?> >Normale</option>
                                                        <option <?php if ( $row['etatbobine']=='Disloquée') {echo "selected='selected'";} ?> >Disloquée</option>
                                                        <option <?php if ( $row['etatbobine']=='Autres') {echo "selected='selected'";} ?> >Autres</option>
                                                    </select>                                                    
                                                </div>
                                            </div>
                                            <div id="erreurEpaisseur"></div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12 text-end">
                                                <div class="col-md-8 align-items-center col-md-12 text-end">
                                                    <?php if($error == "erreurEpaisseur"){ ?> 
                                                        <script>    
                                                            Swal.fire({
                                                                    text: 'Veiller revoir votre stockage (nombre de bobine, epaisseur ou les lieus de transfert) svp!',
                                                                    icon: 'error',
                                                                    timer: 5000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                        </script> 
                                                    <?php } ?>
                                                    <?php if($ProblemeNbBobineDepart == "erreurProblemeNbDepart"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Veiller revoir votre stockage (nombre de bobine, epaisseur ou les lieus de transfert) svp!',
                                                                    icon: 'error',
                                                                    timer: 5000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                    <?php } ?>

                                                    <div class="d-flex gap-2 pt-4">                           
                                                        <a class="btn btn-danger  w-lg bouton mr-3" href="detailTransfert.php?idtransfert=<?= $_GET['idtransfert'] ?>">Annuler</a>
                                                        <input class="btn btn-success  w-lg bouton mr-3" name="modifierTransfert" type="submit" value="Modifier">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>  
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white" style="position: absolute; width: 100%; bottom: 0;">
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

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