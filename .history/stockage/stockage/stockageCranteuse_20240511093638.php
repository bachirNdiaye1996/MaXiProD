<?php   

session_start(); 

if(!$_SESSION){
    header("location: ../../404.php");
    return 0;
}

include "../../connexion/conexiondb.php";


//Variables

//** Nombre des bobines total
    $sql = "SELECT SUM(`3`) + SUM(`3.5`) + SUM(`4`) + SUM(`4.5`) + SUM(`5`) + SUM(`5.5`) + SUM(`6`) + SUM(`6.5`) + SUM(`7`) + SUM(`7.5`)
    + SUM(`8`) + SUM(`8.5`) + SUM(`9`) + SUM(`9.5`) + SUM(`10`) + SUM(`10.5`) + SUM(`11`) + SUM(`11.5`) + SUM(`12`) + SUM(`12.5`) + SUM(`13`) + SUM(`13.5`) + 
    SUM(`14`) + SUM(`14.5`) + SUM(`15`) + SUM(`15.5`) + SUM(`16`) + SUM(`16.5`) + SUM(`17`) AS nb_reception_total FROM `epaisseur` where `lieu`='Cranteuse';";
    // On prépare la requête
    $query = $db->prepare($sql);

    // On exécute
    $query->execute();

    // On récupère le nombre d'articles
    $result = $query->fetch();

    $nbReception = (int) $result['nb_reception_total'];
//** Fin nombre des bobines total

//** Debut select de stockage pour Metal1
$sqlepaisseur = "SELECT * FROM `matiere` where `nbbobineactuel`>0 and `lieutransfert`='Cranteuse'  ORDER BY `idmatiere` DESC;";

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
            
        <!-- Contient la nav bar gauche -->
            <?php include "./navGaucheStockage.php" ?>
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
                                <a class="dropdown-item" href="../../indexPage/Utilisateur/ParametreUtilisateur.php?idUser=<?php echo $_SESSION['id']; ?>">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Changer paramétres
                                </a>
                                <?php if($_SESSION['niveau']=='admin'){ ?>
                                    <a class="dropdown-item" href="../../indexPage/Utilisateur/utilisateur.php">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Gestion des utilisateurs
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
                <div class="row mt-5 ml-5">
                    <div class="col-lg-3 mt-3 mr-5">
                        <div class="">
                            <div class="list-group">
                                <a href="stockage.php" class="list-group-item list-group-item-action" aria-current="true">METAL 1</a>
                                <a href="stockageMetalMbao.php" class="list-group-item list-group-item-action">METAL MBAO</a>
                                <a href="stockageNiambour.php" class="list-group-item list-group-item-action">NIAMBOUR</a>
                                <a href="stockageCranteuse.php" class="list-group-item list-group-item-action active">MACHINE CRANTEUSE</a>
                                <a href="stockageTrefilage.php" class="list-group-item list-group-item-action">MACHINE TREFILAGE</a>
                            </div>
                                <!-- End of Sidebar -->
                            <!-- Page Heading -->
                            <!-- <div class="row">
                                <div class="col-xl-3 col-md-6 mb-1">
                                    <img src="../../image/stockage/ferabeton.jpg" class="img-fluid" alt="" style="border-radius: 50%; margin:20px; opacity: 0.7;" width="200">
                                </div>
                            </div> -->
                        </div> 
                    </div>

                    <!-- DataTales Example -->
                    <!-- Fade In Utility -->
                    <div class="col-lg-8 mt-3">
                        <div class="card position-relative">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Nombre de bobine stocké à la machine Cranteuse : <?php echo $nbReception; ?></h6>
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
                                                <th>Code stockage</th>                                                                                
                                                <th>Epaisseur</th>
                                                <th>Nombre bobine</th>
                                                <th>Poids déclaré</th>
                                                <th>Poids pesé</th>
                                                <th>Etat bobine</th>
                                                <th>Derniére modification</th>
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
                                                    <td style="background-color:#4e73df ; color:white;">
                                                        <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#Information<?php echo $i; ?>" title="Voir details du produit" class="link-offset-2 link-underline"><?php echo "REC00".$stock['idreception']."-BOB-0".$stock['idmatiere']; ?></a>
                                                        <!--<a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" title="Allez vers la reception planifiée correspondante" href="detailsReceptionPlanifie.php?idreception=<?= $stock['idreception'] ?>" class="link-offset-2 link-underline"><?php echo "REC-0".$stock['idreception']."-BOB-0".$stock['idmatiere'] ?></a>!-->
                                                    </td>
                                                    <td style="background-color:#4e73df ; color:white;"> <?= $stock['epaisseur'] ?> </td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['nbbobineactuel'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['poidsdeclare'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['poidspese'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['etatbobine'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['dateajout'] ?></td>
                                                </tr>
                                                
                                                <!-- Pour le status !--> 
                                                <div class="modal fade " id="Information<?php echo $i; ?>" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details du produit consommé correspondant :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            $IDM = $stock['idmatiere'];
                                                                            $IDR = $stock['idreception'];
                                                                            //** Debut select des receptions
                                                                                $sql = "SELECT * FROM `matiere` where `actif`=1 and `idmatiere`=$IDM;";
                                                                    
                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);
                                                                    
                                                                                // On exécute
                                                                                $query->execute();
                                                                    
                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $Matiere = $query->fetch();
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
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Code réception : </span><?php echo "REC00-".$Reception['idreception']; ?></h5></label>
                                                                            <div class="col-sm-4">
                                                                                <h5 style=""></h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Date réception : </span><?php echo $Reception['datereception']; ?></h5></label>
                                                                            <div class="col-sm-4">
                                                                                <h5></h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="staticEmail" class="col-sm-8 col-form-label"><h5 style="color: #199AF3">Commentaire associé : </h5></label><br>
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
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Matricule du camion :  </span><?php echo $Reception['matriculecamion']; ?></h5></label>
                                                                            <div class="col-sm-6">
                                                                                <h5></h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Numéro de BL : </span><?php echo $Reception['bl']; ?></h5></label>
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
                            </div>
                            <!-- Tableau d'en bas -->
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