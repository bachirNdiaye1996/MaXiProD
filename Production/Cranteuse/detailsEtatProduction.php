<?php   

session_start(); 

if(!$_SESSION){
    header("location: ../../404.php");
    return 0;
}

include "../../connexion/conexiondb.php";
//include "./mailTransfert.php";


//Variables
    $PoidsConsommeTotal = 0;
    $RebusTotal = 0;
    $PoidsProduitTotal = 0;
    $TempsArretTotal = 0;
    $TempsFonctionTotal = 0;

$idfichecranteuseq1 = $_GET['dateCreation'];  // On recupére l'ID de la réception par get

/** Quart 1 */
    /** Cranteuse1 Q1 */
        //** Debut select de la production (Pour cranteuse 1)
            $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 1' and `quart`='1';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productioncrantC1Q1 = $query->fetch();
        //** Fin select de la production 

        if ($productioncrantC1Q1) {

            $IdproductioncrantC1Q1 = $productioncrantC1Q1['idfichecranteuseq1'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT sum(poids) as piodstotal, diametre, numerofin, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q1 GROUP BY `diametre` ORDER BY `diametre` ASC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsC1Q1 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsC1Q1 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsC1Q1 as $arretC1Q1){
                    if(((strtotime($arretC1Q1['finarret']) - strtotime($arretC1Q1['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretC1Q1['finarret']) - strtotime($arretC1Q1['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretC1Q1['debutarret']) + strtotime($arretC1Q1['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelC1Q1 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q1 GROUP BY `proddiametre` ORDER BY `proddiametre` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsC1Q1 = $query->fetchAll();
            //** Fin select de la production 
        }
        
    /** Fin Cranteuse1 Q1 */

    /** Fin Cranteuse2 Q1 */
        //** Debut select de la production (Pour cranteuse 2)
            $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 2' and `quart`='1';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productioncrantC2Q1 = $query->fetch();
        //** Fin select de la production 

        if ($productioncrantC2Q1) {

            $IdproductioncrantC2Q1 = $productioncrantC2Q1['idfichecranteuseq1'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT sum(poids) as piodstotal, diametre, numerofin, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q1 GROUP BY `diametre` ORDER BY `diametre` ASC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsC2Q1 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsC2Q1 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsC2Q1 as $arretC2Q1){
                    if(((strtotime($arretC2Q1['finarret']) - strtotime($arretC2Q1['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretC2Q1['finarret']) - strtotime($arretC2Q1['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretC2Q1['debutarret']) + strtotime($arretC2Q1['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelC2Q1 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q1 GROUP BY `proddiametre` ORDER BY `proddiametre` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsC2Q1 = $query->fetchAll();
            //** Fin select de la production
        }
    /** Fin Cranteuse2 Q1 */
/** Fin Quart 1 */

/** Quart 2 */
    /** Cranteuse1 Q1 */
        //** Debut select de la production (Pour cranteuse 1)
        $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 1' and `quart`='2';";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $productioncrantC1Q2 = $query->fetch();
    //** Fin select de la production 

    if ($productioncrantC1Q2) {

        $IdproductioncrantC1Q2 = $productioncrantC1Q2['idfichecranteuseq1'];    // Id de productioncrantC1Q1

        //** Debut select de la production (consommation)
            $sql = "SELECT sum(poids) as piodstotal, diametre, numerofin, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q2 GROUP BY `diametre` ORDER BY `diametre` ASC;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $consommationsC1Q2 = $query->fetchAll();
        //** Fin select de la production 

        //** Debut select de la production (arret)
            $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q2;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $arretsC1Q2 = $query->fetchAll();
        //** Fin select de la production

        $TotalArretH = null;
        // Calcul du temps d'arret
            foreach($arretsC1Q2 as $arretC1Q2){
                if(((strtotime($arretC1Q2['finarret']) - strtotime($arretC1Q2['debutarret'])) > 0)){
                    $TotalArretH +=  (strtotime($arretC1Q2['finarret']) - strtotime($arretC1Q2['debutarret']));
                }else{
                    $TotalArretH +=  (-strtotime($arretC1Q2['debutarret']) + strtotime($arretC1Q2['finarret']));
                }
            }

            $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
            $TotalArretHReelC1Q2 = explode(":",date("H:i",$TotalArretH) );
        // Fin calcul du temps d'arret


        //** Debut select de la production (prod)
            $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q2 GROUP BY `proddiametre` ORDER BY `proddiametre` DESC;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionsC1Q2 = $query->fetchAll();
        //** Fin select de la production 
    }
        
    /** Fin Cranteuse1 Q2 */

    /** Debut Cranteuse2 Q2 */
        //** Debut select de la production (Pour cranteuse 2)
            $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 2' and `quart`='2';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productioncrantC2Q2 = $query->fetch();
        //** Fin select de la production 

        if ($productioncrantC2Q2) {

            $IdproductioncrantC2Q2 = $productioncrantC2Q2['idfichecranteuseq1'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT sum(poids) as piodstotal, diametre, numerofin, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q2 GROUP BY `diametre` ORDER BY `diametre` ASC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsC2Q2 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsC2Q2 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsC2Q2 as $arretC2Q2){
                    if(((strtotime($arretC2Q2['finarret']) - strtotime($arretC2Q2['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretC2Q2['finarret']) - strtotime($arretC2Q2['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretC2Q2['debutarret']) + strtotime($arretC2Q2['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelC2Q2 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q2 GROUP BY `proddiametre` ORDER BY `proddiametre` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsC2Q2 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Cranteuse2 Q1 */
/** Fin Quart 2 */


/** Quart 3 */
    /** Cranteuse1 Q3 */
        //** Debut select de la production (Pour cranteuse 1)
        $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 1' and `quart`='3';";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $productioncrantC1Q3 = $query->fetch();
    //** Fin select de la production 

    if ($productioncrantC1Q3) {

        $IdproductioncrantC1Q3 = $productioncrantC1Q3['idfichecranteuseq1'];    // Id de productioncrantC1Q1

        //** Debut select de la production (consommation)
            $sql = "SELECT sum(poids) as piodstotal, diametre, numerofin, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q3 GROUP BY `diametre` ORDER BY `diametre` ASC;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $consommationsC1Q3 = $query->fetchAll();
        //** Fin select de la production 

        //** Debut select de la production (arret)
            $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $arretsC1Q3 = $query->fetchAll();
        //** Fin select de la production

        $TotalArretH = null;
        // Calcul du temps d'arret
            foreach($arretsC1Q3 as $arretC1Q3){
                if(((strtotime($arretC1Q3['finarret']) - strtotime($arretC1Q3['debutarret'])) > 0)){
                    $TotalArretH +=  (strtotime($arretC1Q3['finarret']) - strtotime($arretC1Q3['debutarret']));
                }else{
                    $TotalArretH +=  (-strtotime($arretC1Q3['debutarret']) + strtotime($arretC1Q3['finarret']));
                }
            }

            $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
            $TotalArretHReelC1Q3 = explode(":",date("H:i",$TotalArretH) );
        // Fin calcul du temps d'arret


        //** Debut select de la production (prod)
            $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q3 GROUP BY `proddiametre` ORDER BY `proddiametre` DESC;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionsC1Q3 = $query->fetchAll();
        //** Fin select de la production 
    }
        
    /** Fin Cranteuse1 Q1 */

    /** Fin Cranteuse2 Q1 */
        //** Debut select de la production (Pour cranteuse 2)
            $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 2' and `quart`='3';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productioncrantC2Q3 = $query->fetch();
        //** Fin select de la production 

        if ($productioncrantC2Q3) {

            $IdproductioncrantC2Q3 = $productioncrantC2Q3['idfichecranteuseq1'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT sum(poids) as piodstotal, diametre, numerofin, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q3 GROUP BY `diametre` ORDER BY `diametre` ASC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsC2Q3 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q3;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsC2Q3 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsC2Q3 as $arretC2Q3){
                    if(((strtotime($arretC2Q3['finarret']) - strtotime($arretC2Q3['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretC2Q3['finarret']) - strtotime($arretC2Q3['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretC2Q3['debutarret']) + strtotime($arretC2Q3['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelC2Q3 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q3 GROUP BY `proddiametre` ORDER BY `proddiametre` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsC2Q3 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Cranteuse2 Q1 */
/** Fin Quart 3 */



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

        <?php $activeEtatProduction = "active"; ?>

        <!-- Contient la nav bar gauche -->
            <?php include "./navGaucheCranteuse.php" ?>
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
                            <img src="../../image/cranteuse.jpg" class="img-fluid" alt="" style="border-radius: 50%; margin:20px; opacity: 0.7;" width="200">
                        </div>
                    </div>

                    <div class="d-sm-flex align-items-end justify-content-end mb-4 mr-3">
                        <a href="pdfEtatCranteuse.php?dateCreation=<?php echo $_GET['dateCreation'];?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Génerer en PDF</a>
                    </div>
                    <!-- DataTales Example -->
                    <!-- Fade In Utility -->
                    <div class="col-lg-12">
                        <div class="card position-relative">
                            <div class="card-header py-3 bg-primary">
                                <p class="m-0 font-weight-bold text-center h2 text-uppercase mt-2 mb-3" style="color: white;">Etat DE PRODUCTION journalier - section cranteuse </p>
                                <p class="m-0 font-weight-bold text-center h2 text-uppercase mt-2 mb-5" style="color: white;"><span class="mr-4">journee du : </span> <?php echo date("l j F Y", strtotime($_GET['dateCreation'])); ?></p>
                                <div class="">                                </div>
                                    <!--<p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 10%;"><span class="mr-4">Début quart : </span> <?php echo $Cranteuseq1['heuredepartquart']; ?></p>
                                    <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 10%;"><span class="mr-4">Fin quart : </span> <?php echo $Cranteuseq1['heurefinquart']; ?></p>
                                    <p class="m-0 mb-3 h5 d-inline" style="color: white;"><span class="mr-4">Contrôleurs : </span> <?php echo $Cranteuseq1['controleur1']." / ".$Cranteuseq1['controleur2']." / ".$Cranteuseq1['controleur3']; ?></p>
                                </div>
                                <p class="m-0 mb-3 h5 mt-3 ml-3 d-inline" style="color: white; padding-right: 30%;"><span class="mr-4">Compteur Horaire Début : </span> <?php echo $Cranteuseq1['compteurdebut']; ; ?></p>
                                <p class="m-0 mb-3 h5 d-inline" style="color: white;"><span class="mr-4">Observations (Début) : </span> <?php echo $Cranteuseq1['observationdebut']; ; ?></p>
                                <p class="m-0 mt-3  h5 ml-3" style="color: white;"><span class="mr-5">Compteur Horaire Fin : </span> <?php echo $Cranteuseq1['compteurfin']; ; ?></p>-->
                            </div>

                            <!-- Debut quart1 -->
                            <?php
                                if($productioncrantC1Q1 || $productioncrantC2Q1){
                            ?>
                                <div class="bg-secondary bg-gradient mt-3">
                                    <p class="font-weight-bold  text-center h2 text-uppercase mt-2 mb-2 text-light">Quart 1</p>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="row m-1 mb-3 col-lg-12">
                                <div class="table-responsive col-lg-12">
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
                                    <?php
                                        if($productioncrantC1Q1){
                                    ?>
                                        <div class="">
                                            <a href="detailsCranteuseQ1.php?idfichecranteuseq1=<?= $productioncrantC1Q1['idfichecranteuseq1'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Cranteuse 1</p></a>
                                        </div>

                                        <div class="row">
                                            <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-3" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>  
                                                        <th>N° FM</th>     
                                                        <th>Consommations (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                        <th>Rebus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($consommationsC1Q1 as $consommationC1Q1){
                                                            $PoidsConsommeTotal += $consommationC1Q1['piodstotal'];
                                                            $RebusTotal += $consommationC1Q1['dechet'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#Information<?php echo $i; ?>" title="Voir details du produit" class="link-offset-2 link-underline"><?= $consommationC1Q1['numerofin'] ?></a></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC1Q1['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC1Q1['diametre'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC1Q1['dechet'] ?></td>
                                                        </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
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
                                                                                    $IDM = $consommationC1Q1['numerofin'];
                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `numbobine`=$IDM;";
                                                                            
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $Matiere = $query->fetch();
                                                                                    //** Fin select des receptions
                                                                                    
                                                                                    $IDR = $Matiere['idreception'];

                                                                                    $IdMatiere = $Matiere['idmatierereception'];

                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `idmatiere`=$IdMatiere;";
                                                                                
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $MatiereDepart = $query->fetch();
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Date réception : </span><?php echo $Reception['datereception']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nombre de bobine : </span><?php echo $MatiereDepart['nbbobine']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids des bobines : </span><?php echo $MatiereDepart['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Lieu de la réception : </span><?php echo $MatiereDepart['lieutransfert']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-8 col-form-label"><h5 style="color: #199AF3">Commentaire associé lors de la réception : </h5></label><br>
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Matricule du camion : </span><?php echo $Reception['matriculecamion']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Numéro de BL : </span><?php echo $Reception['bl']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div> <hr>
                                                                                <div class="form-group row mt-5">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Code bobine : </span><?php echo "REC00".$Matiere['idreception']."-BOB0-".$MatiereDepart['idmatiere']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-6 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids de la bobine déclaré lors du transfert : </span><?php echo $Matiere['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Etat bobine : </span> <?php echo $Matiere['etatbobine']; ?></h5></label>
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
                                            <table class="table table-bordered mb-2 mr-4 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Productions (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($productionsC1Q1 as $productionC1Q1){
                                                            $PoidsProduitTotal += $productionC1Q1['piodstotal'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC1Q1['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC1Q1['proddiametre'] ?></td>
                                                        </tr>
                                                    <!-- Pour le sweetAlert approuveTransfert !--> 
                                                    <?php
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Heure réelle début quart</th>                                                                                
                                                        <th>Heure réelle Fin quart</th>
                                                        <th>Temps d'arret total</th>   
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q1['heuredepartquart'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q1['heurefinquart'] ?></td>
                                                        <?php
                                                            //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                        ?>
                                                        <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretC1Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelC1Q1[0]-1)." H ".$TotalArretHReelC1Q1[1]." min" ?></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 mt-2 mr-2 col-lg-12" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Compteur Horaire</th>                                                                                
                                                        <th>Opérateur 1</th>
                                                        <th>Opérateur 2</th>
                                                        <th>Remarques</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;">Départ : <?= $productioncrantC1Q1['compteurdebut'] ?> /  fin : <?= $productioncrantC1Q1['compteurfin'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q1['controleur1'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q1['controleur2'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q1['observationfin'] ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Bouton et pagnination--> 
                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                        <div class="modal fade " id="InformationArretC1Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                            <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                <div class="modal-content">
                                                    <div class="card">
                                                        <div class="card-header bg-primary text-center">
                                                            <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la cranteuse 1 :</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="col-lg-12 mt-5 mb-5">
                                                                <?php
                                                                    //** Debut select de la production (arret)
                                                                        $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q1;";

                                                                        // On prépare la requête
                                                                        $query = $db->prepare($sql);

                                                                        // On exécute
                                                                        $query->execute();

                                                                        // On récupère les valeurs dans un tableau associatif
                                                                        $arretsC1Q1 = $query->fetchAll();
                                                                    //** Fin select de la production
                                                                ?>

                                                                <?php
                                                                    foreach($arretsC1Q1 as $arretC1Q1 => $key){
                                                                        ?>
                                                                            <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                        <?php
                                                                    }
                                                                ?>
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
                                </div>
                                <!-- Tableau d'en bas -->
                                <div class="table-responsive col-lg-12">
                                    <?php 
                                        if($productioncrantC2Q1){
                                    ?>
                                        <div class="">
                                            <a href="detailsCranteuseQ1.php?idfichecranteuseq1=<?= $productioncrantC2Q1['idfichecranteuseq1'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Cranteuse 2</p></a>
                                        </div>

                                        <div class="row">
                                            <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-3" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>N° FM</th>
                                                        <th>Consommations (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                        <th>Rebus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $i=0;
                                                        foreach($consommationsC2Q1 as $consommationC2Q1){
                                                            $PoidsConsommeTotal += $consommationC2Q1['piodstotal'];
                                                            $RebusTotal += $consommationC2Q1['dechet'];
                                                            $i++;
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#Information<?php echo $i; ?>" title="Voir details du produit" class="link-offset-2 link-underline"><?= $consommationC2Q1['numerofin'] ?></a></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC2Q1['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC2Q1['diametre'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC2Q1['dechet'] ?></td>
                                                        </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
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
                                                                                    $IDM = $consommationC2Q1['numerofin'];
                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `numbobine`=$IDM;";
                                                                            
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $Matiere = $query->fetch();
                                                                                    //** Fin select des receptions
                                                                                    
                                                                                    $IDR = $Matiere['idreception'];

                                                                                    $IdMatiere = $Matiere['idmatierereception'];

                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `idmatiere`=$IdMatiere;";
                                                                                
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $MatiereDepart = $query->fetch();
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Date réception : </span><?php echo $Reception['datereception']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nombre de bobine : </span><?php echo $MatiereDepart['nbbobine']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids des bobines : </span><?php echo $MatiereDepart['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Lieu de la réception : </span><?php echo $MatiereDepart['lieutransfert']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-8 col-form-label"><h5 style="color: #199AF3">Commentaire associé lors de la réception : </h5></label><br>
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Matricule du camion : </span><?php echo $Reception['matriculecamion']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Numéro de BL : </span><?php echo $Reception['bl']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div> <hr>
                                                                                <div class="form-group row mt-5">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Code bobine : </span><?php echo "REC00".$Matiere['idreception']."-BOB0-".$MatiereDepart['idmatiere']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-6 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids de la bobine déclaré lors du transfert : </span><?php echo $Matiere['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Etat bobine : </span> <?php echo $Matiere['etatbobine']; ?></h5></label>
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
                                            <table class="table table-bordered mb-2 mr-4 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Productions (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($productionsC2Q1 as $productionC2Q1){
                                                            $PoidsProduitTotal += $productionC2Q1['piodstotal'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC2Q1['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC2Q1['proddiametre'] ?></td>
                                                        </tr>
                                                    <!-- Pour le sweetAlert approuveTransfert !--> 
                                                    <?php
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Heure réelle début quart</th>                                                                                
                                                        <th>Heure réelle Fin quart</th> 
                                                        <th>Temps d'arret total</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q1['heuredepartquart'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q1['heurefinquart'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretC2Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelC2Q1[0]-1)." H ".$TotalArretHReelC2Q1[1]." min" ?></a></td>
                                                    </tr>
                                                    <?php
                                                        //$TempsFonctionTotal +=  (strtotime($productioncrantC2Q1['heurefinquart']) - strtotime($productioncrantC2Q1['heuredepartquart']));
                                                    ?>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 mt-2 mr-2 col-lg-12" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Compteur Horaire</th>                                                                                
                                                        <th>Opérateur 1</th>
                                                        <th>Opérateur 2</th>
                                                        <th>Remarques</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;">Départ : <?= $productioncrantC2Q1['compteurdebut'] ?> /  fin : <?= $productioncrantC2Q1['compteurfin'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q1['controleur1'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q1['controleur2'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q1['observationfin'] ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Bouton et pagnination--> 
                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                        <div class="modal fade " id="InformationArretC2Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                            <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                <div class="modal-content">
                                                    <div class="card">
                                                        <div class="card-header bg-primary text-center">
                                                            <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la cranteuse 2 :</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="col-lg-12 mt-5 mb-5">
                                                                <?php
                                                                    foreach($arretsC2Q1 as $arretC2Q1 => $key){
                                                                        ?>
                                                                            <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                        <?php
                                                                    }
                                                                ?>
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
                                </div>
                            </div>
                            <!-- Fin quart1 -->


                            <!-- Début quart2 -->
                            <?php
                                if($productioncrantC1Q2 || $productioncrantC2Q2){
                            ?>
                                <div class="bg-secondary bg-gradient mt-3">
                                    <p class="font-weight-bold  text-center h2 text-uppercase mt-2 mb-2 text-light">Quart 2</p>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="row m-1 mb-3 col-lg-12">
                                <div class="table-responsive col-lg-12">
                                    <?php
                                        if($productioncrantC1Q2){
                                    ?>
                                        <div class="">
                                            <a href="detailsCranteuseQ1.php?idfichecranteuseq1=<?= $productioncrantC1Q2['idfichecranteuseq1'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Cranteuse 1</p></a>
                                        </div>

                                        <div class="row">
                                            <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-3" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>N° FM</th>
                                                        <th>Consommations (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                        <th>Rebus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($consommationsC1Q2 as $consommationC1Q2){
                                                            $PoidsConsommeTotal += $consommationC1Q2['piodstotal'];
                                                            $RebusTotal += $consommationC1Q2['dechet'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#Information<?php echo $i; ?>" title="Voir details du produit" class="link-offset-2 link-underline"><?= $consommationC1Q2['numerofin'] ?></a></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC1Q2['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC1Q2['diametre'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC1Q2['dechet'] ?></td>
                                                        </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
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
                                                                                    $IDM = $consommationC1Q2['numerofin'];
                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `numbobine`=$IDM;";
                                                                            
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $Matiere = $query->fetch();
                                                                                    //** Fin select des receptions
                                                                                    
                                                                                    $IDR = $Matiere['idreception'];

                                                                                    $IdMatiere = $Matiere['idmatierereception'];

                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `idmatiere`=$IdMatiere;";
                                                                                
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $MatiereDepart = $query->fetch();
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Date réception : </span><?php echo $Reception['datereception']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nombre de bobine : </span><?php echo $MatiereDepart['nbbobine']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids des bobines : </span><?php echo $MatiereDepart['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Lieu de la réception : </span><?php echo $MatiereDepart['lieutransfert']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-8 col-form-label"><h5 style="color: #199AF3">Commentaire associé lors de la réception : </h5></label><br>
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Matricule du camion : </span><?php echo $Reception['matriculecamion']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Numéro de BL : </span><?php echo $Reception['bl']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div> <hr>
                                                                                <div class="form-group row mt-5">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Code bobine : </span><?php echo "REC00".$Matiere['idreception']."-BOB0-".$MatiereDepart['idmatiere']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-6 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids de la bobine déclaré lors du transfert : </span><?php echo $Matiere['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Etat bobine : </span> <?php echo $Matiere['etatbobine']; ?></h5></label>
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
                                            <table class="table table-bordered mb-2 mr-4 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Productions (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($productionsC1Q2 as $productionC1Q2){
                                                            $PoidsProduitTotal += $productionC1Q2['piodstotal'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC1Q2['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC1Q2['proddiametre'] ?></td>
                                                        </tr>
                                                    <!-- Pour le sweetAlert approuveTransfert !--> 
                                                    <?php
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Heure réelle début quart</th>                                                                                
                                                        <th>Heure réelle Fin quart</th>
                                                        <th>Temps d'arret total</th>   
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q2['heuredepartquart'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q2['heurefinquart'] ?></td>
                                                        <?php
                                                            //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                        ?>
                                                        <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretC1Q2" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelC1Q2[0]-1)." H ".$TotalArretHReelC1Q2[1]." min" ?></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 mt-2 mr-2 col-lg-12" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Compteur Horaire</th>                                                                                
                                                        <th>Opérateur 1</th>
                                                        <th>Opérateur 2</th>
                                                        <th>Remarques</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;">Départ : <?= $productioncrantC1Q2['compteurdebut'] ?> /  fin : <?= $productioncrantC1Q2['compteurfin'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q2['controleur1'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q2['controleur2'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q2['observationfin'] ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Bouton et pagnination--> 
                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                        <div class="modal fade " id="InformationArretC1Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                            <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                <div class="modal-content">
                                                    <div class="card">
                                                        <div class="card-header bg-primary text-center">
                                                            <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la cranteuse 1 :</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="col-lg-12 mt-5 mb-5">
                                                                <?php
                                                                    //** Debut select de la production (arret)
                                                                        $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q2;";

                                                                        // On prépare la requête
                                                                        $query = $db->prepare($sql);

                                                                        // On exécute
                                                                        $query->execute();

                                                                        // On récupère les valeurs dans un tableau associatif
                                                                        $arretsC1Q1 = $query->fetchAll();
                                                                    //** Fin select de la production
                                                                ?>

                                                                <?php
                                                                    foreach($arretsC1Q2 as $arretC1Q2 => $key){
                                                                        ?>
                                                                            <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                        <?php
                                                                    }
                                                                ?>
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
                                </div>
                                <!-- Tableau d'en bas -->
                                <div class="table-responsive col-lg-12">
                                    <?php 
                                        if($productioncrantC2Q2){
                                    ?>
                                        <div class="">
                                        <a href="detailsCranteuseQ1.php?idfichecranteuseq1=<?= $productioncrantC2Q2['idfichecranteuseq1'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Cranteuse 2</p></a>
                                        </div>

                                        <div class="row">
                                            <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-3" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>  
                                                        <th>N° FM</th>     
                                                        <th>Consommations (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                        <th>Rebus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($consommationsC2Q2 as $consommationC2Q2){
                                                            $PoidsConsommeTotal += $consommationC2Q2['piodstotal'];
                                                            $RebusTotal += $consommationC2Q2['dechet'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#Information<?php echo $i; ?>" title="Voir details du produit" class="link-offset-2 link-underline"><?= $consommationC2Q2['numerofin'] ?></a></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC2Q2['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC2Q2['diametre'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC2Q2['dechet'] ?></td>
                                                        </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
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
                                                                                    $IDM = $consommationC2Q2['numerofin'];
                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `numbobine`=$IDM;";
                                                                            
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $Matiere = $query->fetch();
                                                                                    //** Fin select des receptions
                                                                                    
                                                                                    $IDR = $Matiere['idreception'];

                                                                                    $IdMatiere = $Matiere['idmatierereception'];

                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `idmatiere`=$IdMatiere;";
                                                                                
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $MatiereDepart = $query->fetch();
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Date réception : </span><?php echo $Reception['datereception']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nombre de bobine : </span><?php echo $MatiereDepart['nbbobine']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids des bobines : </span><?php echo $MatiereDepart['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Lieu de la réception : </span><?php echo $MatiereDepart['lieutransfert']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-8 col-form-label"><h5 style="color: #199AF3">Commentaire associé lors de la réception : </h5></label><br>
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Matricule du camion : </span><?php echo $Reception['matriculecamion']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Numéro de BL : </span><?php echo $Reception['bl']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div> <hr>
                                                                                <div class="form-group row mt-5">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Code bobine : </span><?php echo "REC00".$Matiere['idreception']."-BOB0-".$MatiereDepart['idmatiere']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-6 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids de la bobine déclaré lors du transfert : </span><?php echo $Matiere['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Etat bobine : </span> <?php echo $Matiere['etatbobine']; ?></h5></label>
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
                                            <table class="table table-bordered mb-2 mr-4 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Productions (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($productionsC2Q2 as $productionC2Q2){
                                                            $PoidsProduitTotal += $productionC2Q2['piodstotal'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC2Q2['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC2Q2['proddiametre'] ?></td>
                                                        </tr>
                                                    <!-- Pour le sweetAlert approuveTransfert !--> 
                                                    <?php
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Heure réelle début quart</th>                                                                                
                                                        <th>Heure réelle Fin quart</th> 
                                                        <th>Temps d'arret total</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q2['heuredepartquart'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q2['heurefinquart'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretC2Q2" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelC2Q2[0]-1)." H ".$TotalArretHReelC2Q2[1]." min" ?></a></td>
                                                    </tr>
                                                    <?php
                                                        //$TempsFonctionTotal +=  (strtotime($productioncrantC2Q1['heurefinquart']) - strtotime($productioncrantC2Q1['heuredepartquart']));
                                                    ?>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 mt-2 mr-2 col-lg-12" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Compteur Horaire</th>                                                                                
                                                        <th>Opérateur 1</th>
                                                        <th>Opérateur 2</th>
                                                        <th>Remarques</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;">Départ : <?= $productioncrantC2Q2['compteurdebut'] ?> /  fin : <?= $productioncrantC2Q2['compteurfin'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q2['controleur1'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q2['controleur2'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q2['observationfin'] ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Bouton et pagnination--> 
                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                        <div class="modal fade " id="InformationArretC2Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                            <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                <div class="modal-content">
                                                    <div class="card">
                                                        <div class="card-header bg-primary text-center">
                                                            <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la cranteuse 2 :</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="col-lg-12 mt-5 mb-5">
                                                                <?php
                                                                    //** Debut select de la production (arret)
                                                                        $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q2;";

                                                                        // On prépare la requête
                                                                        $query = $db->prepare($sql);

                                                                        // On exécute
                                                                        $query->execute();

                                                                        // On récupère les valeurs dans un tableau associatif
                                                                        $arretsC2Q2 = $query->fetchAll();
                                                                    //** Fin select de la production
                                                                ?>
                                                                <?php
                                                                    foreach($arretsC2Q2 as $arretC2Q2 => $key){
                                                                        ?>
                                                                            <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                        <?php
                                                                    }
                                                                ?>
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
                                </div>
                            </div>
                            <!-- Fin quart2 -->

                            <!-- Debut quart3 -->
                            <?php
                                if($productioncrantC1Q3 || $productioncrantC2Q3){
                            ?>
                                <div class="bg-secondary bg-gradient mt-3">
                                    <p class="font-weight-bold  text-center h2 text-uppercase mt-2 mb-2 text-light">Quart 3</p>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="row m-1 mb-3 col-lg-12">
                                <div class="table-responsive col-lg-12">
                                    <?php
                                        if($productioncrantC1Q3){
                                    ?>
                                        <div class="">
                                            <a href="detailsCranteuseQ1.php?idfichecranteuseq1=<?= $productioncrantC1Q3['idfichecranteuseq1'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Cranteuse 1</p></a>
                                        </div>

                                        <div class="row">
                                            <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-3" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>  
                                                        <th>N° FM</th>     
                                                        <th>Consommations (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                        <th>Rebus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($consommationsC1Q3 as $consommationC1Q3){
                                                            $PoidsConsommeTotal += $consommationC1Q3['piodstotal'];
                                                            $RebusTotal += $consommationC1Q3['dechet'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#Information<?php echo $i; ?>" title="Voir details du produit" class="link-offset-2 link-underline"><?= $consommationC1Q3['numerofin'] ?></a></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC1Q3['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC1Q3['diametre'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC1Q3['dechet'] ?></td>
                                                        </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
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
                                                                                    $IDM = $consommationC1Q3['numerofin'];
                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `numbobine`=$IDM;";
                                                                            
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $Matiere = $query->fetch();
                                                                                    //** Fin select des receptions
                                                                                    
                                                                                    $IDR = $Matiere['idreception'];

                                                                                    $IdMatiere = $Matiere['idmatierereception'];

                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `idmatiere`=$IdMatiere;";
                                                                                
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $MatiereDepart = $query->fetch();
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Date réception : </span><?php echo $Reception['datereception']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nombre de bobine : </span><?php echo $MatiereDepart['nbbobine']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids des bobines : </span><?php echo $MatiereDepart['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Lieu de la réception : </span><?php echo $MatiereDepart['lieutransfert']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-8 col-form-label"><h5 style="color: #199AF3">Commentaire associé lors de la réception : </h5></label><br>
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Matricule du camion : </span><?php echo $Reception['matriculecamion']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Numéro de BL : </span><?php echo $Reception['bl']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div> <hr>
                                                                                <div class="form-group row mt-5">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Code bobine : </span><?php echo "REC00".$Matiere['idreception']."-BOB0-".$MatiereDepart['idmatiere']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-6 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids de la bobine déclaré lors du transfert : </span><?php echo $Matiere['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Etat bobine : </span> <?php echo $Matiere['etatbobine']; ?></h5></label>
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
                                            <table class="table table-bordered mb-2 mr-4 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Productions (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($productionsC1Q3 as $productionC1Q3){
                                                            $PoidsProduitTotal += $productionC1Q3['piodstotal'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC1Q3['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC1Q3['proddiametre'] ?></td>
                                                        </tr>
                                                    <!-- Pour le sweetAlert approuveTransfert !--> 
                                                    <?php
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Heure réelle début quart</th>                                                                                
                                                        <th>Heure réelle Fin quart</th>
                                                        <th>Temps d'arret total</th>   
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q3['heuredepartquart'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q3['heurefinquart'] ?></td>
                                                        <?php
                                                            //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                        ?>
                                                        <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretC1Q3" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelC1Q3[0]-1)." H ".$TotalArretHReelC1Q3[1]." min" ?></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 mt-2 mr-2 col-lg-12" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Compteur Horaire</th>                                                                                
                                                        <th>Opérateur 1</th>
                                                        <th>Opérateur 2</th>
                                                        <th>Remarques</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;">Départ : <?= $productioncrantC1Q3['compteurdebut'] ?> /  fin : <?= $productioncrantC1Q3['compteurfin'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q3['controleur1'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q3['controleur2'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC1Q3['observationfin'] ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Bouton et pagnination--> 
                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                        <div class="modal fade " id="InformationArretC1Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                            <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                <div class="modal-content">
                                                    <div class="card">
                                                        <div class="card-header bg-primary text-center">
                                                            <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la cranteuse 1 :</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="col-lg-12 mt-5 mb-5">
                                                                <?php
                                                                    //** Debut select de la production (arret)
                                                                        $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q3;";

                                                                        // On prépare la requête
                                                                        $query = $db->prepare($sql);

                                                                        // On exécute
                                                                        $query->execute();

                                                                        // On récupère les valeurs dans un tableau associatif
                                                                        $arretsC1Q3 = $query->fetchAll();
                                                                    //** Fin select de la production
                                                                ?>

                                                                <?php
                                                                    foreach($arretsC1Q3 as $arretC1Q3 => $key){
                                                                        ?>
                                                                            <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                        <?php
                                                                    }
                                                                ?>
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
                                </div>
                                <!-- Tableau d'en bas -->
                                <div class="table-responsive col-lg-12">
                                    <?php 
                                        if($productioncrantC2Q3){
                                    ?>
                                        <div class="">
                                            <a href="detailsCranteuseQ1.php?idfichecranteuseq1=<?= $productioncrantC2Q3['idfichecranteuseq1'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Cranteuse 2</p></a>
                                        </div>

                                        <div class="row">
                                            <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-3" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>   
                                                        <th>N° FM</th>    
                                                        <th>Consommations (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                        <th>Rebus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($consommationsC2Q3 as $consommationC2Q3){
                                                            $PoidsConsommeTotal += $consommationC2Q3['piodstotal'];
                                                            $RebusTotal += $consommationC2Q3['dechet'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#Information<?php echo $i; ?>" title="Voir details du produit" class="link-offset-2 link-underline"><?= $consommationC2Q3['numerofin'] ?></a></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC2Q3['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC2Q3['diametre'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationC2Q3['dechet'] ?></td>
                                                        </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
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
                                                                                    $IDM = $consommationC2Q3['numerofin'];
                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `numbobine`=$IDM;";
                                                                            
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $Matiere = $query->fetch();
                                                                                    //** Fin select des receptions
                                                                                    
                                                                                    $IDR = $Matiere['idreception'];

                                                                                    $IdMatiere = $Matiere['idmatierereception'];

                                                                                    //** Debut select des receptions
                                                                                        $sql = "SELECT * FROM `matiere` where `idmatiere`=$IdMatiere;";
                                                                                
                                                                                        // On prépare la requête
                                                                                        $query = $db->prepare($sql);
                                                                            
                                                                                        // On exécute
                                                                                        $query->execute();
                                                                            
                                                                                        // On récupère les valeurs dans un tableau associatif
                                                                                        $MatiereDepart = $query->fetch();
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Date réception : </span><?php echo $Reception['datereception']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Nombre de bobine : </span><?php echo $MatiereDepart['nbbobine']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids des bobines : </span><?php echo $MatiereDepart['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Lieu de la réception : </span><?php echo $MatiereDepart['lieutransfert']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-8 col-form-label"><h5 style="color: #199AF3">Commentaire associé lors de la réception : </h5></label><br>
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
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Matricule du camion : </span><?php echo $Reception['matriculecamion']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Numéro de BL : </span><?php echo $Reception['bl']; ?></h5></label>
                                                                                    <div class="col-sm-6">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div> <hr>
                                                                                <div class="form-group row mt-5">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Code bobine : </span><?php echo "REC00".$Matiere['idreception']."-BOB0-".$MatiereDepart['idmatiere']; ?></h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-6 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Poids de la bobine déclaré lors du transfert : </span><?php echo $Matiere['poidsdeclare']; ?> (KG)</h5></label>
                                                                                    <div class="col-sm-4">
                                                                                        <h5></h5>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><h5><span class="mr-3" style="color: #199AF3">Etat bobine : </span> <?php echo $Matiere['etatbobine']; ?></h5></label>
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
                                            <table class="table table-bordered mb-2 mr-4 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Productions (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($productionsC2Q3 as $productionC2Q3){
                                                            $PoidsProduitTotal += $productionC2Q3['piodstotal'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC2Q3['piodstotal'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionC2Q3['proddiametre'] ?></td>
                                                        </tr>
                                                    <!-- Pour le sweetAlert approuveTransfert !--> 
                                                    <?php
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 col-lg-4" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Heure réelle début quart</th>                                                                                
                                                        <th>Heure réelle Fin quart</th> 
                                                        <th>Temps d'arret total</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q3['heuredepartquart'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q3['heurefinquart'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretC2Q3" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelC2Q3[0]-1)." H ".$TotalArretHReelC2Q3[1]." min" ?></a></td>
                                                    </tr>
                                                    <?php
                                                        //$TempsFonctionTotal +=  (strtotime($productioncrantC2Q1['heurefinquart']) - strtotime($productioncrantC2Q1['heuredepartquart']));
                                                    ?>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 mt-2 mr-2 col-lg-12" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Compteur Horaire</th>                                                                                
                                                        <th>Opérateur 1</th>
                                                        <th>Opérateur 2</th>
                                                        <th>Remarques</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;">Départ : <?= $productioncrantC2Q3['compteurdebut'] ?> /  fin : <?= $productioncrantC2Q3['compteurfin'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q3['controleur1'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q3['controleur2'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productioncrantC2Q3['observationfin'] ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Bouton et pagnination--> 
                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                        <div class="modal fade " id="InformationArretC2Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                            <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                <div class="modal-content">
                                                    <div class="card">
                                                        <div class="card-header bg-primary text-center">
                                                            <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la cranteuse 2 :</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="col-lg-12 mt-5 mb-5">
                                                                <?php
                                                                    //** Debut select de la production (arret)
                                                                        $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q3;";

                                                                        // On prépare la requête
                                                                        $query = $db->prepare($sql);

                                                                        // On exécute
                                                                        $query->execute();

                                                                        // On récupère les valeurs dans un tableau associatif
                                                                        $arretsC2Q3 = $query->fetchAll();
                                                                    //** Fin select de la production
                                                                ?>
                                                                <?php
                                                                    foreach($arretsC2Q3 as $arretC2Q3 => $key){
                                                                        ?>
                                                                            <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                        <?php
                                                                    }
                                                                ?>
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
                                </div>
                            </div>
                            <!-- Fin quart3 -->
                        </div>
                        <div class="card-footer py-3 mt-5 bg-primary">
                            <div class="mb-4 mt-3">
                                <p class="m-0 mb-3 h5 d-inline" style="color: white;  padding-right: 10%;"><span class="mr-4"><span class="mr-4">Temps d'arret total :</span> <?php  $TempsArretTotalReel = explode(":",date("H:i",$TempsArretTotal) );  echo ($TempsArretTotalReel[0]-1)." H ".$TempsArretTotalReel[1]." min"; ?></p>
                                <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 10%;"><span class="mr-5">Poids total produit : </span> <?php echo $PoidsProduitTotal; ?> (KG)</p>
                                <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 10%;"><span class="mr-4">Poids total consommé : </span> <?php  echo $PoidsConsommeTotal; ?> (KG)</p>
                                <p class="m-0 mb-3 h5 d-inline" style="color: white;"><span class="mr-5">Rebus total : </span> <?php echo ($RebusTotal); ?> (KG)</p>
                            </div>
                            <!-- <p class="m-0 mt-3  h5 ml-3 mb-3 d-inline" style="color: white; padding-right: 20%;"><span class="mr-5">Temps de fonction total : </span> <?php $TotalArretHReelC1Q1 = explode(":",date("H:i",$TempsFonctionTotal) ); echo ($TotalArretHReelC1Q1[0]-1)." H ".$TotalArretHReelC1Q1[1]." min"; ?></p> -->
                        </div>
                        <div class="col-md-8 align-items-center mt-5 mb-5">
                            <div class="d-flex gap-2 pt-4">
                                <a href="etatProduction.php" class="btn btn-danger w-lg bouton ml-3"><i class="fa fa-angle-double-left mr-2"></i>Retour</a>
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