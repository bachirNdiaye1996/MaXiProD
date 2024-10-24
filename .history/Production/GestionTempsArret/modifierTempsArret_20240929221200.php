<?php
    
    session_start(); 
    
    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";


    //Variables

    $idgestiontempsarret = $_GET['idgestiontempsarret'];  // On recupére l'ID idcranteuseq1 par get

    if($_SERVER["REQUEST_METHOD"]=='GET'){
        if(!isset($_GET['idgestiontempsarret'])){
            header("location: gestionTempsArret.php");
            exit;
        }
        $sql = "select * from gestiontempsarret where idgestiontempsarret=$idgestiontempsarret";
        $result = $db->query($sql);
        $rowTempsArret = $result->fetch();

        while(!$rowTempsArret){
            header("location: gestionTempsArret.php");
            exit;
        }
    }else{  
        //Update une fiche
        if(isset($_POST['modifierTempsArret'])){
            for ($i = 0; $i < count($_POST['libelletempsarret']); $i++){   
                $diametre=htmlspecialchars( $_POST['libelletempsarret'][$i]);
                $nomenclature=htmlspecialchars( $_POST['machine'][$i]);
            
                $insert=$db->prepare("UPDATE `gestiontempsarret` SET `libelletempsarret`=?, `machine`=? where `idgestiontempsarret`=?;");
                $insert->execute(array($libelletempsarret,$machine));
            }
        }
    }

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

    <script type="text/javascript"> 
        $(document).ready(function(){  
            var i = 1;             
            $('#addProductions').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicaddProductions').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="text" name="libelletempsarret[]" id="libelletempsarret" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="machine[]">
                                <option>Trefilage</option>
                                <option>Cranteuse</option>
                                <option>Dresseuse</option> 
                                <option>Four</option>
                                <option>Grillage</option>
                            </select>                                                
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger removeProductions"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>`
            );});
            ;}); 
    </script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" style="background: #C2C3C3;">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" style="margin-bottom: 200px;">
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Modale pour ajouter reception -->
                        <div class="col-lg-12">
                            <div class="modal-dialog-centered">
                                <div class="modal-content col-lg-12">
                                    <div class="modal-header col-lg-12 bg-primary" >
                                        <h5 class="modal-title" id="myExtraLargeModalLabel" style="color:white; text-align: center;">Modification du temps d'arret</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Gestion des temps d'arrets</h5>
                                                    <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Libelle arret</th>
                                                                <th>Machine</th>
                                                                <th>Supprimer ligne</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dynamicaddProductions">
                                                            <?php
                                                                //$i=0;
                                                                foreach($rowProductions as $rowProduction){
                                                                    //$i++;
                                                                    //if($article['status'] == 'termine'){
                                                            ?>
                                                                <tr class="rowClass">
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" type="number" step="0.01" name="Proddiametre[]" id="Proddiametre" value="<?php echo $rowProduction['proddiametre']; ?>" required>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" type="text" name="libelletempsarret[]" id="libelletempsarret" value="<?php echo $rowProduction['libelletempsarret']; ?>" required>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="machine[]">
                                                                                    <option <?php if ( $rowTempsArret['machine']=="Cranteuse") {echo "selected='selected'";} ?>>Cranteuse</option>
                                                                                    <option <?php if ( $rowTempsArret['machine']=="Dresseuse") {echo "selected='selected'";} ?>>Dresseuse</option> 
                                                                                    <option <?php if ( $rowTempsArret['machine']=="Four") {echo "selected='selected'";} ?>>Four</option>
                                                                                    <option <?php if ( $rowTempsArret['machine']=="Grillage") {echo "selected='selected'";} ?>>Grillage</option>
                                                                                    <option <?php if ( $rowTempsArret['machine']=="Trefilage") {echo "selected='selected'";} ?>>Trefilage</option>
                                                                                </select>                                                
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                        <button class="btn btn-danger removeProductions"
                                                                            type="button">Enlever
                                                                        </button> 
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>

                                                    <div class="col-md-4  d-flex gap-2">
                                                        <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                            <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="addProductions" type="button" value="Ajouter une ligne">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12 text-end">
                                                    <div class="col-md-8 align-items-center col-md-12 text-end"> 
                                                        <?php if($valideFiche == "ValideInsertion"){?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Exportation enregistrée avec succès merci!',
                                                                    icon: 'success',
                                                                    timer: 3000,
                                                                    showConfirmButton: false,
                                                                    });
                                                            </script> 
                                                        <?php } ?>
                                                        <div class="d-flex gap-2 pt-4">                           
                                                            <a href="ficheCranteuse.php"><input class="btn btn-danger  w-lg bouton mr-3" name=""  value="Annuler"></a>
                                                            <input class="btn btn-success  w-lg bouton mr-3" name="modifierTempsArret" type="submit" value="ENREGISTRER">
                                                        </div>
                                                        <hr/>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>  
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div>

                    <div class="col-lg-12 mt-5">
                        <div class="card position-relative">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Nombre de bobine stocké à la machine Cranteuse : <?php echo $nbReception; ?></h6>
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
                                                <th>Numéro fil machine</th>                                                                                
                                                <th>Epaisseur</th>
                                                <th>Nombre bobine</th>
                                                <th>Poids déclaré</th>
                                                <th>Poids pesé</th>
                                                <th>Etat bobine</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i=0;
                                                foreach($stockCranteuse as $stock){
                                                    $i++;
                                                    //if($article['status'] == 'termine'){
                                            ?>
                                                <tr>
                                                    <td style="background-color:#4e73df ; color:white;">
                                                        <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#Information<?php echo $i; ?>" title="Voir details du produit" class="link-offset-2 link-underline"><?php echo $stock['numbobine']; ?></a>
                                                        <!--<a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" title="Allez vers la reception planifiée correspondante" href="detailsReceptionPlanifie.php?idreception=<?= $stock['idreception'] ?>" class="link-offset-2 link-underline"><?php echo "REC-0".$stock['idreception']."-BOB-0".$stock['idmatiere'] ?></a>!-->
                                                    </td>
                                                    <td style="background-color:#4e73df ; color:white;"> <?= $stock['epaisseur'] ?> </td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['nbbobineactuel'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['poidsdeclare'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['poidspese'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['etatbobine'] ?></td>
                                                </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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