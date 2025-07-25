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
        $sql = "SELECT SUM(`prodpoids`) as prodpoids, DAY(`dateCreation`) as jour FROM `cranteuseq1production` WHERE `actif`=1 AND MONTH(`dateCreation`)=$dtm 
        GROUP BY DAY(`dateCreation`);";          // On tire les fiches du mois courant
    
        // On prépare la requête
        $query = $db->prepare($sql);
    
        // On exécute
        $query->execute();
    
        // On récupère les valeurs dans un tableau associatif
        $FichesCranteuse = $query->fetchAll();
    //** Fin select des production cranteuse

    //** Debut select des dechet cranteuse
        $sql = "SELECT SUM(`dechet`) as dechet, DAY(`dateCreation`) as jour FROM `cranteuseq1consommation` WHERE `actif`=1 AND MONTH(`dateCreation`)=$dtm 
        GROUP BY DAY(`dateCreation`);";          // On tire les fiches du mois courant
    
        // On prépare la requête
        $query = $db->prepare($sql);
    
        // On exécute
        $query->execute();
    
        // On récupère les valeurs dans un tableau associatif
        $FichesCranteuseDechet = $query->fetchAll();
    //** Fin select des dechet cranteuse

    //** Debut select des productions et dechet section dresseuse
        $sql = "SELECT SUM(`prodpoids`) as prodpoids, SUM(`proddechet`) as dechet, DAY(`dateCreation`) as jour FROM `dresseuseproduction` WHERE `actif`=1 AND MONTH(`dateCreation`)=$dtm 
        GROUP BY DAY(`dateCreation`);";          // On tire les fiches du mois courant
    
        // On prépare la requête
        $query = $db->prepare($sql);
    
        // On exécute
        $query->execute();
    
        // On récupère les valeurs dans un tableau associatif
        $FichesDresseuse = $query->fetchAll();
    //** Fin select des productions et dechet section dresseuse
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
                
                <?php include "../../variables.php"; ?>

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
                                                    <h5>Temps d'arrets</h5>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Earnings (Annual)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            </div>
                        <?php 
                            }
                        ?>
                    </div>

                    <!-- Content Row -->
                    <div class="row mb-4 mt-5">
                        <!-- A mettre le body -->
                        <!-- Bar Chart -->
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Section CRANTEUSE</h6>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <canvas id="myChartCranteuse"></canvas>
                                    </div>
                                    <hr>
                                    Production <span id="ProductCrant" class="text-primary"></span>  et Dechet <span id="DechetCrant"></span>
                                    <code>de ce mois</code> à la section cranteuse.
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Section DRESSEUSE</h6>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <canvas id="myChartDresseuse"></canvas>
                                    </div>
                                    <hr>
                                    Production <span id="ProductDress" class="text-primary"></span>  et Dechet <span id="DechetDress"></span>
                                    <code>de ce mois</code> à la section dresseuse.
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script type="text/javascript">
                        var dechet = <?php echo json_encode($FichesCranteuseDechet); ?>;
                        var production = <?php echo json_encode($FichesCranteuse); ?>;
                        //console.log(test);

                        var Jours = [];
                        var Poids = [];
                        var Dechet = [];
                        Jours = ["0","1", "2", "3", "4", "5", "6","7", "8", "9", "10", "11", "12","13", "14", "15", "16", "17", "18","19", "20", "21", "22", "23", "24","25", "26", "27", "28", "29", "30","31"];
                        
                        for (let i = 0; i < 30; i++) {
                            // Pour la production
                            if(production[i] === undefined){
                            }else{
                                var j = production[i]['jour'];
                                Poids[j] = Number(production[i]['prodpoids']);
                            }

                            // Pour dechets
                            if(dechet[i] === undefined){
                            }else{
                                var t = dechet[i]['jour'];
                                Dechet[t] = Number(dechet[i]['dechet']);
                            }
                        }
                        // On cherche les sommes (dechet et production)
                        const TotalProduit = Poids.reduce(
                            (accumulator, currentValue) => accumulator + currentValue,
                        );
                        const ProductCrant = document.getElementById('ProductCrant');
                        let htmlPC = "<span class='text-primary'> Total = "+TotalProduit+" KG</span>";
                        ProductCrant.insertAdjacentHTML("afterend", htmlPC);

                        const TotalDechet = Dechet.reduce(
                            (accumulator, currentValue) => accumulator + currentValue,
                        );
                        const DechetCrant = document.getElementById('DechetCrant');
                        let htmlCD = "<span class='text-primary'> Total = "+TotalDechet+" KG</span>";
                        DechetCrant.insertAdjacentHTML("afterend", htmlCD);

                        const ctxDressProd = document.getElementById('myChartCranteuse');

                        new Chart(ctxDressProd, {
                        type: "bar",
                        data: {
                            labels: Jours,
                            datasets: [{
                            label: "Production",
                            data: Poids,
                            backgroundColor: "#4e73df",
                            hoverBackgroundColor: "#2e59d9",
                            borderColor: "#4e73df",
                            borderWidth: 1
                            },{
                            label: "Dechet",
                            data: Dechet,
                            backgroundColor: "#2cbd33ff",
                            hoverBackgroundColor: "#06d810ff",
                            borderColor: "#2cbd33ff",
                            borderWidth: 1
                            }]
                        },
                        options: {
                            legend: {display: false}
                        }
                        });
                    </script>

                    <script type="text/javascript">
                        var dechet = <?php echo json_encode($FichesDresseuse); ?>;
                        var production = <?php echo json_encode($FichesDresseuse); ?>;
                        //console.log(test);

                        var Jours = [];
                        var Poids = [];
                        var Dechet = [];
                        Jours = ["0","1", "2", "3", "4", "5", "6","7", "8", "9", "10", "11", "12","13", "14", "15", "16", "17", "18","19", "20", "21", "22", "23", "24","25", "26", "27", "28", "29", "30","31"];
                        
                        for (let i = 0; i < 30; i++) {
                            // Pour la production
                            if(production[i] === undefined){
                            }else{
                                var j = production[i]['jour'];
                                Poids[j] = Number(production[i]['prodpoids']);
                            }

                            // Pour dechets
                            if(dechet[i] === undefined){
                            }else{
                                var t = dechet[i]['jour'];
                                Dechet[t] = Number(dechet[i]['dechet']);
                            }
                        }
                        // On cherche les sommes (dechet et production)
                        const TotalProduitDress = Poids.reduce(
                            (accumulator, currentValue) => accumulator + currentValue,
                        );
                        const ProductDress = document.getElementById('ProductDress');
                        let htmlPD = "<span class='text-primary'> Total = "+TotalProduitDress+" KG</span>";
                        ProductDress.insertAdjacentHTML("afterend", htmlPD);

                        const TotalDechetDress = Dechet.reduce(
                            (accumulator, currentValue) => accumulator + currentValue,
                        );
                        const DechetDress = document.getElementById('DechetDress');
                        let htmlDD = "<span class='text-primary'> Total = "+TotalDechetDress+" KG</span>";
                        DechetDress.insertAdjacentHTML("afterend", htmlDD);


                        const ctxCranProd = document.getElementById('myChartDresseuse');

                        new Chart(ctxCranProd, {
                        type: "bar",
                        data: {
                            labels: Jours,
                            datasets: [{
                            label: "Production",
                            data: Poids,
                            backgroundColor: "#4e73df",
                            hoverBackgroundColor: "#2e59d9",
                            borderColor: "#4e73df",
                            borderWidth: 1
                            },{
                            label: "Dechet",
                            data: Dechet,
                            backgroundColor: "#2cbd33ff",
                            hoverBackgroundColor: "#06d810ff",
                            borderColor: "#2cbd33ff",
                            borderWidth: 1
                            }]
                        },
                        options: {
                            legend: {display: false}
                        }
                        });
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

    <script type="module" src="">
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        //console.log(<?php print_r($Utilisateurs); ?>);
        function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
        }

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["1", "2", "3", "4", "5", "6","7", "8", "9", "10", "11", "12","13", "14", "15", "16", "17", "18","19", "20", "21", "22", "23", "24","25", "26", "27", "28", "29", "30","31"],
            datasets: [{
            label: "Production",
            backgroundColor: "#4e73df",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data: [4215, 5312, 6251, 7841, 9821, 14984,4215, 5312, 6251, 7841, 9821, 14984,4215, 5312, 6251, 7841, 9821, 14984,4215, 5312, 6251, 7841, 9821, 14984,4215, 5312, 6251, 7841, 9821, 14984, 14984],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
            },
            scales: {
            xAxes: [{
                time: {
                unit: 'day'
                },
                gridLines: {
                display: false,
                drawBorder: false
                },
                ticks: {
                maxTicksLimit: 6
                },
                maxBarThickness: 25,
            }],
            yAxes: [{
                ticks: {
                min: 0,
                max: 15000,
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                    return number_format(value) + 'KG';
                }
                },
                gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
                }
            }],
            },
            legend: {
            display: false
            },
            tooltips: {
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ' : ' + number_format(tooltipItem.yLabel) +' Kg ';
                }
            }
            },
        }
        });
    </script>

</body>

</html>