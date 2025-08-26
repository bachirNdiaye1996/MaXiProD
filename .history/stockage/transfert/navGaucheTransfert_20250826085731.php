<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../indexPage/accueil.php">
   <div class="sidebar-brand-icon rotate-n-15">
       <i class="fas fa-laugh-wink"></i>
   </div>
   <div class="sidebar-brand-text mx-3">SB <?php echo $_SESSION['username'];?> <sup>2</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
   <a class="nav-link" href="../../indexPage/accueil.php">
       <i class="fas fa-fw fa-tachometer-alt"></i>
       <span>Accueil Dashboard</span></a>
</li>

<?php if($_SESSION['niveau']=='admin' || $_SESSION['niveau']=='pontbascule' || $_SESSION['niveau']=='chefquart' || $_SESSION['niveau']=='invite'){ ?>
   <!-- Divider -->
   <hr class="sidebar-divider">

   <!-- Nav Item - Tables -->

   <li class="nav-item active">
       <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReception"
           aria-expanded="true" aria-controls="collapseUtilities">
           <i class="fa fa-book fa-fw"></i>
           <span>Pont Bascule</span>
       </a>
       <div id="collapseReception" class="collapse show" aria-labelledby="headingUtilities"
           data-parent="#accordionSidebar">
           <div class="bg-white py-2 collapse-inner rounded">
               <h6 class="collapse-header">Stockage :</h6>
               <a class="collapse-item" href="../../stockage/reception.php">Réception</a>
               <a class="collapse-item" href="../../stockage/receptionPlanifie.php">Réception planifiée</a>
               <a class="collapse-item <?php if(!isset($active)){ echo 'active'; } ?>" href="../../stockage/transfert/transfert.php">Transfert</a>
               <a class="collapse-item" href="../../stockage/Exportation/exportation.php">Export</a>
               <a class="collapse-item <?php if(isset($active)){ echo 'active'; } ?>" href="../../stockage/historique.php">Historique</a>
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
                <a class="collapse-item" href="../../Production/Reception/reception.php">reception</a>
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
       <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
           data-parent="#accordionSidebar">
           <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Les informations :</h6>
               <a class="collapse-item" href="../../Production/Cranteuse/ficheCranteuse.php">Fiches Productions</a>
               <a class="collapse-item" href="../../Production/Cranteuse/etatProduction.php">Etat Production</a>
               <a class="collapse-item" href="../../Production/Cranteuse/historiqueCranteuse.php">Historiques</a>
           </div>
       </div>
   </li>

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
                <a class="collapse-item" href="../../Production/Dresseuse/ficheDresseuse.php">Fiches Productions</a>
                <a class="collapse-item" href="../../Production/Dresseuse/etatProduction.php">Etats Productions</a>
                <a class="collapse-item" href="../../Production/Dresseuse/historiqueDresseuse.php">Historiques</a>
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
                <a class="collapse-item" href="../../Production/Trefilage/ficheParQuartTrefilage.php">Fiches Productions</a>
                <a class="collapse-item" href="../../Production/Trefilage/etatProduction.php">Etats Productions</a>
                <a class="collapse-item" href="../../Production/Trefilage/historiqueTrefilage.php">Historiques</a>
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