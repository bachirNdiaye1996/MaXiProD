<?php   
    session_start(); 

    if(!$_SESSION){
        header("location: ../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";

    //** Debut select de la fiche
        $sql = "SELECT * FROM `cranteuseq1` where `actif`=1 ORDER BY `idcranteuseq1` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $Cranteuseq1 = $query->fetchAll();
    //** Fin select de la fiche

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

    <!-- Custom fonts for this template-->
    <link href="../../indexPage/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        
    <!-- Sweet Alert -->
    <link href="../../libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <script src="../../libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../libs/sweetalert2/jquery-1.12.4.js"></script>

    <!-- Custom styles for this template-->
    <link href="../../indexPage/css/sb-admin-2.min.css" rel="stylesheet">

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
            <?php include "./navGaucheCranteuse.php" ?>
        <!-- End  -->

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
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#InformationProfile" title="Voir votre profile" class="dropdown-item">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="./Utilisateur/ParametreUtilisateur.php?idUser=<?php echo $_SESSION['id']; ?>">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Changer paramétres
                                </a>
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
                            <img src="../../image/cranteuse.jpg" class="img-fluid" alt="" style="border-radius: 50%; margin:20px; opacity: 0.7;" width="200">
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <!-- Fade In Utility -->
                    <div class="col-lg-12">
                        <div class="card position-relative">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Listes des productions pour la section cranteuse (Quart 1) </h6>
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
                                                <th>Code production</th>   
                                                <th>Compte utilisateur</th>
                                                <th>Date de création</th>
                                                <th>Date enregistrée</th>   
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
                                                foreach($Cranteuseq1 as $cranteuseq1){
                                                    $i++;
                                                    //if($article['status'] == 'termine'){<p><a class="" href="#">Underline opacity 0</a></p>
                                            ?>
                                                <tr>
                                                    <td style="<?php if($cranteuseq1['actif'] == 1){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FFBD6E"; ?><?php }?>; text-align: center;" class="codeReception">
                                                        <a style="text-decoration: none; font-family: arial; font-size: 20px;" href="detailsCranteuseQ1.php?idcranteuseq1=<?= $cranteuseq1['idcranteuseq1'] ?>&quart=1" class="link-offset-2 link-underline"><?php echo "CRANQ1-".$cranteuseq1['idcranteuseq1'] ?></a>
                                                    </td>
                                                    <td style="<?php if($cranteuseq1['actif'] == 1){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FFBD6E"; ?><?php }?>;">
                                                        <?= $cranteuseq1['user'] ?>
                                                    </td>
                                                    <td style="<?php if($cranteuseq1['actif'] == 1){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FFBD6E"; ?><?php }?>;">
                                                        <?= $cranteuseq1['dateajout'] ?>
                                                    </td>
                                                    <td style="<?php if($cranteuseq1['actif'] == 1){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FFBD6E"; ?><?php }?>;">
                                                        <?= $cranteuseq1['dateCreation'] ?>
                                                    </td>
                                                    <td style="<?php if($cranteuseq1['actif'] == 1){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FFBD6E"; ?><?php }?>;">
                                                        <?= $cranteuseq1['heuredepartquart'] ?>
                                                    </td>
                                                    <td style="<?php if($cranteuseq1['actif'] == 1){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FFBD6E"; ?><?php }?>;">
                                                        <?= $cranteuseq1['heurefinquart'] ?>
                                                    </td>
                                                    <td style="<?php if($cranteuseq1['actif'] == 1){ echo "background-color:#CFFEDA"; ?> <?php }else{ echo "background-color:#FFBD6E"; ?><?php }?>;">
                                                        <?php if($cranteuseq1['accepteprodmodif'] == 0 && $_SESSION['niveau']==''){ ?>
                                                            <a href="javascript:void(0);" data-toggle="modal" data-target=".approuveReceptionRectifie<?= $i ?>" class="px-2" title="Demander l'autorisation de modifier ou suprimer cette exportation au prêt du DSI">
                                                            <i class="fas fa-file-signature"></i></a>
                                                        <?php }?>
                                                        <?php if($cranteuseq1['accepteprodmodif'] == 1 && $_SESSION['niveau']=='admin'){ ?>
                                                            <a href="javascript:void(0);" class="accepteExportationmod<?= $i ?> px-2" class="px-2" title="Permettre au responsable du pont bascule de modifier ou suprimer cette exportation">
                                                            <i class="fas fa-paper-plane"></i></a>
                                                        <?php }?>
                                                        <?php if(($cranteuseq1['accepteprodmodif'] == 0) && ($cranteuseq1['actifapprouvprod'] == 1) && $_SESSION['niveau']==''){ ?>
                                                            <a href="modifierExportation.php?idexportation=<?= $_GET['idexportation'] ?>" title="Modifier l'exportation"><i class="far fa-edit"></i></a>
                                                        <?php }?>
                                                        <?php if(($cranteuseq1['accepteprodmodif'] == 0) && ($cranteuseq1['actifapprouvprod'] == 1) && $_SESSION['niveau']==''){ ?>
                                                            <a href="javascript:void(0);" id="suprimerExportation<?= $i ?>" class=" px-2 text-danger" title="Suprimer l'exportation"><i class="fa fa-cut"></i></a>
                                                        <?php }?>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="fileModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="fileModalLabel">Description de la réception :</h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>  
                                                            <h6 class="form-label fw-bold" for="nom" style="margin-left:25px; margin-top:10px;">Commentaire :</h6>
                                                            <div class="modal-body border border-warning" style="margin:70px; border-radius: 15px 30px; margin-top:20px; background-color: #fef1df;">
                                                                <h4><?php echo $cranteuseq1['commentaire']; ?></h4>                                                                                                
                                                            </div>                                                                                             
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Pour le sweetAlert Suprimer transfert !-->
                                                <script>
                                                    console.log(<?= $i ?>);
                                                    $(document).ready( function(){
                                                        $('.suprimerReception<?= $i ?>').click(function(e) {
                                                            e.preventDefault();
                                                            Swal.fire({
                                                            title: 'En es-tu sure?',
                                                            text: 'Voulez-vous vraiment supprimer cette réception ?',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: "Supprimer la réception",
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {                                                                                                                  
                                                                    $.ajax({
                                                                            type: "POST",
                                                                            url: 'supressionReception.php?idsupreception=<?= $cranteuseq1['idreception'] ?>',
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

                                                <!-- Pour le sweetAlert autoriser Reception !-->
                                                <script>
                                                    console.log(<?= $i ?>);
                                                    $(document).ready( function(){
                                                        $('.autoriserReception<?= $i ?>').click(function(e) {
                                                            e.preventDefault();
                                                            Swal.fire({
                                                            title: 'En es-tu sure?',
                                                            text: 'Voulez-vous vraiment autoriser cette demande de rectification ?',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: "Autoriser la demande",
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {                                                                                                                  
                                                                    $.ajax({
                                                                            type: "POST",
                                                                            url: 'autoriserReception.php?idautoriserreception=<?= $cranteuseq1['idreception'] ?>',
                                                                            //data: str,
                                                                            success: function( response ) {
                                                                                Swal.fire({
                                                                                    text: 'Autorisation suprimée avec succes!',
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
                                                            confirmButtonText: "Approuver cette réception",
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {                                                                                                                  
                                                                    $.ajax({
                                                                            type: "POST",
                                                                            url: 'approuveReception.php?idappreception=<?= $cranteuseq1['idreception']?>',
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
                                                    //if($_SESSION['niveau']==''){
                                                ?>
                                                    <a href="javascript:void(0);" class="ajouterProduction btn btn-success w-lg bouton"><i class="fa fa-plus me-1"></i> Créer production</a>
                                                <?php
                                                    //} 
                                                ?>
                                                <a href="../indexPage/accueil.php" class="btn btn-danger w-lg bouton ml-3"><i class="fa fa-angle-double-left mr-2"></i>Retour</a>
                                            </div>
                                        </div>
                                        <!-- Pour le sweetAlert approuveTransfert !-->
                                        <script>
                                            nomcomplet = "<?= $_SESSION['nomcomplet'] ?>"
                                            //console.log("creerRecTran.php?creerReception=true&user="+nomcomplet)
                                            $(document).ready( function(){
                                                $('.ajouterProduction').click(function(e) {
                                                    e.preventDefault();
                                                    Swal.fire({
                                                    title: 'En es-tu sure?',
                                                    text: 'Voulez-vous vraiment créer une nouvelle production ?',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: "Créer une production",
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {                                                                                                                  
                                                            $.ajax({
                                                                    type: "POST",
                                                                    url: 'creerProctionCranteuse.php?creerProdCranteuseq1=true&user='+nomcomplet,
                                                                    //data: str,
                                                                    success: function( response ) {
                                                                        Swal.fire({
                                                                            text: 'Production créée avec succes!',
                                                                            icon: 'success',
                                                                            timer: 3000,
                                                                            showConfirmButton: false,
                                                                        });
                                                                        location.reload();
                                                                    },
                                                                    error: function( response ) {
                                                                        $('#status').text('Impossible de créer une production : '+ response.status + " " + response.statusText);
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
                                        //}
                                    ?>
                                </div>
                            </div>
                            <!-- Tableau d'en bas -->
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
    <script src="../../indexPage/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->

    <script src="../../indexPage/js/demo/diagrammes.js"></script>

</body>

</html>