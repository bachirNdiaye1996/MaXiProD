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

<?php if($_SESSION['niveau']=='admin' || $_SESSION['niveau']=='pontbascule'){ ?>
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
               <a class="collapse-item active" href="../../stockage/transfert/transfert.php">Transfert</a>
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
<?php } ?>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
   <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>