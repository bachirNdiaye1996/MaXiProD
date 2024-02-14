<?php

session_start(); 

if(!$_SESSION['niveau']){
    header('Location: 404.php');
}

include "../connexion/conexiondb.php";

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

    if($_SERVER["REQUEST_METHOD"]=='GET'){
        if(!isset($_GET['idtransfertModifSimp'])){
            header("location: transfert.php");
            exit;
        }
        $id = $_GET['idtransfertModifSimp'];
        $sql = "select * from transfert where idtransfert=$id";
        $result = $db->query($sql);
        $row = $result->fetch();
        while(!$row){
            header("location: transfert.php");
        exit;
        }
        $lieutransfert=$row['lieutransfert'];
        $epaisseur=$row['epaisseur'];
        $poidsroulaux=$row['poidsroulaux'];
        $idlot=$row['idlot'];
        $dateajout=$row['dateajout'];
        $idbobine=$row['idbobine'];
        $user=$row['user'];
        $nbbobine=$row['nbbobine'];
        //echo $EstDemande;
    }else{    
        if(isset($_POST['modifierTransfert'])){
            $id = $_GET['idtransfertModifSimp'];
            $lieutransfert=$_POST['lieutransfert'];
            $epaisseur=$_POST['epaisseur'];
            $poidsroulaux=$_POST['poidsroulaux'];
            $idlot=$_POST['idlot'];
            $idbobine=$_POST['idbobine'];
            $nbbobine=$_POST['nbbobine'];

            //** On vérifie si le nombre est exact
            $sqlEpaisseur = "SELECT `$epaisseur` AS epaisseurVerifier FROM `epaisseur`;";
            // On prépare la requête
            $queryEpaisseur = $db->prepare($sqlEpaisseur);

            // On exécute
            $queryEpaisseur->execute();

            // On récupère le nombre d'articles
            $resultEpaisseur = $queryEpaisseur->fetch();

            $nbEpaisseur = (int) $resultEpaisseur['epaisseurVerifier'];

            if($epaisseur == $_GET['epaisseur']){
                //** On vérifie si le nombre est exact
                    if($nbEpaisseur < $nbbobine){
                        header("location: transf.php?$nbEpaisseur");
                        exit;
                    }else{
                        //--> Pour changer transfert
                            $sql = "UPDATE `transfert` SET `lieutransfert` = '$lieutransfert',`epaisseur` = '$epaisseur',`poidsroulaux` = '$poidsroulaux', `idlot` = '$idlot'
                            , `idbobine` = '$idbobine', `nbbobine` = '$nbbobine' WHERE `idtransfert` = ?;";
                            //$result = $db->query($sql); 
                            $sth = $db->prepare($sql);    
                            $sth->execute(array($id));
                        //--> Fin changer transfert

                        //Debut inserer le nombre de bobine par epaisseur
                            $oldnombrebobine = $_GET['nombrebobine'];
                            $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + $oldnombrebobine - ?;";
                            $reqtitre = $db->prepare($req);
                            $reqtitre->execute(array($nbbobine));
                        //Fin inserer le nombre de bobine par epaisseur
                    }
                //** Fin verification
            }else{
                //** On vérifie si le nombre est exact
                    if($nbEpaisseur < $nbbobine){
                        header("location: transf.php?$nbEpaisseur");
                        exit;
                    }else{
                        //--> Pour changer transfert
                            $sql = "UPDATE `transfert` SET `lieutransfert` = '$lieutransfert',`epaisseur` = '$epaisseur',`poidsroulaux` = '$poidsroulaux', `idlot` = '$idlot'
                            , `idbobine` = '$idbobine', `nbbobine` = '$nbbobine' WHERE `idtransfert` = ?;";
                            //$result = $db->query($sql); 
                            $sth = $db->prepare($sql);    
                            $sth->execute(array($id));
                        //--> Fin changer transfert

                        //Debut inserer le nombre de bobine par epaisseur
                            $oldepaisseur = $_GET['epaisseur'];
                            $oldnombrebobine = $_GET['nombrebobine'];
                            $req ="UPDATE epaisseur SET `$oldepaisseur` = `$oldepaisseur` + ?;";
                            $reqtitre = $db->prepare($req);
                            $reqtitre->execute(array($oldnombrebobine));
                        //Fin inserer le nombre de bobine par epaisseur
        
                        //Debut inserer le nombre de bobine par epaisseur
                            $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` - ?;";
                            $reqtitre = $db->prepare($req);
                            $reqtitre->execute(array($nbbobine));
                        //Fin inserer le nombre de bobine par epaisseur
                    }
                //** Fin verification
            }
            header("location: transfert.php");
            exit;
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

    <link rel="shortcut icon" href="../image/iconOnglet.png" />
    <title>METAL AFRIQUE</title>

    <!-- Custom fonts for this template -->
    <link href="../indexPage/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../indexPage/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../indexPage/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

             <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../indexPage/accueil.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../indexPage/accueil.php">
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
                        <a class="collapse-item" href="../stockage/reception.php">Réception</a>
                        <a class="collapse-item active" href="../stockage/transfert.php">Transfert</a>
                        <a class="collapse-item" href="../stockage/stockage.php">Stockage</a>
                        <a class="collapse-item" href="../stockage/graphe.php">Graphique</a>
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
                                    src="../indexPage/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Changer paramétres
                                </a>
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
                                    <form action="#" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-6 text-start">
                                                    <label class="form-label fw-bold" for="nom">Lieu de transfert</label>
                                                    <select class="form-control" name="lieutransfert" value="<?php echo $row['lieutransfert'];?>">
                                                        <option>Metal1 Cranteuses</option>
                                                        <option>Metal1 Tréfilage</option>
                                                        <option>Metal3</option>
                                                        <option>Metal4 (ancien Metalco)</option>
                                                    </select>                                                  
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-6 text-start">
                                                    <label class="form-label fw-bold" for="prenom" >Epaisseur</label>
                                                    <input class="form-control designa" type="number" value="<?php echo $row['epaisseur'];?>" step="0.01" name="epaisseur" id="example"  placeholder="Taper l'épaisseur de la bobine">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-6 text-start">
                                                    <label class="form-label fw-bold" for="nom">Nombre de bobine</label>
                                                    <input class="form-control" type="number" name="nbbobine" value="<?php echo $row['nbbobine'];?>" id="example-date-input4" placeholder="Taper le nombre de bobine">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-6 text-start">
                                                    <label class="form-label fw-bold" for="nom">Poids roulaux</label>
                                                    <input class="form-control" type="number" name="poidsroulaux" value="<?php echo $row['poidsroulaux'];?>" id="example-date-input4" placeholder="Taper le poids pesé">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-6 text-start">
                                                    <label class="form-label fw-bold" for="priorites" >Lot</label>
                                                    <select class="form-control" name="idlot" value="<?php echo $row['idlot'];?>">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-6 text-start">
                                                    <label class="form-label fw-bold" for="priorites">Bobine</label>
                                                    <select class="form-control" name="idbobine" value="<?php echo $row['idbobine'];?>">
                                                        <option>B0015</option>
                                                        <option>B0014</option>
                                                        <option>B006</option>
                                                        <option>B00945</option>
                                                    </select>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12 text-end">
                                                <div class="col-md-8 align-items-center col-md-12 text-end">
                                                    <?php //if($mess == "error"){ ?> <script>    Swal.fire({
                                                        text: 'Veiller remplir tous les champs svp!',
                                                        icon: 'error',
                                                        timer: 2000,
                                                        showConfirmButton: false,
                                                        });</script> <?php //} ?>
                                                    <?php //if(){?> <script>    Swal.fire({
                                                        text: 'Commande enregistrée avec succès merci!',
                                                        icon: 'success',
                                                        timer: 2000,
                                                        showConfirmButton: false,
                                                        });</script> <?php //} ?>
                                                    <div class="d-flex gap-2 pt-4">                           
                                                        <a class="btn btn-danger  w-lg bouton mr-3" href="transfert.php">Annuler</a>
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
    <script src="../indexPage/vendor/jquery/jquery.min.js"></script>
    <script src="../indexPage/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../indexPage/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../indexPage/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../indexPage/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../indexPage/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../indexPage/js/demo/datatables-demo.js"></script>

</body>

</html>