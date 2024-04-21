<?php
    
    session_start(); 

    if(!$_SESSION['niveau']){
        header('Location: ../../../404.php');
    }

    include "../connexion/conexiondb.php";


    //Variables
    // Il faut savoir que metal3 est remplacer par niambour
    $valideTransfert="";
    $idreception = $_GET['idreception'];  // On recupére l'ID de la réception par get
    $Reception[]=null;
    $NombreLigne = $_GET['NombreLigne'];


    //** Debut select des receptions
        $sql = "SELECT * FROM `matierePlanifie` where `actif`=1 and `actifRectifie`=0 and `idreception`=$idreception ORDER BY `idmatiereplanifie` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $ReceptionPlanifieARemplir = $query->fetchAll();
    //** Fin select des receptions


    //Revoir si on a ajouter une ligne
        $nomrecepteur="";
        $matriculecamion="";
        $commentaire="";
        $entetedf="";
        $poidscamion="";
        $datereception="";

        $sql = "select * from reception where idreception=$idreception";
        $result = $db->query($sql);
        $row = $result->fetch();

        $nomrecepteur=$row['nomrecepteur'];
        $matriculecamion=$row['matriculecamion'];
        $commentaire=$row['commentaire'];
        $entetedf=$row['entetedf'];
        $poidscamion=$row['poidscamion'];
        $dateplanifie=$row['datereception'];
    //Fin revoir si on a ajouter une ligne

    //Changer valeur NombreLigne   
        if(isset($_POST['ChangerNombreLigne'])){
            $NombreLignes=htmlspecialchars( $_POST['NombreLigne']) - 1;
            header("location: ajouterReceptionFormulaire.php?idreception=$_GET[idreception]&NombreLigne=$NombreLignes");
            exit;
        }
    //Fin changer valeur NombreLigne  

    //Insertion des réceptions
    if(isset($_POST['CreerReception'])){
        $idreception=htmlspecialchars($_POST['idreception']);
        //$referenceusine=htmlspecialchars( $_POST['referenceusine']);
        $nomrecepteur=htmlspecialchars( $_POST['nomrecepteur']);
        $dateplanifie=htmlspecialchars( $_POST['dateplanifie']);
        $entetedf=htmlspecialchars( $_POST['entetedf']);
        $commentaire=htmlspecialchars($_POST['commentaire']);
        $poidscamion=htmlspecialchars($_POST['poidscamion']);
        $matriculecamion=htmlspecialchars($_POST['matriculecamion']);

        //print_r($_POST['nbbobine']);
    
        
        $sql = "UPDATE `reception` SET `nomrecepteur` = '$nomrecepteur', `status` = 'En cours de reception', `datereception` = '$dateplanifie', `poidscamion` = '$poidscamion', `matriculecamion` = '$matriculecamion', `commentaire` = '$commentaire', `entetedf` = '$entetedf' WHERE `idreception` = ?;";
        //$result = $db->query($sql); 
        $sth = $db->prepare($sql);    
        $sth->execute(array($idreception));
        
        
        for ($i = 0; $i < count($_POST['epaisseur']); $i++){
            if(!empty($_POST['epaisseur'][$i])){
                if(!empty($_POST['nbbobine'][$i])){
                    $epaisseur=htmlspecialchars( $_POST['epaisseur'][$i]);
                    //$largeur=htmlspecialchars($_POST['largeur']);
                    $lieutransfert=htmlspecialchars($_POST['lieutransfert'][$i]);
                    $etatbobine=htmlspecialchars($_POST['etatbobine'][$i]);
                    $user=htmlspecialchars($_POST['user'][$i]);
                    $poidsdeclare=htmlspecialchars($_POST['poidsdeclare'][$i]);
                    $poidspese=htmlspecialchars($_POST['poidspese'][$i]);
                    //$idLot=htmlspecialchars($_POST['idLot']);
                    //$idbobine=htmlspecialchars($Reception[$i]['idbobine']);
                    $nbbobine=htmlspecialchars($_POST['nbbobine'][$i]);
                    //$idreceptionMatiere=htmlspecialchars($_POST['idreceptionMatiere'][$i]);
                    $idreceptionMatierePlanifie=htmlspecialchars($_POST['idreceptionMatierePlanifie'][$i]);
    
    
                    if($nbbobine == 0){
                        $valideTransfert="erreurEpaisseur";
                    }else{
    
                        //Fin mettre epaisseur
                            if(($lieutransfert == "Metal1")){ // Vérifie le type de transfert
                                //Debut inserer le nombre de bobine par epaisseur
                                $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=1;";  //Metal 1
                                //$db->query($req); 
                                $reqtitre = $db->prepare($req);
                                $reqtitre->execute(array($nbbobine));
                                //Fin inserer le nombre de bobine par epaisseur
                            }elseif(($lieutransfert == "Niambour")){
                                //Debut inserer le nombre de bobine par epaisseur
                                $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=3;";  // Metal 3 dit Niambour
                                //$db->query($req); 
                                $reqtitre = $db->prepare($req);
                                $reqtitre->execute(array($nbbobine));
                                //Fin inserer le nombre de bobine par epaisseur
                            }
                            elseif(($lieutransfert == "Metal Mbao")){
                                //Debut inserer le nombre de bobine par epaisseur
                                $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=6;";  // Metal Mbao dit Niambour
                                //$db->query($req); 
                                $reqtitre = $db->prepare($req);
                                $reqtitre->execute(array($nbbobine));
                                //Fin inserer le nombre de bobine par epaisseur
                            }
                        //Fin mettre epaisseur
    
                        //$sql = "UPDATE `matiere` SET `epaisseur` = '$epaisseur', `poidsdeclare` = '$poidsdeclare', `poidspese` = '$poidspese', `nbbobine` = '$nbbobine', `lieutransfert` = '$lieutransfert', `idreception` = '$idreception', `etatbobine` = '$etatbobine' WHERE `idmatiere` = ?;";
                        //$result = $db->query($sql); 
                        //$sth = $db->prepare($sql);    
                        //$sth->execute(array($idreceptionMatiere));
                        $insertUser=$db->prepare("INSERT INTO `matiere` (`idmatiere`, `epaisseur`, `poidsdeclare`, `poidspese`, `dateajout`, `user`,`nbbobine`,`lieutransfert`, `idreception`, `etatbobine`,`nbbobineactuel`) 
                        VALUES (NULL, ?, ?, ?, current_timestamp(), ?, ?, ?, ?, ?, ?);");
                        $insertUser->execute(array($epaisseur,$poidsdeclare, $poidspese, $user,$nbbobine,$lieutransfert,$idreception, $etatbobine, $nbbobine));
    
                        //Mettre inactif les matieres a remplir 
                            $sql = "UPDATE `matiereplanifie` SET `actifRectifie` = 1 WHERE `idmatiereplanifie` = ?;";
                            //$result = $db->query($sql); 
                            $sth = $db->prepare($sql);    
                            $sth->execute(array($idreceptionMatierePlanifie));
                        //Fin mettre inactif les matieres a remplir 
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

    
    

    // Pour insertion details reception
        /*if(isset($_POST['CreerReception'])){
            if(!empty($_POST['referenceusine']) && !empty($_POST['epaisseur'])  && !empty($_POST['lieutransfert'])  && !empty($_POST['poidsdeclare'])){
                $referenceusine=htmlspecialchars($_POST['referenceusine']);
                $epaisseur=htmlspecialchars($_POST['epaisseur']);
                //$largeur=htmlspecialchars($_POST['largeur']);
                $lieutransfert=htmlspecialchars($_POST['lieutransfert']);
                $commentaire=htmlspecialchars($_POST['commentaire']);
                $user=htmlspecialchars($_POST['user']);
                $poidsdeclare=htmlspecialchars($_POST['poidsdeclare']);
                //$poidspese=htmlspecialchars($_POST['poidspese']);
                //$idLot=htmlspecialchars($_POST['idLot']);
                $idbobine=htmlspecialchars($_POST['idbobine']);
                //$idreception=htmlspecialchars($_POST['idreception']);
                $nbbobine=htmlspecialchars($_POST['nbbobine']);

                if($nbbobine == 0){
                    $valideTransfert="erreurEpaisseur";
                }else{
                    $insertUser=$db->prepare("INSERT INTO `matiere` (`idmatiere`, `referenceusine`, `epaisseur`, `largeur`, `poidsdeclare`, `laminage`, `poidspese`, `produitfini`,
                    `travaille`, `idlot`, `annee`, `numprod`, `dateajout`, `idbobine`,`user`,`nbbobine`,`commentaire`,`lieutransfert`, `idreception`) VALUES (NULL, ?, ?, '', ?, '', '', '', '', '', '', '', current_timestamp(), '1',?,?,?,?,?);");
                $insertUser->execute(array($referenceusine,$epaisseur,$poidsdeclare,$user,$nbbobine,$commentaire,$lieutransfert,$idreception));

                header("location: detailsReception.php?idreception=$idreception");
                exit;
                }
                
            }else{
                $valideTransfert="erreurInsertion";
            }
        }*/
    //Fin insertion details reception

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

    <!-- Sweet Alert -->
    <link href="../libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <script src="../libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="../libs/sweetalert2/jquery-1.12.4.js"></script>

    <!-- Custom styles for this template -->
    <link href="../indexPage/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../indexPage/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                            <input class="form-control" type="number" name="nbbobine[]" value="" id="validationDefault0<?$i+9?>" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                <div class="col-md-10">
                    <div class="mb-1 text-start">
                        <input class="form-control designa" type="number" name="poidsdeclare[]" id="validationDefault0<?$i+10?>" required>
                    </div>
                </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" name="poidspese[]">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="lieutransfert[]" value="">
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
                <div class="container-fluid">
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
                                                <div class="col-md-2 ml-5 mr-5 mt-3">
                                                    <div class="mb-5 text-start">
                                                        <label class="form-label fw-bold" for="nom">Entete de la DF</label> 
                                                        <input class="form-control" type="text" name="entetedf" value="<?= $row['entetedf'] ?>" id="validationDefault01" required placeholder="Mettez l'entete de la DF">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mr-2 mt-3">
                                                    <div class="mb-1 text-start">
                                                        <label class="form-label fw-bold" for="nom">Nom complet du saisisseur</label>
                                                        <input class="form-control" type="text" name="nomrecepteur" value="<?= $row['nomrecepteur'] ?>" id="validationDefault02" required placeholder="Mettez le nom complet du saisisseur">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 ml-5 mt-3">
                                                    <div class="mb-1 text-start">
                                                        <label class="form-label fw-bold" for="nom">Matricule du Camion</label>
                                                        <input class="form-control" type="text" name="matriculecamion" value="<?= $row['matriculecamion'] ?>" id="validationDefault03" required placeholder="Mettez le matricule du camion">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 ml-5 mt-3">
                                                    <div class="mb-1 text-start">
                                                        <label class="form-label fw-bold" for="nom">Poids pont bascule</label>
                                                        <input class="form-control" type="text" name="poidscamion" value="<?= $row['poidscamion'] ?>" id="validationDefault20" required placeholder="Mettez le poids pont bascule">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-3 ml-5">
                                                    <div class="mb-1 text-start">
                                                        <label class="form-label fw-bold" for="nom">Date de reception</label>
                                                        <input class="form-control" type="date" name="dateplanifie" value="<?php echo $row['datereception']; ?>" id="validationDefault25" required>
                                                    </div>
                                                </div>
                                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Epaisseur</th>
                                                            <th>Nombre bobine</th>
                                                            <th>Poids déclaré</th>
                                                            <th>Poids pesé</th>
                                                            <th>Lieu de réception</th>
                                                            <th>Etat de la bobine</th>
                                                            <th style="background-color:#CFFEDA ;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dynamicadd">
                                                        <?php
                                                            //$i=0;
                                                            //for ($i = 0; $i <= $NombreLigne; $i++){
                                                                //$i++;
                                                                //if($article['status'] == 'termine'){
                                                            //if($ReceptionPlanifieARemplir){
                                                                foreach($ReceptionPlanifieARemplir as $reception){
                                                                //$i++;
                                                        ?>
                                                            <tr class="rowClass">
                                                                <td style="background-color:#CFFEDA ;">
                                                                    <div class="">
                                                                        <div class="mb-1 text-start">
                                                                            <select class="form-control" name="epaisseur[]" placeholder="Taper l'épaisseur de la bobine" value="">
                                                                                <option <?php if ( $reception['epaisseur']=='3') {echo "selected='selected'";} ?> >3</option>
                                                                                <option  <?php if ( $reception['epaisseur']=='3.5') {echo "selected='selected'";} ?> >3.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='4') {echo "selected='selected'";} ?> >4</option>
                                                                                <option <?php if ( $reception['epaisseur']=='4.5') {echo "selected='selected'";} ?> >4.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='5') {echo "selected='selected'";} ?> >5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='5.5') {echo "selected='selected'";} ?> >5.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='6') {echo "selected='selected'";} ?> >6</option>
                                                                                <option <?php if ( $reception['epaisseur']=='6.5') {echo "selected='selected'";} ?> >6.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='7') {echo "selected='selected'";} ?> >7</option>
                                                                                <option <?php if ( $reception['epaisseur']=='7.5') {echo "selected='selected'";} ?> >7.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='8') {echo "selected='selected'";} ?> >8</option>
                                                                                <option <?php if ( $reception['epaisseur']=='8.5') {echo "selected='selected'";} ?> >8.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='9') {echo "selected='selected'";} ?> >9</option>
                                                                                <option <?php if ( $reception['epaisseur']=='9.5') {echo "selected='selected'";} ?> >9.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='10') {echo "selected='selected'";} ?> >10</option>
                                                                                <option <?php if ( $reception['epaisseur']=='10.5') {echo "selected='selected'";} ?> >10.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='11') {echo "selected='selected'";} ?> >11</option>
                                                                                <option <?php if ( $reception['epaisseur']=='11.5') {echo "selected='selected'";} ?> >11.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='12') {echo "selected='selected'";} ?> >12</option>
                                                                                <option <?php if ( $reception['epaisseur']=='12.5') {echo "selected='selected'";} ?> >12.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='13') {echo "selected='selected'";} ?> >13</option>
                                                                                <option <?php if ( $reception['epaisseur']=='13.5') {echo "selected='selected'";} ?> >13.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='14') {echo "selected='selected'";} ?> >14</option>
                                                                                <option <?php if ( $reception['epaisseur']=='14.5') {echo "selected='selected'";} ?> >14.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='15') {echo "selected='selected'";} ?> >15</option>
                                                                                <option <?php if ( $reception['epaisseur']=='15.5') {echo "selected='selected'";} ?> >15.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='16') {echo "selected='selected'";} ?> >16</option>
                                                                                <option <?php if ( $reception['epaisseur']=='16.5') {echo "selected='selected'";} ?>>16.5</option>
                                                                                <option <?php if ( $reception['epaisseur']=='17') {echo "selected='selected'";} ?> >17</option>
                                                                            </select> 
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="background-color:#CFFEDA ;">
                                                                    <div class="col-md-10">
                                                                        <div class="mb-1 text-start">
                                                                            <input class="form-control" type="number" name="nbbobine[]" value="" id="validationDefault04" required>
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
                                                            <div class="col-md-6 invisible">
                                                                <div class="mb-1 text-start">
                                                                    <input class="form-control" type="text" value="<?php
                                                                        echo $reception['idmatiereplanifie'];?>; 
                                                                    ?>" name="idreceptionMatierePlanifie[]" id="example-date-input3">
                                                                </div>
                                                            </div>
                                                        <?php
                                                                //}
                                                            }
                                                        ?>
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
                                                        <textarea class="form-control"  name="commentaire" rows="4" cols="50" placeholder="Commentaire en quelques mots ( pas obligatoire... )"><?= $row['commentaire'] ?></textarea>
                                                    </div>
                                                </div> 
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
                                                        <?php if($valideTransfert == "erreurEpaisseur"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Vérifiez le nombre de bobine svp!',
                                                                    icon: 'error',
                                                                    timer: 2500,
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