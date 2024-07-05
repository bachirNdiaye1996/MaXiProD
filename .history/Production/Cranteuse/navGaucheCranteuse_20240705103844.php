
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../indexPage/accueil.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB  <?php echo $_SESSION['username'];?> <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="../../indexPage/accueil.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Accueil Dashboard</span>
        </a>
    </li>

    <?php if($_SESSION['niveau']=='admin' || $_SESSION['niveau']=='pontbascule'){ ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Tables -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReception"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fa fa-book fa-fw"></i>
                <span>Pont Bascule</span>
            </a>
            <div id="collapseReception" class="collapse" aria-labelledby="headingReception"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Stockage :</h6>
                    <a class="collapse-item" href="../../stockage/reception.php">Réception</a>
                    <a class="collapse-item" href="../../stockage/receptionPlanifie.php">Réception planifiée</a>
                    <a class="collapse-item" href="../../stockage/transfert/transfert.php">Transfert</a>
                    <a class="collapse-item" href="../../stockage/Exportation/exportation.php">Export</a>
                    <a class="collapse-item" href="../../stockage/historique.php">Historique</a>
                    <a class="collapse-item" href="../../stockage/stockage/stockage.php">Stockage</a>
                    <a class="collapse-item" href="../../stockage/graphe.php">Graphe Niambour</a>
                    <a class="collapse-item" href="../../stockage/grapheMetal1.php">Graphe Metal 1</a>
                    <a class="collapse-item" href="../../stockage/grapheMetalMbao.php">Graphe Metal Mbao</a>
                </div>
            </div>
        </li>
    <?php } ?>

    <?php if($_SESSION['niveau'] != 'pontbascule'){ ?>
        <!-- Divider -->
        <hr class="sidebar-divider">
        
        <!-- Nav Item - Tables -->

        <li class="nav-item active">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fa fa-book fa-fw"></i>
                <span>Production Cranteuse</span>
            </a>
            <div id="collapseUtilities" class="collapse show" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Les informations :</h6>
                    <a class="collapse-item <?php if(isset($activeQ)){echo $activeQ;} ?>" href="./ficheCranteuse.php">Fiches Productions</a>
                    <a class="collapse-item <?php if(isset($activeEtatProduction)){echo $activeEtatProduction;} ?>" href="./etatProduction.php">Etats Productions</a>
                    <a class="collapse-item <?php if(isset($historique)){echo $historique;} ?>" href="./historiqueCranteuse.php">Historiques</a>
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
                    <a class="collapse-item" href="../Dresseuse/ficheDresseuse.php">Fiches Productions</a>
                    <a class="collapse-item" href="../Dresseuse/etatProduction.php">Etats Productions</a>
                    <a class="collapse-item" href="../Dresseuse/historiqueCranteuse.php">Historiques</a>
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
                    <a class="collapse-item" href="../Trefilage/ficheTrefilage.php">Fiches Productions</a>
                    <a class="collapse-item" href="../Trefilage/etatProduction.php">Etats Productions</a>
                    <a class="collapse-item" href="../Trefilage/historiqueTrefilage.php">Historiques</a>
                </div>
            </div>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesFour"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fa fa-book fa-fw"></i>
                <span>Production Four</span>
            </a>
            <div id="collapseUtilitiesFour" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Les différents quarts :</h6>
                    <a class="collapse-item" href="quart1.php">Quart 1</a>
                    <a class="collapse-item" href="quart2.php">Quart 2</a>
                    <a class="collapse-item" href="quart3.php">Quart 3</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">



        <!-- Nav Item - Utilities Collapse Menu -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesClou"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fa fa-book fa-fw"></i>
                <span>Production Clou</span>
            </a>
            <div id="collapseUtilitiesClou" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Les différents quarts :</h6>
                    <a class="collapse-item" href="quart1.php">Quart 1</a>
                    <a class="collapse-item" href="quart2.php">Quart 2</a>
                    <a class="collapse-item" href="quart3.php">Quart 3</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">

        <!-- Nav Item - Tables -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesGrillage"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fa fa-book fa-fw"></i>
                <span>Production Grillage</span>
            </a>
            <div id="collapseUtilitiesGrillage" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Les différents quarts :</h6>
                    <a class="collapse-item" href="quart1.php">Quart 1</a>
                    <a class="collapse-item" href="quart2.php">Quart 2</a>
                    <a class="collapse-item" href="quart3.php">Quart 3</a>
                </div>
            </div>
        </li>

    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->