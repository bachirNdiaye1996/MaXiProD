<?php   

session_start(); 

if(!$_SESSION){
    header("location: ../../404.php");
    return 0;
}

include "../../connexion/conexiondb.php";
include "./mailProductionTrefilage.php";
include "../../variables.php";


//Variables
// Il faut savoir que metal3 est remplacer par niambour
$valideTransfert="";
$idmatierearrive="";
$ValideFiche = "";

$idficheparquarttrefilage = $_GET['idficheparquarttrefilage'];  // 



//echo phpversion();


//Pour send mail approuveProdRectifie
    if(isset($_POST['approuveProdRectifie'])){
        if(!empty($_POST['motifRectifier'])){
            $idfichetrefilage=htmlspecialchars($_POST['idfichetrefilage']);
            $quart=htmlspecialchars($_POST['quart']);
            $motifRectifier=htmlspecialchars($_POST['motifRectifier']); 
            $dateCreation=htmlspecialchars($_POST['dateCreation']);
            $machine=htmlspecialchars($_POST['machine']);
            $idficheparquarttrefilage=htmlspecialchars($_POST['idficheparquarttrefilage']);

            //Mettre de la couleur aux fiche et fiche par quart :
            $sql1 = "UPDATE `fichetrefilage` set `actifapprouvprod`=1 where idfichetrefilage=$idfichetrefilage";
            $db->query($sql1);

            /*$sql1 = "UPDATE `ficheparquarttrefilage` set `actifapprouvprod`=1 where idficheparquarttrefilage=$idficheparquarttrefilage";
            $db->query($sql1);*/
 
            $messageD = "
            <html>
            <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                <title></title>
            </head>
            <body> 
                <div id='email-wrap' style='background: #3F5EFB; border-radius: 10px;'><br><br>
                    <p align='center' style='margin-top:20px;'>
                        <h2 align='center' style='color:white'>METAL * * * AFRIQUE</h2>
                        <p align='center' style='color:white'>$_SESSION[nomcomplet] vous demande l'autorisation de modifier ou de supprimer une fiche de production de la machine $machine (quart $quart) du $dateCreation de code de production : <strong>TREF-$idficheparquarttrefilage</strong></p>
                        <p align='center' style='color:white'>Avec comme motif : <strong>$motifRectifier</strong></p>
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
                envoie_mail("Gestion de production réctification",$item['email'],"Demande de réctification de la fiche de code TREF-$idficheparquarttrefilage",$messageD);
            }

            $ValideFiche="reussi"; 
                
            header("location: ficheTrefilage.php?idficheparquarttrefilage=$idficheparquarttrefilage&quart=$quart&dateCreation=$dateCreation");
            exit;
        }else{
        }
    }
//Fin send mail approuveProdRectifie 
 

//** Debut select de la production
    $sql = "SELECT * FROM `fichetrefilage` where `actif`=1 and `idficheparquarttrefilage`=$idficheparquarttrefilage ORDER BY `idfichetrefilage` DESC";

    // On prépare la requête
    $query = $db->prepare($sql);

    // On exécute
    $query->execute();

    // On récupère les valeurs dans un tableau associatif
    $Trefilages = $query->fetchAll();
//** Fin select de la production


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
            document.addEventListener('DOMContentLoaded', () => {
                //console.log(loader);
                document.getElementById("loader").remove();
            })
        //Pour le loading
    </script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php $activeD = "active"; ?>

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
                            <img src="../../image/trefilet.jpg" class="img-fluid" alt="" style="border-radius: 50%; margin:20px; opacity: 0.9;" width="200">
                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <!-- Fade In Utility -->
                    <div class="mt-5 mb-3 col-lg-12">
                        <div class="card position-relative">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Liste des fiches de production de la section tréfilage</h6>
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
                                                <th>code de production</th>    
                                                <th>Machine</th>   
                                                <th>Date production</th>   
                                                <th>Compte utilisateur</th>
                                                <th>Quart</th>
                                                <th>Date de création</th>
                                                <th>Début quart</th>
                                                <th>Fin quart</th>
                                                <?php //if($_SESSION['niveau'] == ''){ ?>
                                                    <th>Option</th>
                                                <?php //}?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i=0;
                                                foreach($Trefilages as $trefilage){
                                                    $i++;
                                                    //if($article['status'] == 'termine'){<p><a class="" href="#">Underline opacity 0</a></p>
                                            ?>
                                                <tr>
                                                    <td style="<?php if($trefilage['actifapprouvprod'] == 0){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FF5335"; ?><?php }?>; text-align: center;" class="">
                                                        <a style="text-decoration: none; font-family: arial; font-size: 20px;" href="detailsFicheTrefilage.php?idfichetrefilage=<?= $trefilage['idfichetrefilage'] ?>&quart=<?= $trefilage['quart'] ?>&idficheparquarttrefilage=<?= $trefilage['idficheparquarttrefilage'] ?>&dateCreation=<?= $trefilage['dateCreation'] ?>" class="link-offset-2 link-underline"><?php echo "FICHE-".$trefilage['idfichetrefilage']; ?></a>
                                                    </td>
                                                    <td style="<?php if($trefilage['actifapprouvprod'] == 0){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FF5335"; ?><?php }?>;">
                                                        <?= $trefilage['machine'] ?>
                                                    </td>
                                                    <td style="<?php if($trefilage['actifapprouvprod'] == 0){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FF5335"; ?><?php }?>;">
                                                        <?= $trefilage['user'] ?>
                                                    </td>
                                                    <td style="<?php if($trefilage['actifapprouvprod'] == 0){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FF5335"; ?><?php }?>;">
                                                        <?= $trefilage['quart'] ?>
                                                    </td>
                                                    <td style="<?php if($trefilage['actifapprouvprod'] == 0){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FF5335"; ?><?php }?>;">
                                                        <?= $trefilage['dateajout'] ?>
                                                    </td>
                                                    <td style="<?php if($trefilage['actifapprouvprod'] == 0){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FF5335"; ?><?php }?>;">
                                                        <?= $trefilage['dateCreation'] ?>
                                                    </td>
                                                    <td style="<?php if($trefilage['actifapprouvprod'] == 0){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FF5335"; ?><?php }?>;">
                                                        <?= $trefilage['heuredepartquart'] ?>
                                                    </td>
                                                    <td style="<?php if($trefilage['actifapprouvprod'] == 0){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FF5335"; ?><?php }?>;">
                                                        <?= $trefilage['heurefinquart'] ?>
                                                    </td>
                                                    <td style="<?php if($trefilage['actifapprouvprod'] == 0){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#CFFEDA"; ?><?php }?>;">
                                                        <?php if($trefilage['actifapprouvprod'] == 0 && $_SESSION['niveau']=='chefquart'){ ?>
                                                            <a href="javascript:void(0);" data-toggle="modal" data-target=".approuveProdRectifie<?= $i ?>" class="px-2" title="Demander l'autorisation de modifier ou de suprimer cette fiche au prêt du DSI <?php echo ' --> TREF-'.$trefilage['idfichetrefilage']; ?>">
                                                            <i class="fas fa-file-signature"></i></a>
                                                        <?php }?>
                                                        <?php if(($trefilage['accepteprodmodif'] == 0) && ($trefilage['actifapprouvprod'] == 1) && $_SESSION['niveau']=='admin'){ ?>
                                                            <a href="javascript:void(0);" class="accepteProdmodifmod<?= $i ?> px-2" class="px-2" title="Permettre au chef de quart de modifier ou de suprimer cette fiche de production">
                                                            <i class="fas fa-paper-plane"></i></a>
                                                        <?php }?>
                                                        <?php if(($trefilage['accepteprodmodif'] == 1) && ($trefilage['actifapprouvprod'] == 1) && $_SESSION['niveau']=='chefquart'){ ?>
                                                            <a href="modifierFicheTrefilage.php?idsupfiche=<?= $trefilage['idfichetrefilage'] ?>&dateCreation=<?= $trefilage['dateCreation'] ?>&machine=<?= $trefilage['machine']; ?>&quart=<?= $trefilage['quart']; ?>&idficheparquarttrefilage=<?= $trefilage['idficheparquarttrefilage']; ?>" title="Modifier la fiche"><i class="far fa-edit"></i></a>
                                                        <?php }?>
                                                        <?php if(($trefilage['accepteprodmodif'] == 1) && ($trefilage['actifapprouvprod'] == 1) && $_SESSION['niveau']=='chefquart'){ ?>
                                                            <a href="javascript:void(0);" id="suprimerFiche<?= $i ?>" class=" px-2 text-danger" title="Suprimer cette fiche de production"><i class="fa fa-cut"></i></a>
                                                        <?php }?>
                                                    </td>
                                                </tr>
                                                <!-- Pour la rectification des receptions !-->
                                                <div class="modal fade approuveProdRectifie<?php echo $i; ?>" id="" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myExtraLargeModalLabel">Demander la rectification de cette fiche au prét de l'administrateur</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                                                                    <div class="row">
                                                                        <div class="invisible">
                                                                            <div class="">
                                                                                <input class="" type="text" value="<?= $trefilage['idfichetrefilage'] ?>" name="idfichetrefilage">
                                                                            </div>
                                                                        </div> 
                                                                        <div class="invisible">
                                                                            <div class="">
                                                                                <input class="" type="text" value="<?= $trefilage['quart'] ?>" name="quart">
                                                                            </div>
                                                                        </div> 
                                                                        <div class="invisible">
                                                                            <div class="">
                                                                                <input class="" type="text" value="<?= $trefilage['dateCreation'] ?>" name="dateCreation">
                                                                            </div>
                                                                        </div> 
                                                                        <div class="invisible">
                                                                            <div class="">
                                                                                <input class="" type="text" value="<?= $trefilage['idficheparquarttrefilage'] ?>" name="idficheparquarttrefilage">
                                                                            </div>
                                                                        </div> 
                                                                        <div class="invisible">
                                                                            <div class="">
                                                                                <input class="" type="text" value="<?= $trefilage['machine'] ?>" name="machine">
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-10 mb-5">
                                                                            <label class="form-label fw-bold" for="rectification"><h4>Motif de la rectification</h4></label>
                                                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="motifRectifier" placeholder="Mettez en quelques mots le motif de la rectification qui sera recu par le DSI par MAIL." required></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="">
                                                                        <div class="">
                                                                            <?php 
                                                                                if($ValideFiche == "reussi"){ 
                                                                            ?> 
                                                                                <script>    Swal.fire({
                                                                                    text: 'Veillez entrer le motif de la rectification svp!',
                                                                                    icon: 'success',
                                                                                    timer: 3500,
                                                                                    showConfirmButton: false,
                                                                                    });
                                                                                </script> 
                                                                            <?php
                                                                                } 
                                                                            ?>
                                                                            <div class="d-flex gap-2 pt-5">                           
                                                                                <a href="#"><input class="btn btn-danger  w-lg bouton" name="" type="submit" value="Annuler"></a>
                                                                                <input class="btn btn-success  w-lg bouton ml-4" name="approuveProdRectifie" type="submit" value="Enregistrer">
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
                                                    $(document).ready( function(){
                                                        $('#suprimerFiche<?= $i ?>').click(function(e) {
                                                            e.preventDefault();
                                                            Swal.fire({
                                                            title: 'En es-tu sure?',
                                                            text: 'Voulez-vous vraiment supprimer cette fiche de production?',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: "Supprimer la fiche",
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {                                                                                                                  
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: 'suppressionFiche.php?idsupficheTrefilage=<?= $trefilage['idfichetrefilage'] ?>&dateCreation=<?= $trefilage['dateCreation'] ?>&quart=<?= $trefilage['quart']; ?>&idficheparquarttrefilage=<?= $trefilage['idficheparquarttrefilage']?>',
                                                                        //data: str,
                                                                        success: function( response ) {
                                                                            Swal.fire({
                                                                                text: 'Fiche suprimée avec succes!',
                                                                                icon: 'success',
                                                                                timer: 3000,
                                                                                showConfirmButton: false,
                                                                            });
                                                                            location.reload();
                                                                        },
                                                                        error: function( response ) {
                                                                            $('#status').text('Impossible de supprimer cette fiche : '+ response.status + " " + response.statusText);
                                                                            //console.log( response );
                                                                        }						
                                                                    });
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                                <!-- Pour le sweetAlert Suprimer transfert !--> 

                                                <!-- Pour le sweetAlert autoriser Reception !-->
                                                <script>
                                                    //console.log(<?= $i ?>);
                                                    $(document).ready( function(){
                                                        $('.accepteProdmodifmod<?= $i ?>').click(function(e) {
                                                            e.preventDefault();
                                                            Swal.fire({
                                                            title: 'En es-tu sure?',
                                                            text: 'Voulez-vous vraiment autoriser cette demande de réctification ?',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: "Autoriser la demande",
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {                                                                                                                  
                                                                    $.ajax({
                                                                            type: "POST",
                                                                            url: 'autoriserProductionRectifie.php?idfichetrefilage=<?= $trefilage['idfichetrefilage'] ?>&machine=<?= $trefilage['machine'] ?>&dateCreation=<?= $trefilage['dateCreation'] ?>&quart=<?= $trefilage['quart']; ?>&idficheparquarttrefilage=<?= $trefilage['idficheparquarttrefilage'] ?>',
                                                                            //data: str,
                                                                            success: function( response ) {
                                                                                Swal.fire({
                                                                                    text: 'Autorisation envoyée avec succes!',
                                                                                    icon: 'success',
                                                                                    timer: 3000,
                                                                                    showConfirmButton: false,
                                                                                });
                                                                                location.reload();
                                                                            },
                                                                            error: function( response ) {
                                                                                $('#status').text('Impossible d autoriser cette fiche : '+ response.status + " " + response.statusText);
                                                                                //console.log( response );
                                                                            }						
                                                                    });
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                                <!-- Pour le sweetAlert Suprimer transfert !--> 
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <!-- Bouton et pagnination !--> 
                                                    
                                    <div class="col-md-8 align-items-center mt-5 mb-4">
                                        <div class="d-flex gap-2 pt-4">
                                            <a href="ficheParQuartTrefilage.php" class="btn btn-danger w-lg bouton ml-3 mr-4"><i class="fa fa-angle-double-left mr-2"></i>Retour</a>
                                            <?php
                                                if($_SESSION['niveau']=='chefquart'){
                                            ?>
                                                <a href="ajoutFormulaire.php?idficheparquarttrefilage=<?= $_GET['idficheparquarttrefilage'] ?>&quart=<?= $_GET['quart'] ?>&dateCreation=<?= $_GET['dateCreation'] ?>" class="btn btn-success w-lg bouton"><i class="fa fa-plus me-1"></i> Ajouter une fiche</a>
                                            <?php
                                                } 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
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