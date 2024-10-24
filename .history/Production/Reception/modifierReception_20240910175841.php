<?php

session_start(); 

if(!$_SESSION['niveau']){
    header('Location: ../../404.php');
}

include "../../connexion/conexiondb.php";

//La partie de recupe de l'id et script pour modifier
    $referenceusine="";
    $epaisseur="";
    $largeur="";
    $laminage="";
    $poidspese="";
    $produitfini="";
    $travaille="";
    $idlot="";
    $annee="";
    $numprod="";
    $dateajout="";
    $idbobine="";
    $user="";
    $nbbobine="";


    $error="";
    $success="";


    if($_SERVER["REQUEST_METHOD"]=='GET'){
        if(!isset($_GET['idmatiereModifSimp'])){
            header("location: detailsReception.php?idreception=$_GET[idreception]");
            exit;
        }
        $id = $_GET['idmatiereModifSimp'];
        $sql = "select * from receptionmachinedetails where idreceptionmachinedetails=$id";
        $result = $db->query($sql);
        $row = $result->fetch();
        while(!$row){
            header("location: detailsReception.php?idreception=$_GET[idreception]");
        exit;
        }
        $epaisseur=$row['epaisseur'];
        $poidspese=$row['poidspese'];
        $dateajout=$row['dateajout'];
        $user=$row['user'];
        $df=$row['df'];
        //echo $EstDemande;
    }else{    
        if(isset($_POST['modifierReception'])){
            $id = $_GET['idmatiereModifSimp'];
            //$referenceusine=$_POST['referenceusine'];
            $epaisseur=$_POST['epaisseur'];
            $poidspese=$_POST['poidspese'];
            $etatbobine=$_POST['etatbobine'];
            $lieutransfert=$_POST['lieutransfert'];
            $poidsdeclare=$_POST['poidsdeclare'];
            //$produitfini=$_POST['produitfini'];
            //$idlot=$_POST['idlot'];
            //$annee=$_POST['annee'];trans
            //$numprod=$_POST['numprod'];
            //$idbobine=$_POST['idbobine'];
            //$user=$_POST['user'];
            $df=$_POST['df'];

            $sql = "UPDATE `receptionmachinedetails` SET `poidspese` = '$poidspese', `etatbobine` = '$etatbobine', `epaisseur` = '$epaisseur',`lieutransfert` = '$lieutransfert',`poidsdeclare` = '$poidsdeclare'
            , `df` = '$df', `couleurhistorique` = '2', `actifapprouvreception`=0 WHERE `idreceptionmachinedetails` = ?;";
            //$result = $db->query($sql); 
            $sth = $db->prepare($sql);    
            $sth->execute(array($id));

            header("location: detailsReception.php?idreception=$_GET[idreception]");
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

        <!-- Contient la nav bar gauche -->
            <?php include "./navGaucheReception.php" ?>
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
                                                    <input class="form-control" type="number" name="nbbobine" id="validationDefault01" value="<?php echo $row['nbbobine'];?>" id="example-date-input4" placeholder="Taper le nombre de bobine" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-6 mt-3 text-start">
                                                    <label class="form-label fw-bold" for="nom">Lieu de réception</label>
                                                    <select class="form-control" name="lieutransfert" value="<?php echo $row['lieutransfert'];?>">
                                                        <option <?php if ( $row['lieutransfert']=='Metal1') {echo "selected='selected'";} ?> >Metal1</option>
                                                        <option <?php if ( $row['lieutransfert']=='Niambour') {echo "selected='selected'";} ?> >Niambour</option>
                                                        <option <?php if ( $row['lieutransfert']=='Metal Mbao') {echo "selected='selected'";} ?> >Metal Mbao</option>
                                                    </select>                                                  
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="mb-6 text-start">
                                                    <label class="form-label fw-bold" for="prenom" >Poids déclare</label>
                                                    <input class="form-control designa" type="number" id="validationDefault02" value="<?php echo $row['poidsdeclare'];?>" name="poidsdeclare" id="example"  placeholder="Taper le poids déclaré" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="mb-6 mt-3 text-start">
                                                    <label class="form-label fw-bold" for="nom">Poids pesé</label>
                                                    <input class="form-control" type="number" name="poidspese" value="<?php echo $row['poidspese'];?>" id="example-date-input4" placeholder="Taper le poids pesé">
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
                                                        <a class="btn btn-danger  w-lg bouton mr-3" href="detailsReception.php?idreception=<?= $_GET['idreception'] ?>">Annuler</a>
                                                        <input class="btn btn-success  w-lg bouton mr-3" name="modifierReception" type="submit" value="Modifier">
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