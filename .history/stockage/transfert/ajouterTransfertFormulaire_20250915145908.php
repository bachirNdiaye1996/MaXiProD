<?php
    
    session_start(); 
    
    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";


    //Variables
    // Il faut savoir que metal3 est remplacer par niambour
    $valideTransfert="";
    $ProblemeLieu="";
    $ProblemeNbBobineDepart="";
    $Iddepart=null;                        // Variable qui nous permet d'optenir l'Id de la matiere de départ
    $idtransfert = $_GET['idtransfert'];  // On recupére l'ID du transfert par get
    $Reception[]=null;
    $NombreLigne = $_GET['NombreLigne'];  
    $ProblemeNumeroBobine="";
    $ProblemeUnicite="";        // Unicite du num bobine
    $ProblemeUniciteExist="";   // Unicite du num bobine Existant dans la base





    //Revoir si on a ajouté une ligne
        $saisisseur="";
        $commentaire="";
        $transporteur="";
        $datetransfert="";

        $sql = "select * from transfert where idtransfert=$idtransfert";
        $result = $db->query($sql);
        $row = $result->fetch();  

        $commentaire=$row['commentaire'];
        $saisisseur=$row['saisisseur'];
        $transporteur=$row['transporteur'];
        $datetransfert=$row['datetransfert'];

    //Changer valeur NombreLigne   
        if(isset($_POST['ChangerNombreLigne'])){
            $NombreLignes=htmlspecialchars( $_POST['NombreLigne']) - 1;
            header("location: ajouterReceptionFormulaire.php?idreception=$_GET[idreception]&NombreLigne=$NombreLignes");
            exit;
        }
    // Fin changer valeur NombreLigne 

    //Insertion des réceptions
    if(isset($_POST['CreerTransfert'])){

        //
        /*$Epaisseurs = array ( array ());
        for ($i = 0; $i < count($_POST['epaisseur']); $i++){
            $Epaisseurs['epaisseur']=htmlspecialchars( $_POST['epaisseur'][$i]);
        }

        foreach($IdFichesCranteuse as $key => $idFichesCranteuses){
        $tempProductionParControleur=null;
        }*/

        $last_names = array_column($_POST['epaisseur'], 'epaisseur');
        print_r($last_names);

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

    <link rel="shortcut icon" href="../image/iconOnglet.png" />
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
                            <input class="form-control" type="number" name="nbbobine[]" value="" id="validationDefault0<?$i+9?>">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control" type="text" name="numbobine[]" value="" id="validationDefault0<?$i+99?>">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="poidsdeclare[]" id="validationDefault0<?$i+11?>" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="poidspese[]">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="pointdepart[]">
                                <option>Metal1</option>
                                <option>Niambour</option>
                                <option>Metal Mbao</option>
                            </select>                                                
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="pointarrive[]">
                                <option>Metal1</option>
                                <option>Niambour</option>
                                <option>Tréfilage</option>
                                <option>Cranteuse</option>
                                <option>Metal Mbao</option>
                            </select>                                                
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
                                        <h5 class="modal-title" id="myExtraLargeModalLabel">Ajouter un transfert</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                                            <div class="row">
                                                <?php if($valideTransfert != "erreurEpaisseur" && $ProblemeNbBobineDepart != "erreurProblemeNbDepart" && $ProblemeNumeroBobine != "erreurProblemeNumeroBobine" && $ProblemeLieu != "erreurProblemeLieu" && $ProblemeUnicite != "erreurProblemeUnicite" && $ProblemeUniciteExist != "erreurProblemeUniciteExist"){ // Lorsqu'il y'a pas d'erreur ?> 
                                                    <div class="col-md-2 mr-2 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Nom complet du saisisseur</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="saisisseur" value="<?= $row['saisisseur'] ?>" placeholder="Mettez le nom complet du saisisseur" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 ml-5 mt-3">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Transporteur</label>
                                                            <input class="form-control" id="validationDefault02" type="text" name="transporteur" value="<?= $row['transporteur'] ?>" placeholder="Mettez le nom complet du transporteur" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Date du transfert</label>
                                                            <input class="form-control" id="validationDefault03" type="date" name="datetransfert" value="<?= $row['datetransfert'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Epaisseur</th>
                                                                <th>Nombre de bobine</th>
                                                                <th>Numéro fil machine</th>
                                                                <th>Poids déclaré</th>
                                                                <th>Poids pesé</th>
                                                                <th>Point de départ</th>
                                                                <th>Point d'arrivée</th>
                                                                <th>Etat bobine</th>
                                                                <th>Supprimer ligne</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dynamicadd">
                                                            <?php
                                                                //$i=0;
                                                                //for ($i = 0; $i <= $NombreLigne; $i++){
                                                                    //$i++;
                                                                    //if($article['status'] == 'termine'){
                                                            ?>
                                                                <tr class="rowClass">
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="epaisseur[]" placeholder="Taper l'épaisseur de la bobine">
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
                                                                                <input class="form-control" id="validationDefault04" type="number" name="nbbobine[]">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control" type="text" name="numbobine[]" value="" id="validationDefault099">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" id="validationDefault06" type="number" step="0.01" name="poidsdeclare[]" value="" required>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" type="number" step="0.01" name="poidspese[]" value="">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="pointdepart[]">
                                                                                    <option>Metal1</option>
                                                                                    <option>Niambour</option>
                                                                                    <option>Metal Mbao</option>
                                                                                </select>                                                
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="pointarrive[]">
                                                                                    <option>Metal1</option>
                                                                                    <option>Niambour</option>
                                                                                    <option>Tréfilage</option>
                                                                                    <option>Cranteuse</option>
                                                                                    <option>Metal Mbao</option>
                                                                                </select>                                                
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
                                                            <?php
                                                            // }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="col-md-4  d-flex gap-2">
                                                        <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                            <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="add" type="button" value="Ajouter une ligne">
                                                        </div>
                                                    </div>
                                                <?php }else{  // Lorsqu'il y'a erreur ?>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Nom complet du saisisseur</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="saisisseur" value="<?php echo $_POST['saisisseur']; ?>" placeholder="Mettez le nom complet du saisisseur" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 ml-5 mt-3">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Transporteur</label>
                                                            <input class="form-control" id="validationDefault02" type="text" name="transporteur" value="<?php echo $_POST['transporteur']; ?>" placeholder="Mettez le nom complet du transporteur" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Date du transfert</label>
                                                            <input class="form-control" id="validationDefault03" type="date" name="datetransfert" value="<?php echo $_POST['datetransfert']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Epaisseur</th>
                                                                <th>Nombre de bobine</th>
                                                                <th>Numéro fil machine</th>
                                                                <th>Poids déclaré</th>
                                                                <th>Poids pesé</th>
                                                                <th>Point de départ</th>
                                                                <th>Point d'arrivée</th>
                                                                <th>Etat bobine</th>
                                                                <th>Supprimer ligne</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dynamicadd">
                                                            <?php
                                                                //print_r($_POST);
                                                                for ($i = 0; $i < count($_POST['epaisseur']); $i++){
                                                            ?>
                                                                <tr class="rowClass">
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="epaisseur[]" placeholder="Taper l'épaisseur de la bobine">
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='3') {echo "selected='selected'";} ?> >3</option>
                                                                                    <option  <?php if ( $_POST['epaisseur'][$i]=='3.5') {echo "selected='selected'";} ?> >3.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='4') {echo "selected='selected'";} ?> >4</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='4.5') {echo "selected='selected'";} ?> >4.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='5') {echo "selected='selected'";} ?> >5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='5.5') {echo "selected='selected'";} ?> >5.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='6') {echo "selected='selected'";} ?> >6</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='6.5') {echo "selected='selected'";} ?> >6.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='7') {echo "selected='selected'";} ?> >7</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='7.5') {echo "selected='selected'";} ?> >7.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='8') {echo "selected='selected'";} ?> >8</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='8.5') {echo "selected='selected'";} ?> >8.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='9') {echo "selected='selected'";} ?> >9</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='9.5') {echo "selected='selected'";} ?> >9.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='10') {echo "selected='selected'";} ?> >10</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='10.5') {echo "selected='selected'";} ?> >10.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='11') {echo "selected='selected'";} ?> >11</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='11.5') {echo "selected='selected'";} ?> >11.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='12') {echo "selected='selected'";} ?> >12</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='12.5') {echo "selected='selected'";} ?> >12.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='13') {echo "selected='selected'";} ?> >13</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='13.5') {echo "selected='selected'";} ?> >13.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='14') {echo "selected='selected'";} ?> >14</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='14.5') {echo "selected='selected'";} ?> >14.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='15') {echo "selected='selected'";} ?> >15</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='15.5') {echo "selected='selected'";} ?> >15.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='16') {echo "selected='selected'";} ?> >16</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='16.5') {echo "selected='selected'";} ?>>16.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='17') {echo "selected='selected'";} ?> >17</option>
                                                                                </select> 
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control" value="<?php echo $_POST['nbbobine'][$i]; ?>" id="validationDefault04" type="number" name="nbbobine[]">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control" value="<?php echo $_POST['numbobine'][$i]; ?>" id="validationDefault04" type="number" name="numbobine[]">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" id="validationDefault06" type="number" step="0.01" name="poidsdeclare[]" value="<?php echo $_POST['poidsdeclare'][$i]; ?>" required>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" type="number" step="0.01" name="poidspese[]" id="example" value="<?php echo $_POST['poidspese'][$i]; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="pointdepart[]">
                                                                                    <option <?php if ( $_POST['pointdepart'][$i]=='Metal1') {echo "selected='selected'";} ?> >Metal1</option>
                                                                                    <option <?php if ( $_POST['pointdepart'][$i]=='Niambour') {echo "selected='selected'";} ?> >Niambour</option>
                                                                                    <option <?php if ( $_POST['pointdepart'][$i]=='Metal Mbao') {echo "selected='selected'";} ?> >Metal Mbao</option>
                                                                                    <option <?php  if ( $_POST['pointdepart'][$i]=='Tréfilage') {echo "selected='selected'";} ?> >Tréfilage</option>
                                                                                    <option <?php  if ( $_POST['pointdepart'][$i]=='Cranteuse') {echo "selected='selected'";} ?> >Cranteuse</option>
                                                                                </select>                                                
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="pointarrive[]">
                                                                                    <option <?php if ( $_POST['pointarrive'][$i]=='Metal1') {echo "selected='selected'";} ?> >Metal1</option>
                                                                                    <option <?php if ( $_POST['pointarrive'][$i]=='Niambour') {echo "selected='selected'";} ?> >Niambour</option>
                                                                                    <option <?php if ( $_POST['pointarrive'][$i]=='Metal Mbao') {echo "selected='selected'";} ?> >Metal Mbao</option>
                                                                                    <option <?php  if ( $_POST['pointarrive'][$i]=='Tréfilage') {echo "selected='selected'";} ?> >Tréfilage</option>
                                                                                    <option <?php  if ( $_POST['pointarrive'][$i]=='Cranteuse') {echo "selected='selected'";} ?> >Cranteuse</option>                                                                                </select>                                                
                                                                                </select> 
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="etatbobine[]" value="">
                                                                                    <option <?php if ( $_POST['etatbobine'][$i]=='Normale') {echo "selected='selected'";} ?> >Normale</option>
                                                                                    <option <?php if ( $_POST['etatbobine'][$i]=='Disloquée') {echo "selected='selected'";} ?> >Disloquée</option>
                                                                                    <option <?php if ( $_POST['etatbobine'][$i]=='Autres') {echo "selected='selected'";} ?> >Autres</option>
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
                                                            <?php
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                <?php } ?>

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
                                                            echo $_GET['idtransfert']; 
                                                        ?>" name="idtransfert" id="example-date-input2">
                                                    </div>
                                                </div>
                                                <?php if($valideTransfert != "erreurEpaisseur" && $ProblemeNbBobineDepart != "erreurProblemeNbDepart" && $ProblemeLieu != "erreurProblemeLieu" && $ProblemeUnicite != "erreurProblemeUnicite" && $ProblemeUniciteExist != "erreurProblemeUniciteExist"){ // Lorsqu'il y'a pas d'erreur ?> 
                                                    <div class="col-md-8">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="commentaire" >Commentaire</label>
                                                            <textarea class="form-control" name="commentaire" rows="4" cols="50"  placeholder="Commentaire en quelques mots ( pas obligatoire... )"><?= $row['commentaire'] ?></textarea>
                                                        </div>
                                                    </div> 
                                                <?php }else{  // Lorsqu'il y'a erreur ?>
                                                    <div class="col-md-8">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="commentaire" >Commentaire</label>
                                                            <textarea class="form-control" name="commentaire" rows="4" cols="50"  placeholder="Commentaire en quelques mots ( pas obligatoire... )"><?= $_POST['commentaire'] ?></textarea>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-end">
                                                    <div class="col-md-8 align-items-center col-md-12 text-end"> 
                                                        <?php if($valideTransfert == "erreurInsertion"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Veiller remplir tous les champs svp!',
                                                                    icon: 'error',
                                                                    timer: 2500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script>
                                                        <?php } ?>
                                                        <?php if($ProblemeNumeroBobine == "erreurProblemeNumeroBobine"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Veiller renseigner le numéro de fil machine en corrigeant la ligne <?php echo $ligneErreurBobine; ?> svp!',
                                                                    icon: 'error',
                                                                    timer: 5500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeLieu == "erreurProblemeLieu"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Le lieu de départ doit étre différent du lieu d arrivé à la ligne <?php echo $ligneErreurLieu; ?>',
                                                                    icon: 'error',
                                                                    timer: 5500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeUniciteExist == "erreurProblemeUniciteExist"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Le numéro de FM existe déja dans la base de donnée à la ligne <?php echo $ligneErreurProblemeUnicite; ?>',
                                                                    icon: 'error',
                                                                    timer: 5500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeUnicite == "erreurProblemeUnicite"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Vérifier le numéro de FM doit etre unique',
                                                                    icon: 'error',
                                                                    timer: 5500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeNbBobineDepart == "erreurProblemeNbDepart"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Veiller revoir votre stockage (nombre de bobine, epaisseur ou poids déclaré) et corrigé la ligne <?php echo $ligneErreur; ?> svp!',
                                                                    icon: 'error',
                                                                    timer: 5500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($valideTransfert == "ValideInsertion"){?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Transfert enregistré avec succès merci!',
                                                                    icon: 'success',
                                                                    timer: 3000,
                                                                    showConfirmButton: false,
                                                                    });
                                                            </script> 
                                                        <?php } ?>
                                                        <div class="d-flex gap-2 pt-4">                           
                                                            <a href="detailTransfert.php?idtransfert=<?= $_GET['idtransfert'] ?>"><input class="btn btn-danger  w-lg bouton mr-3" name=""  value="Annuler"></a>
                                                            <input class="btn btn-success  w-lg bouton mr-3" name="CreerTransfert" type="submit" value="ENREGISTRER">
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