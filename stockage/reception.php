<?php   

session_start(); 

if(!$_SESSION['niveau']){
    header('Location: 404.php');
}

$pages=3;

/////////////////////////////////////////

   /*// On definie le nombre de DA
   $sqlda = "SELECT COUNT(*) AS nb_articles FROM `da` where `actif`=1;";
   // On prépare la requête
   $queryda = $db->prepare($sqlda);

   // On exécute
   $queryda->execute();
   
   // On récupère le nombre d'articles
   $resultda = $queryda->fetch();
   
   $nbda = (int) $resultda['nb_articles'];
   

   // On détermine le nombre total d'articles

   // $sql = "SELECT COUNT(*) AS nb_articles FROM `articles` where `actif`= 1 and `actifmang`=1;";


   // // On prépare la requête
   // $query = $db->prepare($sql);

   // // On exécute
   // $query->execute();

   // // On récupère le nombre d'articles
   // $result = $query->fetch();

   // $nbArticles = (int) $result['nb_articles'];

   // On détermine le nombre d'articles par page

   // On definie le nombre de DA
   $sqlda = "SELECT COUNT(*) AS nb_articles FROM `da` where `actif`=1;";
   // On prépare la requête
   $queryda = $db->prepare($sqlda);

   // On exécute
   $queryda->execute();
   
   // On récupère le nombre d'articles
   $resultda = $queryda->fetch();
   
   $nbda = (int) $resultda['nb_articles'];


   $parPage = 15;

   // On calcule le nombre de pages total
   $pages = ceil($nbda / $parPage);

   // Calcul du 1er article de la page
   $premier = ($currentPage * $parPage) - $parPage;

   $sql = "SELECT * FROM `da` where `actif`=1 ORDER BY `id`  DESC LIMIT :premier, :parpage;";

   // On prépare la requête
   $query = $db->prepare($sql);

   $query->bindValue(':premier', $premier, PDO::PARAM_INT);
   $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);

   // On exécute
   $query->execute();

   // On récupère les valeurs dans un tableau associatif
   $articles = $query->fetchAll(PDO::FETCH_ASSOC);

   //------------DA a approvisionner
   $sql6 = "SELECT COUNT(*) AS nb_articles FROM `da` where `actif`= 1 and `actifmang`=1 and `actifkem`=0;";


   // On prépare la requête
   $query6 = $db->prepare($sql6);

   // On exécute
   $query6->execute();

   // On récupère le nombre d'articles
   $result6 = $query6->fetch();

   $nbArticles6 = (int) $result6['nb_articles'];

   $sql = "SELECT COUNT(*) AS nb_articles FROM `articles` where `actif`= 1 and `actifmang`=1;";


   // On prépare la requête
   $query = $db->prepare($sql);

   // On exécute
   $query->execute();

   // On récupère le nombre d'articles
   $result = $query->fetch();

   $nbArticles = (int) $result['nb_articles'];
   
   $sql5 = "SELECT * FROM `da` where `actif`=1 and `actifmang`=1  ORDER BY `id`  DESC LIMIT :premier, :parpage;";

   // On prépare la requête
   $query5 = $db->prepare($sql5);

   $query5->bindValue(':premier', $premier, PDO::PARAM_INT);
   $query5->bindValue(':parpage', $parPage, PDO::PARAM_INT);

   // On exécute
   $query5->execute();

   // On récupère les valeurs dans un tableau associatif
   $articles5 = $query5->fetchAll(PDO::FETCH_ASSOC);*/

/////////////////////////////////////////


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

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReception"
                    aria-expanded="true" aria-controls="collapseReception">
                    <span>Pont Bascule</span>
                </a>
                <div id="collapseReception" class="collapse" aria-labelledby="headingReception"
                    data-parent="#collapseReception">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Stockage :</h6>
                        <a class="collapse-item" href="../stockage/reception.php">Réception</a>
                        <a class="collapse-item" href="../stockage/livraison.php">Livraison</a>
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
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

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

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <img src="../image/stockage/ferabeton.jpg" class="img-fluid" alt="" style="border-radius: 50%; margin:20px; opacity: 0.7;" width="200">
                        </div>
                    </div>
                    <?php 
                        //if($_SESSION['niveau']=='kemc'){
                    ?>
                        <div class="d-flex justify-content-end mb-3">
                            <div class="d-flex gap-2 pt-4">
                            <a href="javascript:void(0);" class="creerDA btn btn-danger  w-lg bouton"><i class="bi bi-plus me-1"></i>Demande de rectification</a>
                            </div>
                        </div>
                    <?php
                        //}
                    ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Détails de toutes les réceptions</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>                                                                                       
                                            <th>Nom</th>
                                            <th>Créée Par</th>
                                            <th>Status</th>
                                            <th>Date creation</th>
                                            <th>Date livraison partielle</th>
                                            <th> Durée de la DA</th>
                                            <th>Option</th>
                                            <th>Nom</th>
                                            <th>Créée Par</th>
                                            <th>Status</th>
                                            <th>Date creation</th>
                                            <th>Date livraison partielle</th>
                                            <th> Durée de la DA</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Créée Par</th>
                                            <th>Status</th>
                                            <th>Date creation</th>
                                            <th>Date livraison partielle</th>
                                            <th> Durée de la DA</th>
                                            <th>Option</th>
                                            <th>Nom</th>
                                            <th>Créée Par</th>
                                            <th>Status</th>
                                            <th>Date creation</th>
                                            <th>Date livraison partielle</th>
                                            <th> Durée de la DA</th>
                                            <th>Option</th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <tr style="background-color:#DEFAFC ;">
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                            <td>$320,800</td>
                                            <td>
                                                <a href="#" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <a href="#" class="btn btn-success btn-circle btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr style="background-color:#DEFAFC ;">
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>$320,800</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                            <td>
                                                <a href="#" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <a href="#" class="btn btn-success btn-circle btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                            //foreach($articles as $article){
                                        ?>                                                                              
                                            <div class="modal fade add-new<?php echo $i; ?>" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myExtraLargeModalLabel">approbation de la DA n° 00<?php echo $article['id']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="#" method="POST" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="form-check visually-hidden">
                                                                        <input class="form-check-input" type="text" style="margin-left: 10px; margin-right: 50px;  width: 35px; height: 35px" name="id" value="<?= $article['id'] ?>" id="flexCheckDefault">
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" style="margin-left: 10px; margin-right: 50px;  width: 35px; height: 35px" name="email" value="y.souleiman@metalafrique.com" id="flexCheckDefault">
                                                                        <p class="form-check-label text-start" style="font-size: 25px;" for="flexCheckDefault">
                                                                            Youssef SOULEIMAN
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-md-12 text-end">
                                                                        <div class="col-md-8 align-items-center col-md-12 text-end">
                                                                            <div class="d-flex gap-2 pt-4">                           
                                                                                <a href="#"><input class="btn btn-danger  w-lg bouton" name="" type="submit" value="Annuler"></a>
                                                                                <input class="btn btn-success  w-lg bouton" name="valideDAEmail" type="submit" value="Valider">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>  
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        <?php
                                                //}
                                            //}
                                        ?>
                                    </tbody>
                                </table>
                                <!-- Bouton et pagnination--> 
                                <?php 
                                    //if($_SESSION['niveau']=='kemc'){
                                ?>
                                    <div class="col-md-8 align-items-center">
                                        <div class="d-flex gap-2 pt-4">
                                        <a href="javascript:void(0);" class="creerDA btn btn-success  w-lg bouton"><i class="bx bx-plus me-1"></i>Nouvelle reception</a>
                                        </div>
                                    </div>
                                <?php
                                    //}
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Tableau d'en bas -->
                    <div class="card shadow mb-4 col-lg-8">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">La réception</h6>
                        </div>
                        <div class="row m-2">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="" cellspacing="0">
                                    <thead>
                                        <tr>                                                                                       
                                            <th></th>
                                            <th>Créée Par</th>
                                            <th>Status</th>
                                            <th>Date creation</th>
                                            <th>Date livraison partielle</th>
                                            <th> Durée de la DA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Types</td>
                                            <td style="background-color:#CFFEDA ;">System Architect</td>
                                            <td style="background-color:#CFFEDA ;">Edinburgh</td>
                                            <td style="background-color:#CFFEDA ;">61</td>
                                            <td style="background-color:#CFFEDA ;">2011/04/25</td>
                                            <td style="background-color:#CFFEDA ;">$320,800</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td style="background-color:#CFFEDA ;">System Architect</td>
                                            <td style="background-color:#CFFEDA ;">Edinburgh</td>
                                            <td style="background-color:#CFFEDA ;">61</td>
                                            <td style="background-color:#CFFEDA ;">2011/04/25</td>
                                            <td style="background-color:#CFFEDA ;">$320,800</td>
                                        </tr>
                                        <?php
                                            //foreach($articles as $article){
                                        ?>                                                                              
                                            <div class="modal fade add-new<?php echo $i; ?>" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myExtraLargeModalLabel">approbation de la DA n° 00<?php echo $article['id']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="#" method="POST" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="form-check visually-hidden">
                                                                        <input class="form-check-input" type="text" style="margin-left: 10px; margin-right: 50px;  width: 35px; height: 35px" name="id" value="<?= $article['id'] ?>" id="flexCheckDefault">
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" style="margin-left: 10px; margin-right: 50px;  width: 35px; height: 35px" name="email" value="y.souleiman@metalafrique.com" id="flexCheckDefault">
                                                                        <p class="form-check-label text-start" style="font-size: 25px;" for="flexCheckDefault">
                                                                            Youssef SOULEIMAN
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-md-12 text-end">
                                                                        <div class="col-md-8 align-items-center col-md-12 text-end">
                                                                            <div class="d-flex gap-2 pt-4">                           
                                                                                <a href="#"><input class="btn btn-danger  w-lg bouton" name="" type="submit" value="Annuler"></a>
                                                                                <input class="btn btn-success  w-lg bouton" name="valideDAEmail" type="submit" value="Valider">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>  
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        <?php
                                                //}
                                            //}
                                        ?>
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