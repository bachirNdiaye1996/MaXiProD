<?php
    
    session_start(); 

    if(!$_SESSION['niveau']){
        header('Location: ../../../404.php');
    }

    include "../../connexion/conexiondb.php";


    //Variables
    // Il faut savoir que metal3 est remplacer par niambour


    //** Debut select des receptions
    $valideTransfert="";

    //** Fin select des receptions
  

    //Insertion des réceptions
    if(isset($_POST['CreerReception'])){
        $commentaire=htmlspecialchars($_POST['commentaire']);
        
        
        for ($i = 0; $i < count($_POST['epaisseur']); $i++){
            if(!empty($_POST['epaisseur'][$i])){
                if(!empty($_POST['epaisseur'][$i])){
                    $epaisseur=htmlspecialchars( $_POST['epaisseur'][$i]);
                    $numbobine=htmlspecialchars( $_POST['numbobine'][$i]);
                    $datereception=htmlspecialchars($_POST['datereception'][$i]);
                    $etatbobine=htmlspecialchars($_POST['etatbobine'][$i]);
                    $user=htmlspecialchars($_POST['user'][$i]);
                    $poidsdeclare=htmlspecialchars($_POST['poidsdeclare'][$i]);
                    $poidspese=htmlspecialchars($_POST['poidspese'][$i]);
                    $df=htmlspecialchars($_POST['df'][$i]);
    
                    if($nbbobine == 0){
                        $valideTransfert="erreurEpaisseur";
                    }else{
                       /* //Rechercher le nombre de piéces sur le lieu d'arrive 
                            $sqlEpaisseur = "SELECT * FROM `matiere` where `lieutransfert`='$lieutransfert' and `epaisseur`='$epaisseur' LIMIT 1;";
                            // On prépare la requête
                            $queryEpaisseur = $db->prepare($sqlEpaisseur);

                            // On exécute
                            $queryEpaisseur->execute();

                            // On récupère le nombre d'articles
                            $resultMatiereArrive = $queryEpaisseur->fetch();
                        //Fin Rechercher le nombre de piéces d'arrive */
    
                        /*if($resultMatiereArrive){
                            // ajouter le nombre de bobine dans le lieu de depart
                                $req ="UPDATE matiere SET `nbbobineactuel` = `nbbobineactuel` + ?, `poidsdeclare` = `poidsdeclare` + ? where `idmatiere`='$resultMatiereArrive[idmatiere]';";
                                $reqtitre = $db->prepare($req);
                                $reqtitre->execute(array($nbbobine,$poidsdeclare));
                            // Fin ajouter le nombre de bobine dans le lieu de depart
                        }else{*/
                            // Ajouter le nombre de bobine dans le lieu de reception
                                $insertUser=$db->prepare("INSERT INTO `receptionmachinedetails` (`idreceptionmachinedetails`, `poidsdeclare`, `poidspese`, `dateajout`,`user`,`nbbobine`,`lieutransfert`, `idreception`,`epaisseur`,`etatbobine`,`numbobine`) 
                                VALUES (NULL, ?, ?, ?, current_timestamp(), ?, ?, ?, ?, ?, ?);");
                                $insertUser->execute(array($epaisseur,$poidsdeclare, $poidspese, $user,$nbbobine,$lieutransfert,$idreception, $etatbobine, $nbbobine));
                            // Fin ajouter le nombre de bobine dans le lieu de reception
                            $valideTransfert="ValideInsertion";
                        //}
                    }    
                }
            }else{
                $valideTransfert="erreurInsertion";
            }
        }
        if($valideTransfert != "erreurInsertion"){
            header("location: detailsReception.php?idreception=$idreception");
            exit;
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

    <script>
        $(document).ready(() => { 
            // Removing Row on click to Remove button
            $('#dynamicadd').on('click', '.remove', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });
        })
    </script>

    <script type="text/javascript"> 
        $(document).ready(function(){  
            var i = 1;         
            $('#add').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicadd').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="epaisseur[]" placeholder="Taper l'épaisseur de la bobine" value="">
                                <option>3</option>
                                <option>3.5</option>
                                <option>4</option>
                                <option>4.5</option>
                                <option>5</option>
                                <option>5.5</option>
                                <option>6</option>
                                <option>6.5</option>
                                <option>7</option>
                                <option>7.5</option>
                                <option>8</option>
                                <option>8.5</option>
                                <option>9</option>
                                <option>9.5</option>
                                <option>10</option>
                                <option>10.5</option>
                                <option>11</option>
                                <option>11.5</option>
                                <option>12</option>
                                <option>12.5</option>
                                <option>13</option>
                                <option>13.5</option>
                                <option>14</option>
                                <option>14.5</option>
                                <option>15</option>
                                <option>15.5</option>
                                <option>16</option>
                                <option>16.5</option>
                                <option>17</option>
                            </select> 
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control" type="number" name="numbobine[]" value="" id="validationDefault04" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01"  value="" name="poidsdeclare[]" id="example">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" value="" name="poidspese[]">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="lieutransfert[]">
                                <option>Machine Tréfilage</option>
                                <option>Machine Cranteuse</option>
                            </select>                                                
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="date" value="" name="machinereception[]">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="text" value="" name="df[]" id="example">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="etatbobine[]" value="">
                                <option>Normale</option>
                                <option>Disloquée</option>
                                <option>Autres</option>
                            </select>                                                  
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger remove"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>`
            );});
            $(document).on('click','.remove_row',function(){ 
            var row_id = $(this).attr("id");          
            $('#row'+row_id+'').remove();});});      
    </script> 

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">


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

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" style="margin-bottom: 200px;">
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Modale pour ajouter reception -->
                        <div class="col-lg-12 ">
                            <div class="modal-dialog-centered">
                                <div class="modal-content col-lg-12">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myExtraLargeModalLabel">Ajouter une réception</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Epaisseur</th>
                                                            <th>Numéro bobine</th>
                                                            <th>Poids déclaré</th>
                                                            <th>Poids pesé</th>
                                                            <th>Machine de réception</th>
                                                            <th>Date de réception</th>
                                                            <th>DF</th>
                                                            <th>Etat de la bobine</th>
                                                            <th>Supprimer ligne</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dynamicadd">
                                                        <tr class="rowClass">
                                                            <td style="background-color:#CFFEDA ;">
                                                                <div class="">
                                                                    <div class="mb-1 text-start">
                                                                        <select class="form-control" name="epaisseur[]" placeholder="Taper l'épaisseur de la bobine" value="">
                                                                            <option>3</option>
                                                                            <option>3.5</option>
                                                                            <option>4</option>
                                                                            <option>4.5</option>
                                                                            <option>5</option>
                                                                            <option>5.5</option>
                                                                            <option>6</option>
                                                                            <option>6.5</option>
                                                                            <option>7</option>
                                                                            <option>7.5</option>
                                                                            <option>8</option>
                                                                            <option>8.5</option>
                                                                            <option>9</option>
                                                                            <option>9.5</option>
                                                                            <option>10</option>
                                                                            <option>10.5</option>
                                                                            <option>11</option>
                                                                            <option>11.5</option>
                                                                            <option>12</option>
                                                                            <option>12.5</option>
                                                                            <option>13</option>
                                                                            <option>13.5</option>
                                                                            <option>14</option>
                                                                            <option>14.5</option>
                                                                            <option>15</option>
                                                                            <option>15.5</option>
                                                                            <option>16</option>
                                                                            <option>16.5</option>
                                                                            <option>17</option>
                                                                        </select> 
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="background-color:#CFFEDA ;">
                                                                <div class="col-md-10">
                                                                    <div class="mb-1 text-start">
                                                                        <input class="form-control" type="number" name="numbobine[]" value="" id="validationDefault04" required>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="background-color:#CFFEDA ;">
                                                                <div class="col-md-10">
                                                                    <div class="mb-1 text-start">
                                                                        <input class="form-control designa" type="number" step="0.01"  value="" name="poidsdeclare[]" id="example">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="background-color:#CFFEDA ;">
                                                                <div class="col-md-10">
                                                                    <div class="mb-1 text-start">
                                                                        <input class="form-control designa" type="number" step="0.01" value="" name="poidspese[]">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="background-color:#CFFEDA ;">
                                                                <div class="col-md-10">
                                                                    <div class="mb-1 text-start">
                                                                        <select class="form-control" name="machinereception[]">
                                                                            <option>Machine Tréfilage</option>
                                                                            <option>Machine Cranteuse</option>
                                                                        </select>                                                
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="background-color:#CFFEDA ;">
                                                                <div class="col-md-10">
                                                                    <div class="mb-1 text-start">
                                                                        <input class="form-control designa" type="date" value="" name="datereception[]">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="background-color:#CFFEDA ;">
                                                                <div class="col-md-10">
                                                                    <div class="mb-1 text-start">
                                                                        <input class="form-control designa" type="text" value="" name="df[]" id="example">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="background-color:#CFFEDA ;">
                                                                <div class="col-md-10">
                                                                    <div class="mb-1 text-start">
                                                                        <select class="form-control" name="etatbobine[]" value="">
                                                                            <option>Normale</option>
                                                                            <option>Disloquée</option>
                                                                            <option>Autres</option>
                                                                        </select>                                                  
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                <button class="btn btn-danger remove"
                                                                    type="button">Enlever
                                                                </button> 
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-md-4  d-flex gap-2">
                                                    <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                        <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="add" type="button" value="Ajouter une ligne">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 invisible">
                                                    <div class="mb-1 text-start">
                                                        <label class="form-label fw-bold" for="user" ></label>
                                                        <input class="form-control " type="text" value="<?php
                                                            echo $_SESSION['nomcomplet']; 
                                                        ?>" name="user" id="example-date-input2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 invisible">
                                                    <div class="mb-1 text-start">
                                                        <input class="form-control " type="text" value="<?php
                                                            echo $_GET['idreception']; 
                                                        ?>" name="idreception" id="example-date-input2">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="mb-1 text-start">
                                                        <label class="form-label fw-bold" for="commentaire" >Commentaire</label>
                                                        <textarea class="form-control"  name="commentaire" rows="4" cols="50" placeholder="Commentaire en quelques mots ( pas obligatoire... )"></textarea>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-end">
                                                    <div class="col-md-8 align-items-center col-md-12 text-end">
                                                        <?php if($valideTransfert == "ValideInsertion"){?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Réception enregistrée avec succès merci!',
                                                                    icon: 'success',
                                                                    timer: 3000,
                                                                    showConfirmButton: false,
                                                                    });
                                                            </script> 
                                                        <?php } ?>
                                                        <div class="d-flex gap-2 pt-4">                           
                                                            <a href="detailsReception.php?idreception=<?= $_GET['idreception'] ?>"><input class="btn btn-danger  w-lg bouton mr-3" name=""  value="Annuler"></a>
                                                            <input class="btn btn-success  w-lg bouton mr-3" name="CreerReception" type="submit" value="ENREGISTRER">
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
                </div>
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