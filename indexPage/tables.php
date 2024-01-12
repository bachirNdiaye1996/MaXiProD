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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


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
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
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
            <li class="nav-item">
                <a class="nav-link" href="tables.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Production clou</span></a>
            </li>


            <div class="sidebar-heading">
                Section CLOU
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider">

            
            <!-- Nav Item - Tables -->
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
                                    src="img/undraw_profile.svg">
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

                    <!-- Page Heading -->
                    <img src="../image/clou/clou.jpg" class="img-fluid" alt="" style="border-radius: 50%; margin:20px; opacity: 0.7;" width="200">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Production de la section 1</h6>
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
                                    <a href="javascript:void(0);" class="creerDA btn btn-success  w-lg bouton"><i class="bx bx-plus me-1"></i>Créer une nouvelle DA</a>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready( function(){
                                        $('.creerDA').click(function(e) {
                                            //var idda = $(this).closest("tr").find(".idda").val();
                                            e.preventDefault();
                                            Swal.fire({
                                            title: 'En es-tu sure?',
                                            text: 'Voulez-vous vraiment créer une nouvelle DA ?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: "Créer nouvelle DA",
                                            }).then((result) => {
                                                if (result.isConfirmed) {                                                                                                                  
                                                    $.ajax({
                                                            type: "POST",
                                                            url: 'ajouterDA.php',
                                                            //data: str,
                                                            success: function( response ) {
                                                                Swal.fire({
                                                                    text: 'DA créée avec success!',
                                                                    icon: 'success',
                                                                    timer: 3000,
                                                                    showConfirmButton: false,
                                                                });
                                                                location.reload();
                                                            },
                                                            error: function( response ) {
                                                                $('#status').text('Impossible de supprimer la DA : '+ response.status + " " + response.statusText);
                                                                //console.log( response );
                                                            }						
                                                    });
                                                }
                                            });
                                        });
                                    });
                                </script>
                            <?php
                                //}
                            ?>

                        </div>
                    </div>
                </div>
            </div> 
        </div><!-- end accordion -->
        <!--End !-->
                            </div>
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>